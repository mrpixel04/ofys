<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ShopInfo;
use App\Models\Activity;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

/**
 * Provider Controller
 *
 * Handles all provider-specific functionality including profile management,
 * shop information, activity management, and booking management.
 * Supports both web and API requests for future mobile app integration.
 *
 * @package App\Http\Controllers\Provider
 */
class ProviderController extends Controller
{
    /**
     * Show the provider dashboard
     *
     * Displays the main provider dashboard with statistics and overview.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function dashboard(Request $request)
    {
        try {
            $user = Auth::user();
            $shopInfo = $user->shopInfo;

            // If no shop info exists, create one
            if (!$shopInfo) {
                $shopInfo = ShopInfo::create([
                    'user_id' => $user->id,
                    'company_name' => $user->name . "'s Shop",
                    'country' => 'Malaysia',
                    'is_verified' => false,
                ]);
            }

            // Get basic dashboard statistics
            $activitiesCount = Activity::where('shop_info_id', $shopInfo->id)->count();
            $pendingBookingsCount = Booking::whereHas('activity', function($query) use ($shopInfo) {
                $query->where('shop_info_id', $shopInfo->id);
            })->where('status', 'pending')->count();

            $stats = [
                'activities_count' => $activitiesCount,
                'pending_bookings' => $pendingBookingsCount
            ];

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'user' => $user,
                    'shop_info' => $shopInfo,
                    'stats' => $stats
                ]);
            }

            return view('provider.dashboard', [
                'user' => $user,
                'shopInfo' => $shopInfo,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load dashboard',
                    'error' => $e->getMessage()
                ], 500);
            }

            return view('provider.dashboard', [
                'error' => 'An error occurred while loading the dashboard. Please try again.'
            ]);
        }
    }

    /**
     * Show the provider profile page
     *
     * Displays the provider's profile information for viewing and editing.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showProfile(Request $request)
    {
        try {
            $user = Auth::user();
            $shopInfo = $user->shopInfo;

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'user' => $user,
                    'shop_info' => $shopInfo
                ]);
            }

            return view('provider.simple-profile', [
                'user' => $user,
                'shopInfo' => $shopInfo
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load profile',
                    'error' => $e->getMessage()
                ], 500);
            }

            return view('provider.simple-profile', [
                'error' => 'An error occurred while loading your profile. Please try again.'
            ]);
        }
    }

    /**
     * Update the provider profile
     *
     * Processes profile update requests and handles validation.
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

            return redirect()->route('provider.profile')->with('success', 'Profile updated successfully');
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
     * Show the shop information page
     *
     * Displays and manages the provider's shop/business information.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showShopInfo(Request $request)
    {
        try {
            $user = Auth::user();
            $shopInfo = $user->shopInfo;

            // If shop info doesn't exist yet, create it
            if (!$shopInfo) {
                $shopInfo = ShopInfo::create([
                    'user_id' => $user->id,
                    'company_name' => $user->name . "'s Shop",
                    'country' => 'Malaysia',
                    'is_verified' => false,
                ]);
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'shop_info' => $shopInfo
                ]);
            }

            return view('provider.shop-info', [
                'user' => $user,
                'shopInfo' => $shopInfo
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load shop information',
                    'error' => $e->getMessage()
                ], 500);
            }

            return view('provider.shop-info', [
                'error' => 'An error occurred while loading your shop information. Please try again.'
            ]);
        }
    }

    /**
     * Update shop information
     *
     * Processes shop information update requests and handles validation.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function updateShopInfo(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'company_name' => 'required|string|max:255',
                'company_email' => 'nullable|email|max:255',
                'business_type' => 'nullable|string|max:100',
                'description' => 'nullable|string|max:1000',
                'services_offered' => 'nullable|string|max:500',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'postal_code' => 'nullable|string|max:20',
                'zip' => 'nullable|string|max:20',
                'country' => 'nullable|string|max:100',
                'phone' => 'nullable|string|max:20',
                'website' => 'nullable|url|max:255',
                'logo' => 'nullable|image|max:2048',
                'shop_image' => 'nullable|image|max:2048',
                'business_hours' => 'nullable|json',
            ]);

            $user = Auth::user();
            $shopInfo = $user->shopInfo;

            if (!$shopInfo) {
                $shopInfo = new ShopInfo();
                $shopInfo->user_id = $user->id;
            }

            // Prepare update data
            $shopData = $validated;

            // Handle logo upload if provided
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('shop_logos', 'public');
                $shopData['logo'] = $logoPath;
            }

            // Handle shop image upload if provided
            if ($request->hasFile('shop_image')) {
                $imagePath = $request->file('shop_image')->store('shop_images', 'public');
                $shopData['shop_image'] = $imagePath;
            }

            // Update shop info
            ShopInfo::where('id', $shopInfo->id)->update($shopData);

            // Refresh shop info
            $shopInfo = ShopInfo::find($shopInfo->id);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Shop information updated successfully',
                    'shop_info' => $shopInfo
                ]);
            }

            return redirect()->route('provider.shop-info')->with('success', 'Shop information updated successfully');
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Shop information update failed',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withErrors([
                'error' => 'An error occurred while updating your shop information. Please try again.'
            ])->withInput();
        }
    }

    /**
     * Show the bookings management page
     *
     * Displays and manages the provider's activity bookings.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showBookings(Request $request)
    {
        try {
            $user = Auth::user();
            $shopInfo = ShopInfo::where('user_id', $user->id)->first();

            if (!$shopInfo) {
                return redirect()->route('provider.shop-info')->with('error', 'Please complete your shop information before managing bookings.');
            }

            return view('provider.bookings', [
                'user' => $user,
                'shopInfo' => $shopInfo
            ]);
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Error loading bookings: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Error loading bookings: ' . $e->getMessage());
        }
    }

    /**
     * Show the activities management page
     *
     * Displays and manages the provider's available activities.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showActivities(Request $request)
    {
        try {
            $user = Auth::user();
            $shopInfo = $user->shopInfo;

            if (!$shopInfo) {
                // No shop info, so no activities
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'activities' => []
                    ]);
                }

                return view('provider.simple-activities', [
                    'user' => $user,
                    'activities' => []
                ]);
            }

            // Get activities for this provider
            $activities = Activity::where('shop_info_id', $shopInfo->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'activities' => $activities,
                    'activity_types' => Activity::getActivityTypes(),
                    'price_types' => Activity::getPriceTypes()
                ]);
            }

            return view('provider.simple-activities', [
                'user' => $user,
                'activities' => $activities,
                'activityTypes' => Activity::getActivityTypes(),
                'priceTypes' => Activity::getPriceTypes()
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load activities',
                    'error' => $e->getMessage()
                ], 500);
            }

            return view('provider.simple-activities', [
                'user' => Auth::user(),
                'activities' => [],
                'error' => 'An error occurred while retrieving activities.'
            ]);
        }
    }

    /**
     * Show the pricing management page
     *
     * Displays and manages the provider's pricing information.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showPricing(Request $request)
    {
        try {
            $user = Auth::user();
            $shopInfo = $user->shopInfo;

            if (!$shopInfo) {
                // No shop info, so no pricing info
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'pricing_info' => null
                    ]);
                }

                return view('provider.pricing', [
                    'user' => $user,
                    'pricingInfo' => null
                ]);
            }

            // Get activities with pricing information
            $activities = Activity::where('shop_info_id', $shopInfo->id)
                ->select('id', 'name', 'price', 'price_type')
                ->orderBy('name')
                ->get();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'activities' => $activities,
                    'price_types' => Activity::getPriceTypes()
                ]);
            }

            return view('provider.pricing', [
                'user' => $user,
                'activities' => $activities,
                'priceTypes' => Activity::getPriceTypes()
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load pricing information',
                    'error' => $e->getMessage()
                ], 500);
            }

            return view('provider.pricing', [
                'user' => Auth::user(),
                'activities' => [],
                'error' => 'An error occurred while retrieving pricing information.'
            ]);
        }
    }

    /**
     * Show the activities creation page
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View
     */
    public function createActivity(Request $request)
    {
        try {
            $user = Auth::user();

            return view('provider.create-activity', [
                'user' => $user,
                'activityId' => null
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'An error occurred while loading the activity creation page. Please try again.'
            ]);
        }
    }

    /**
     * Show the activities edit page
     *
     * @param Request $request The incoming request
     * @param int $id The activity ID to edit
     * @return \Illuminate\View\View
     */
    public function editActivity(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $shopInfo = $user->shopInfo;

            if (!$shopInfo) {
                return redirect()->route('provider.activities')->with('error', 'You need to set up your shop information first.');
            }

            // Check if the activity exists and belongs to this provider
            $activity = Activity::where('id', $id)
                ->where('shop_info_id', $shopInfo->id)
                ->first();

            if (!$activity) {
                return redirect()->route('provider.activities')->with('error', 'Activity not found or does not belong to you.');
            }

            return view('provider.create-activity', [
                'user' => $user,
                'activityId' => $id
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'An error occurred while loading the activity edit page. Please try again.'
            ]);
        }
    }

    /**
     * Show the activity details page
     *
     * @param Request $request The incoming request
     * @param int $id The activity ID to view
     * @return \Illuminate\View\View
     */
    public function viewActivity($id)
    {
        try {
            $user = Auth::user();
            $shopInfo = $user->shopInfo;

            if (!$shopInfo) {
                return redirect()->route('provider.shop-info')
                    ->with('error', 'Please set up your shop information first.');
            }

            $activity = Activity::with('lots')->where('shop_info_id', $shopInfo->id)
                ->where('id', $id)
                ->firstOrFail();

            return view('provider.view-activity', [
                'activity' => $activity,
                'activityTypes' => Activity::getActivityTypes(),
                'priceTypes' => Activity::getPriceTypes(),
                'malaysianStates' => Activity::getMalaysianStates()
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Activity not found or you do not have permission to view it.');
        }
    }

    public function showBooking(Request $request, Booking $booking)
    {
        // Ensure the booking belongs to the provider
        $shopInfo = Auth::user()->shopInfo;
        if (!$shopInfo || $booking->activity->shop_info_id !== $shopInfo->id) {
            return redirect()->route('provider.bookings')->with('error', 'Booking not found or access denied.');
        }

        // Eager load necessary relationships, explicitly selecting activity_type
        $booking->load([
            'user',
            'activity' => function ($query) {
                $query->select('id', 'shop_info_id', 'activity_type', 'name', 'location' /* Add other needed fields */);
            },
            'lot' => function ($query) {
                $query->select('id', 'activity_id', 'name', 'description' /* Add other needed fields */);
            }
        ]);

        // --- TEMPORARY DEBUGGING ---
        /* logger('Debugging showBooking:', [
           'booking_id' => $booking->id,
           'activity_id' => $booking->activity_id,
           'activity_object_loaded' => $booking->relationLoaded('activity'),
           'activity_type_via_relation' => $booking->activity->activity_type ?? 'NULL via relation', // Direct access
           'activity_attributes' => $booking->activity ? $booking->activity->getAttributes() : 'Activity not loaded', // Raw attributes
           'lot_id' => $booking->lot_id,
           'lot_object_loaded' => $booking->relationLoaded('lot'),
           'lot_name_via_relation' => $booking->lot->name ?? 'NULL via relation',
           'lot_attributes' => $booking->lot ? $booking->lot->getAttributes() : 'Lot not loaded or N/A'
        ]); */
        // --- END DEBUGGING ---

        return view('provider.show-booking', [
            'user' => Auth::user(),
            'booking' => $booking
        ]);
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(['pending', 'confirmed', 'completed', 'cancelled'])],
        ]);

        // Ensure the booking belongs to the provider
        $shopInfo = Auth::user()->shopInfo;
        if (!$shopInfo || $booking->activity->shop_info_id !== $shopInfo->id) {
            return back()->with('error', 'Update failed. Booking not found or access denied.');
        }

        try {
            $booking->status = $validated['status'];
            $booking->save();
            return back()->with('success', 'Booking status updated successfully.');
        } catch (\Exception $e) {
            // Log the error
            logger()->error('Error updating booking status: ' . $e->getMessage(), ['booking_id' => $booking->id]);
            return back()->with('error', 'An error occurred while updating the booking status.');
        }
    }

    /**
     * Delete an activity
     *
     * @param int $id The activity ID to delete
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function deleteActivity($id)
    {
        try {
            $user = Auth::user();
            $shopInfo = $user->shopInfo;

            if (!$shopInfo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Shop information not found'
                ], 404);
            }

            // Check if activity exists and belongs to this provider
            $activity = Activity::where('id', $id)
                ->where('shop_info_id', $shopInfo->id)
                ->first();

            if (!$activity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Activity not found or does not belong to you'
                ], 404);
            }

            // Check if bookings exist for this activity
            $hasBookings = Booking::where('activity_id', $id)->exists();
            if ($hasBookings) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete activity with existing bookings'
                ], 400);
            }

            // Delete activity
            $activity->delete();

            return response()->json([
                'success' => true,
                'message' => 'Activity deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete activity',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
