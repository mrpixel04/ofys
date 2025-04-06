<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Activity;
use App\Models\Booking;
use App\Models\ShopInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProviderController extends Controller
{
    /**
     * Display the provider dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();
        $shopInfo = ShopInfo::where('user_id', Auth::id())->first();

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

        $totalBookingsCount = Booking::whereHas('activity', function($query) use ($shopInfo) {
            $query->where('shop_info_id', $shopInfo->id);
        })->count();

        // Get recent bookings
        $recentBookings = Booking::whereHas('activity', function($query) use ($shopInfo) {
            $query->where('shop_info_id', $shopInfo->id);
        })
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

        return view('provider.dashboard', [
            'user' => $user,
            'shopInfo' => $shopInfo,
            'stats' => [
                'activities_count' => $activitiesCount,
                'pending_bookings' => $pendingBookingsCount,
                'total_bookings' => $totalBookingsCount
            ],
            'recentBookings' => $recentBookings
        ]);
    }

    /**
     * Display the shop information page.
     *
     * @return \Illuminate\View\View
     */
    public function shopInfo()
    {
        return view('provider.shop-info');
    }

    /**
     * Update the shop information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateShopInfo(Request $request)
    {
        // To be implemented
        return redirect()->route('provider.shop-info')->with('success', 'Shop information updated successfully.');
    }

    /**
     * Display the bookings page.
     *
     * @return \Illuminate\View\View
     */
    public function bookings()
    {
        return view('provider.bookings');
    }

    /**
     * Display a specific booking.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\View\View
     */
    public function showBooking(Booking $booking)
    {
        return view('provider.booking-details', compact('booking'));
    }

    /**
     * Update a booking status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateBookingStatus(Request $request, Booking $booking)
    {
        // To be implemented
        return redirect()->route('provider.bookings.show', $booking->id)->with('success', 'Booking status updated successfully.');
    }

    /**
     * Display the activities page.
     *
     * @return \Illuminate\View\View
     */
    public function activities()
    {
        $user = Auth::user();
        $shopInfo = ShopInfo::where('user_id', Auth::id())->first();

        $activities = Activity::where('shop_info_id', $shopInfo->id ?? 0)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $activityTypes = Activity::getActivityTypes();

        return view('provider.activities', [
            'activities' => $activities,
            'activityTypes' => $activityTypes
        ]);
    }

    /**
     * Display the create activity form.
     *
     * @return \Illuminate\View\View
     */
    public function createActivity()
    {
        return view('provider.activities.create');
    }

    /**
     * Display a specific activity.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function viewActivity($id)
    {
        $activity = Activity::findOrFail($id);
        $activityTypes = Activity::getActivityTypes();
        return view('provider.activities.view', compact('activity', 'activityTypes'));
    }

    /**
     * Display the edit activity form.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function editActivity($id)
    {
        $activity = Activity::findOrFail($id);
        return view('provider.activities.edit', compact('activity'));
    }

    /**
     * Delete an activity.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteActivity($id)
    {
        $user = Auth::user();
        $shopInfo = ShopInfo::where('user_id', $user->id)->first();

        if (!$shopInfo) {
            return response()->json(['success' => false, 'message' => 'Shop information not found'], 404);
        }

        $activity = Activity::where('id', $id)
            ->where('shop_info_id', $shopInfo->id)
            ->first();

        if (!$activity) {
            return response()->json(['success' => false, 'message' => 'Activity not found or does not belong to you'], 404);
        }

        // Check if there are bookings for this activity
        // If implemented, add check here

        // Delete the activity
        $activity->delete();

        return response()->json(['success' => true, 'message' => 'Activity deleted successfully']);
    }

    /**
     * Display the pricing page.
     *
     * @return \Illuminate\View\View
     */
    public function showPricing()
    {
        return view('provider.pricing');
    }

    /**
     * Display the provider profile page.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('provider.profile', ['user' => Auth::user()]);
    }

    /**
     * Update the provider's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:1024'],
        ]);

        $dataToUpdate = [
            'name' => $request->name,
            'phone' => $request->phone,
        ];

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image) {
                Storage::delete($user->profile_image);
            }

            // Store new image
            $path = $request->file('profile_image')->store('profile-images', 'public');
            $dataToUpdate['profile_image'] = $path;
        }

        // Handle profile image removal
        if ($request->has('remove_profile_image') && $request->remove_profile_image && $user->profile_image) {
            Storage::delete($user->profile_image);
            $dataToUpdate['profile_image'] = null;
        }

        // Update the user record
        DB::table('users')
            ->where('id', $user->id)
            ->update($dataToUpdate);

        return redirect()->route('provider.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the provider's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update the password
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => Hash::make($request->password)
            ]);

        return redirect()->route('provider.profile')->with('success', 'Password updated successfully.');
    }
}
