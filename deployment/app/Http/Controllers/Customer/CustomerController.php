<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

/**
 * Customer Controller
 *
 * Handles customer-specific functionality including profile management
 * and account settings. Supports both web and API requests.
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
}
