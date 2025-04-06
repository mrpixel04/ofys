@extends('layouts.simple-admin')

@section('content')
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

                    <!-- Activity Information -->
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
                    <!-- Customer Information (Read-only) -->
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

                    <!-- Payment Information (Read-only) -->
                    <div>
                        <h2 class="text-lg font-medium text-gray-800 mb-4">Payment Information</h2>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="mb-3">
                                <p class="text-sm text-gray-500">Booking Status:</p>
                                <p class="font-medium">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ strtolower($booking->status) == 'confirmed' ? 'bg-green-100 text-green-800' :
                                       (strtolower($booking->status) == 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                       (strtolower($booking->status) == 'cancelled' ? 'bg-red-100 text-red-800' :
                                       'bg-blue-100 text-blue-800')) }}">
                                        {{ ucfirst(strtolower($booking->status)) }}
                                    </span>
                                </p>
                            </div>

                            <div class="mb-3">
                                <p class="text-sm text-gray-500">Payment Status:</p>
                                <p class="font-medium">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ strtolower($booking->payment_status) == 'paid' ? 'bg-green-100 text-green-800' :
                                       (strtolower($booking->payment_status) == 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                       (strtolower($booking->payment_status) == 'failed' ? 'bg-red-100 text-red-800' :
                                       'bg-blue-100 text-blue-800')) }}">
                                        {{ ucfirst(strtolower($booking->payment_status)) }}
                                    </span>
                                </p>
                            </div>

                            <div class="mb-3">
                                <p class="text-sm text-gray-500">Payment Method:</p>
                                <p class="font-medium">{{ $booking->payment_method ? ucfirst($booking->payment_method) : 'Not specified' }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Payment ID/Reference:</p>
                                <p class="font-medium">{{ $booking->payment_id ?: 'Not provided' }}</p>
                            </div>

                            @if(strtolower($booking->status) == 'cancelled' && $booking->cancelation_reason)
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <p class="text-sm text-gray-500">Cancellation Reason:</p>
                                <p class="font-medium">{{ $booking->cancelation_reason }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Hidden fields to preserve payment data during form submission -->
                    <input type="hidden" name="status" value="{{ $booking->status }}">
                    <input type="hidden" name="payment_status" value="{{ $booking->payment_status }}">
                    <input type="hidden" name="payment_method" value="{{ $booking->payment_method }}">
                    <input type="hidden" name="payment_id" value="{{ $booking->payment_id }}">
                    <input type="hidden" name="cancelation_reason" value="{{ $booking->cancelation_reason }}">
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
@endsection
