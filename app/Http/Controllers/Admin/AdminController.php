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
            $recentActivities = Activity::with(['shopInfo.user'])->orderBy('created_at', 'desc')->limit(5)->get();
            $recentBookings = Booking::with(['user', 'activity'])->orderBy('created_at', 'desc')->limit(5)->get();

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
                ->whereRaw('LOWER(role) = ?', ['provider'])
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
     * @param int|string $id The provider ID or 'new' for a new provider
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function editProvider(Request $request, $id)
    {
        // If id is 'new', return the create form
        if ($id === 'new') {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'provider' => null
                ]);
            }

            return view('admin.providers.edit');
        }

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
     * @param int|string $id The provider ID or 'new' for a new provider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function updateProvider(Request $request, $id)
    {
        // If id is 'new', create a new provider
        if ($id === 'new') {
            try {
                // Validate the request data
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|max:255|unique:users,email',
                    'username' => 'nullable|string|max:255|unique:users,username',
                    'password' => 'required|string|min:8',
                    'phone' => 'nullable|string|max:20',
                    'status' => 'nullable|string|in:active,inactive,pending',
                    'company_name' => 'nullable|string|max:255',
                    'company_email' => 'nullable|email',
                    'business_type' => 'nullable|string|max:255',
                    'description' => 'nullable|string',
                    'address' => 'nullable|string',
                    'city' => 'nullable|string',
                    'state' => 'nullable|string',
                    'postal_code' => 'nullable|string',
                    'country' => 'nullable|string',
                    'is_verified' => 'nullable|boolean',
                ]);

                // Create user with provider role
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username ?? strtolower(explode(' ', $request->name)[0] . rand(100, 999)),
                    'password' => bcrypt($request->password),
                    'role' => 'PROVIDER',
                    'phone' => $request->phone,
                    'status' => $request->status ?? 'active',
                ]);

                // Create shop info if company details provided
                if ($request->company_name || $request->has('is_verified')) {
                    $shopInfo = ShopInfo::create([
                        'user_id' => $user->id,
                        'company_name' => $request->company_name,
                        'company_email' => $request->company_email ?? $request->email,
                        'business_type' => $request->business_type,
                        'description' => $request->description,
                        'address' => $request->address,
                        'city' => $request->city,
                        'state' => $request->state,
                        'postal_code' => $request->postal_code,
                        'country' => $request->country,
                        'phone' => $request->phone,
                        'is_verified' => $request->has('is_verified'),
                    ]);
                }

                return redirect()->route('admin.simple-providers-basic')
                    ->with('success', 'Provider created successfully.');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to create provider: ' . $e->getMessage());
            }
        }

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
                'username' => 'nullable|string|max:255|unique:users,username,' . $provider->id,
                'password' => 'nullable|string|min:8',
                'phone' => 'nullable|string|max:20',
                'status' => 'nullable|string|in:active,inactive,pending',
                'company_name' => 'nullable|string|max:255',
                'company_email' => 'nullable|email',
                'business_type' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'state' => 'nullable|string',
                'postal_code' => 'nullable|string',
                'country' => 'nullable|string',
                'is_verified' => 'nullable|boolean',
            ]);

            // Update user data
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status,
            ];

            if ($request->username) {
                $userData['username'] = $request->username;
            }

            if ($request->password) {
                $userData['password'] = bcrypt($request->password);
            }

            User::where('id', $provider->id)->update($userData);

            // Update or create shop info
            if ($provider->shopInfo) {
                $shopData = [
                    'company_name' => $request->company_name,
                    'company_email' => $request->company_email,
                    'business_type' => $request->business_type,
                    'description' => $request->description,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'postal_code' => $request->postal_code,
                    'country' => $request->country,
                    'is_verified' => $request->has('is_verified'),
                ];

                ShopInfo::where('id', $provider->shopInfo->id)->update($shopData);
            }
            // Create shop info if it doesn't exist but data provided
            else if ($request->company_name || $request->has('is_verified')) {
                ShopInfo::create([
                    'user_id' => $provider->id,
                    'company_name' => $request->company_name,
                    'company_email' => $request->company_email ?? $provider->email,
                    'business_type' => $request->business_type,
                    'description' => $request->description,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'postal_code' => $request->postal_code,
                    'country' => $request->country,
                    'phone' => $request->phone ?? $provider->phone,
                    'is_verified' => $request->has('is_verified'),
                ]);
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Provider updated successfully',
                ]);
            }

            return redirect()->route('admin.simple-providers-basic')
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

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update provider: ' . $e->getMessage());
        }
    }

    /**
     * Show the customers management page
     *
     * Displays and manages all customers in the system.
     * Enhanced to match Livewire CustomersList component functionality.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showCustomers(Request $request)
    {
        try {
            $query = User::where('role', 'CUSTOMER');

            // Apply search filter (matches Livewire search)
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            }

            // Apply status filter (matches Livewire statusFilter)
            if ($request->filled('statusFilter')) {
                $query->where('status', $request->statusFilter);
            }

            // Apply date filter (matches Livewire dateFilter)
            if ($request->filled('dateFilter')) {
                $dateFilter = $request->dateFilter;
                $now = now();
                switch ($dateFilter) {
                    case 'today':
                        $query->whereDate('created_at', $now->toDateString());
                        break;
                    case 'week':
                        $query->whereBetween('created_at', [$now->startOfWeek()->toDateString(), $now->endOfWeek()->toDateString()]);
                        break;
                    case 'month':
                        $query->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year);
                        break;
                    case 'year':
                        $query->whereYear('created_at', $now->year);
                        break;
                }
            }

            // Get customers with pagination (matches Livewire pagination)
            $customers = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
            $total = $customers->total();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'customers' => $customers,
                    'total' => $total
                ]);
            }

            return view('admin.customers', [
                'customers' => $customers,
                'total' => $total
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
                'customers' => collect([]),
                'total' => 0,
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
     * Show all activities for admin (Non-Livewire implementation)
     *
     * Displays all activities with filtering and pagination
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View
     */
    public function showActivities(Request $request)
    {
        try {
            // Start query builder for activities
            $query = Activity::with(['shopInfo.user']);

            // Apply filters from request
            // Search filter for activity name or location
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
                });
            }

            // Provider search filter
            if ($request->has('providerSearch') && !empty($request->providerSearch)) {
                $providerSearch = $request->providerSearch;
                $query->whereHas('shopInfo.user', function($q) use ($providerSearch) {
                    $q->where('name', 'like', "%{$providerSearch}%")
                      ->orWhere('email', 'like', "%{$providerSearch}%");
                });
            }

            // Category filter
            if ($request->has('categoryFilter') && !empty($request->categoryFilter)) {
                $query->where('activity_type', $request->categoryFilter);
            }

            // Status filter
            if ($request->has('statusFilter') && !empty($request->statusFilter)) {
                $isActive = $request->statusFilter === 'active';
                $query->where('is_active', $isActive);
            }

            // Get paginated results
            $activities = $query->latest()->paginate(9);

            // Get activity types for filter dropdown
            $activityTypes = Activity::getActivityTypes();

            return view('admin.providers.activities', [
                'activities' => $activities,
                'activityTypes' => $activityTypes
            ]);
        } catch (\Exception $e) {
            return view('admin.providers.activities', [
                'activities' => collect([]),
                'activityTypes' => Activity::getActivityTypes(),
                'error' => 'An error occurred while loading activities: ' . $e->getMessage()
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
     * Toggle activity status (active/inactive)
     *
     * @param int $id Activity ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleActivityStatus($id)
    {
        try {
            $activity = Activity::findOrFail($id);
            $activity->is_active = !$activity->is_active;
            $activity->save();

            $status = $activity->is_active ? 'activated' : 'deactivated';
            return redirect()->back()->with('success', "Activity has been {$status} successfully.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update activity status: ' . $e->getMessage());
        }
    }

    /**
     * Delete an activity
     *
     * @param int $id Activity ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteActivity($id)
    {
        try {
            $activity = Activity::findOrFail($id);
            $activity->delete();

            return redirect()->route('admin.providers.activities')->with('success', 'Activity deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.providers.activities')->with('error', 'Failed to delete activity: ' . $e->getMessage());
        }
    }

    /**
     * Show activity edit form
     *
     * @param int $id Activity ID
     * @return \Illuminate\View\View
     */
    public function editActivity($id)
    {
        try {
            // Get activity with provider info and lots
            $activity = Activity::with(['shopInfo.user', 'lots'])
                ->findOrFail($id);

            $activityTypeLabels = Activity::getActivityTypes();
            $malaysianStates = Activity::getMalaysianStates();

            return view('admin.providers.activity-edit', [
                'activity' => $activity,
                'activityTypes' => $activityTypeLabels,
                'malaysianStates' => $malaysianStates,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.providers.activities')
                ->with('error', 'Failed to load activity for editing: ' . $e->getMessage());
        }
    }

    /**
     * Show activity creation form
     *
     * @return \Illuminate\View\View
     */
    public function createActivity()
    {
        try {
            $activityTypeLabels = Activity::getActivityTypes();
            $malaysianStates = Activity::getMalaysianStates();

            return view('admin.providers.activity-create', [
                'activityTypes' => $activityTypeLabels,
                'malaysianStates' => $malaysianStates,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.providers.activities')
                ->with('error', 'Failed to load activity creation form: ' . $e->getMessage());
        }
    }

    /**
     * Store a new activity
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeActivity(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'shop_info_id' => 'required|exists:shop_infos,id',
                'activity_type' => 'required|string',
                'description' => 'required|string',
                'requirements' => 'nullable|string',
                'location' => 'required|string|max:255',
                'state' => 'required|string|max:100',
                'price' => 'required|numeric|min:0',
                'price_type' => 'required|string',
                'duration_minutes' => 'nullable|integer|min:0',
                'min_participants' => 'required|integer|min:1',
                'max_participants' => 'nullable|integer|min:1',
                'is_active' => 'nullable|boolean',
                'included_items' => 'nullable|array',
                'excluded_items' => 'nullable|array',
                'amenities' => 'nullable|array',
                'rules' => 'nullable|array',
                'cancelation_policy' => 'nullable|string',
                'activity_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'lots' => 'nullable|array',
                'lots.*.name' => 'required_if:activity_type,camping,glamping|string|max:255',
                'lots.*.capacity' => 'required_if:activity_type,camping,glamping|integer|min:1',
                'lots.*.description' => 'nullable|string',
                'lots.*.is_available' => 'nullable|boolean',
            ]);

            // Handle arrays
            $arrayFields = ['included_items', 'excluded_items', 'amenities', 'rules'];
            $activityData = $validated;

            foreach ($arrayFields as $field) {
                if (!isset($activityData[$field])) {
                    $activityData[$field] = [];
                }
            }

            // Handle is_active checkbox
            $activityData['is_active'] = $request->has('is_active');

            // Handle image uploads if any
            if ($request->hasFile('activity_images')) {
                $images = [];

                foreach ($request->file('activity_images') as $image) {
                    $path = $image->store('activity_images', 'public');
                    $images[] = $path;
                }

                $activityData['images'] = $images;
            }

            // Remove lots data from activity data
            $lotsData = $request->has('lots') ? $request->lots : null;
            unset($activityData['lots']);

            // Create activity
            $activity = Activity::create($activityData);

            // Handle lots for camping/glamping activities
            if (in_array($activity->activity_type, ['camping', 'glamping']) && $lotsData) {
                foreach ($lotsData as $lot) {
                    // Create the lot
                    $activity->lots()->create([
                        'provider_id' => $activity->shopInfo->user_id,
                        'name' => $lot['name'],
                        'capacity' => $lot['capacity'],
                        'description' => $lot['description'] ?? null,
                        'is_available' => isset($lot['is_available']),
                    ]);
                }
            }

            return redirect()->route('admin.providers.activities.show', $activity->id)
                ->with('success', 'Activity created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create activity: ' . $e->getMessage());
        }
    }

    /**
     * Update an activity
     *
     * @param Request $request
     * @param int $id Activity ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateActivity(Request $request, $id)
    {
        try {
            $activity = Activity::findOrFail($id);

            // Validate the request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'activity_type' => 'required|string',
                'description' => 'required|string',
                'requirements' => 'nullable|string',
                'location' => 'required|string|max:255',
                'state' => 'required|string|max:100',
                'price' => 'required|numeric|min:0',
                'price_type' => 'required|string',
                'duration_minutes' => 'nullable|integer|min:0',
                'min_participants' => 'required|integer|min:1',
                'max_participants' => 'nullable|integer|min:1',
                'is_active' => 'nullable|boolean',
                'included_items' => 'nullable|array',
                'excluded_items' => 'nullable|array',
                'amenities' => 'nullable|array',
                'rules' => 'nullable|array',
                'cancelation_policy' => 'nullable|string',
                'activity_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'lots' => 'nullable|array',
                'lots.*.id' => 'nullable|exists:activity_lots,id',
                'lots.*.name' => 'required_if:activity_type,camping,glamping|string|max:255',
                'lots.*.capacity' => 'required_if:activity_type,camping,glamping|integer|min:1',
                'lots.*.description' => 'nullable|string',
                'lots.*.is_available' => 'nullable|boolean',
            ]);

            // Handle arrays
            $arrayFields = ['included_items', 'excluded_items', 'amenities', 'rules'];
            $updateData = $validated;

            foreach ($arrayFields as $field) {
                if (!isset($updateData[$field])) {
                    $updateData[$field] = [];
                }
            }

            // Handle is_active checkbox
            $updateData['is_active'] = $request->has('is_active');

            // Handle image uploads if any
            if ($request->hasFile('activity_images')) {
                $images = [];

                // Keep existing images if any
                if ($activity->images) {
                    $images = $activity->images;
                }

                foreach ($request->file('activity_images') as $image) {
                    $path = $image->store('activity_images', 'public');
                    $images[] = $path;
                }

                $updateData['images'] = $images;
            }

            // Handle image removal if requested
            if ($request->has('remove_images') && is_array($request->remove_images)) {
                $currentImages = $activity->images ?? [];
                $imagesToKeep = array_diff($currentImages, $request->remove_images);
                $updateData['images'] = array_values($imagesToKeep);
            }

            // Remove lots data from activity data
            $lotsData = $request->has('lots') ? $request->lots : null;
            unset($updateData['lots']);

            // Update activity
            $activity->update($updateData);

            // Handle lots for camping/glamping activities
            if (in_array($activity->activity_type, ['camping', 'glamping']) && $lotsData) {
                // Get existing lot IDs
                $existingLotIds = $activity->lots->pluck('id')->toArray();
                $updatedLotIds = [];

                // Create/update lots
                foreach ($lotsData as $lot) {
                    if (isset($lot['id'])) {
                        // Update existing lot
                        $activityLot = $activity->lots()->find($lot['id']);
                        if ($activityLot) {
                            $activityLot->update([
                                'name' => $lot['name'],
                                'capacity' => $lot['capacity'],
                                'description' => $lot['description'] ?? null,
                                'is_available' => isset($lot['is_available']),
                            ]);
                            $updatedLotIds[] = $lot['id'];
                        }
                    } else {
                        // Create new lot
                        $newLot = $activity->lots()->create([
                            'provider_id' => $activity->shopInfo->user_id,
                            'name' => $lot['name'],
                            'capacity' => $lot['capacity'],
                            'description' => $lot['description'] ?? null,
                            'is_available' => isset($lot['is_available']),
                        ]);
                        $updatedLotIds[] = $newLot->id;
                    }
                }

                // Delete lots that weren't updated
                $lotsToDelete = array_diff($existingLotIds, $updatedLotIds);
                if (!empty($lotsToDelete)) {
                    $activity->lots()->whereIn('id', $lotsToDelete)->delete();
                }
            } else if (!in_array($activity->activity_type, ['camping', 'glamping'])) {
                // If activity type was changed from camping/glamping, delete all lots
                $activity->lots()->delete();
            }

            return redirect()->route('admin.providers.activities.show', $id)
                ->with('success', 'Activity updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update activity: ' . $e->getMessage());
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
                'phone' => 'nullable|string|max:20',
                'profile_image' => 'nullable|image|max:2048', // 2MB max
            ]);

            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? Auth::user()->phone,
            ];

            // Handle profile image upload if provided
            if ($request->hasFile('profile_image')) {
                $imagePath = $request->file('profile_image')->store('profile_images', 'public');
                $userData['profile_image'] = $imagePath;
            }

            // Update user
            User::where('id', Auth::id())->update($userData);

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

    /**
     * Show admin profile page using simple template (non-Livewire)
     *
     * Displays the admin user profile information and form to update it.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View
     */
    public function showSimpleProfile(Request $request)
    {
        try {
            $user = Auth::user();

            return view('admin.simple-profile', [
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return view('admin.simple-profile', [
                'error' => 'An error occurred while retrieving profile information: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show the simple providers management page
     *
     * Displays and manages all providers in the system using a non-Livewire approach.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function showSimpleProviders(Request $request)
    {
        try {
            $query = User::where('role', 'PROVIDER')->with('shopInfo');

            // Handle search
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%");
                });
            }

            // Handle status filter
            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }

            // Handle date filter
            if ($request->has('date_filter') && !empty($request->date_filter)) {
                $dateFilter = $request->date_filter;
                if ($dateFilter === 'today') {
                    $query->whereDate('created_at', now()->toDateString());
                } elseif ($dateFilter === 'week') {
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                } elseif ($dateFilter === 'month') {
                    $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                } elseif ($dateFilter === 'year') {
                    $query->whereYear('created_at', now()->year);
                }
            }

            // Get providers with pagination
            $providers = $query->orderBy('created_at', 'desc')->paginate(15);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'providers' => $providers
                ]);
            }

            return view('admin.simple-providers', [
                'providers' => $providers
            ]);
        } catch (\Exception $e) {
            // Error handling
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load providers',
                    'error' => $e->getMessage()
                ], 500);
            }

            return view('admin.simple-providers', [
                'providers' => [],
                'error' => 'An error occurred while retrieving providers: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show a basic version of the providers management page
     *
     * Displays a simplified list of providers without complex functionality.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\View\View
     */
    public function showSimpleProvidersBasic(Request $request)
    {
        try {
            $query = User::where('role', 'PROVIDER')->with('shopInfo');

            // Handle search
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%");
                });
            }

            // Handle status filter
            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }

            // Get providers with pagination
            $providers = $query->orderBy('created_at', 'desc')->paginate(15);

            return view('admin.simple-providers-basic', [
                'providers' => $providers
            ]);
        } catch (\Exception $e) {
            return view('admin.simple-providers-basic', [
                'providers' => collect(),
                'error' => 'An error occurred while retrieving providers: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get provider details (API)
     *
     * @param int $id Provider ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProviderDetails($id)
    {
        try {
            $provider = User::where('id', $id)
                ->where('role', 'PROVIDER')
                ->with('shopInfo')
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'provider' => $provider
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Provider not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Store a new provider (API)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeProvider(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'username' => 'nullable|string|max:255|unique:users,username',
                'password' => 'required|string|min:8',
                'phone' => 'nullable|string|max:20',
                'status' => 'nullable|string|in:active,inactive,pending',
                'company_name' => 'nullable|string|max:255',
                'company_email' => 'nullable|email',
                'business_type' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'state' => 'nullable|string',
                'postal_code' => 'nullable|string',
                'country' => 'nullable|string',
            ]);

            // Create user with provider role
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username ?? strtolower(explode(' ', $request->name)[0] . rand(100, 999)),
                'password' => bcrypt($request->password),
                'role' => 'PROVIDER',
                'phone' => $request->phone,
                'status' => $request->status ?? 'active',
            ]);

            // Create shop info if company details provided
            if ($request->company_name) {
                $shopInfo = ShopInfo::create([
                    'user_id' => $user->id,
                    'company_name' => $request->company_name,
                    'company_email' => $request->company_email ?? $request->email,
                    'business_type' => $request->business_type,
                    'description' => $request->description,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'postal_code' => $request->postal_code,
                    'country' => $request->country,
                    'phone' => $request->phone,
                    'is_verified' => false,
                ]);
            }

            // Refresh user with shop info
            $user = User::with('shopInfo')->find($user->id);

            return response()->json([
                'success' => true,
                'message' => 'Provider created successfully',
                'provider' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create provider',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update provider (API)
     *
     * @param Request $request
     * @param int $id Provider ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProviderApi(Request $request, $id)
    {
        try {
            // Find provider
            $provider = User::where('id', $id)
                ->where('role', 'PROVIDER')
                ->with('shopInfo')
                ->firstOrFail();

            // Validate request
            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $provider->id,
                'username' => 'nullable|string|max:255|unique:users,username,' . $provider->id,
                'password' => 'nullable|string|min:8',
                'phone' => 'nullable|string|max:20',
                'status' => 'nullable|string|in:active,inactive,pending',
                'company_name' => 'nullable|string|max:255',
                'company_email' => 'nullable|email',
                'business_type' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'state' => 'nullable|string',
                'postal_code' => 'nullable|string',
                'country' => 'nullable|string',
                'is_verified' => 'nullable|boolean',
            ]);

            // Update user data
            $userData = [];

            if ($request->has('name')) $userData['name'] = $request->name;
            if ($request->has('email')) $userData['email'] = $request->email;
            if ($request->has('username')) $userData['username'] = $request->username;
            if ($request->has('phone')) $userData['phone'] = $request->phone;
            if ($request->has('status')) $userData['status'] = $request->status;
            if ($request->has('password')) $userData['password'] = bcrypt($request->password);

            if (count($userData) > 0) {
                User::where('id', $provider->id)->update($userData);
            }

            // Update shop info if exists
            if ($provider->shopInfo) {
                $shopData = [];

                if ($request->has('company_name')) $shopData['company_name'] = $request->company_name;
                if ($request->has('company_email')) $shopData['company_email'] = $request->company_email;
                if ($request->has('business_type')) $shopData['business_type'] = $request->business_type;
                if ($request->has('description')) $shopData['description'] = $request->description;
                if ($request->has('address')) $shopData['address'] = $request->address;
                if ($request->has('city')) $shopData['city'] = $request->city;
                if ($request->has('state')) $shopData['state'] = $request->state;
                if ($request->has('postal_code')) $shopData['postal_code'] = $request->postal_code;
                if ($request->has('country')) $shopData['country'] = $request->country;
                if ($request->has('is_verified')) $shopData['is_verified'] = $request->is_verified;

                if (count($shopData) > 0) {
                    ShopInfo::where('id', $provider->shopInfo->id)->update($shopData);
                }
            }
            // Create shop info if it doesn't exist but data provided
            else if ($request->has('company_name')) {
                ShopInfo::create([
                    'user_id' => $provider->id,
                    'company_name' => $request->company_name,
                    'company_email' => $request->company_email ?? $provider->email,
                    'business_type' => $request->business_type,
                    'description' => $request->description,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'postal_code' => $request->postal_code,
                    'country' => $request->country,
                    'phone' => $request->phone ?? $provider->phone,
                    'is_verified' => $request->is_verified ?? false,
                ]);
            }

            // Refresh provider with shop info
            $provider = User::with('shopInfo')->find($provider->id);

            return response()->json([
                'success' => true,
                'message' => 'Provider updated successfully',
                'provider' => $provider
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update provider',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete provider (API)
     *
     * @param int $id Provider ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteProvider($id)
    {
        try {
            // Find provider
            $provider = User::where('id', $id)
                ->where('role', 'PROVIDER')
                ->firstOrFail();

            // Delete shop info if exists (will cascade delete activities)
            if ($provider->shopInfo) {
                $provider->shopInfo->delete();
            }

            // Delete user
            $provider->delete();

            return response()->json([
                'success' => true,
                'message' => 'Provider deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete provider',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show API Documentation
     *
     * Displays embedded Swagger API documentation for Admin, Customer, and Provider APIs
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showApiDocumentation(Request $request)
    {
        return view('admin.developers.api');
    }

    /**
     * Show Integration Settings
     *
     * Displays integration settings for WhatsApp Web.js and N8N
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showIntegration(Request $request)
    {
        // Get existing integration settings from database or config
        $integrations = [
            'whatsapp' => [
                'api_url' => config('services.whatsapp.api_url', ''),
                'webhook_url' => config('services.whatsapp.webhook_url', ''),
                'api_key' => config('services.whatsapp.api_key', ''),
                'secret_key' => config('services.whatsapp.secret_key', ''),
                'qr_endpoint' => config('services.whatsapp.qr_endpoint', ''),
                'session_active' => false, // Check session status
            ],
            'n8n' => [
                'api_url' => config('services.n8n.api_url', ''),
                'webhook_url' => config('services.n8n.webhook_url', ''),
                'api_key' => config('services.n8n.api_key', ''),
                'workflow_id' => config('services.n8n.workflow_id', ''),
            ],
        ];

        return view('admin.developers.integration', compact('integrations'));
    }

    /**
     * Update WhatsApp Integration Settings
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateWhatsAppIntegration(Request $request)
    {
        $request->validate([
            'api_url' => 'required|url',
            'webhook_url' => 'nullable|url',
            'api_key' => 'required|string',
            'secret_key' => 'nullable|string',
            'qr_endpoint' => 'nullable|url',
        ]);

        try {
            // Save to config or database
            // For now, we'll return success
            // In production, save to database or .env file

            return response()->json([
                'success' => true,
                'message' => 'WhatsApp integration settings updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update WhatsApp settings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update N8N Integration Settings
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateN8NIntegration(Request $request)
    {
        $request->validate([
            'api_url' => 'required|url',
            'webhook_url' => 'nullable|url',
            'api_key' => 'required|string',
            'workflow_id' => 'nullable|string',
        ]);

        try {
            // Save to config or database
            // For now, we'll return success
            // In production, save to database or .env file

            return response()->json([
                'success' => true,
                'message' => 'N8N integration settings updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update N8N settings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show WhatsApp Messages Management
     *
     * Displays all WhatsApp messages from BuzzBridge integration
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showWhatsAppMessages(Request $request)
    {
        // In production, fetch messages from database
        // For now, return empty array
        $messages = [];

        return view('admin.whatsapp.messages', compact('messages'));
    }

    /**
     * Fetch WhatsApp Messages from BuzzBridge
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchWhatsAppMessages(Request $request)
    {
        try {
            $apiUrl = config('services.whatsapp.api_url');
            $apiKey = config('services.whatsapp.api_key');

            if (!$apiUrl || !$apiKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'WhatsApp integration not configured'
                ], 400);
            }

            // In production, make API call to BuzzBridge
            // Example: $response = Http::withHeaders(['Authorization' => "Bearer {$apiKey}"])->get("{$apiUrl}/messages");

            // Mock response for now
            $messages = [
                [
                    'id' => 1,
                    'from' => '+60123456789',
                    'name' => 'John Doe',
                    'message' => 'Hi, I want to book a hiking trip',
                    'timestamp' => now()->subMinutes(5)->toIso8601String(),
                    'status' => 'unread'
                ],
                [
                    'id' => 2,
                    'from' => '+60198765432',
                    'name' => 'Jane Smith',
                    'message' => 'What are the available activities?',
                    'timestamp' => now()->subMinutes(10)->toIso8601String(),
                    'status' => 'unread'
                ]
            ];

            return response()->json([
                'success' => true,
                'messages' => $messages
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch messages',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reply to WhatsApp Message
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function replyWhatsAppMessage(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string',
        ]);

        try {
            $apiUrl = config('services.whatsapp.api_url');
            $apiKey = config('services.whatsapp.api_key');

            if (!$apiUrl || !$apiKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'WhatsApp integration not configured'
                ], 400);
            }

            // In production, make API call to BuzzBridge to send message
            // Example:
            // $response = Http::withHeaders(['Authorization' => "Bearer {$apiKey}"])
            //     ->post("{$apiUrl}/send", [
            //         'phone' => $request->phone,
            //         'message' => $request->message
            //     ]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Train Chatbot Response
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function trainChatbotResponse(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string',
            'response' => 'required|string',
        ]);

        try {
            // In production, save to database table: chatbot_responses
            // Example:
            // ChatbotResponse::create([
            //     'keyword' => $request->keyword,
            //     'response' => $request->response,
            //     'created_by' => Auth::id()
            // ]);

            return response()->json([
                'success' => true,
                'message' => 'Chatbot response trained successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to train chatbot',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
