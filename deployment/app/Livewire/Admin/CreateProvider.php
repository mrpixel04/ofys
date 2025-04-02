<?php

namespace App\Livewire\Admin;

use App\Models\ShopInfo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProvider extends Component
{
    use WithFileUploads;

    public $open = false;

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

    protected $rules = [
        // Profile
        'companyName' => 'required|string|min:3|max:255',
        'ownerFullname' => 'required|string|min:3|max:255',

        // Credentials
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|same:passwordConfirmation',
        'passwordConfirmation' => 'required|min:8',
    ];

    protected $validationAttributes = [
        'companyName' => 'company name',
        'ownerFullname' => 'owner full name',
        'passwordConfirmation' => 'password confirmation',
    ];

    public function toggleModal()
    {
        $this->open = !$this->open;

        if (!$this->open) {
            $this->resetForm();
        } else {
            // Reset to first section when opening
            $this->currentSection = 'profile';
        }
    }

    public function resetForm()
    {
        $this->reset([
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

    public function createProvider()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Create a safe username from the email (max 50 chars to be safe)
            $username = substr(Str::slug(explode('@', $this->email)[0]), 0, 50);

            // Create user with provider role
            $user = User::create([
                'name' => $this->ownerFullname,
                'email' => $this->email,
                'username' => $username,
                'password' => Hash::make($this->password),
                'role' => 'PROVIDER',
            ]);

            // Create basic shop info
            ShopInfo::create([
                'user_id' => $user->id,
                'company_name' => $this->companyName,
                'country' => 'Malaysia', // Default value
                'is_verified' => false,  // Default value
            ]);

            DB::commit();

            // Close modal and reset form
            $this->toggleModal();

            // Dispatch success event to parent component
            $this->dispatch('provider-created', [
                'message' => 'Provider created successfully!',
                'user_id' => $user->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to create provider: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.create-provider');
    }
}
