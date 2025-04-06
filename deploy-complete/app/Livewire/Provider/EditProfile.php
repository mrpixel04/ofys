<?php

namespace App\Livewire\Provider;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class EditProfile extends Component
{
    use WithFileUploads;

    // Modal state
    public $open = false;
    public $currentSection = 'basic';

    // User data
    public $userId;
    public $name;
    public $email;
    public $username;
    public $phone;

    // Password update
    public $currentPassword;
    public $password;
    public $passwordConfirmation;

    // Password visibility toggles
    public $showCurrentPassword = false;
    public $showPassword = false;
    public $showPasswordConfirmation = false;

    // Profile image
    public $profileImage;
    public $existingProfileImage;
    public $removeExistingImage = false;

    protected $listeners = ['openEditProfile' => 'open'];

    public function mount()
    {
        $this->userId = Auth::id();
        $this->loadUserData();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->userId),
            ],
            'phone' => 'nullable|string|max:20',
            'profileImage' => 'nullable|image|max:1024', // 1MB max

            // Only validate password fields if the user is updating the password
            'currentPassword' => $this->currentSection === 'password' ? 'required' : 'nullable',
            'password' => $this->currentSection === 'password' ? 'required|min:8' : 'nullable',
            'passwordConfirmation' => $this->currentSection === 'password' ? 'required|same:password' : 'nullable',
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already in use by another account.',
            'profileImage.image' => 'The uploaded file must be an image.',
            'profileImage.max' => 'The image must not be larger than 1MB.',
            'currentPassword.required' => 'Please enter your current password.',
            'password.required' => 'Please enter a new password.',
            'password.min' => 'Your new password must be at least 8 characters.',
            'passwordConfirmation.required' => 'Please confirm your new password.',
            'passwordConfirmation.same' => 'The password confirmation does not match.',
        ];
    }

    public function loadUserData()
    {
        $user = User::find($this->userId);

        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
            $this->username = $user->username;
            $this->phone = $user->phone;
            $this->existingProfileImage = $user->profile_image;
        }
    }

    public function open()
    {
        $this->loadUserData();
        $this->resetValidation();
        $this->open = true;
    }

    public function close()
    {
        $this->open = false;
        $this->reset(['currentPassword', 'password', 'passwordConfirmation', 'profileImage', 'removeExistingImage']);
        $this->resetValidation();
    }

    public function setSection($section)
    {
        $this->currentSection = $section;
        $this->resetValidation();
    }

    public function toggleShowCurrentPassword()
    {
        $this->showCurrentPassword = !$this->showCurrentPassword;
    }

    public function toggleShowPassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function toggleShowPasswordConfirmation()
    {
        $this->showPasswordConfirmation = !$this->showPasswordConfirmation;
    }

    public function save()
    {
        if ($this->currentSection === 'basic') {
            $this->saveBasicInfo();
            $this->setSection('password');
        } else {
            $this->savePassword();
            $this->close();
            session()->flash('success', 'Profile updated successfully!');
        }
    }

    private function saveBasicInfo()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->userId),
            ],
            'phone' => 'nullable|string|max:20',
            'profileImage' => 'nullable|image|max:1024', // 1MB max
        ]);

        $user = User::find($this->userId);

        if (!$user) {
            session()->flash('error', 'User not found.');
            return;
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;

        // Handle profile image
        if ($this->profileImage) {
            // Delete old image if it exists
            if ($user->profile_image && Storage::exists('public/' . $user->profile_image)) {
                Storage::delete('public/' . $user->profile_image);
            }

            // Store new image
            $path = $this->profileImage->store('profile-images', 'public');
            $user->profile_image = $path;
        }

        // Remove existing image if requested
        if ($this->removeExistingImage && $user->profile_image) {
            if (Storage::exists('public/' . $user->profile_image)) {
                Storage::delete('public/' . $user->profile_image);
            }
            $user->profile_image = null;
        }

        $user->save();

        // Update the local existingProfileImage property
        $this->existingProfileImage = $user->profile_image;
        $this->reset(['profileImage', 'removeExistingImage']);

        session()->flash('success', 'Basic information updated successfully!');
    }

    private function savePassword()
    {
        // Only validate if user is trying to update password
        if ($this->currentPassword || $this->password || $this->passwordConfirmation) {
            $this->validate([
                'currentPassword' => 'required',
                'password' => 'required|min:8',
                'passwordConfirmation' => 'required|same:password',
            ]);

            $user = User::find($this->userId);

            if (!$user) {
                session()->flash('error', 'User not found.');
                return;
            }

            // Verify current password
            if (!Hash::check($this->currentPassword, $user->password)) {
                $this->addError('currentPassword', 'The current password is incorrect.');
                return;
            }

            $user->password = Hash::make($this->password);
            $user->save();

            $this->reset(['currentPassword', 'password', 'passwordConfirmation']);

            session()->flash('success', 'Password updated successfully!');
        }
    }

    public function render()
    {
        return view('livewire.provider.edit-profile');
    }
}
