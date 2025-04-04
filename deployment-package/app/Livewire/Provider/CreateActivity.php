<?php

namespace App\Livewire\Provider;

use Livewire\Component;
use App\Models\ShopInfo;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class CreateActivity extends Component
{
    use WithFileUploads;

    public $shopInfo;
    public $successMessage = '';

    // For activity form
    public $activityId = null;
    public $activityType = '';
    public $name = '';
    public $description = '';
    public $location = '';
    public $state = '';
    public $requirements = '';
    public $minParticipants = 1;
    public $maxParticipants = null;
    public $durationHours = 0;
    public $durationMinutes = 0;
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

    // For image uploads
    public $activityImages = [];
    public $existingImages = [];
    public $imagesToDelete = [];

    // For lot management
    public $lots = [];
    public $newLotDescription = '';
    public $newLotCapacity = 1;
    public $showLotSection = false;

    public function updatedActivityType($value)
    {
        $this->showLotSection = in_array($value, ['camping', 'glamping']);
        if (!$this->showLotSection) {
            $this->lots = [];
            $this->newLotDescription = '';
            $this->newLotCapacity = 1;
        }
    }

    public function mount($activityId = null)
    {
        $this->loadShopInfo();

        if ($activityId) {
            $this->activityId = $activityId;
            $this->loadActivity();
            $this->loadLots();
        }

        $this->showLotSection = in_array($this->activityType, ['camping', 'glamping']);
    }

    public function loadShopInfo()
    {
        $this->shopInfo = ShopInfo::where('user_id', Auth::id())->first();

        if (!$this->shopInfo) {
            $this->shopInfo = new ShopInfo();
            $this->shopInfo->user_id = Auth::id();
            $this->shopInfo->save();
        }
    }

    public function loadActivity()
    {
        $activity = Activity::find($this->activityId);
        if (!$activity) {
            return redirect()->route('provider.activities')->with('error', 'Activity not found');
        }

        $this->activityType = $activity->activity_type;
        $this->name = $activity->name;
        $this->description = $activity->description;
        $this->location = $activity->location;
        $this->state = $activity->state;
        $this->requirements = $activity->requirements;
        $this->minParticipants = $activity->min_participants;
        $this->maxParticipants = $activity->max_participants;

        // Convert total minutes to hours and minutes
        $totalMinutes = $activity->duration_minutes;
        $this->durationHours = floor($totalMinutes / 60);
        $this->durationMinutes = $totalMinutes % 60;
        $this->price = $activity->price;
        $this->priceType = $activity->price_type;
        $this->includesGear = $activity->includes_gear;
        $this->includedItems = $activity->included_items ?: [];
        $this->excludedItems = $activity->excluded_items ?: [];
        $this->amenities = $activity->amenities ?: [];
        $this->rules = $activity->rules ?: [];
        $this->cancelationPolicy = $activity->cancelation_policy;
        $this->isActive = $activity->is_active;
        $this->existingImages = $activity->images ?: [];
    }

    public function loadLots()
    {
        if ($this->activityId) {
            $activity = Activity::find($this->activityId);
            if ($activity) {
                $this->lots = $activity->lots()->get()->map(function($lot) {
                    return [
                        'id' => $lot->id,
                        'name' => $lot->name,
                        'description' => $lot->description,
                        'capacity' => $lot->capacity,
                        'is_available' => $lot->is_available
                    ];
                })->toArray();
            }
        }
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

    public function addLot()
    {
        $this->validate([
            'newLotDescription' => 'nullable|string|max:255',
            'newLotCapacity' => 'required|integer|min:1'
        ]);

        $lotNumber = count($this->lots) + 1;
        $this->lots[] = [
            'id' => null,
            'name' => "Lot {$lotNumber}",
            'description' => $this->newLotDescription,
            'capacity' => $this->newLotCapacity,
            'is_available' => true
        ];

        $this->newLotDescription = '';
        $this->newLotCapacity = 1;
    }

    public function removeLot($index)
    {
        if (isset($this->lots[$index])) {
            unset($this->lots[$index]);
            $this->lots = array_values($this->lots);
        }
    }

    // Image management methods
    public function removeImage($index)
    {
        unset($this->activityImages[$index]);
        $this->activityImages = array_values($this->activityImages);
    }

    public function removeExistingImage($index)
    {
        $this->imagesToDelete[] = $this->existingImages[$index];
        unset($this->existingImages[$index]);
        $this->existingImages = array_values($this->existingImages);
    }

    public function saveActivity()
    {
        $this->validate([
            'activityType' => 'required|string',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'priceType' => 'required|string',
            'minParticipants' => 'required|integer|min:1',
            'durationHours' => 'nullable|integer|min:0',
            'durationMinutes' => 'nullable|integer|min:0|max:59',
            'lots.*.name' => 'required|string|max:255',
            'lots.*.capacity' => 'required|integer|min:1',
            'activityImages.*' => 'image|max:5120', // 5MB max per image
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
        $activity->state = $this->state;
        $activity->requirements = $this->requirements;
        $activity->min_participants = $this->minParticipants;
        $activity->max_participants = $this->maxParticipants;
        $activity->duration_minutes = ($this->durationHours * 60) + $this->durationMinutes;
        $activity->price = $this->price;
        $activity->price_type = $this->priceType;
        $activity->includes_gear = $this->includesGear;
        $activity->included_items = $this->includedItems;
        $activity->excluded_items = $this->excludedItems;
        $activity->amenities = $this->amenities;
        $activity->rules = $this->rules;
        $activity->cancelation_policy = $this->cancelationPolicy;
        $activity->is_active = $this->isActive;

        // Handle image uploads
        $images = $this->existingImages ?: [];

        // Remove images that were marked for deletion
        if (!empty($this->imagesToDelete)) {
            $images = array_diff($images, $this->imagesToDelete);
        }

        // Process new images
        foreach ($this->activityImages as $image) {
            $imagePath = $image->store('activity_images', 'public');
            $images[] = $imagePath;
        }

        // Update activity with the new images
        $activity->images = $images;
        $activity->save();

        // Save lots if activity type requires them
        if (in_array($this->activityType, ['camping', 'glamping'])) {
            // Delete existing lots that are not in the current list
            if ($this->activityId) {
                $existingLotIds = collect($this->lots)->pluck('id')->filter()->toArray();
                $activity->lots()->whereNotIn('id', $existingLotIds)->delete();
            }

            // Create or update lots
            foreach ($this->lots as $lot) {
                if (isset($lot['id'])) {
                    $activity->lots()->where('id', $lot['id'])->update([
                        'name' => $lot['name'],
                        'description' => $lot['description'],
                        'capacity' => $lot['capacity'],
                        'is_available' => $lot['is_available']
                    ]);
                } else {
                    $activity->lots()->create([
                        'provider_id' => Auth::id(),
                        'name' => $lot['name'],
                        'description' => $lot['description'],
                        'capacity' => $lot['capacity'],
                        'is_available' => $lot['is_available']
                    ]);
                }
            }
        }

        $action = $this->activityId ? 'updated' : 'created';
        session()->flash('success', "Activity {$action} successfully!");

        return redirect()->route('provider.activities');
    }

    public function render()
    {
        return view('livewire.provider.create-activity', [
            'activityTypes' => Activity::getActivityTypes(),
            'priceTypes' => Activity::getPriceTypes(),
            'malaysianStates' => Activity::getMalaysianStates()
        ]);
    }
}
