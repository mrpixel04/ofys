<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
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
        $user = Auth::user();
        $shopInfo = ShopInfo::where('user_id', $user->id)->first();

        return view('provider.shop-info', compact('shopInfo'));
    }

    /**
     * Update the shop information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateShopInfo(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'shop_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get existing shop info to preserve images if not updated
        $existingShopInfo = ShopInfo::where('user_id', $user->id)->first();

        // Prepare data for update
        $updateData = [
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'description' => $request->description,
            'phone' => $request->phone,
            'website' => $request->website,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country ?? 'Malaysia',
        ];

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($existingShopInfo && $existingShopInfo->logo) {
                Storage::disk('public')->delete($existingShopInfo->logo);
            }

            $logoFile = $request->file('logo');
            $logoName = time() . '_' . $user->id . '_logo.' . $logoFile->getClientOriginalExtension();
            $logoPath = $logoFile->storeAs('logos', $logoName, 'public');
            $updateData['logo'] = $logoPath;
        }

        // Handle shop image upload
        if ($request->hasFile('shop_image')) {
            // Delete old shop image if exists
            if ($existingShopInfo && $existingShopInfo->shop_image) {
                Storage::disk('public')->delete($existingShopInfo->shop_image);
            }

            $shopImageFile = $request->file('shop_image');
            $shopImageName = time() . '_' . $user->id . '_shop.' . $shopImageFile->getClientOriginalExtension();
            $shopImagePath = $shopImageFile->storeAs('shop_images', $shopImageName, 'public');
            $updateData['shop_image'] = $shopImagePath;
        }

        $shopInfo = ShopInfo::updateOrCreate(
            ['user_id' => $user->id],
            $updateData
        );

        return redirect()->route('provider.shop-info')->with('success', 'Shop information updated successfully.');
    }

    /**
     * Display the bookings page.
     *
     * @return \Illuminate\View\View
     */
    public function bookings()
    {
        $user = Auth::user();
        $shopInfo = ShopInfo::where('user_id', $user->id)->first();

        if (!$shopInfo) {
            return redirect()->route('provider.shop-info')
                ->with('error', 'Please complete your shop information before managing bookings.');
        }

        // Get all bookings for this provider
        $bookings = Booking::whereHas('activity', function($query) use ($shopInfo) {
                $query->where('shop_info_id', $shopInfo->id);
            })
            ->with(['user', 'activity', 'lot'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Count bookings by status
        $pendingBookings = $bookings->where('status', 'pending')->count();
        $confirmedBookings = $bookings->where('status', 'confirmed')->count();
        $completedBookings = $bookings->where('status', 'completed')->count();
        $totalBookings = $bookings->count();

        return view('provider.bookings', [
            'bookings' => $bookings,
            'pendingBookings' => $pendingBookings,
            'confirmedBookings' => $confirmedBookings,
            'completedBookings' => $completedBookings,
            'totalBookings' => $totalBookings
        ]);
    }

    /**
     * Display a specific booking.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\View\View
     */
    public function showBooking(Booking $booking)
    {
        return view('provider.simple-booking-details', compact('booking'));
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
        $user = Auth::user();
        $shopInfo = ShopInfo::where('user_id', $user->id)->first();

        // Check if booking belongs to this provider
        $isBookingValid = $booking->activity && $booking->activity->shop_info_id == $shopInfo->id;

        if (!$isBookingValid) {
            return redirect()->route('provider.bookings')->with('error', 'You do not have permission to update this booking.');
        }

        // Validate requested status
        $request->validate([
            'status' => ['required', 'string', 'in:pending,confirmed,cancelled,completed']
        ]);

        $newStatus = $request->status;
        $oldStatus = $booking->status;

        // Update booking status
        $booking->status = $newStatus;
        $booking->save();

        // Format messages based on status change
        $statusMessages = [
            'pending' => 'Booking has been marked as pending.',
            'confirmed' => 'Booking has been confirmed successfully.',
            'cancelled' => 'Booking has been cancelled.',
            'completed' => 'Booking has been marked as completed.'
        ];

        return redirect()->route('provider.bookings.show', $booking->id)
            ->with('success', $statusMessages[$newStatus] ?? 'Booking status updated successfully.');
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

        return view('provider.simple-activities', [
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
        $user = Auth::user();
        return view('provider.profile', compact('user'));
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
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        // Update the user record
        User::where('id', $user->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

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
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::where('id', Auth::id())->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('provider.profile')->with('success', 'Password updated successfully.');
    }

    /**
     * Display the simplified activities page with a modern UI.
     *
     * @return \Illuminate\View\View
     */
    public function simpleActivities()
    {
        $user = Auth::user();
        $shopInfo = ShopInfo::where('user_id', Auth::id())->first();

        $activities = Activity::where('shop_info_id', $shopInfo->id ?? 0)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $activityTypes = Activity::getActivityTypes();

        return view('provider.simple-activities', [
            'activities' => $activities,
            'activityTypes' => $activityTypes
        ]);
    }
}
