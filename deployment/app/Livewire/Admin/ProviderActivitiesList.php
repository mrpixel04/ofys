<?php

namespace App\Livewire\Admin;

use App\Models\Activity;
use App\Models\Shop;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class ProviderActivitiesList extends Component
{
    use WithPagination;

    public $search = '';
    public $providerSearch = '';
    public $categoryFilter = '';
    public $statusFilter = '';
    public $activityTypes = [];
    public $perPage = 10;

    public $showViewModal = false;
    public $viewingActivity = null;

    public function mount()
    {
        // Initialize activity types
        $this->activityTypes = [
            'water_sports' => 'Water Sports',
            'land_activities' => 'Land Activities',
            'air_activities' => 'Air Activities',
            'cultural' => 'Cultural Experience',
            'tours' => 'Tours & Excursions',
            'cooking' => 'Cooking Class',
            'wellness' => 'Wellness & Spa',
            'team_building' => 'Team Building',
            'workshops' => 'Workshops',
            'other' => 'Other',
            'houseboat' => 'House Boat',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingProviderSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->providerSearch = '';
        $this->categoryFilter = '';
        $this->statusFilter = '';
        $this->resetPage();
    }

    public function viewActivity($activityId)
    {
        $this->viewingActivity = Activity::with(['shopInfo.user', 'lots'])->find($activityId);
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewingActivity = null;
    }

    public function formatDuration($minutes)
    {
        if (!$minutes) return null;

        $hours = floor($minutes / 60);
        $mins = $minutes % 60;

        return $hours . 'h ' . $mins . 'm';
    }

    public function getStatusClass($isActive)
    {
        return $isActive
            ? 'bg-green-100 text-green-800'
            : 'bg-red-100 text-red-800';
    }

    public function render()
    {
        $activities = Activity::query()
            ->with(['shopInfo.user'])
            ->when($this->providerSearch, function (Builder $query) {
                $query->whereHas('shopInfo.user', function (Builder $userQuery) {
                    $userQuery->where('name', 'like', '%' . $this->providerSearch . '%')
                        ->orWhere('email', 'like', '%' . $this->providerSearch . '%');
                });
            })
            ->when($this->search, function (Builder $query) {
                $query->where(function (Builder $searchQuery) {
                    $searchQuery->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('location', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter, function (Builder $query) {
                $query->where('activity_type', $this->categoryFilter);
            })
            ->when($this->statusFilter !== '', function (Builder $query) {
                $isActive = $this->statusFilter === 'active';
                $query->where('is_active', $isActive);
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.provider-activities-list', [
            'activities' => $activities
        ]);
    }
}
