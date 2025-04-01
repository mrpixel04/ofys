<div class="p-6">
    @if($successMessage)
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
        class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <p>{{ $successMessage }}</p>
        </div>
    </div>
    @endif

    <!-- Booking Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Bookings -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Paid Bookings</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $totalBookings }}</h3>
                </div>
                <div class="p-3 bg-indigo-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500">
                    Fully paid bookings
                </span>
            </div>
        </div>

        <!-- Pending Bookings -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pending</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $pendingBookings }}</h3>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500">
                    Awaiting confirmation
                </span>
            </div>
        </div>

        <!-- Confirmed Bookings -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Confirmed</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $confirmedBookings }}</h3>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500">
                    Ready for service
                </span>
            </div>
        </div>

        <!-- Completed Bookings -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Completed</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $completedBookings }}</h3>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500">
                    Finalized services
                </span>
            </div>
        </div>
    </div>

    <!-- Bookings List Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="text-lg font-medium text-gray-900 mb-2 md:mb-0">Paid Bookings</h2>
            <div class="flex flex-col sm:flex-row gap-2">
                <div class="relative">
                    <input wire:model.debounce.300ms="search" type="text" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Search bookings...">
                    <div class="absolute left-3 top-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <div class="relative">
                    <select wire:model="statusFilter" class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
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
                                    <span class="text-indigo-800 font-medium text-sm">{{ substr($booking['customer_details']['name'], 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $booking['customer_details']['name'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking['customer_details']['email'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $booking['activity_details']['name'] }}</div>
                            <div class="text-sm text-gray-500">{{ $booking['activity_details']['location'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $booking['booking_date']->format('M d, Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $booking['start_time']->format('h:i A') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($booking['status'] === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking['status'] === 'confirmed') bg-green-100 text-green-800
                                @elseif($booking['status'] === 'completed') bg-blue-100 text-blue-800
                                @elseif($booking['status'] === 'cancelled') bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($booking['status']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">RM {{ number_format($booking['total_price'], 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button type="button" wire:click="viewBooking({{ $booking['id'] }})" class="text-blue-600 hover:text-blue-900 mr-3">
                                View
                            </button>
                            <button type="button" wire:click="editBooking({{ $booking['id'] }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                Edit
                            </button>
                            <button type="button" wire:click="confirmDelete({{ $booking['id'] }})" class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No paid bookings found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination will be added here in the future -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-700">
                    Showing <span class="font-medium">{{ count($bookings) }}</span> paid bookings
                </div>
            </div>
        </div>
    </div>

    <!-- View Booking Modal -->
    @if($showViewModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-5 flex justify-between items-center border-b pb-4">
                        <h3 class="text-xl leading-6 font-medium text-gray-900" id="modal-title">
                            Booking Details
                        </h3>
                        <button type="button" wire:click="closeViewModal" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-6">
                        <!-- Booking Reference and Status -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 rounded-lg">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Booking Reference</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $currentBooking['booking_reference'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($currentBooking['status'] === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($currentBooking['status'] === 'confirmed') bg-green-100 text-green-800
                                        @elseif($currentBooking['status'] === 'completed') bg-blue-100 text-blue-800
                                        @elseif($currentBooking['status'] === 'cancelled') bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($currentBooking['status']) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                                <dd class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Paid
                                    </span>
                                </dd>
                            </div>
                        </div>

                        <!-- Customer & Activity -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Customer Details</h4>
                                <div class="flex items-center mb-4">
                                    <div class="h-12 w-12 rounded-full bg-indigo-100 flex-shrink-0 mr-3 flex items-center justify-center">
                                        <span class="text-indigo-800 font-medium text-sm">{{ substr($currentBooking['customer_details']['name'], 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-gray-800 font-medium">{{ $currentBooking['customer_details']['name'] }}</p>
                                        <p class="text-gray-600 text-sm">{{ $currentBooking['customer_details']['email'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                                <h4 class="font-semibold text-gray-800 mb-2">Activity Details</h4>
                                <p class="text-gray-800 font-medium">{{ $currentBooking['activity_details']['name'] }}</p>
                                <p class="text-gray-600 text-sm mb-2">{{ $currentBooking['activity_details']['location'] }}</p>
                                <p class="text-gray-600 text-sm">
                                    <span class="font-medium">Duration:</span>
                                    {{ $currentBooking['activity_details']['duration'] }}
                                </p>
                            </div>
                        </div>

                        <!-- Booking Details -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Booking Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-gray-500 text-sm">Date</p>
                                    <p class="text-gray-800">{{ $currentBooking['booking_date']->format('F d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Time</p>
                                    <p class="text-gray-800">{{ $currentBooking['start_time']->format('h:i A') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Participants</p>
                                    <p class="text-gray-800">{{ $currentBooking['participants'] }}</p>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <p class="text-gray-500 text-sm">Total Price</p>
                                    <p class="text-gray-800 font-bold text-lg">RM {{ number_format($currentBooking['total_price'], 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Special Requests -->
                        @if($currentBooking['special_requests'])
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Special Requests</h4>
                            <p class="text-gray-700">{{ $currentBooking['special_requests'] }}</p>
                        </div>
                        @endif

                        <!-- Payment Details -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Payment Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-gray-500 text-sm">Payment Method</p>
                                    <p class="text-gray-800">{{ $currentBooking['payment_method'] }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Payment ID</p>
                                    <p class="text-gray-800">{{ $currentBooking['payment_id'] }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Payment Status</p>
                                    <p class="text-green-600 font-medium">Paid</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                    <button type="button" wire:click="closeViewModal"
                        class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Edit Booking Modal -->
    @if($showEditModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form wire:submit.prevent="saveBooking">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="mb-5 flex justify-between items-center border-b pb-4">
                            <h3 class="text-xl leading-6 font-medium text-gray-900" id="modal-title">
                                Edit Booking
                            </h3>
                            <button type="button" wire:click="closeEditModal" class="text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-4">
                            <!-- Booking Date -->
                            <div>
                                <label for="bookingDate" class="block text-sm font-medium text-gray-700">Booking Date</label>
                                <input type="date" id="bookingDate" wire:model="bookingDate"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @if($errors->has('bookingDate')) <span class="text-red-500 text-xs">{{ $errors->first('bookingDate') }}</span> @endif
                            </div>

                            <!-- Start Time -->
                            <div>
                                <label for="startTime" class="block text-sm font-medium text-gray-700">Start Time</label>
                                <input type="time" id="startTime" wire:model="startTime"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @if($errors->has('startTime')) <span class="text-red-500 text-xs">{{ $errors->first('startTime') }}</span> @endif
                            </div>

                            <!-- Participants -->
                            <div>
                                <label for="participants" class="block text-sm font-medium text-gray-700">Participants</label>
                                <input type="number" min="1" id="participants" wire:model="participants"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @if($errors->has('participants')) <span class="text-red-500 text-xs">{{ $errors->first('participants') }}</span> @endif
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select id="status" wire:model="status"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                @if($errors->has('status')) <span class="text-red-500 text-xs">{{ $errors->first('status') }}</span> @endif
                            </div>

                            <!-- Special Requests -->
                            <div>
                                <label for="specialRequests" class="block text-sm font-medium text-gray-700">Special Requests</label>
                                <textarea id="specialRequests" wire:model="specialRequests" rows="3"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Update Booking
                        </button>
                        <button type="button" wire:click="closeEditModal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Delete Booking
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete this booking? This action cannot be undone.
                                </p>
                                @if($currentBooking)
                                <div class="mt-3 p-3 bg-gray-50 rounded-md">
                                    <p class="font-medium text-gray-800">{{ $currentBooking['booking_reference'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $currentBooking['customer_details']['name'] }} - {{ $currentBooking['activity_details']['name'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $currentBooking['booking_date']->format('M d, Y') }} at {{ $currentBooking['start_time']->format('h:i A') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="deleteBooking"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button type="button" wire:click="cancelDelete"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
