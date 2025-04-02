<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Rule;

class Login extends Component
{
    #[Rule('required|email')]
    public $email = '';

    #[Rule('required')]
    public $password = '';

    public $remember = false;

    protected $messages = [
        'email.required' => 'auth.email_required',
        'email.email' => 'auth.email_valid',
        'password.required' => 'auth.password_required',
    ];

    protected function getMessages()
    {
        return [
            'email.required' => __('auth.email_required'),
            'email.email' => __('auth.email_valid'),
            'password.required' => __('auth.password_required'),
        ];
    }

    public function login()
    {
        $validatedData = $this->validate(null, $this->getMessages());

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            $this->dispatch('loggedIn', [
                'message' => __('auth.login_success')
            ]);

            // Get authenticated user
            $user = Auth::user();
            $userRole = strtoupper($user->role);

            // Redirect based on user role (using uppercase comparison)
            if ($userRole === 'ADMIN') {
                return redirect()->route('admin.dashboard');
            } elseif ($userRole === 'PROVIDER') {
                return redirect()->route('provider.dashboard');
            } else {
                // Default redirect for customers and other roles
                return redirect()->route('customer.dashboard');
            }
        }

        // Wrong credentials notification
        $this->addError('email', __('auth.invalid_credentials'));

        // Dispatch an event for showing an error notification
        $this->dispatch('loginError', [
            'message' => __('auth.invalid_credentials')
        ]);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
