<?php

namespace App\Livewire\Provider;

use App\Models\ShopInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class EditShopInfo extends Component
{
    use WithFileUploads;

    // Shop basic info
    public $shop_id;
    public $company_name;
    public $company_email;
    public $phone;
    public $website;
    public $description;
    public $business_type;

    // Images
    public $logo;
    public $shop_image;
    public $existing_logo;
    public $existing_shop_image;

    // Operations section
    public $opening_hours = [];
    public $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    public $special_instructions;

    // Location section
    public $address;
    public $city;
    public $state;
    public $postal_code;
    public $country;

    protected $listeners = ['refreshShopInfo' => '$refresh'];

    public function mount()
    {
        $user = Auth::user();
        $shop = $user->shopInfo;

        if ($shop) {
            $this->shop_id = $shop->id;
            $this->company_name = $shop->company_name;
            $this->company_email = $shop->company_email;
            $this->phone = $shop->phone;
            $this->website = $shop->website;
            $this->description = $shop->description;
            $this->business_type = $shop->business_type;
            $this->existing_logo = $shop->logo;
            $this->existing_shop_image = $shop->shop_image;

            // Handle opening hours from either field
            if ($shop->opening_hours) {
                $this->opening_hours = is_string($shop->opening_hours)
                    ? json_decode($shop->opening_hours, true)
                    : $shop->opening_hours;
            } elseif ($shop->business_hours) {
                $this->opening_hours = is_string($shop->business_hours)
                    ? json_decode($shop->business_hours, true)
                    : $shop->business_hours;
            } else {
                $this->opening_hours = $this->getDefaultOpeningHours();
            }

            $this->special_instructions = $shop->special_instructions;
            $this->address = $shop->address;
            $this->city = $shop->city;
            $this->state = $shop->state;
            $this->postal_code = $shop->postal_code ?? $shop->zip;
            $this->country = $shop->country ?: 'Malaysia';
        } else {
            // Default values
            $this->company_email = $user->email;
            $this->phone = $user->phone;
            $this->opening_hours = $this->getDefaultOpeningHours();
            $this->country = 'Malaysia';
        }
    }

    /**
     * Get default opening hours for all days of the week
     */
    private function getDefaultOpeningHours()
    {
        $hours = [];
        foreach ($this->weekdays as $day) {
            $hours[$day] = [
                'is_open' => false,
                'open' => '09:00',
                'close' => '17:00'
            ];
        }
        return $hours;
    }

    public function saveShopInfo()
    {
        try {
            $this->validate([
                'company_name' => 'required|string|max:100',
                'company_email' => 'required|email|max:100',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'postal_code' => 'required|string|max:20',
                'country' => 'required|string|max:100',
                'website' => 'nullable|url|max:255',
            ]);

            // Debug data before saving
            Log::info('Saving shop info with data:', [
                'company_name' => $this->company_name,
                'company_email' => $this->company_email,
                'user_id' => Auth::id()
            ]);

            $user = Auth::user();
            $shopInfo = $user->shopInfo;

            // Create ShopInfo if it doesn't exist
            if (!$shopInfo) {
                $shopInfo = new ShopInfo();
                $shopInfo->user_id = $user->id;
            }

            // Handle logo upload
            if ($this->logo) {
                // Delete the old logo if it exists
                if ($shopInfo && $shopInfo->logo) {
                    $oldLogoPath = public_path('storage/' . $shopInfo->logo);
                    if (file_exists($oldLogoPath)) {
                        unlink($oldLogoPath);
                    }
                }

                $logoName = time() . '_' . $this->logo->getClientOriginalName();
                $logoPath = $this->logo->storeAs('logos', $logoName, 'public');
                $shopInfo->logo = $logoPath;
            }

            // Handle shop image upload
            if ($this->shop_image) {
                // Delete the old shop image if it exists
                if ($shopInfo && $shopInfo->shop_image) {
                    $oldImagePath = public_path('storage/' . $shopInfo->shop_image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $imageName = time() . '_' . $this->shop_image->getClientOriginalName();
                $imagePath = $this->shop_image->storeAs('shop_images', $imageName, 'public');
                $shopInfo->shop_image = $imagePath;
            }

            // Update all fields
            $shopInfo->company_name = $this->company_name;
            $shopInfo->company_email = $this->company_email;
            $shopInfo->phone = $this->phone;
            $shopInfo->address = $this->address;
            $shopInfo->city = $this->city;
            $shopInfo->state = $this->state;
            $shopInfo->postal_code = $this->postal_code;
            $shopInfo->zip = $this->postal_code;
            $shopInfo->country = $this->country;
            $shopInfo->website = $this->website;
            $shopInfo->opening_hours = json_encode($this->opening_hours);
            $shopInfo->business_hours = json_encode($this->opening_hours);
            $shopInfo->description = $this->description;
            $shopInfo->business_type = $this->business_type;
            $shopInfo->special_instructions = $this->special_instructions;

            Log::info('Prepared shop info data for saving');

            $success = $shopInfo->save();
            Log::info('Shop info save result: ' . ($success ? 'success' : 'failure'));

            if ($success) {
                session()->flash('message', 'Shop information saved successfully!');
                session()->flash('message_type', 'success');
                Log::info('Shop info saved successfully');
            } else {
                session()->flash('message', 'Failed to save shop information. Please try again.');
                session()->flash('message_type', 'error');
                Log::error('Failed to save shop info - database save failed');
            }

            return redirect()->route('provider.shop-info');
        } catch (\Exception $e) {
            Log::error('Error saving shop info: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('message_type', 'error');

            return null;
        }
    }

    public function updatedOpeningHours()
    {
        // This method is called when opening_hours property is updated
        // We can use it for validation or additional logic if needed
    }

    public function render()
    {
        return view('livewire.provider.edit-shop-info');
    }
}
