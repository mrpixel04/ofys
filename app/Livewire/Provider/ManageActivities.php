<?php

namespace App\Livewire\Provider;

use Livewire\Component;
use App\Models\ShopInfo;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ManageActivities extends Component
{
    use WithFileUploads, WithPagination;

    public $shopInfo;
    public $activities = [];
    public $successMessage = '';
    public $searchTerm = '';
    public $showViewModal = false;
    public $viewActivity = null;
    public $showDeleteModal = false;
    public $activityToDelete = null;
    public $filterActivityType = '';

    public function getListeners()
    {
        return [
            'viewActivity',
            'confirmDelete',
            'deleteActivity'
        ];
    }

    public function mount()
    {
        $this->loadShopInfo();
    }

    public function loadShopInfo()
    {
        $this->shopInfo = ShopInfo::where('user_id', Auth::id())->first();
    }

    public function toggleCreateModal()
    {
        return redirect()->route('provider.activities.create');
    }

    public function viewActivity($id)
    {
        $activity = Activity::find($id);
        if ($activity) {
            $this->viewActivity = $activity;
            $this->showViewModal = true;
        } else {
            $this->successMessage = "Activity not found.";
        }
    }

    public function toggleViewModal()
    {
        $this->showViewModal = !$this->showViewModal;
        if (!$this->showViewModal) {
            $this->viewActivity = null;
        }
    }

    public function confirmDelete($id)
    {
        $this->activityToDelete = Activity::find($id);
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->activityToDelete = null;
    }

    public function deleteActivity($id)
    {
        $activity = Activity::find($id);
        if ($activity) {
            $activity->delete();
            $this->successMessage = "Activity deleted successfully!";
            $this->showDeleteModal = false;
            $this->activityToDelete = null;
        }
    }

    public function editActivity($id)
    {
        return redirect()->route('provider.activities.edit', $id);
    }

    public function render()
    {
        $activityTypes = Activity::getActivityTypes();
        $priceTypes = Activity::getPriceTypes();

        $query = Activity::query()->where('shop_info_id', $this->shopInfo->id ?? 0);

        if (!empty($this->searchTerm)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
            });
        }

        if (!empty($this->filterActivityType)) {
            $query->where('activity_type', $this->filterActivityType);
        }

        $activities = $query->orderBy('created_at', 'desc')
                          ->paginate(10);

        return view('livewire.provider.manage-activities', [
            'activitiesList' => $activities,
            'activityTypes' => $activityTypes,
            'priceTypes' => $priceTypes
        ]);
    }
}
