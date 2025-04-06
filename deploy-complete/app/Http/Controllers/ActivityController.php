<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    /**
     * Display a listing of the activities.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Activity::with('shopInfo')->where('is_active', true);

        // Apply activity filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('activity_type', 'like', "%{$search}%");
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

        // Apply price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $activities = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

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

        return view('activities.index', [
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

        return view('activities.show', [
            'activity' => $activity,
            'activityTypes' => $activityTypes,
        ]);
    }
}
