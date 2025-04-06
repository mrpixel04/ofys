<?php

namespace App\Livewire;

use App\Models\Activity;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class HomeActivities extends Component
{
    use WithPagination;

    public $activitySearch = '';
    public $locationSearch = '';
    public $dateSearch = '';
    public $selectedType = '';
    public $minPrice = null;
    public $maxPrice = null;

    protected $queryString = [
        'activitySearch' => ['except' => ''],
        'locationSearch' => ['except' => ''],
        'dateSearch' => ['except' => ''],
        'selectedType' => ['except' => ''],
        'minPrice' => ['except' => ''],
        'maxPrice' => ['except' => ''],
    ];

    public function updatingActivitySearch()
    {
        $this->resetPage();
    }

    public function updatingLocationSearch()
    {
        $this->resetPage();
    }

    public function updatingDateSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedType()
    {
        $this->resetPage();
    }

    public function updatingMinPrice()
    {
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
        $this->resetPage();
    }

    public function search()
    {
        // This is triggered when the search form is submitted
        // The filtering will happen in the render method
        // This method is here if you need to add more logic on form submission
    }

    public function render()
    {
        $query = Activity::with('shopInfo')
            ->where('is_active', true);

        // Apply activity filter
        if (!empty($this->activitySearch)) {
            $query->where(function($q) {
                $q->where('name', 'like', "%{$this->activitySearch}%")
                  ->orWhere('description', 'like', "%{$this->activitySearch}%")
                  ->orWhere('activity_type', 'like', "%{$this->activitySearch}%");
            });
        }

        // Apply location filter
        if (!empty($this->locationSearch)) {
            $query->where('location', 'like', "%{$this->locationSearch}%");
        }

        // Apply type filter
        if (!empty($this->selectedType)) {
            $query->where('activity_type', $this->selectedType);
        }

        // Apply date filter (this would need to be expanded for real availability checks)
        if (!empty($this->dateSearch)) {
            // We'll leave this simple for now
            // In a real system, you'd check availability on this date
        }

        // Apply price range filter
        if (!empty($this->minPrice)) {
            $query->where('price', '>=', $this->minPrice);
        }

        if (!empty($this->maxPrice)) {
            $query->where('price', '<=', $this->maxPrice);
        }

        $activities = $query->orderBy('created_at', 'desc')->paginate(8);

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

        return view('livewire.home-activities', [
            'activities' => $activities,
            'activityTypes' => $availableActivityTypes,
            'priceRange' => $priceRange,
        ]);
    }
}