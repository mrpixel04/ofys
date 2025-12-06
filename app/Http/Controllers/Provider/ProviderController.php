<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Activity;
use App\Models\ActivityLot;
use App\Models\Booking;
use App\Models\ShopInfo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
    public function bookings(Request $request)
    {
        $user = Auth::user();
        $shopInfo = ShopInfo::where('user_id', $user->id)->first();

        if (!$shopInfo) {
            return redirect()->route('provider.shop-info')
                ->with('error', 'Please complete your shop information before managing bookings.');
        }

        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $startDate = $validated['start_date'] ?? null;
        $endDate = $validated['end_date'] ?? null;

        // Get all bookings for this provider
        $bookingsQuery = Booking::whereHas('activity', function($query) use ($shopInfo) {
                $query->where('shop_info_id', $shopInfo->id);
            })
            ->with(['user', 'activity', 'lot']);

        if ($startDate) {
            $bookingsQuery->whereDate('booking_date', '>=', Carbon::parse($startDate)->startOfDay());
        }

        if ($endDate) {
            $bookingsQuery->whereDate('booking_date', '<=', Carbon::parse($endDate)->endOfDay());
        }

        $bookings = $bookingsQuery
            ->orderBy('booking_date', 'desc')
            ->orderBy('start_time', 'desc')
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
            'totalBookings' => $totalBookings,
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
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
        $user = Auth::user();
        $shopInfo = ShopInfo::where('user_id', $user->id)->first();

        // Ensure the booking belongs to this provider
        if (
            !$shopInfo ||
            !$booking->activity ||
            $booking->activity->shop_info_id !== $shopInfo->id
        ) {
            abort(403, 'You do not have permission to view this booking.');
        }

        $booking->load(['user', 'activity.shopInfo.user', 'lot']);

        $customer = $booking->user;
        $providerShop = $booking->activity?->shopInfo;

        return view('provider.simple-booking-details', compact('booking', 'customer', 'providerShop'));
    }

    /**
     * Show the form to create a walk-in booking.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function createWalkInBooking()
    {
        $user = Auth::user();
        $shopInfo = ShopInfo::where('user_id', $user->id)->first();

        if (!$shopInfo) {
            return redirect()->route('provider.shop-info')
                ->with('error', 'Please complete your shop information before creating bookings.');
        }

        $activities = Activity::where('shop_info_id', $shopInfo->id)
            ->with(['lots' => function ($query) {
                $query->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        if ($activities->isEmpty()) {
            return redirect()->route('provider.activities')
                ->with('error', 'Add at least one activity before creating a booking.');
        }

        $activityMeta = $activities->mapWithKeys(function ($activity) {
            return [
                $activity->id => [
                    'name' => $activity->name,
                    'location' => $activity->location,
                    'min' => $activity->min_participants ?? 1,
                    'max' => $activity->max_participants,
                    'price' => (float) $activity->price,
                    'price_type' => $activity->price_type,
                ],
            ];
        })->toArray();

        return view('provider.bookings-create', [
            'shopInfo' => $shopInfo,
            'activities' => $activities,
            'activityMeta' => $activityMeta,
        ]);
    }

    /**
     * Store a newly created walk-in booking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeWalkInBooking(Request $request)
    {
        $user = Auth::user();
        $shopInfo = ShopInfo::where('user_id', $user->id)->first();

        if (!$shopInfo) {
            return redirect()->route('provider.shop-info')
                ->with('error', 'Please complete your shop information before creating bookings.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:30',
            'customer_notes' => 'nullable|string|max:500',
            'activity_id' => [
                'required',
                Rule::exists('activities', 'id')->where(function ($query) use ($shopInfo) {
                    return $query->where('shop_info_id', $shopInfo->id);
                }),
            ],
            'lot_id' => [
                'nullable',
                'integer',
            ],
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
            'participants' => 'required|integer|min:1|max:500',
            'total_price' => 'nullable|numeric|min:0',
            'status' => ['required', Rule::in(['pending', 'confirmed', 'completed', 'cancelled'])],
            'payment_status' => ['required', Rule::in(['pending', 'processing', 'done', 'refunded', 'failed'])],
            'payment_method' => 'nullable|string|max:100',
            'special_requests' => 'nullable|string|max:500',
        ]);

        $activity = Activity::where('shop_info_id', $shopInfo->id)
            ->with('lots')
            ->findOrFail($validated['activity_id']);

        $lot = null;
        if (!empty($validated['lot_id'])) {
            $lot = ActivityLot::where('activity_id', $activity->id)
                ->where('id', $validated['lot_id'])
                ->first();

            if (!$lot) {
                return back()->withInput()->withErrors([
                    'lot_id' => 'The selected lot is not available for this activity.',
                ]);
            }
        }

        DB::beginTransaction();

        try {
            $customerUser = null;
            if (!empty($validated['customer_email'])) {
                $customerUser = User::where('email', $validated['customer_email'])->first();
            }

            if (!$customerUser) {
                $email = $validated['customer_email'] ?? $this->generatePlaceholderEmail();

                $customerUser = User::create([
                    'name' => $validated['customer_name'],
                    'email' => $email,
                    'username' => null,
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'CUSTOMER',
                    'phone' => $validated['customer_phone'] ?? null,
                    'status' => 'active',
                ]);

                $customerUser->email_verified_at = now();
                $customerUser->save();
            } else {
                $customerUser->update([
                    'phone' => $validated['customer_phone'] ?? $customerUser->phone,
                    'name' => $validated['customer_name'],
                ]);
            }

            $startDateTime = Carbon::parse($validated['booking_date'] . ' ' . $validated['start_time']);
            $bookingDate = Carbon::parse($validated['booking_date']);
            $endDateTime = !empty($validated['end_time'])
                ? Carbon::parse($validated['booking_date'] . ' ' . $validated['end_time'])
                : $startDateTime->copy()->addHours(2);

            $calculatedPrice = $validated['total_price'] ?? $activity->price;
            if (
                !$validated['total_price'] &&
                in_array($activity->price_type, ['per_person', 'per_pack'])
            ) {
                $calculatedPrice = $activity->price * $validated['participants'];
            }

            $booking = Booking::create([
                'booking_reference' => $this->generateBookingReference(),
                'user_id' => $customerUser->id,
                'activity_id' => $activity->id,
                'lot_id' => $lot->id ?? null,
                'booking_date' => $bookingDate,
                'start_time' => $startDateTime,
                'end_time' => $endDateTime,
                'participants' => $validated['participants'],
                'total_price' => $calculatedPrice,
                'status' => $validated['status'],
                'payment_status' => $validated['payment_status'],
                'payment_method' => $validated['payment_method'] ?? 'walk_in',
                'special_requests' => $validated['special_requests'] ?? null,
                'customer_details' => [
                    'name' => $validated['customer_name'],
                    'email' => $validated['customer_email'] ?? $customerUser->email,
                    'phone' => $validated['customer_phone'] ?? null,
                    'notes' => $validated['customer_notes'] ?? null,
                    'type' => 'walk_in',
                    'captured_by' => $user->id,
                    'captured_at' => now()->toDateTimeString(),
                ],
                'activity_details' => [
                    'name' => $activity->name,
                    'location' => $activity->location,
                    'activity_type' => $activity->activity_type,
                    'price' => $activity->price,
                    'price_type' => $activity->price_type,
                ],
            ]);

            DB::commit();

            return redirect()
                ->route('provider.bookings.show', $booking->id)
                ->with('success', 'Walk-in booking created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Unable to create booking. Please try again.');
        }
    }

    /**
     * Generate a unique booking reference.
     *
     * @return string
     */
    protected function generateBookingReference(): string
    {
        do {
            $reference = 'BK-' . strtoupper(Str::random(8));
        } while (Booking::where('booking_reference', $reference)->exists());

        return $reference;
    }

    /**
     * Generate a placeholder email when a customer email is not provided.
     *
     * @return string
     */
    protected function generatePlaceholderEmail(): string
    {
        do {
            $email = 'walkin+' . now()->format('YmdHis') . Str::random(4) . '@ofys.local';
        } while (User::where('email', $email)->exists());

        return $email;
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
        $activityTypes = Activity::getActivityTypes();
        $priceTypes = Activity::getPriceTypes();
        $states = Activity::getMalaysianStates();
        return view('provider.activities.create', compact('activityTypes','priceTypes','states'));
    }

    /**
     * Display a specific activity.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function viewActivity($id)
    {
        $user = Auth::user();

        $activity = Activity::with(['lots'])
            ->where('id', $id)
            ->whereHas('shopInfo', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->firstOrFail();

        $activityTypes = Activity::getActivityTypes();

        return view('provider.activities.view', [
            'activity' => $activity,
            'activityTypes' => $activityTypes,
            'states' => Activity::getMalaysianStates(),
        ]);
    }

    /**
     * Display the edit activity form.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function editActivity($id)
    {
        $user = Auth::user();

        $activity = Activity::with(['lots'])
            ->where('id', $id)
            ->whereHas('shopInfo', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->firstOrFail();

        return view('provider.activities.edit', [
            'activity' => $activity,
            'activityTypes' => Activity::getActivityTypes(),
            'priceTypes' => Activity::getPriceTypes(),
            'states' => Activity::getMalaysianStates(),
        ]);
    }

    /**
     * Update an existing activity.
     */
    public function updateActivity(Request $request, $id)
    {
        $user = Auth::user();
        $shopInfo = ShopInfo::where('user_id', $user->id)->firstOrFail();

        $activity = Activity::with('lots')
            ->where('id', $id)
            ->where('shop_info_id', $shopInfo->id)
            ->firstOrFail();

        $validated = $request->validate([
            'activity_type' => ['required', 'string', Rule::in(array_keys(Activity::getActivityTypes()))],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'requirements' => ['nullable', 'string'],
            'min_participants' => ['required', 'integer', 'min:1'],
            'max_participants' => ['nullable', 'integer', 'gte:min_participants'],
            'duration_days' => ['nullable', 'integer', 'min:0', 'max:365'],
            'duration_hours' => ['nullable', 'integer', 'min:0', 'max:23'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_type' => ['required', 'string', Rule::in(array_keys(Activity::getPriceTypes()))],
            'includes_gear' => ['nullable', 'boolean'],
            'included_items' => ['nullable', 'array'],
            'included_items.*' => ['string'],
            'excluded_items' => ['nullable', 'array'],
            'excluded_items.*' => ['string'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['string'],
            'rules' => ['nullable', 'array'],
            'rules.*' => ['string'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:4096'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['string'],
            'lots' => ['nullable', 'array'],
            'lots.*.id' => ['nullable', 'integer', 'exists:activity_lots,id'],
            'lots.*.name' => ['required_with:lots', 'string', 'max:255'],
            'lots.*.capacity' => ['required_with:lots', 'integer', 'min:1'],
            'lots.*.description' => ['nullable', 'string'],
        ]);

        $requiresLots = in_array($validated['activity_type'], ['camping', 'glamping']);
        $submittedLots = collect($request->input('lots', []));

        if ($requiresLots && $submittedLots->isEmpty()) {
            return back()
                ->withErrors(['lots' => 'At least one lot is required for this activity type.'])
                ->withInput();
        }

        $durationMinutes = null;
        if ($request->filled('duration_days') || $request->filled('duration_hours')) {
            $days = (int) $request->input('duration_days', 0);
            $hours = (int) $request->input('duration_hours', 0);
            $durationMinutes = ($days * 24 * 60) + ($hours * 60);
        }

        $updateData = [
            'activity_type' => $validated['activity_type'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'] ?? null,
            'state' => $validated['state'] ?? null,
            'requirements' => $validated['requirements'] ?? null,
            'min_participants' => $validated['min_participants'],
            'max_participants' => $validated['max_participants'] ?? null,
            'duration_minutes' => $durationMinutes,
            'price' => $validated['price'],
            'price_type' => $validated['price_type'],
            'includes_gear' => $request->boolean('includes_gear'),
            'included_items' => $request->input('included_items', []),
            'excluded_items' => $request->input('excluded_items', []),
            'amenities' => $request->input('amenities', []),
            'rules' => $request->input('rules', []),
        ];

        $currentImages = $activity->images ?? [];
        $imagesToRemove = $request->input('remove_images', []);

        if (!empty($imagesToRemove)) {
            foreach ($imagesToRemove as $imagePath) {
                if (in_array($imagePath, $currentImages, true)) {
                    Storage::disk('public')->delete($imagePath);
                    $currentImages = array_values(array_filter($currentImages, fn ($path) => $path !== $imagePath));
                }
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $safeName = time() . '_' . $user->id . '_' . uniqid('', true) . '.' . $image->getClientOriginalExtension();
                $currentImages[] = $image->storeAs('activity_images', $safeName, 'public');
            }
        }

        $updateData['images'] = $currentImages;

        $activity->update($updateData);

        if ($requiresLots) {
            $retainedIds = [];

            foreach ($submittedLots as $lotData) {
                $lotId = $lotData['id'] ?? null;

                if ($lotId) {
                    $lot = $activity->lots->firstWhere('id', (int) $lotId);
                    if ($lot) {
                        $lot->update([
                            'name' => $lotData['name'],
                            'description' => $lotData['description'] ?? null,
                            'capacity' => $lotData['capacity'],
                        ]);
                        $retainedIds[] = $lot->id;
                        continue;
                    }
                }

                $newLot = ActivityLot::create([
                    'activity_id' => $activity->id,
                    'provider_id' => $user->id,
                    'name' => $lotData['name'],
                    'description' => $lotData['description'] ?? null,
                    'capacity' => $lotData['capacity'],
                    'is_available' => true,
                ]);

                $retainedIds[] = $newLot->id;
            }

            $activity->lots()
                ->whereNotIn('id', $retainedIds)
                ->delete();
        } else {
            $activity->lots()->delete();
        }

        return redirect()
            ->route('provider.activities.view', $activity->id)
            ->with('success', 'Activity updated successfully.');
    }

    /**
     * Store a newly created activity.
     */
    public function storeActivity(Request $request)
    {
        $user = Auth::user();
        $shopInfo = ShopInfo::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'activity_type' => ['required','string', Rule::in(array_keys(Activity::getActivityTypes()))],
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'location' => ['nullable','string','max:255'],
            'state' => ['nullable','string','max:255'],
            'requirements' => ['nullable','string'],
            'min_participants' => ['required','integer','min:1'],
            'max_participants' => ['nullable','integer','gte:min_participants'],
            'duration_days' => ['nullable','integer','min:0','max:365'],
            'duration_hours' => ['nullable','integer','min:0','max:23'],
            'price' => ['required','numeric','min:0'],
            'price_type' => ['required','string', Rule::in(array_keys(Activity::getPriceTypes()))],
            'includes_gear' => ['nullable','boolean'],
            'included_items' => ['nullable','array'],
            'excluded_items' => ['nullable','array'],
            'amenities' => ['nullable','array'],
            'rules' => ['nullable','array'],
            'images.*' => ['nullable','image','mimes:jpeg,png,jpg','max:4096'],
            // Lots
            'lots' => ['nullable','array'],
            'lots.*.name' => ['required_with:lots','string','max:255'],
            'lots.*.capacity' => ['required_with:lots','integer','min:1'],
        ]);

        // Upload images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $safeName = time() . '_' . $user->id . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePaths[] = $image->storeAs('activity_images', $safeName, 'public');
            }
        }

        // Convert days and hours to minutes
        $durationMinutes = null;
        if (isset($validated['duration_days']) || isset($validated['duration_hours'])) {
            $days = (int)($validated['duration_days'] ?? 0);
            $hours = (int)($validated['duration_hours'] ?? 0);
            $durationMinutes = ($days * 24 * 60) + ($hours * 60);
        }

        $activity = Activity::create([
            'shop_info_id' => $shopInfo->id,
            'activity_type' => $validated['activity_type'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'] ?? null,
            'state' => $validated['state'] ?? null,
            'requirements' => $validated['requirements'] ?? null,
            'min_participants' => $validated['min_participants'],
            'max_participants' => $validated['max_participants'] ?? null,
            'duration_minutes' => $durationMinutes,
            'price' => $validated['price'],
            'price_type' => $validated['price_type'],
            'includes_gear' => (bool)($validated['includes_gear'] ?? false),
            'included_items' => $validated['included_items'] ?? [],
            'excluded_items' => $validated['excluded_items'] ?? [],
            'amenities' => $validated['amenities'] ?? [],
            'rules' => $validated['rules'] ?? [],
            'images' => $imagePaths,
            'is_active' => true,
        ]);

        // Create lots if provided and type requires
        if (!empty($validated['lots']) && in_array($validated['activity_type'], ['camping','glamping'])) {
            foreach ($validated['lots'] as $lot) {
                ActivityLot::create([
                    'activity_id' => $activity->id,
                    'provider_id' => $user->id,
                    'name' => $lot['name'],
                    'description' => $lot['description'] ?? null,
                    'capacity' => $lot['capacity'],
                    'is_available' => true,
                ]);
            }
        }

        return redirect()->route('provider.activities')->with('success', 'Activity created successfully');
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

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'remove_profile_image' => ['nullable', 'boolean'],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ];

        if ($request->boolean('remove_profile_image') && $user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
            $updateData['profile_image'] = null;
        }

        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $profilePath = $profileImage->storeAs(
                'profile_images',
                time() . '_' . $user->id . '.' . $profileImage->getClientOriginalExtension(),
                'public'
            );

            if (!empty($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $updateData['profile_image'] = $profilePath;
        }

        User::where('id', $user->id)->update($updateData);

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
