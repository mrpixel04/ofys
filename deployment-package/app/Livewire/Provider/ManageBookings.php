<?php

namespace App\Livewire\Provider;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Activity;
use App\Models\ShopInfo;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ManageBookings extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $successMessage = '';

    protected $listeners = [
        'refreshBookings' => '$refresh',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    protected function fetchBooking($id)
    {
        // This method is no longer strictly needed here but keep for potential future use?
        // Or remove if definitely not needed.
        return Booking::with(['user', 'activity', 'lot'])->findOrFail($id);
    }

    public function render()
    {
        $user = Auth::user();
        $shopInfo = $user->shopInfo;

        if (!$shopInfo) {
            return view('livewire.provider.manage-bookings', [
                'bookings' => [],
                'totalBookings' => 0,
                'pendingBookings' => 0,
                'confirmedBookings' => 0,
                'completedBookings' => 0,
            ]);
        }

        // Get real bookings for this provider's activities
        $query = Booking::whereHas('activity', function($query) use ($shopInfo) {
            $query->where('shop_info_id', $shopInfo->id);
        });

        // Apply status filter if set
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Apply search filter if set
        if ($this->search) {
            $search = '%' . $this->search . '%';
            $query->where(function($q) use ($search) {
                $q->where('booking_reference', 'like', $search)
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', $search)
                        ->orWhere('email', 'like', $search);
                  })
                  ->orWhereHas('activity', function($q) use ($search) {
                      $q->where('name', 'like', $search)
                        ->orWhere('location', 'like', $search);
                  });
            });
        }

        $bookings = $query->with(['user', 'activity', 'lot'])->latest()->get();

        // Get counts for stat cards
        $totalBookings = $bookings->count();
        $pendingBookings = $bookings->where('status', 'pending')->count();
        $confirmedBookings = $bookings->where('status', 'confirmed')->count();
        $completedBookings = $bookings->where('status', 'completed')->count();

        return view('livewire.provider.manage-bookings', [
            'bookings' => $bookings,
            'totalBookings' => $totalBookings,
            'pendingBookings' => $pendingBookings,
            'confirmedBookings' => $confirmedBookings,
            'completedBookings' => $completedBookings,
        ]);
    }
}
