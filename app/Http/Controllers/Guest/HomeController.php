<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ShopInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get featured activities (we'll assume active activities and limit to 8)
        $featuredActivities = Activity::with('shopInfo')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        // Get activity types that have at least one activity
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

        // Get popular locations (based on the locations with most activities)
        $popularLocations = DB::table('activities')
            ->select('location', DB::raw('count(*) as total'))
            ->where('is_active', true)
            ->whereNotNull('location')
            ->groupBy('location')
            ->orderBy('total', 'desc')
            ->take(6)
            ->pluck('location')
            ->toArray();

        return view('homepage', [
            'featuredActivities' => $featuredActivities,
            'activityTypes' => $availableActivityTypes,
            'popularLocations' => $popularLocations,
        ]);
    }

    /**
     * Search for activities with filters
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = Activity::with('shopInfo')->where('is_active', true);

        // Apply activity filter
        if ($request->filled('activity')) {
            $activitySearch = $request->activity;
            $query->where(function($q) use ($activitySearch) {
                $q->where('name', 'like', "%{$activitySearch}%")
                  ->orWhere('description', 'like', "%{$activitySearch}%")
                  ->orWhere('activity_type', 'like', "%{$activitySearch}%");
            });
        }

        // Apply location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Apply type filter
        if ($request->filled('type')) {
            $query->where('activity_type', $request->type);
        }

        // Apply date filter for lots (this would need to be expanded based on your booking system)
        if ($request->filled('date')) {
            // We'll leave this simple for now
            // In a real system, you'd check availability on this date
        }

        // Apply price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $activities = $query->paginate(12)->withQueryString();

        // Get activity types that have at least one activity
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

        return view('activities.search', [
            'activities' => $activities,
            'activityTypes' => $availableActivityTypes,
            'filters' => $request->all(),
        ]);
    }
}
