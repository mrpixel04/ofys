<div class="p-6">
    <!-- Search and Filters Bar -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search Input -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="relative">
                    <input wire:model.debounce.300ms="search" type="text" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Customer, reference...">
                    <div class="absolute left-3 top-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Booking Status</label>
                <select wire:model="statusFilter" id="statusFilter" class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Statuses</option>
                    <option value="new">New</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <!-- Date Range -->
            <div>
                <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input wire:model="startDate" type="date" id="startDate" class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input wire:model="endDate" type="date" id="endDate" class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <div class="mt-4 flex justify-end">
            <button wire:click="clearFilters" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Clear Filters
            </button>
        </div>
    </div>

    <!-- Booking Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 mb-6">
        <!-- Total Bookings -->
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <div class="flex justify-between">
                <div>
                    <p class="text-xs font-medium uppercase text-gray-500">Total Bookings</p>
                    <h3 class="text-xl font-bold mt-1 text-gray-800">{{ $totalBookings }}</h3>
                </div>
                <div class="bg-indigo-100 rounded-md p-2">
                    <svg class="w-5 h-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- New Bookings -->
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <div class="flex justify-between">
                <div>
                    <p class="text-xs font-medium uppercase text-gray-500">New</p>
                    <h3 class="text-xl font-bold mt-1 text-gray-800">{{ $newBookings }}</h3>
                </div>
                <div class="bg-blue-100 rounded-md p-2">
                    <svg class="w-5 h-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Bookings -->
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <div class="flex justify-between">
                <div>
                    <p class="text-xs font-medium uppercase text-gray-500">Pending</p>
                    <h3 class="text-xl font-bold mt-1 text-gray-800">{{ $pendingBookings }}</h3>
                </div>
                <div class="bg-yellow-100 rounded-md p-2">
                    <svg class="w-5 h-5 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Confirmed Bookings -->
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <div class="flex justify-between">
                <div>
                    <p class="text-xs font-medium uppercase text-gray-500">Confirmed</p>
                    <h3 class="text-xl font-bold mt-1 text-gray-800">{{ $confirmedBookings }}</h3>
                </div>
                <div class="bg-green-100 rounded-md p-2">
                    <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completed Bookings -->
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <div class="flex justify-between">
                <div>
                    <p class="text-xs font-medium uppercase text-gray-500">Completed</p>
                    <h3 class="text-xl font-bold mt-1 text-gray-800">{{ $completedBookings }}</h3>
                </div>
                <div class="bg-indigo-100 rounded-md p-2">
                    <svg class="w-5 h-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Cancelled Bookings -->
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
            <div class="flex justify-between">
                <div>
                    <p class="text-xs font-medium uppercase text-gray-500">Cancelled</p>
                    <h3 class="text-xl font-bold mt-1 text-gray-800">{{ $cancelledBookings }}</h3>
                </div>
                <div class="bg-red-100 rounded-md p-2">
                    <svg class="w-5 h-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-gray-900">All Bookings</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Provider</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $booking['booking_reference'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex-shrink-0 mr-3 flex items-center justify-center">
                                    <span class="text-indigo-800 font-medium text-xs">{{ substr($booking['customer_details']['name'], 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $booking['customer_details']['name'] }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking['customer_details']['email'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $booking['provider_details']['name'] }}</div>
                            <div class="text-xs text-gray-500">{{ $booking['provider_details']['location'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $booking['activity_details']['name'] }}</div>
                            <div class="text-xs text-gray-500">{{ $booking['activity_details']['location'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $booking['booking_date']->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $booking['start_time']->format('h:i A') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusClass($booking['status']) }}">
                                {{ ucfirst($booking['status']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getPaymentStatusClass($booking['payment_status']) }}">
                                {{ ucfirst($booking['payment_status']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">RM {{ number_format($booking['total_price'], 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="viewBooking({{ $booking['id'] }})" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                View
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                            No bookings found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Results Count -->
        <div class="bg-white px-6 py-3 border-t border-gray-200">
            <div class="text-sm text-gray-700">
                Showing <span class="font-medium">{{ count($bookings) }}</span> bookings
                @if($search || $statusFilter || $startDate || $endDate)
                    with applied filters
                @endif
            </div>
        </div>
    </div>

    <!-- Booking Details Modal -->
    @if($showViewModal && $currentBooking)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-5 flex justify-between items-center border-b pb-4">
                        <h3 class="text-xl leading-6 font-medium text-gray-900" id="modal-title">
                            Booking Details - {{ $currentBooking['booking_reference'] }}
                        </h3>
                        <button wire:click="closeViewModal" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Booking Summary -->
                        <div>
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <h4 class="text-md font-medium text-gray-800 mb-2">Booking Summary</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">Reference:</span>
                                        <span class="text-sm font-medium">{{ $currentBooking['booking_reference'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">Created:</span>
                                        <span class="text-sm">{{ $currentBooking['created_at']->format('M d, Y H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">Status:</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusClass($currentBooking['status']) }}">
                                            {{ ucfirst($currentBooking['status']) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">Payment Status:</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getPaymentStatusClass($currentBooking['payment_status']) }}">
                                            {{ ucfirst($currentBooking['payment_status']) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Details -->
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 mb-4">
                                <h4 class="text-md font-medium text-gray-800 mb-3">Customer Details</h4>
                                <div class="flex items-center mb-4">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex-shrink-0 mr-3 flex items-center justify-center">
                                        <span class="text-indigo-800 font-medium">{{ substr($currentBooking['customer_details']['name'], 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $currentBooking['customer_details']['name'] }}</p>
                                        <p class="text-xs text-gray-600">{{ $currentBooking['customer_details']['email'] }}</p>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex">
                                        <span class="text-sm text-gray-500 w-24">Phone:</span>
                                        <span class="text-sm">{{ $currentBooking['customer_details']['phone'] }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Details -->
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                                <h4 class="text-md font-medium text-gray-800 mb-3">Payment Details</h4>
                                <div class="space-y-2">
                                    <div class="flex">
                                        <span class="text-sm text-gray-500 w-24">Method:</span>
                                        <span class="text-sm">{{ $currentBooking['payment_method'] ?? 'Not specified' }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="text-sm text-gray-500 w-24">Payment ID:</span>
                                        <span class="text-sm">{{ $currentBooking['payment_id'] ?? 'Not available' }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="text-sm text-gray-500 w-24">Total:</span>
                                        <span class="text-sm font-medium">RM {{ number_format($currentBooking['total_price'], 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div>
                            <!-- Provider Details -->
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 mb-4">
                                <h4 class="text-md font-medium text-gray-800 mb-3">Provider Details</h4>
                                <div class="space-y-2">
                                    <div class="flex">
                                        <span class="text-sm text-gray-500 w-24">Name:</span>
                                        <span class="text-sm font-medium">{{ $currentBooking['provider_details']['name'] }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="text-sm text-gray-500 w-24">Location:</span>
                                        <span class="text-sm">{{ $currentBooking['provider_details']['location'] }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Details -->
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 mb-4">
                                <h4 class="text-md font-medium text-gray-800 mb-3">Activity Details</h4>
                                <div class="space-y-2">
                                    <div class="flex">
                                        <span class="text-sm text-gray-500 w-24">Activity:</span>
                                        <span class="text-sm font-medium">{{ $currentBooking['activity_details']['name'] }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="text-sm text-gray-500 w-24">Location:</span>
                                        <span class="text-sm">{{ $currentBooking['activity_details']['location'] }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="text-sm text-gray-500 w-24">Duration:</span>
                                        <span class="text-sm">{{ $currentBooking['activity_details']['duration'] }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="text-sm text-gray-500 w-24">Date:</span>
                                        <span class="text-sm">{{ $currentBooking['booking_date']->format('F d, Y') }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="text-sm text-gray-500 w-24">Time:</span>
                                        <span class="text-sm">{{ $currentBooking['start_time']->format('h:i A') }} - {{ $currentBooking['end_time']->format('h:i A') }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="text-sm text-gray-500 w-24">Participants:</span>
                                        <span class="text-sm">{{ $currentBooking['participants'] }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                                <h4 class="text-md font-medium text-gray-800 mb-3">Additional Information</h4>

                                @if($currentBooking['special_requests'])
                                <div class="mb-3">
                                    <h5 class="text-sm font-medium text-gray-700 mb-1">Special Requests</h5>
                                    <p class="text-sm text-gray-600 bg-gray-50 p-2 rounded">{{ $currentBooking['special_requests'] }}</p>
                                </div>
                                @endif

                                @if($currentBooking['notes'])
                                <div>
                                    <h5 class="text-sm font-medium text-gray-700 mb-1">Notes</h5>
                                    <p class="text-sm text-gray-600 bg-gray-50 p-2 rounded">{{ $currentBooking['notes'] }}</p>
                                </div>
                                @endif

                                @if(!$currentBooking['special_requests'] && !$currentBooking['notes'])
                                <p class="text-sm text-gray-500">No additional information provided.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                    <button wire:click="closeViewModal" class="inline-flex justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
