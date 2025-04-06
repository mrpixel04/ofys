<?php

namespace App\Livewire\Admin;

use App\Models\ShopInfo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProvider extends Component
{
    use WithFileUploads;

    public $open = false;
    public $providerId = null;

    // Profile info
    public $companyName = '';
    public $ownerFullname = '';

    // Credentials
    public $email = '';
    public $password = '';
    public $passwordConfirmation = '';

    // UI states
    public $showPassword = false;
    public $showPasswordConfirmation = false;
    public $currentSection = 'profile'; // profile, credentials

    protected $listeners = [
        'edit-provider' => 'openEditModal',
        'triggerEditProvider' => 'openEditModal'
    ];

    protected function rules()
    {
        return [
            // Profile
            'companyName' => 'required|string|min:3|max:255',
            'ownerFullname' => 'required|string|min:3|max:255',

            // Credentials - email must be unique except for the current provider
            'email' => 'required|email|unique:users,email,' . $this->providerId,
            'password' => $this->password ? 'nullable|min:8|same:passwordConfirmation' : '',
            'passwordConfirmation' => $this->password ? 'nullable|min:8' : '',
        ];
    }

    protected $validationAttributes = [
        'companyName' => 'company name',
        'ownerFullname' => 'owner full name',
        'passwordConfirmation' => 'password confirmation',
    ];

    // Open the edit modal with provider data
    public function openEditModal($providerId)
    {
        $this->providerId = $providerId;
        $provider = User::with('shopInfo')->find($providerId);

        if ($provider && $provider->role === 'PROVIDER') {
            // Load provider data
            $this->ownerFullname = $provider->name;
            $this->email = $provider->email;

            // Load shop info if exists
            if ($provider->shopInfo) {
                $this->companyName = $provider->shopInfo->company_name;
            }

            // Reset password fields
            $this->password = '';
            $this->passwordConfirmation = '';

            // Reset UI states
            $this->currentSection = 'profile';
            $this->showPassword = false;
            $this->showPasswordConfirmation = false;

            // Open the modal
            $this->open = true;
        }
    }

    public function toggleModal()
    {
        $this->open = !$this->open;

        if (!$this->open) {
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->reset([
            'providerId',
            'companyName',
            'ownerFullname',
            'email',
            'password',
            'passwordConfirmation',
            'showPassword',
            'showPasswordConfirmation',
            'currentSection',
        ]);

        $this->resetValidation();
    }

    public function setSection($section)
    {
        $this->currentSection = $section;
    }

    public function toggleShowPassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function toggleShowPasswordConfirmation()
    {
        $this->showPasswordConfirmation = !$this->showPasswordConfirmation;
    }

    // Auto-capitalize fields as they are updated
    public function updatedCompanyName($value)
    {
        $this->companyName = strtoupper($value);
    }

    public function updatedOwnerFullname($value)
    {
        $this->ownerFullname = strtoupper($value);
    }

    public function updateProvider()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Find the provider
            $provider = User::find($this->providerId);

            if (!$provider || $provider->role !== 'PROVIDER') {
                throw new \Exception('Provider not found');
            }

            // Update user data
            $provider->name = $this->ownerFullname;
            $provider->email = $this->email;

            // Update password if provided
            if ($this->password) {
                $provider->password = Hash::make($this->password);
            }

            $provider->save();

            // Update or create shop info
            $shopInfo = ShopInfo::firstOrNew(['user_id' => $provider->id]);
            $shopInfo->company_name = $this->companyName;
            $shopInfo->save();

            DB::commit();

            // Close modal
            $this->toggleModal();

            // Dispatch success event to parent component
            $this->dispatch('provider-updated', [
                'message' => 'Provider updated successfully!',
                'user_id' => $provider->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to update provider: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.edit-provider');
    }
}
