<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Str;

class Register extends Component
{
    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('required|string|email|max:255|unique:users')]
    public $email = '';

    #[Rule('nullable|string|max:255|unique:users|alpha_dash')]
    public $username = '';

    #[Rule('required|string|min:8|confirmed')]
    public $password = '';

    public $password_confirmation = '';

    #[Rule('accepted')]
    public $terms = false;

    protected $messages = [
        'name.required' => 'Sila masukkan nama penuh anda.',
        'email.required' => 'Sila masukkan alamat e-mel anda.',
        'email.email' => 'Sila masukkan alamat e-mel yang sah.',
        'email.unique' => 'Alamat e-mel ini telah digunakan.',
        'username.unique' => 'Nama pengguna ini telah digunakan.',
        'username.alpha_dash' => 'Nama pengguna hanya boleh mengandungi huruf, nombor, tanda sengkang dan garis bawah.',
        'password.required' => 'Sila masukkan kata laluan.',
        'password.min' => 'Kata laluan mestilah sekurang-kurangnya 8 aksara.',
        'password.confirmed' => 'Pengesahan kata laluan tidak sepadan.',
        'terms.accepted' => 'Anda mesti bersetuju dengan terma perkhidmatan kami.',
    ];

    public function generateUsernameFromEmail()
    {
        if (empty($this->username) && !empty($this->email)) {
            // Extract username from email (part before @)
            $emailParts = explode('@', $this->email);
            $baseUsername = $emailParts[0];

            // Make it unique by adding random characters if needed
            $username = $baseUsername;
            $counter = 0;

            // Check if username exists and add random string if needed
            while (User::where('username', $username)->exists()) {
                $counter++;
                $username = $baseUsername . Str::random(3) . $counter;
            }

            $this->username = $username;
        }
    }

    public function register()
    {
        try {
            $validatedData = $this->validate();

            // Generate username from email if not provided
            $this->generateUsernameFromEmail();

            // Check if email already exists (additional check)
            $existingUser = User::where('email', $this->email)->first();
            if ($existingUser) {
                $this->addError('email', 'Alamat e-mel ini telah digunakan.');

                // Display error notification
                $this->dispatch('registrationError', [
                    'message' => 'Alamat e-mel ini telah digunakan.'
                ]);

                return;
            }

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'username' => $this->username,
                'password' => Hash::make($this->password),
                'role' => 'CUSTOMER',
            ]);

            // Dispatch the registered event for notification
            $this->dispatch('registered', [
                'message' => 'Akaun anda telah berjaya didaftarkan!'
            ]);

            // Add a delay before redirecting (2 seconds)
            session()->flash('success', 'Pendaftaran berjaya! Sila log masuk dengan akaun anda.');

            // Using JavaScript to delay the redirect
            $this->dispatch('registrationSuccess');

            // Note: We're not returning a redirect here because we'll handle it with JavaScript
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            $this->dispatch('registrationError', [
                'message' => 'Sila semak semula maklumat anda.'
            ]);

            throw $e;
        } catch (\Exception $e) {
            // Handle other exceptions
            $this->dispatch('registrationError', [
                'message' => 'Ralat semasa pendaftaran. Sila cuba lagi.'
            ]);
            $this->addError('general', 'Ralat semasa pendaftaran. Sila cuba lagi.');
        }
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
