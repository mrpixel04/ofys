<?php

namespace App\Livewire\Provider;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Activity;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ManageBookings extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $paymentStatusFilter = 'done'; // Default to showing only paid bookings

    // Booking view/edit properties
    public $showViewModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $currentBooking = null;
    public $editBookingId = null;

    // Edit form properties
    public $bookingDate;
    public $startTime;
    public $participants;
    public $status;
    public $specialRequests;

    // Success message
    public $successMessage = '';

    protected $listeners = [
        'refreshBookings' => '$refresh',
    ];

    public function mount()
    {
        // Default to showing only paid bookings
        $this->paymentStatusFilter = 'done';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingPaymentStatusFilter()
    {
        $this->resetPage();
    }

    public function viewBooking($id)
    {
        $this->currentBooking = $this->fetchBooking($id);
        $this->showViewModal = true;
    }

    public function editBooking($id)
    {
        $booking = $this->fetchBooking($id);
        $this->editBookingId = $booking->id;
        $this->bookingDate = $booking->booking_date->format('Y-m-d');
        $this->startTime = $booking->start_time->format('H:i');
        $this->participants = $booking->participants;
        $this->status = $booking->status;
        $this->specialRequests = $booking->special_requests;

        $this->showEditModal = true;
    }

    public function confirmDelete($id)
    {
        $this->currentBooking = $this->fetchBooking($id);
        $this->showDeleteModal = true;
    }

    public function deleteBooking()
    {
        if ($this->currentBooking) {
            Booking::destroy($this->currentBooking->id);
            $this->showDeleteModal = false;
            $this->currentBooking = null;
            $this->successMessage = 'Booking has been deleted successfully.';
        }
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->currentBooking = null;
    }

    public function saveBooking()
    {
        $this->validate([
            'bookingDate' => 'required|date',
            'startTime' => 'required',
            'participants' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking = Booking::find($this->editBookingId);

        if ($booking) {
            $booking->update([
                'booking_date' => $this->bookingDate,
                'start_time' => $this->bookingDate . ' ' . $this->startTime,
                'participants' => $this->participants,
                'status' => $this->status,
                'special_requests' => $this->specialRequests,
            ]);

            $this->showEditModal = false;
            $this->resetEditForm();
            $this->successMessage = 'Booking has been updated successfully.';
        }
    }

    public function resetEditForm()
    {
        $this->editBookingId = null;
        $this->bookingDate = null;
        $this->startTime = null;
        $this->participants = null;
        $this->status = null;
        $this->specialRequests = null;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->currentBooking = null;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetEditForm();
    }

    protected function fetchBooking($id)
    {
        return Booking::with(['user', 'activity'])->findOrFail($id);
    }

    protected function generateDummyBookings()
    {
        $activities = [
            ['name' => 'Hiking Tour', 'location' => 'Mount Kinabalu', 'price' => 350.00],
            ['name' => 'Scuba Diving', 'location' => 'Sipadan Island', 'price' => 450.00],
            ['name' => 'Camping Trip', 'location' => 'Taman Negara', 'price' => 500.00],
            ['name' => 'Fishing Tour', 'location' => 'Kuala Selangor', 'price' => 250.00],
            ['name' => 'Cave Exploration', 'location' => 'Mulu Caves', 'price' => 380.00],
            ['name' => 'Rafting Adventure', 'location' => 'Sungai Selangor', 'price' => 320.00],
        ];

        $customers = [
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ['name' => 'Mike Johnson', 'email' => 'mike@example.com'],
            ['name' => 'Sarah Williams', 'email' => 'sarah@example.com'],
            ['name' => 'Robert Brown', 'email' => 'robert@example.com'],
        ];

        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        $paymentStatuses = ['pending', 'processing', 'done', 'refunded', 'failed'];

        $bookings = [];
        for ($i = 1; $i <= 20; $i++) {
            $activity = $activities[array_rand($activities)];
            $customer = $customers[array_rand($customers)];
            $status = $statuses[array_rand($statuses)];
            $paymentStatus = $paymentStatuses[array_rand($paymentStatuses)];
            $dateOffset = rand(1, 30);
            $participants = rand(1, 5);

            $bookingDate = now()->addDays($dateOffset)->startOfDay();
            $startTime = $bookingDate->copy()->addHours(rand(8, 16));
            $endTime = $startTime->copy()->addHours(rand(2, 6));

            $bookings[] = [
                'id' => $i,
                'booking_reference' => 'BK-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'user_id' => 1, // Dummy user ID
                'activity_id' => rand(1, 5), // Dummy activity ID
                'booking_date' => $bookingDate,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'participants' => $participants,
                'total_price' => $activity['price'] * $participants,
                'status' => $status,
                'payment_status' => $paymentStatus,
                'payment_method' => 'Credit Card',
                'payment_id' => 'PAY-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'special_requests' => rand(0, 1) ? 'Please provide vegetarian food options.' : null,
                'customer_details' => $customer,
                'activity_details' => array_merge($activity, ['duration' => rand(2, 6) . ' hours']),
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => now(),
            ];
        }

        return collect($bookings);
    }

    public function render()
    {
        // Use dummy data for now
        $bookingsCollection = $this->generateDummyBookings();

        // Filter by payment status (done) - ALWAYS filter by 'done' regardless of filter setting
        $bookingsCollection = $bookingsCollection->filter(function ($booking) {
            return $booking['payment_status'] === 'done';
        });

        // Filter by status if selected
        if ($this->statusFilter) {
            $bookingsCollection = $bookingsCollection->filter(function ($booking) {
                return $booking['status'] === $this->statusFilter;
            });
        }

        // Search functionality
        if ($this->search) {
            $search = strtolower($this->search);
            $bookingsCollection = $bookingsCollection->filter(function ($booking) use ($search) {
                return stripos($booking['booking_reference'], $search) !== false ||
                       stripos($booking['customer_details']['name'], $search) !== false ||
                       stripos($booking['customer_details']['email'], $search) !== false ||
                       stripos($booking['activity_details']['name'], $search) !== false;
            });
        }

        // Sort by created_at (newest first)
        $bookingsCollection = $bookingsCollection->sortByDesc('created_at');

        // For real application, you would use the following query instead of dummy data:
        // $query = Booking::query()
        //     ->where('shop_info_id', Auth::user()->shopInfo->id)
        //     ->with(['user', 'activity']);
        //
        // if ($this->paymentStatusFilter) {
        //     $query->where('payment_status', $this->paymentStatusFilter);
        // }
        //
        // if ($this->statusFilter) {
        //     $query->where('status', $this->statusFilter);
        // }
        //
        // if ($this->search) {
        //     $query->where(function ($q) {
        //         $q->where('booking_reference', 'like', '%' . $this->search . '%')
        //             ->orWhereHas('user', function ($user) {
        //                 $user->where('name', 'like', '%' . $this->search . '%')
        //                     ->orWhere('email', 'like', '%' . $this->search . '%');
        //             })
        //             ->orWhereHas('activity', function ($activity) {
        //                 $activity->where('name', 'like', '%' . $this->search . '%');
        //             });
        //     });
        // }
        //
        // $bookings = $query->latest()->paginate(10);

        // Stats for dashboard
        $totalBookings = $bookingsCollection->count();
        $pendingBookings = $bookingsCollection->where('status', 'pending')->count();
        $confirmedBookings = $bookingsCollection->where('status', 'confirmed')->count();
        $completedBookings = $bookingsCollection->where('status', 'completed')->count();

        return view('livewire.provider.manage-bookings', [
            'bookings' => $bookingsCollection->values(),
            'totalBookings' => $totalBookings,
            'pendingBookings' => $pendingBookings,
            'confirmedBookings' => $confirmedBookings,
            'completedBookings' => $completedBookings,
        ]);
    }
}
