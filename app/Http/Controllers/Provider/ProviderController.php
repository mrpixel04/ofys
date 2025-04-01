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

            return view('provider.profile', [
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

            return view('provider.profile', [
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
            $shopInfo = $user->shopInfo;

            if (!$shopInfo) {
                // No shop info, so no bookings
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'bookings' => []
                    ]);
                }

                return view('provider.bookings', [
                    'user' => $user,
                    'bookings' => []
                ]);
            }

            // Get bookings for this provider's activities
            $bookings = Booking::whereHas('activity', function($query) use ($shopInfo) {
                $query->where('shop_info_id', $shopInfo->id);
            })->orderBy('created_at', 'desc')->get();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'bookings' => $bookings
                ]);
            }

            return view('provider.bookings', [
                'user' => $user,
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

            return view('provider.bookings', [
                'user' => Auth::user(),
                'bookings' => [],
                'error' => 'An error occurred while retrieving bookings.'
            ]);
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

                return view('provider.activities', [
                    'user' => $user,
                    'activities' => []
                ]);
            }

            // Get activities for this provider
            $activities = Activity::where('shop_info_id', $shopInfo->id)
                ->orderBy('created_at', 'desc')
                ->get();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'activities' => $activities,
                    'activity_types' => Activity::getActivityTypes(),
                    'price_types' => Activity::getPriceTypes()
                ]);
            }

            return view('provider.activities', [
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

            return view('provider.activities', [
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
    public function viewActivity(Request $request, $id)
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

            return view('provider.view-activity', [
                'user' => $user,
                'activity' => $activity,
                'activityTypes' => Activity::getActivityTypes(),
                'priceTypes' => Activity::getPriceTypes()
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'An error occurred while loading the activity details. Please try again.'
            ]);
        }
    }
}
