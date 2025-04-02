<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;

/**
 * Admin Booking Controller
 *
 * Handles all booking-related functionality for admins, including listing,
 * viewing details, updating status, and managing bookings.
 * Supports both web and API requests for future mobile app integration.
 *
 * @package App\Http\Controllers\Admin
 */
class BookingController extends Controller
{
    /**
     * Display a listing of all bookings
     *
     * Lists all bookings in the system with filtering capabilities.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $query = Booking::query();

            // Apply filters if provided
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            if ($request->has('payment_status')) {
                $query->where('payment_status', $request->payment_status);
            }

            if ($request->has('provider_id')) {
                $query->whereHas('activity', function($q) use ($request) {
                    $q->whereHas('shopInfo', function($q2) use ($request) {
                        $q2->where('user_id', $request->provider_id);
                    });
                });
            }

            if ($request->has('customer_id')) {
                $query->where('user_id', $request->customer_id);
            }

            // Include relationships
            $query->with(['user', 'activity.shopInfo.user']);

            // Order by creation date (newest first)
            $query->orderBy('created_at', 'desc');

            // Get paginated results
            $bookings = $query->paginate(15);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'bookings' => $bookings
                ]);
            }

            return view('admin.bookings', [
                'bookings' => $bookings
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load bookings',
                    'error' => $e->getMessage()
                ], 500);
            }

            return view('admin.bookings', [
                'bookings' => [],
                'error' => 'An error occurred while retrieving bookings.'
            ]);
        }
    }

    /**
     * Display details for a specific booking
     *
     * Shows detailed information about a specific booking.
     *
     * @param Request $request The incoming request
     * @param int $id The booking ID
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        try {
            $booking = Booking::with(['user', 'activity.shopInfo.user'])
                ->findOrFail($id);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'booking' => $booking
                ]);
            }

            return view('admin.bookings.view', [
                'booking' => $booking
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found',
                    'error' => $e->getMessage()
                ], 404);
            }

            return redirect()->route('admin.bookings')
                ->with('error', 'Booking not found.');
        }
    }

    /**
     * Show the edit form for a booking
     *
     * Displays the form to edit a booking's details.
     *
     * @param Request $request The incoming request
     * @param int $id The booking ID
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, $id)
    {
        try {
            $booking = Booking::with(['user', 'activity.shopInfo.user', 'activity.lots', 'lot'])
                ->findOrFail($id);

            // Get list of possible statuses
            $statuses = [
                'pending' => 'Pending',
                'confirmed' => 'Confirmed',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled'
            ];

            // Get list of possible payment statuses
            $paymentStatuses = [
                'pending' => 'Pending',
                'processing' => 'Processing',
                'paid' => 'Paid',
                'refunded' => 'Refunded',
                'failed' => 'Failed'
            ];

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'booking' => $booking,
                    'statuses' => $statuses,
                    'payment_statuses' => $paymentStatuses
                ]);
            }

            return view('admin.bookings.edit', [
                'booking' => $booking,
                'statuses' => $statuses,
                'paymentStatuses' => $paymentStatuses
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found',
                    'error' => $e->getMessage()
                ], 404);
            }

            return redirect()->route('admin.bookings')
                ->with('error', 'Booking not found.');
        }
    }

    /**
     * Update a booking
     *
     * Updates a booking's details, status, or payment information.
     *
     * @param Request $request The incoming request
     * @param int $id The booking ID
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);

            // Validate the incoming request
            $validated = $request->validate([
                'booking_date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'nullable',
                'participants' => 'required|integer|min:1',
                'total_price' => 'required|numeric|min:0',
                'status' => 'required|string|in:pending,confirmed,completed,cancelled',
                'payment_status' => 'required|string|in:pending,processing,paid,refunded,failed',
                'payment_method' => 'nullable|string',
                'payment_id' => 'nullable|string',
                'special_requests' => 'nullable|string',
                'cancelation_reason' => 'nullable|string|required_if:status,cancelled',
                'lot_id' => 'nullable|exists:activity_lots,id',
            ]);

            // Format datetime fields
            $bookingDate = $validated['booking_date'];
            $startTime = $validated['start_time'];
            $endTime = $validated['end_time'] ?? null;

            // Combine date and time
            $startDateTime = \Carbon\Carbon::parse($bookingDate . ' ' . $startTime);
            $endDateTime = $endTime ? \Carbon\Carbon::parse($bookingDate . ' ' . $endTime) : null;

            // Update booking data
            $booking->booking_date = $startDateTime->toDateString();
            $booking->start_time = $startDateTime;
            $booking->end_time = $endDateTime;
            $booking->participants = $validated['participants'];
            $booking->total_price = $validated['total_price'];
            $booking->status = $validated['status'];
            $booking->payment_status = $validated['payment_status'];
            $booking->payment_method = $validated['payment_method'];
            $booking->payment_id = $validated['payment_id'];
            $booking->special_requests = $validated['special_requests'];
            $booking->lot_id = $validated['lot_id'];

            // Set cancellation reason if status is cancelled
            if ($validated['status'] === 'cancelled') {
                $booking->cancelation_reason = $validated['cancelation_reason'];
            }

            $booking->save();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Booking updated successfully',
                    'booking' => $booking->fresh(['user', 'activity.shopInfo.user', 'lot'])
                ]);
            }

            return redirect()->route('admin.bookings.show', ['id' => $booking->id])
                ->with('success', 'Booking updated successfully.');
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update booking',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withErrors([
                'error' => 'An error occurred while updating the booking. Please try again.'
            ])->withInput();
        }
    }

    /**
     * Cancel a booking
     *
     * Allows an admin to cancel a booking and optionally process a refund.
     *
     * @param Request $request The incoming request
     * @param int $id The booking ID
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function cancel(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);

            // Validate the incoming request
            $validated = $request->validate([
                'cancelation_reason' => 'required|string|max:255',
                'issue_refund' => 'nullable|boolean',
            ]);

            // Update booking status
            $booking->status = 'cancelled';
            $booking->cancelation_reason = $validated['cancelation_reason'];

            // Process refund if requested
            if (isset($validated['issue_refund']) && $validated['issue_refund']) {
                $booking->payment_status = 'refunded';
                // In a real application, you would integrate with a payment gateway here
            }

            $booking->save();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Booking cancelled successfully',
                    'booking' => $booking->fresh(['user', 'activity.shopInfo.user'])
                ]);
            }

            return redirect()->route('admin.bookings.show', ['id' => $booking->id])
                ->with('success', 'Booking cancelled successfully.');
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to cancel booking',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withErrors([
                'error' => 'An error occurred while cancelling the booking. Please try again.'
            ])->withInput();
        }
    }

    /**
     * Get booking statistics
     *
     * Provides statistical information about bookings for admin dashboard.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatistics(Request $request)
    {
        try {
            // Count bookings by status
            $byStatus = [
                'pending' => Booking::where('status', 'pending')->count(),
                'confirmed' => Booking::where('status', 'confirmed')->count(),
                'completed' => Booking::where('status', 'completed')->count(),
                'cancelled' => Booking::where('status', 'cancelled')->count(),
            ];

            // Count bookings by payment status
            $byPaymentStatus = [
                'pending' => Booking::where('payment_status', 'pending')->count(),
                'processing' => Booking::where('payment_status', 'processing')->count(),
                'done' => Booking::where('payment_status', 'done')->count(),
                'refunded' => Booking::where('payment_status', 'refunded')->count(),
                'failed' => Booking::where('payment_status', 'failed')->count(),
            ];

            // Get recent bookings
            $recentBookings = Booking::with(['user', 'activity'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return response()->json([
                'success' => true,
                'by_status' => $byStatus,
                'by_payment_status' => $byPaymentStatus,
                'recent_bookings' => $recentBookings,
                'total_count' => Booking::count(),
                'total_revenue' => Booking::where('payment_status', 'done')->sum('total_price')
            ]);
        } catch (\Exception $e) {
            // Error handling
            return response()->json([
                'success' => false,
                'message' => 'Failed to get booking statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process a manual payment
     *
     * Records a manual payment for a booking (bank transfer or cash)
     *
     * @param Request $request The incoming request
     * @param int $id The booking ID
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function processPayment(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);

            // Validate the incoming request
            $validated = $request->validate([
                'payment_method' => 'required|string|in:bank_transfer,cash,online',
                'payment_amount' => 'required|numeric|min:0',
                'payment_id' => 'nullable|string',
                'payment_notes' => 'nullable|string',
                'receipt_image' => 'nullable|image|max:2048', // Max 2MB
            ]);

            // Handle receipt upload if provided
            $receiptPath = null;
            if ($request->hasFile('receipt_image')) {
                $receiptPath = $request->file('receipt_image')->store('receipts', 'public');
            }

            // Update booking payment information
            $booking->payment_method = $validated['payment_method'];
            $booking->payment_status = 'paid';
            $booking->payment_id = $validated['payment_id'];

            // Store receipt path and notes in customer_details json field
            $customerDetails = $booking->customer_details ?? [];
            $customerDetails['payment_notes'] = $validated['payment_notes'];

            if ($receiptPath) {
                $customerDetails['receipt_image'] = $receiptPath;
            }

            $booking->customer_details = $customerDetails;
            $booking->save();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment processed successfully',
                    'booking' => $booking->fresh(['user', 'activity.shopInfo.user'])
                ]);
            }

            return redirect()->route('admin.bookings.show', ['id' => $booking->id])
                ->with('success', 'Payment processed successfully.');
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to process payment',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withErrors([
                'error' => 'An error occurred while processing the payment. Please try again.'
            ])->withInput();
        }
    }
}
