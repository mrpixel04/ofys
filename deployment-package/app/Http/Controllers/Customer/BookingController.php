<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display the booking form for the specified activity.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function create($id)
    {
        // This route should be protected with auth middleware
        $activity = Activity::with('shopInfo')->findOrFail($id);

        // Only allow booking active activities
        if (!$activity->is_active) {
            abort(404);
        }

        return view('customer.bookings.create', [
            'activity' => $activity,
        ]);
    }

    /**
     * Process the booking request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $id)
    {
        // This route should be protected with auth middleware
        $activity = Activity::with('lots')->findOrFail($id);

        // Base validation
        $validationRules = [
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'participants' => 'required|integer|min:' . $activity->min_participants . '|max:' . $activity->max_participants,
            'special_requests' => 'nullable|string|max:500',
        ];

        // Add lot validation for camping and glamping activities
        if (in_array($activity->activity_type, ['camping', 'glamping'])) {
            $validationRules['lot_id'] = 'required|exists:activity_lots,id';
        }

        // Validate booking
        $request->validate($validationRules);

        // For camping/glamping activities, check if lot is available
        if (in_array($activity->activity_type, ['camping', 'glamping'])) {
            $lot = $activity->lots->where('id', $request->lot_id)->first();

            if (!$lot || !$lot->is_available) {
                return back()->withErrors(['lot_id' => 'The selected lot is not available. Please choose another lot.'])
                    ->withInput();
            }
        }

        // Calculate end time (based on duration)
        $startTime = \Carbon\Carbon::parse($request->booking_date . ' ' . $request->start_time);
        $endTime = $startTime->copy()->addMinutes($activity->duration_minutes);

        // Calculate total price
        $totalPrice = $activity->price;
        if ($activity->price_type === 'per_person') {
            $totalPrice *= $request->participants;
        }

        // Create booking reference
        $bookingReference = 'BK-' . strtoupper(Str::random(6));

        // Prepare booking data
        $bookingData = [
            'booking_reference' => $bookingReference,
            'user_id' => Auth::id(),
            'activity_id' => $activity->id,
            'booking_date' => $request->booking_date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'participants' => $request->participants,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'pending',
            'special_requests' => $request->special_requests,
            'customer_details' => [
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
            ],
            'activity_details' => [
                'name' => $activity->name,
                'type' => $activity->activity_type,
                'location' => $activity->location,
                'provider' => $activity->shopInfo->company_name,
                'price' => $activity->price,
                'price_type' => $activity->price_type,
            ],
        ];

        // Add lot information for camping/glamping activities
        if (in_array($activity->activity_type, ['camping', 'glamping']) && $request->lot_id) {
            $bookingData['lot_id'] = $request->lot_id;
            $bookingData['activity_details']['lot'] = [
                'id' => $lot->id,
                'name' => $lot->name,
                'description' => $lot->description,
                'capacity' => $lot->capacity,
            ];
        }

        // Create booking
        $booking = new Booking($bookingData);
        $booking->save();

        // Mark the lot as unavailable if this is a camping/glamping activity
        if (in_array($activity->activity_type, ['camping', 'glamping']) && $request->lot_id) {
            $lot->update(['is_available' => false]);
        }

        // Here you would normally redirect to a payment page
        // For now, we'll just redirect to the booking confirmation page
        return redirect()->route('customer.bookings.confirmation', $booking->id)
            ->with('success', 'Your booking has been created. Please complete the payment to confirm.');
    }

    /**
     * Display the booking confirmation page.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function confirmation($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('customer.bookings.confirmation', [
            'booking' => $booking,
            'redirect_to_dashboard' => true
        ]);
    }

    /**
     * Show details for a specific booking
     *
     * @param int $id The booking ID
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        try {
            $user = Auth::user();
            $booking = Booking::where('id', $id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            return view('customer.bookings.show', [
                'user' => $user,
                'booking' => $booking
            ]);
        } catch (\Exception $e) {
            return redirect()->route('customer.dashboard', ['tab' => 'bookings'])
                ->with('error', 'Booking not found or access denied.');
        }
    }

    /**
     * Show the customer bookings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $bookings = Booking::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('customer.bookings.index', [
                'user' => $user,
                'bookings' => $bookings
            ]);
        } catch (\Exception $e) {
            return view('customer.bookings.index', [
                'user' => Auth::user(),
                'bookings' => [],
                'error' => 'An error occurred while retrieving your bookings.'
            ]);
        }
    }

    /**
     * Cancel a booking
     *
     * @param Request $request The incoming request
     * @param int $id The booking ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $booking = Booking::where('id', $id)
                ->where('user_id', $user->id)
                ->where('status', '!=', 'completed')
                ->where('status', '!=', 'cancelled')
                ->firstOrFail();

            // Validate cancelation reason if required
            $validated = $request->validate([
                'cancelation_reason' => 'required|string|max:255',
            ]);

            // Update booking status
            Booking::where('id', $booking->id)->update([
                'status' => 'cancelled',
                'cancelation_reason' => $validated['cancelation_reason']
            ]);

            return redirect()->route('customer.dashboard', ['tab' => 'bookings'])
                ->with('success', 'Booking cancelled successfully.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'An error occurred while cancelling your booking. Please try again.'
            ]);
        }
    }

    /**
     * Process bank transfer payment
     *
     * @param Request $request The incoming request
     * @param int $id The booking ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processTransferPayment(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $booking = Booking::where('id', $id)
                ->where('user_id', $user->id)
                ->where('payment_status', 'pending')
                ->firstOrFail();

            // Validate receipt upload
            $validated = $request->validate([
                'receipt' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            ]);

            // Store the receipt file
            $receiptPath = $request->file('receipt')->store('receipts', 'public');

            // Update booking with payment information
            $booking->update([
                'payment_status' => 'processing', // Set to processing until admin verifies
                'payment_method' => 'bank_transfer',
                'payment_details' => [
                    'receipt_path' => $receiptPath,
                    'uploaded_at' => now()->toDateTimeString(),
                ],
                'status' => 'pending', // Keep status as pending until payment is verified
            ]);

            return redirect()->route('customer.bookings.show', $booking->id)
                ->with('success', 'Payment receipt uploaded successfully. Your payment is being processed.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'An error occurred while processing your payment. Please try again.'
            ]);
        }
    }

    /**
     * Show online payment page (placeholder for integration with payment gateway)
     *
     * @param int $id The booking ID
     * @return \Illuminate\View\View
     */
    public function showOnlinePayment($id)
    {
        try {
            $user = Auth::user();
            $booking = Booking::where('id', $id)
                ->where('user_id', $user->id)
                ->where('payment_status', 'pending')
                ->firstOrFail();

            // This would normally be a redirect to the payment gateway
            // For now, we'll just show a placeholder page

            return view('customer.bookings.online-payment', [
                'booking' => $booking,
                // Additional parameters for the payment gateway would be added here
            ]);
        } catch (\Exception $e) {
            return redirect()->route('customer.dashboard', ['tab' => 'bookings'])
                ->with('error', 'Unable to process online payment. Please try again.');
        }
    }

    /**
     * Process cash payment (payment at site)
     *
     * @param Request $request The incoming request
     * @param int $id The booking ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processCashPayment(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $booking = Booking::where('id', $id)
                ->where('user_id', $user->id)
                ->where('payment_status', 'pending')
                ->firstOrFail();

            // Update booking with payment method
            $booking->update([
                'payment_status' => 'pending',
                'payment_method' => 'cash_on_site',
                'payment_details' => [
                    'pay_at_site' => true,
                    'selected_at' => now()->toDateTimeString(),
                ],
                'status' => 'confirmed', // Confirm the booking since they'll pay at the site
            ]);

            return redirect()->route('customer.bookings.show', $booking->id)
                ->with('success', 'Your booking is confirmed. Please pay at the site before your activity begins.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'An error occurred while processing your booking. Please try again.'
            ]);
        }
    }
}
