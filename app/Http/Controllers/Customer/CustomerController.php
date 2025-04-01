<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

/**
 * Customer Controller
 *
 * Handles all customer-specific functionality including profile management,
 * account settings, and booking management. Supports both web and API requests.
 *
 * @package App\Http\Controllers\Customer
 */
class CustomerController extends Controller
{
    /**
     * Show the customer dashboard
     *
     * Displays the main customer dashboard with optional tab selection
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View
     */
    public function dashboard(Request $request)
    {
        $tab = $request->query('tab', 'overview');
        $user = Auth::user();

        return view('customer.dashboard', [
            'user' => $user,
            'tab' => $tab
        ]);
    }

    /**
     * Show the customer profile page.
     *
     * Displays the customer's profile information for viewing and editing.
     * Also supports API requests for mobile applications.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showProfile(Request $request)
    {
        $user = Auth::user();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        }

        return view('customer.profile', [
            'user' => $user
        ]);
    }

    /**
     * Update the customer profile
     *
     * Processes profile update requests and handles validation.
     * Supports both web and API requests.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'profile_image' => 'nullable|image|max:2048', // 2MB max
            ]);

            $user = Auth::user();
            $userData = [
                'name' => $validated['name'],
                'phone' => $validated['phone'] ?? $user->phone,
            ];

            // Handle profile image upload if provided
            if ($request->hasFile('profile_image')) {
                $imagePath = $request->file('profile_image')->store('profile_images', 'public');
                $userData['profile_image'] = $imagePath;
            }

            // Update user data
            User::where('id', $user->id)->update($userData);

            // Refresh user data
            $user = User::find($user->id);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profile updated successfully',
                    'user' => $user
                ]);
            }

            return redirect()->route('customer.profile')->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profile update failed',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withErrors([
                'error' => 'An error occurred while updating your profile. Please try again.'
            ])->withInput();
        }
    }

    /**
     * Show the customer account page.
     *
     * Displays the customer's account settings.
     * Also supports API requests for mobile applications.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showAccount(Request $request)
    {
        $user = Auth::user();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        }

        return view('customer.account', [
            'user' => $user
        ]);
    }

    /**
     * Update the customer account password
     *
     * Handles password change requests with validation.
     * Supports both web and API requests.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function updatePassword(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'current_password' => 'required|current_password',
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            $user = Auth::user();

            // Update password
            User::where('id', $user->id)->update([
                'password' => Hash::make($validated['new_password'])
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Password updated successfully'
                ]);
            }

            return redirect()->route('customer.account')->with('success', 'Password updated successfully');
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password update failed',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withErrors([
                'error' => 'An error occurred while updating your password. Please try again.'
            ])->withInput();
        }
    }

    /**
     * Show the customer bookings page.
     *
     * Displays the customer's booking history.
     * Also supports API requests for mobile applications.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showBookings(Request $request)
    {
        try {
            $user = Auth::user();
            $bookings = Booking::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'bookings' => $bookings
                ]);
            }

            return view('customer.bookings', [
                'user' => $user,
                'bookings' => $bookings
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve bookings',
                    'error' => $e->getMessage()
                ], 500);
            }

            return view('customer.bookings', [
                'user' => Auth::user(),
                'bookings' => [],
                'error' => 'An error occurred while retrieving your bookings.'
            ]);
        }
    }

    /**
     * Show details for a specific booking
     *
     * Displays detailed information about a specific booking.
     * Also supports API requests for mobile applications.
     *
     * @param Request $request The incoming request
     * @param int $id The booking ID
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showBookingDetails(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $booking = Booking::where('id', $id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'booking' => $booking
                ]);
            }

            return view('customer.booking-details', [
                'user' => $user,
                'booking' => $booking
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found or access denied',
                    'error' => $e->getMessage()
                ], 404);
            }

            return redirect()->route('customer.bookings')
                ->with('error', 'Booking not found or access denied.');
        }
    }

    /**
     * Cancel a booking
     *
     * Allows customers to cancel their bookings if eligible.
     * Supports both web and API requests.
     *
     * @param Request $request The incoming request
     * @param int $id The booking ID
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function cancelBooking(Request $request, $id)
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

            // Refresh booking data
            $booking = Booking::find($booking->id);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Booking cancelled successfully',
                    'booking' => $booking
                ]);
            }

            return redirect()->route('customer.bookings')
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
                'error' => 'An error occurred while cancelling your booking. Please try again.'
            ]);
        }
    }
}
