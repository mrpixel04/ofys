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
    public $showCreateModal = false;
    public $showViewModal = false;
    public $viewActivity = null;
    public $showDeleteModal = false;
    public $activityToDelete = null;
    public $filterActivityType = '';

    // For activity form
    public $activityId = null;
    public $activityType = '';
    public $name = '';
    public $description = '';
    public $location = '';
    public $requirements = '';
    public $minParticipants = 1;
    public $maxParticipants = null;
    public $durationMinutes = null;
    public $price = 0;
    public $priceType = 'per_person';
    public $includesGear = false;
    public $includedItems = [];
    public $excludedItems = [];
    public $amenities = [];
    public $rules = [];
    public $cancelationPolicy = '';
    public $isActive = true;
    public $newIncludedItem = '';
    public $newExcludedItem = '';
    public $newAmenity = '';
    public $newRule = '';

    public function getListeners()
    {
        return [
            'editActivity',
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
        $this->showCreateModal = !$this->showCreateModal;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'activityId', 'activityType', 'name', 'description', 'location',
            'requirements', 'minParticipants', 'maxParticipants', 'durationMinutes',
            'price', 'priceType', 'includesGear', 'includedItems', 'excludedItems',
            'amenities', 'rules', 'cancelationPolicy', 'isActive'
        ]);
        $this->includedItems = [];
        $this->excludedItems = [];
        $this->amenities = [];
        $this->rules = [];
    }

    public function addIncludedItem()
    {
        if (!empty($this->newIncludedItem)) {
            $this->includedItems[] = $this->newIncludedItem;
            $this->newIncludedItem = '';
        }
    }

    public function removeIncludedItem($index)
    {
        if (isset($this->includedItems[$index])) {
            unset($this->includedItems[$index]);
            $this->includedItems = array_values($this->includedItems);
        }
    }

    public function addExcludedItem()
    {
        if (!empty($this->newExcludedItem)) {
            $this->excludedItems[] = $this->newExcludedItem;
            $this->newExcludedItem = '';
        }
    }

    public function removeExcludedItem($index)
    {
        if (isset($this->excludedItems[$index])) {
            unset($this->excludedItems[$index]);
            $this->excludedItems = array_values($this->excludedItems);
        }
    }

    public function addAmenity()
    {
        if (!empty($this->newAmenity)) {
            $this->amenities[] = $this->newAmenity;
            $this->newAmenity = '';
        }
    }

    public function removeAmenity($index)
    {
        if (isset($this->amenities[$index])) {
            unset($this->amenities[$index]);
            $this->amenities = array_values($this->amenities);
        }
    }

    public function addRule()
    {
        if (!empty($this->newRule)) {
            $this->rules[] = $this->newRule;
            $this->newRule = '';
        }
    }

    public function removeRule($index)
    {
        if (isset($this->rules[$index])) {
            unset($this->rules[$index]);
            $this->rules = array_values($this->rules);
        }
    }

    public function saveActivity()
    {
        $this->validate([
            'activityType' => 'required|string',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'priceType' => 'required|string',
            'minParticipants' => 'required|integer|min:1',
        ]);

        if (!$this->shopInfo) {
            $this->shopInfo = new ShopInfo();
            $this->shopInfo->user_id = Auth::id();
            $this->shopInfo->save();
        }

        if ($this->activityId) {
            // Update existing activity
            $activity = Activity::find($this->activityId);
        } else {
            // Create new activity
            $activity = new Activity();
            $activity->shop_info_id = $this->shopInfo->id;
        }

        $activity->activity_type = $this->activityType;
        $activity->name = $this->name;
        $activity->description = $this->description;
        $activity->location = $this->location;
        $activity->requirements = $this->requirements;
        $activity->min_participants = $this->minParticipants;
        $activity->max_participants = $this->maxParticipants;
        $activity->duration_minutes = $this->durationMinutes;
        $activity->price = $this->price;
        $activity->price_type = $this->priceType;
        $activity->includes_gear = $this->includesGear;
        $activity->included_items = $this->includedItems;
        $activity->excluded_items = $this->excludedItems;
        $activity->amenities = $this->amenities;
        $activity->rules = $this->rules;
        $activity->cancelation_policy = $this->cancelationPolicy;
        $activity->is_active = $this->isActive;

        $activity->save();

        $this->showCreateModal = false;
        $this->resetForm();

        $action = $this->activityId ? 'updated' : 'created';
        $this->successMessage = "Activity {$action} successfully!";
        $this->dispatch('activity-saved');
    }

    public function editActivity($id)
    {
        $activity = Activity::find($id);
        if (!$activity) {
            return;
        }

        $this->activityId = $activity->id;
        $this->activityType = $activity->activity_type;
        $this->name = $activity->name;
        $this->description = $activity->description;
        $this->location = $activity->location;
        $this->requirements = $activity->requirements;
        $this->minParticipants = $activity->min_participants;
        $this->maxParticipants = $activity->max_participants;
        $this->durationMinutes = $activity->duration_minutes;
        $this->price = $activity->price;
        $this->priceType = $activity->price_type;
        $this->includesGear = $activity->includes_gear;
        $this->includedItems = $activity->included_items ?: [];
        $this->excludedItems = $activity->excluded_items ?: [];
        $this->amenities = $activity->amenities ?: [];
        $this->rules = $activity->rules ?: [];
        $this->cancelationPolicy = $activity->cancelation_policy;
        $this->isActive = $activity->is_active;

        $this->showCreateModal = true;
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
