@extends('layouts.provider.app')

@section('title', 'Booking Details - ' . ($booking->booking_reference ?? $booking->id))

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-teal-500 to-cyan-600 text-white p-6 rounded-lg shadow-lg mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-1">Booking Details</h1>
                <p class="text-teal-100">Reference: {{ $booking->booking_reference ?? ('BK-' . str_pad($booking->id, 4, '0', STR_PAD_LEFT)) }}</p>
            </div>
            <a href="{{ route('provider.bookings') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-100 text-teal-600 text-sm font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Bookings
            </a>
        </div>
        <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 text-white">
                <svg class="-ml-0.5 mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Status: {{ ucfirst($booking->status) }}
            </span>
             <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 text-white">
                <svg class="-ml-0.5 mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
                Payment: {{ ucfirst($booking->payment_status ?? 'N/A') }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-md shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-800 rounded-md shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column (Main Details) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Activity Card --}}
            <div class="bg-white shadow overflow-hidden rounded-lg border border-gray-200">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Activity Information
                    </h3>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $booking->activity->name ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                 <span class="px-2 py-0.5 inline-flex text-xs leading-4 font-semibold rounded-full
                                    @if($booking->activity && $booking->activity->type === 'camping') bg-green-100 text-green-800
                                    @elseif($booking->activity && $booking->activity->type === 'glamping') bg-purple-100 text-purple-800
                                    @elseif($booking->activity && $booking->activity->type === 'hiking') bg-blue-100 text-blue-800
                                    @elseif($booking->activity && $booking->activity->type === 'water_rafting') bg-cyan-100 text-cyan-800
                                    @elseif($booking->activity && $booking->activity->type === 'houseboat') bg-orange-100 text-orange-800
                                    {{-- Add more specific types as needed --}}
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{-- Check if activity exists before accessing type --}}
                                    {{ $booking->activity ? ucfirst(str_replace('_', ' ', $booking->activity->type ?? 'Unknown')) : 'Unknown' }}
                                </span>
                            </dd>
                        </div>
                         <div>
                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->activity->location ?? 'N/A' }}</dd>
                        </div>

                        {{-- Lot Info (Conditional) --}}
                        @if($booking->activity && in_array($booking->activity->type, ['camping', 'glamping']) && $booking->lot)
                        <div class="sm:col-span-2 pt-4 border-t border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                               <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Booked Lot
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span class="font-medium">{{ $booking->lot->name ?? ('Lot #' . $booking->lot_id) }}</span>
                                @if($booking->lot->description)
                                    <span class="text-gray-500"> - {{ $booking->lot->description }}</span>
                                @endif
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            {{-- Special Requests Card --}}
            @if($booking->special_requests)
             <div class="bg-white shadow overflow-hidden rounded-lg border border-gray-200">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 flex items-center">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        Special Requests
                    </h3>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <p class="text-sm text-gray-700 italic">{{ $booking->special_requests }}</p>
                </div>
            </div>
            @endif

        </div>

        {{-- Right Column (Customer & Booking Timing/Price) --}}
        <div class="space-y-6">
            {{-- Booking Details Card --}}
             <div class="bg-white shadow overflow-hidden rounded-lg border border-gray-200">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 flex items-center">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Booking Schedule & Cost
                    </h3>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <dl class="space-y-4">
                         <div>
                            <dt class="text-sm font-medium text-gray-500">Date & Time</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->formatted_date ?? 'N/A' }} at {{ $booking->formatted_time ?? 'N/A' }}</dd>
                        </div>
                         <div>
                            <dt class="text-sm font-medium text-gray-500">Participants</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->participants ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Price</dt>
                            <dd class="mt-1 text-xl font-semibold text-gray-900">RM {{ number_format($booking->total_price ?? 0, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

             {{-- Customer Card --}}
             <div class="bg-white shadow overflow-hidden rounded-lg border border-gray-200">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                        </svg>
                        Customer Information
                    </h3>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->user->name ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->user->email ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->user->phone ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
