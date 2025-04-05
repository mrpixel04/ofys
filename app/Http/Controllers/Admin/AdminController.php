<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ShopInfo;
use App\Models\Activity;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;

/**
 * Admin Controller
 *
 * Handles all admin-specific functionality including dashboard, user management,
 * provider management, and system settings.
 * Supports both web and API requests for future mobile app integration.
 *
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    /**
     * Show the admin dashboard
     *
     * Displays the main admin dashboard with statistics and overview.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function dashboard(Request $request)
    {
        try {
            // Get basic dashboard statistics
            $stats = [
                'users_count' => User::count(),
                'providers_count' => User::where('role', 'provider')->count(),
                'customers_count' => User::where('role', 'customer')->count(),
                'activities_count' => Activity::count(),
                'bookings_count' => Booking::count(),
                'pending_bookings_count' => Booking::where('status', 'pending')->count(),
                'completed_bookings_count' => Booking::where('status', 'completed')->count(),
                'cancelled_bookings_count' => Booking::where('status', 'cancelled')->count(),
            ];

            // Recent activities and bookings for the dashboard
            $recentActivities = Activity::orderBy('created_at', 'desc')->limit(5)->get();
            $recentBookings = Booking::orderBy('created_at', 'desc')->limit(5)->get();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'stats' => $stats,
                    'recent_activities' => $recentActivities,
                    'recent_bookings' => $recentBookings
                ]);
            }

            // Return the new simple-dashboard view without Livewire/Alpine
            return view('admin.simple-dashboard', [
                'stats' => $stats,
                'recentActivities' => $recentActivities,
                'recentBookings' => $recentBookings
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

            return view('admin.simple-dashboard', [
                'error' => 'An error occurred while loading the dashboard. Please try again.'
            ]);
        }
    }

    /**
     * Show the providers management page
     *
     * Displays and manages all providers in the system.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showProviders(Request $request)
    {
        try {
            // Get all providers with their shop info
            $providers = User::where('role', 'provider')
                ->with('shopInfo')
                ->orderBy('created_at', 'desc')
                ->get();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'providers' => $providers
                ]);
            }

            return view('admin.providers', [
                'providers' => $providers
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load providers',
                    'error' => $e->getMessage()
                ], 500);
            }

            return view('admin.providers', [
                'providers' => [],
                'error' => 'An error occurred while retrieving providers.'
            ]);
        }
    }

    /**
     * Show provider details
     *
     * Displays detailed information about a specific provider.
     *
     * @param Request $request The incoming request
     * @param int $id The provider ID
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showProviderDetails(Request $request, $id)
    {
        try {
            // Get provider with shop info and activities
            $provider = User::where('id', $id)
                ->where('role', 'provider')
                ->with('shopInfo.activities')
                ->firstOrFail();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'provider' => $provider
                ]);
            }

            return view('admin.providers.view', [
                'provider' => $provider
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Provider not found',
                    'error' => $e->getMessage()
                ], 404);
            }

            return redirect()->route('admin.providers')
                ->with('error', 'Provider not found.');
        }
    }

    /**
     * Show edit provider form
     *
     * Displays the form to edit a provider's information.
     *
     * @param Request $request The incoming request
     * @param int $id The provider ID
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function editProvider(Request $request, $id)
    {
        try {
            // Get provider with shop info
            $provider = User::where('id', $id)
                ->where('role', 'provider')
                ->with('shopInfo')
                ->firstOrFail();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'provider' => $provider
                ]);
            }

            return view('admin.providers.edit', [
                'provider' => $provider
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Provider not found',
                    'error' => $e->getMessage()
                ], 404);
            }

            return redirect()->route('admin.providers')
                ->with('error', 'Provider not found.');
        }
    }

    /**
     * Update provider information
     *
     * Processes provider update requests and handles validation.
     *
     * @param Request $request The incoming request
     * @param int $id The provider ID
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function updateProvider(Request $request, $id)
    {
        try {
            // Get provider with shop info
            $provider = User::where('id', $id)
                ->where('role', 'provider')
                ->with('shopInfo')
                ->firstOrFail();

            // Validate the incoming request for user data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $provider->id,
                'is_verified' => 'nullable|boolean',
            ]);

            // Update provider data
            User::where('id', $provider->id)->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Update shop verification status if shop info exists
            if ($provider->shopInfo && isset($validated['is_verified'])) {
                ShopInfo::where('id', $provider->shopInfo->id)->update([
                    'is_verified' => $validated['is_verified'] ? true : false,
                ]);
            }

            // Refresh provider data
            $provider = User::where('id', $id)
                ->with('shopInfo')
                ->first();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Provider updated successfully',
                    'provider' => $provider
                ]);
            }

            return redirect()->route('admin.providers.view', ['provider' => $provider->id])
                ->with('success', 'Provider updated successfully.');
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update provider',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withErrors([
                'error' => 'An error occurred while updating the provider. Please try again.'
            ])->withInput();
        }
    }

    /**
     * Show the customers management page
     *
     * Displays and manages all customers in the system.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showCustomers(Request $request)
    {
        try {
            // Get all customers
            $customers = User::where('role', 'customer')
                ->orderBy('created_at', 'desc')
                ->get();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'customers' => $customers
                ]);
            }

            return view('admin.customers', [
                'customers' => $customers
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load customers',
                    'error' => $e->getMessage()
                ], 500);
            }

            return view('admin.customers', [
                'customers' => [],
                'error' => 'An error occurred while retrieving customers.'
            ]);
        }
    }

    /**
     * Show the bookings management page
     *
     * Displays and manages all bookings in the system.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showBookings(Request $request)
    {
        try {
            // Get all bookings with relationships
            $bookings = Booking::with(['user', 'activity.shopInfo'])
                ->orderBy('created_at', 'desc')
                ->get();

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
     * Show the settings page
     *
     * Displays and manages system settings.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showSettings(Request $request)
    {
        try {
            // Load settings from config or database as needed
            $settings = [
                'site_name' => config('app.name'),
                'contact_email' => config('mail.from.address'),
                // Add more settings as needed
            ];

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'settings' => $settings
                ]);
            }

            return view('admin.settings', [
                'settings' => $settings
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load settings',
                    'error' => $e->getMessage()
                ], 500);
            }

            return view('admin.settings', [
                'error' => 'An error occurred while retrieving settings.'
            ]);
        }
    }

    /**
     * Update system settings
     *
     * Processes settings update requests.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function updateSettings(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'site_name' => 'required|string|max:255',
                'contact_email' => 'required|email|max:255',
                // Add more validation rules as needed
            ]);

            // Update settings in database or config as needed
            // For demonstration, we'll just return success

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Settings updated successfully'
                ]);
            }

            return redirect()->route('admin.settings')
                ->with('success', 'Settings updated successfully.');
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update settings',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withErrors([
                'error' => 'An error occurred while updating settings. Please try again.'
            ])->withInput();
        }
    }

    /**
     * Update admin panel language
     *
     * Changes the language for the admin panel
     *
     * @param Request $request The incoming request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateLanguage(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'language' => 'required|string|in:en,ms',
            ]);

            // Store the selected language in the session
            $language = $validated['language'];
            session(['locale' => $language]);

            // Force the App locale to update immediately
            app()->setLocale($language);

            return redirect()->route('admin.settings')
                ->with('success', __('admin.language_updated_successfully') . " ($language)");

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'An error occurred: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Show the activities management page for admin
     *
     * Displays all activities created by providers, with special handling for
     * camping/glamping activities to show their lots.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showActivities(Request $request)
    {
        try {
            // Get activities with provider info and lots
            $activities = Activity::with(['shopInfo.user', 'lots'])
                ->orderBy('created_at', 'desc')
                ->get();

            $activityTypeLabels = Activity::getActivityTypes();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'activities' => $activities,
                    'activityTypes' => $activityTypeLabels,
                ]);
            }

            return view('admin.providers.activities', [
                'activities' => $activities,
                'activityTypes' => $activityTypeLabels,
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

            return view('admin.providers.activities', [
                'error' => 'An error occurred while loading activities. Please try again.'
            ]);
        }
    }

    /**
     * Show detailed view of an activity for admin
     *
     * Displays all details about an activity including provider information
     * and lots for camping/glamping activities.
     *
     * @param int $id The activity ID
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showActivityDetails($id)
    {
        try {
            // Get activity with provider info and lots
            $activity = Activity::with(['shopInfo.user', 'lots'])
                ->findOrFail($id);

            $activityTypeLabels = Activity::getActivityTypes();

            return view('admin.providers.activity-details', [
                'activity' => $activity,
                'activityTypes' => $activityTypeLabels,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.providers.activities')
                ->with('error', 'Failed to load activity details: ' . $e->getMessage());
        }
    }

    /**
     * Show admin profile page
     *
     * Displays the admin user profile information and form to update it.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View
     */
    public function showProfile(Request $request)
    {
        try {
            $user = Auth::user();

            return view('admin.profile', [
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return view('admin.profile', [
                'error' => 'An error occurred while retrieving profile information: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Update admin profile
     *
     * Update the admin user's profile information
     *
     * @param Request $request The incoming request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            ]);

            // Update user
            User::where('id', Auth::id())->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            return redirect()->route('admin.profile')
                ->with('success', __('admin.profile_updated'));

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'An error occurred: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Update admin password
     *
     * Update the admin user's password
     *
     * @param Request $request The incoming request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'current_password' => 'required|current_password',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Update password
            User::where('id', Auth::id())->update([
                'password' => bcrypt($validated['password']),
            ]);

            return redirect()->route('admin.profile')
                ->with('success', __('admin.password_updated'));

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'An error occurred: ' . $e->getMessage()
            ])->withInput();
        }
    }
}
