<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    /**
     * Display a listing of the activities.
     * Enhanced to match Livewire HomeActivities component functionality.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Activity::with('shopInfo')->where('is_active', true);

        // Apply activity search filter (matches Livewire activitySearch)
        if ($request->filled('activitySearch')) {
            $search = $request->activitySearch;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('activity_type', 'like', "%{$search}%");
            });
        }

        // Apply location filter (matches Livewire locationSearch)
        if ($request->filled('locationSearch')) {
            $query->where('location', 'like', "%{$request->locationSearch}%");
        }

        // Apply date filter (matches Livewire dateSearch)
        if ($request->filled('dateSearch')) {
            // For now, we'll leave this simple as in the Livewire component
            // In a real system, you'd check availability on this date
        }

        // Apply type filter (matches Livewire selectedType)
        if ($request->filled('selectedType')) {
            $query->where('activity_type', $request->selectedType);
        }

        // Apply price range filter (matches Livewire minPrice/maxPrice)
        if ($request->filled('minPrice')) {
            $query->where('price', '>=', $request->minPrice);
        }

        if ($request->filled('maxPrice')) {
            $query->where('price', '<=', $request->maxPrice);
        }

        // Paginate with 8 items per page (matches Livewire pagination)
        $activities = $query->orderBy('created_at', 'desc')->paginate(8)->withQueryString();

        // Get activity types with at least one activity
        $activityTypes = DB::table('activities')
            ->select('activity_type')
            ->where('is_active', true)
            ->distinct()
            ->get()
            ->pluck('activity_type')
            ->toArray();

        $availableActivityTypes = [];
        $activityTypeLabels = Activity::getActivityTypes();

        foreach ($activityTypes as $type) {
            if (isset($activityTypeLabels[$type])) {
                $availableActivityTypes[$type] = $activityTypeLabels[$type];
            }
        }

        // Get min and max prices for the slider
        $priceRange = Activity::where('is_active', true)->selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();

        return view('guest.activities.index', [
            'activities' => $activities,
            'activityTypes' => $availableActivityTypes,
            'priceRange' => $priceRange,
            'filters' => $request->all(),
        ]);
    }

    /**
     * Display the specified activity.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $activity = Activity::with('shopInfo')->findOrFail($id);

        // Only show active activities
        if (!$activity->is_active) {
            abort(404);
        }

        $activityTypes = Activity::getActivityTypes();

        return view('guest.activities.show', [
            'activity' => $activity,
            'activityTypes' => $activityTypes,
        ]);
    }
}
