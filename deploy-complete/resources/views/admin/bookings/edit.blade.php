<x-admin-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="mb-4 flex items-center space-x-2">
            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-purple-600 hover:text-purple-900 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Booking Details
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white">
                <h1 class="text-xl font-bold">Edit Booking: {{ $booking->booking_reference }}</h1>
            </div>

            <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                        <p class="font-bold">Please fix the following errors:</p>
                        <ul class="list-disc ml-4">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-lg font-medium text-gray-800 mb-4">Booking Details</h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Booking Reference (read-only) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Reference</label>
                                    <input type="text" value="{{ $booking->booking_reference }}" class="w-full bg-gray-100 border-gray-300 rounded-md shadow-sm py-3 px-4 text-base" readonly>
                                </div>

                                <!-- Booking Date -->
                                <div>
                                    <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-1">Booking Date</label>
                                    <input type="date" id="booking_date" name="booking_date" value="{{ $booking->booking_date->format('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 py-3 px-4 text-base">
                                </div>

                                <!-- Start Time -->
                                <div>
                                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                                    <input type="time" id="start_time" name="start_time" value="{{ $booking->start_time->format('H:i') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 py-3 px-4 text-base">
                                </div>

                                <!-- End Time -->
                                <div>
                                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                                    <input type="time" id="end_time" name="end_time" value="{{ $booking->end_time ? $booking->end_time->format('H:i') : '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 py-3 px-4 text-base">
                                </div>

                                <!-- Participants -->
                                <div>
                                    <label for="participants" class="block text-sm font-medium text-gray-700 mb-1">Participants</label>
                                    <input type="number" id="participants" name="participants" value="{{ $booking->participants }}" min="1" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 py-3 px-4 text-base">
                                </div>

                                <!-- Total Price -->
                                <div>
                                    <label for="total_price" class="block text-sm font-medium text-gray-700 mb-1">Total Price (RM)</label>
                                    <input type="number" id="total_price" name="total_price" value="{{ $booking->total_price }}" step="0.01" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 py-3 px-4 text-base">
                                </div>
                            </div>
                        </div>

                        <!-- Activity Information (read-only) -->
                        <div>
                            <h2 class="text-lg font-medium text-gray-800 mb-4">Activity Information</h2>

                            <div class="bg-gray-50 rounded-lg p-4">
                                @if($booking->activity)
                                    <div class="flex items-center mb-3">
                                        <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-md flex items-center justify-center mr-3">
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $booking->activity->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $booking->activity->location }}</p>
                                        </div>
                                    </div>

                                    @if($booking->activity->activity_type == 'camping' || $booking->activity->activity_type == 'glamping')
                                        <div class="mb-3">
                                            <label for="lot_id" class="block text-sm font-medium text-gray-700 mb-1">Assigned Lot</label>
                                            <select id="lot_id" name="lot_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 py-3 px-4 text-base">
                                                <option value="">-- Select Lot --</option>
                                                @foreach($booking->activity->lots as $lot)
                                                    <option value="{{ $lot->id }}" {{ $booking->lot_id == $lot->id ? 'selected' : '' }}>
                                                        {{ $lot->name }} (Capacity: {{ $lot->capacity }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-sm text-gray-500">Activity information not available.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Special Requests -->
                        <div>
                            <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-1">Special Requests</label>
                            <textarea id="special_requests" name="special_requests" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 py-3 px-4 text-base">{{ $booking->special_requests }}</textarea>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-lg font-medium text-gray-800 mb-4">Customer Information</h2>

                            <div class="bg-gray-50 rounded-lg p-4">
                                @if($booking->user)
                                    <div class="flex items-center mb-3">
                                        <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-purple-700 font-medium">{{ substr($booking->user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $booking->user->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $booking->user->email }}</p>
                                            @if($booking->user->phone)
                                                <p class="text-sm text-gray-500">{{ $booking->user->phone }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">Customer information not available.</p>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Booking Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Booking Status</label>
                                <select id="status" name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 py-3 px-4 text-base">
                                    @foreach($statuses as $key => $statusName)
                                        <option value="{{ $key }}" {{ strtolower($booking->status) == $key ? 'selected' : '' }}>
                                            {{ $statusName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Payment Status -->
                            <div>
                                <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                                <select id="payment_status" name="payment_status" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 py-3 px-4 text-base">
                                    @foreach($paymentStatuses as $key => $statusName)
                                        <option value="{{ $key }}" {{ strtolower($booking->payment_status) == $key ? 'selected' : '' }}>
                                            {{ $statusName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                                <select id="payment_method" name="payment_method" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 py-3 px-4 text-base">
                                    <option value="">-- Select Method --</option>
                                    <option value="bank_transfer" {{ $booking->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="cash" {{ $booking->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="online" {{ $booking->payment_method == 'online' ? 'selected' : '' }}>Online Payment</option>
                                    <option value="credit_card" {{ $booking->payment_method == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                </select>
                            </div>

                            <!-- Payment ID -->
                            <div>
                                <label for="payment_id" class="block text-sm font-medium text-gray-700 mb-1">Payment ID/Reference</label>
                                <input type="text" id="payment_id" name="payment_id" value="{{ $booking->payment_id }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 py-3 px-4 text-base" placeholder="Transaction ID, receipt number, etc.">
                            </div>

                            <!-- Cancellation Reason -->
                            <div id="cancellation-reason-container" class="{{ strtolower($booking->status) == 'cancelled' ? '' : 'hidden' }}">
                                <label for="cancelation_reason" class="block text-sm font-medium text-gray-700 mb-1">Cancellation Reason</label>
                                <textarea id="cancelation_reason" name="cancelation_reason" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 py-3 px-4 text-base">{{ $booking->cancelation_reason }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-6 rounded-md transition-colors text-base">
                        Cancel
                    </a>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-6 rounded-md transition-colors text-base">
                        Update Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status');
            const cancellationContainer = document.getElementById('cancellation-reason-container');

            // Show/hide cancellation reason based on status
            statusSelect.addEventListener('change', function() {
                if (this.value === 'cancelled') {
                    cancellationContainer.classList.remove('hidden');
                } else {
                    cancellationContainer.classList.add('hidden');
                }
            });
        });
    </script>
</x-admin-layout>
