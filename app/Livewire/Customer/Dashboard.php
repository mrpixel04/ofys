<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $activeTab = 'profile';
    public $user;
    public $bookings = [];

    public function mount($tab = null)
    {
        $this->user = Auth::user();

        // Set active tab if provided in URL
        if ($tab && in_array($tab, ['profile', 'account', 'bookings', 'settings'])) {
            $this->activeTab = $tab;
        }

        // Here you would normally fetch bookings from a database
        // For now, we'll just use an empty array
        $this->bookings = [];
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.customer.dashboard');
    }
}
