<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class Dashboard extends Component
{
    public $activeTab = 'profile';
    public $user;
    public $bookings = [];

    public function mount($tab = null)
    {
        $this->user = Auth::user();

        // Set active tab if provided in URL
        if ($tab && in_array($tab, ['profile', 'bookings', 'settings'])) {
            $this->activeTab = $tab;
        }

        // Fetch bookings from database
        $this->loadBookings();
    }

    public function loadBookings()
    {
        try {
            $this->bookings = Booking::where('user_id', $this->user->id)
                ->orderBy('booking_date', 'desc')
                ->get();
        } catch (\Exception $e) {
            // If there's an error, leave bookings as empty array
            $this->bookings = [];
        }
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
