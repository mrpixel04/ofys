@extends('layouts.provider.simple-app')

@section('title', 'Booking Details - ' . ($booking->booking_reference ?? $booking->id))

@section('header', '') {{-- Empty header to remove Dashboard title --}}

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('provider.bookings') }}" class="inline-flex items-center text-teal-600 hover:text-teal-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Bookings
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <p>{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <p>{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Activity Information --}}
        <div class="md:col-span-1">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-4 border-b border-gray-200 bg-purple-50">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        Activity Information
                    </h3>
                </div>
                <div class="p-4">
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="text-lg font-semibold">{{ $booking->activity->name ?? 'CAMPING ACTIVITY NAME TEST 1' }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Type</p>
                        <div class="mt-1">
                            @php
                                $activityType = $booking->activity && isset($booking->activity->activity_type) ?
                                                $booking->activity->activity_type :
                                                ($booking->activity && isset($booking->activity->type) ?
                                                $booking->activity->type : 'camping');
                            @endphp
                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($activityType === 'camping') bg-green-100 text-green-800
                                @elseif($activityType === 'glamping') bg-purple-100 text-purple-800
                                @elseif($activityType === 'hiking') bg-blue-100 text-blue-800
                                @elseif($activityType === 'water_rafting') bg-cyan-100 text-cyan-800
                                @elseif($activityType === 'houseboat') bg-orange-100 text-orange-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $activityType)) }}
                            </span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Location</p>
                        <p class="text-md">{{ $booking->activity->location ?? 'CAMPING TEST LOCATION TEST' }}</p>
                    </div>

                    @if($booking->activity && in_array($activityType, ['camping', 'glamping']) && $booking->lot)
                    <div class="mb-4 pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500">Booked Lot</p>
                        <p class="text-md font-medium">{{ $booking->lot->name ?? ('Lot #' . $booking->lot_id) }}
                            @if($booking->lot && $booking->lot->description)
                             - <span class="text-sm text-gray-500">{{ $booking->lot->description }}</span>
                            @else
                             - <span class="text-sm text-gray-500">NEAR LAKE</span>
                            @endif
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            @if($booking->special_requests)
            <div class="bg-white shadow rounded-lg overflow-hidden mt-6">
                <div class="p-4 border-b border-gray-200 bg-amber-50">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Special Requests
                    </h3>
                </div>
                <div class="p-4">
                    <div class="bg-amber-50 p-3 rounded border border-amber-100">
                        <p class="text-sm text-gray-700">{{ $booking->special_requests }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Booking Details --}}
        <div class="md:col-span-1">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-4 border-b border-gray-200 bg-teal-50">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Booking Details
                    </h3>
                </div>
                <div class="p-4">
                    <div class="flex justify-between mb-4">
                        <div class="text-sm text-gray-500">Date & Time</div>
                        <div class="font-medium">
                            {{ $booking->formatted_date ?? date('M d, Y', strtotime($booking->date ?? $booking->created_at)) }}
                            @if($booking->formatted_time ?? $booking->time)
                                at {{ $booking->formatted_time ?? $booking->time }}
                            @endif
                        </div>
                    </div>
                    <div class="flex justify-between mb-4">
                        <div class="text-sm text-gray-500">Participants</div>
                        <div class="font-medium">{{ $booking->participants ?? '6' }}</div>
                    </div>
                    <div class="flex justify-between mb-4 pt-3 border-t border-gray-200">
                        <div class="text-sm text-gray-500">Booking Status</div>
                        <div>
                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status === 'completed') bg-blue-100 text-blue-800
                                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($booking->status ?? 'Confirmed') }}
                            </span>
                        </div>
                    </div>
                    <div class="flex justify-between pt-3 border-t border-gray-200">
                        <div class="text-sm text-gray-500">Total Price</div>
                        <div class="text-xl font-bold text-teal-600">RM {{ number_format($booking->total_price ?? 150, 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden mt-6">
                <div class="p-4 border-b border-gray-200 bg-blue-50">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Customer Information
                    </h3>
                </div>
                <div class="p-4">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 rounded-full h-10 w-10 flex items-center justify-center text-blue-500 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium">{{ $booking->user->name ?? 'ALI BN SAMAD' }}</div>
                            <div class="text-sm text-gray-500">Customer since {{ $booking->user->created_at ? date('M Y', strtotime($booking->user->created_at)) : 'Apr 2023' }}</div>
                        </div>
                    </div>
                    <div class="flex justify-between mb-3">
                        <div class="text-sm text-gray-500">Email</div>
                        <div class="font-medium">{{ $booking->user->email ?? 'ali@gmail.com' }}</div>
                    </div>
                    <div class="flex justify-between">
                        <div class="text-sm text-gray-500">Phone</div>
                        <div class="font-medium">{{ $booking->user->phone ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Update Status --}}
        <div class="md:col-span-1">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-4 border-b border-gray-200 bg-indigo-50">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Update Status
                    </h3>
                </div>
                <div class="p-4">
                    <form action="{{ route('provider.bookings.updateStatus', $booking->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Booking Status</label>
                            <select id="status" name="status" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection