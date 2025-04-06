<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class BookingsList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $startDate = '';
    public $endDate = '';

    // Viewing details
    public $showViewModal = false;
    public $currentBooking = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->resetPage();
    }

    public function viewBooking($id)
    {
        $this->currentBooking = $this->generateDummyBookings()->firstWhere('id', $id);
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->currentBooking = null;
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
            ['name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '+6012-3456789'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'phone' => '+6013-9876543'],
            ['name' => 'Mike Johnson', 'email' => 'mike@example.com', 'phone' => '+6017-6543210'],
            ['name' => 'Sarah Williams', 'email' => 'sarah@example.com', 'phone' => '+6019-1234567'],
            ['name' => 'Robert Brown', 'email' => 'robert@example.com', 'phone' => '+6018-7654321'],
        ];

        $providers = [
            ['name' => 'Adventure Tours Sdn Bhd', 'location' => 'Kuala Lumpur'],
            ['name' => 'Island Getaways', 'location' => 'Penang'],
            ['name' => 'Borneo Explorers', 'location' => 'Sabah'],
            ['name' => 'Nature Discovery', 'location' => 'Sarawak'],
            ['name' => 'Jungle Trekkers', 'location' => 'Pahang'],
        ];

        $statuses = ['new', 'pending', 'confirmed', 'completed', 'cancelled'];
        $paymentStatuses = ['pending', 'processing', 'done', 'refunded', 'failed'];

        $bookings = [];
        for ($i = 1; $i <= 50; $i++) {
            $activity = $activities[array_rand($activities)];
            $customer = $customers[array_rand($customers)];
            $provider = $providers[array_rand($providers)];
            $status = $statuses[array_rand($statuses)];
            $paymentStatus = $paymentStatuses[array_rand($paymentStatuses)];
            $dateOffset = rand(-60, 30); // Some bookings in the past, some in the future
            $participants = rand(1, 5);

            $bookingDate = now()->addDays($dateOffset)->startOfDay();
            $startTime = $bookingDate->copy()->addHours(rand(8, 16));
            $endTime = $startTime->copy()->addHours(rand(2, 6));

            $bookings[] = [
                'id' => $i,
                'booking_reference' => 'BK-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'user_id' => rand(1, 20), // Random user ID
                'activity_id' => rand(1, 15), // Random activity ID
                'booking_date' => $bookingDate,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'participants' => $participants,
                'total_price' => $activity['price'] * $participants,
                'status' => $status,
                'payment_status' => $paymentStatus,
                'payment_method' => rand(0, 1) ? 'Credit Card' : 'Online Banking',
                'payment_id' => rand(0, 1) ? 'PAY-' . str_pad($i, 6, '0', STR_PAD_LEFT) : null,
                'special_requests' => rand(0, 1) ? 'Please provide vegetarian food options.' : null,
                'notes' => rand(0, 1) ? 'Customer requested early check-in if possible.' : null,
                'customer_details' => $customer,
                'activity_details' => array_merge($activity, ['duration' => rand(2, 6) . ' hours']),
                'provider_details' => $provider,
                'created_at' => now()->subDays(rand($dateOffset < 0 ? abs($dateOffset) + 5 : 5, 90)),
                'updated_at' => now()->subDays(rand(0, 5)),
            ];
        }

        return collect($bookings);
    }

    public function getStatusClass($status)
    {
        return [
            'new' => 'bg-blue-100 text-blue-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-green-100 text-green-800',
            'completed' => 'bg-indigo-100 text-indigo-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ][$status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getPaymentStatusClass($status)
    {
        return [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'done' => 'bg-green-100 text-green-800',
            'refunded' => 'bg-purple-100 text-purple-800',
            'failed' => 'bg-red-100 text-red-800',
        ][$status] ?? 'bg-gray-100 text-gray-800';
    }

    public function render()
    {
        // Get dummy bookings
        $bookingsCollection = $this->generateDummyBookings();

        // Filter by status if selected
        if ($this->statusFilter) {
            $bookingsCollection = $bookingsCollection->filter(function ($booking) {
                return $booking['status'] === $this->statusFilter;
            });
        }

        // Filter by date range
        if ($this->startDate) {
            $startDate = Carbon::parse($this->startDate)->startOfDay();
            $bookingsCollection = $bookingsCollection->filter(function ($booking) use ($startDate) {
                return $booking['booking_date']->greaterThanOrEqualTo($startDate);
            });
        }

        if ($this->endDate) {
            $endDate = Carbon::parse($this->endDate)->endOfDay();
            $bookingsCollection = $bookingsCollection->filter(function ($booking) use ($endDate) {
                return $booking['booking_date']->lessThanOrEqualTo($endDate);
            });
        }

        // Search functionality
        if ($this->search) {
            $search = strtolower($this->search);
            $bookingsCollection = $bookingsCollection->filter(function ($booking) use ($search) {
                return stripos($booking['booking_reference'], $search) !== false ||
                       stripos($booking['customer_details']['name'], $search) !== false ||
                       stripos($booking['customer_details']['email'], $search) !== false ||
                       stripos($booking['activity_details']['name'], $search) !== false ||
                       stripos($booking['provider_details']['name'], $search) !== false;
            });
        }

        // Sort by created_at (newest first)
        $bookingsCollection = $bookingsCollection->sortByDesc('created_at');

        // Stats
        $totalBookings = $bookingsCollection->count();
        $newBookings = $bookingsCollection->where('status', 'new')->count();
        $pendingBookings = $bookingsCollection->where('status', 'pending')->count();
        $confirmedBookings = $bookingsCollection->where('status', 'confirmed')->count();
        $completedBookings = $bookingsCollection->where('status', 'completed')->count();
        $cancelledBookings = $bookingsCollection->where('status', 'cancelled')->count();

        // Payment stats
        $pendingPayments = $bookingsCollection->where('payment_status', 'pending')->count();
        $processingPayments = $bookingsCollection->where('payment_status', 'processing')->count();
        $completedPayments = $bookingsCollection->where('payment_status', 'done')->count();
        $refundedPayments = $bookingsCollection->where('payment_status', 'refunded')->count();
        $failedPayments = $bookingsCollection->where('payment_status', 'failed')->count();

        return view('livewire.admin.bookings-list', [
            'bookings' => $bookingsCollection->values(),
            'totalBookings' => $totalBookings,
            'newBookings' => $newBookings,
            'pendingBookings' => $pendingBookings,
            'confirmedBookings' => $confirmedBookings,
            'completedBookings' => $completedBookings,
            'cancelledBookings' => $cancelledBookings,
            'pendingPayments' => $pendingPayments,
            'processingPayments' => $processingPayments,
            'completedPayments' => $completedPayments,
            'refundedPayments' => $refundedPayments,
            'failedPayments' => $failedPayments,
        ]);
    }
}
