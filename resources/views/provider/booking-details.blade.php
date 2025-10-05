@extends('layouts.provider.simple-app')

@section('title', 'Booking Details - ' . ($booking->booking_reference ?? $booking->id))

@section('header', '') {{-- Empty header to remove Dashboard title --}}

@section('content')
<div class="container mx-auto">

    {{-- Header Banner --}}
    <div class="bg-gradient-to-r from-teal-500 to-emerald-600 text-white p-6 rounded-lg shadow-lg mb-6">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Booking Details
                </h1>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-teal-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                    </svg>
                    <p class="text-teal-100 font-medium">Ref: {{ $booking->booking_reference ?? ('BK-' . str_pad($booking->id, 4, '0', STR_PAD_LEFT)) }}</p>
                </div>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('provider.bookings') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-100 text-teal-600 text-sm font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Bookings
                </a>
            </div>
        </div>
        <div class="mt-6 flex flex-wrap items-center gap-x-4 gap-y-2">
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-white/20 text-white">
                @if($booking->status == 'pending')
                    <svg class="h-5 w-5 mr-1.5 text-yellow-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @elseif($booking->status == 'confirmed')
                    <svg class="h-5 w-5 mr-1.5 text-green-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                @elseif($booking->status == 'cancelled')
                    <svg class="h-5 w-5 mr-1.5 text-red-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                @elseif($booking->status == 'completed')
                    <svg class="h-5 w-5 mr-1.5 text-teal-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                @endif
                Status: {{ ucfirst($booking->status) }}
            </span>
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-white/20 text-white">
                <svg class="h-5 w-5 mr-1.5 text-teal-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Payment: {{ ucfirst($booking->payment_status ?? 'N/A') }}
            </span>
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-white/20 text-white">
                <svg class="h-5 w-5 mr-1.5 text-teal-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Created: {{ date('F j, Y', strtotime($booking->created_at)) }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-md shadow-sm flex items-center">
            <svg class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-800 rounded-md shadow-sm flex items-center">
            <svg class="h-5 w-5 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column (Main Details) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Activity Card --}}
            <div class="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                <div class="px-6 py-4 bg-gradient-to-r from-teal-50 to-emerald-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        Activity Information
                    </h3>
                </div>
                <div class="px-6 py-5">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Name
                            </dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $booking->activity->name ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                </svg>
                                Type
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @php
                                    $activityType = $booking->activity && isset($booking->activity->activity_type) ?
                                                    $booking->activity->activity_type :
                                                    ($booking->activity && isset($booking->activity->type) ?
                                                     $booking->activity->type : '');
                                @endphp
                                @if($activityType)
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($activityType === 'camping') bg-green-100 text-green-800
                                        @elseif($activityType === 'glamping') bg-purple-100 text-purple-800
                                        @elseif($activityType === 'hiking') bg-emerald-100 text-emerald-700
                                        @elseif($activityType === 'water_rafting') bg-cyan-100 text-cyan-800
                                        @elseif($activityType === 'houseboat') bg-orange-100 text-orange-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $activityType)) }}
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Unknown
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Location
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->activity->location ?? 'N/A' }}</dd>
                        </div>

                        {{-- Lot Info (Conditional) --}}
                        @php
                            $activityType = $booking->activity && isset($booking->activity->activity_type) ?
                                            $booking->activity->activity_type :
                                            ($booking->activity && isset($booking->activity->type) ?
                                             $booking->activity->type : '');
                        @endphp
                        @if($booking->activity && in_array($activityType, ['camping', 'glamping']) && $booking->lot)
                        <div class="sm:col-span-2 pt-4 border-t border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
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
            <div class="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                <div class="px-6 py-4 bg-gradient-to-r from-amber-50 to-yellow-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Special Requests
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <div class="bg-yellow-50 p-4 rounded-md border border-yellow-100">
                        <p class="text-sm text-gray-700">{{ $booking->special_requests }}</p>
                    </div>
                </div>
            </div>
            @endif

        </div>

        {{-- Right Column (Customer & Booking Timing/Price) --}}
        <div class="space-y-6">
            {{-- Booking Details Card --}}
            <div class="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                <div class="px-6 py-4 bg-gradient-to-r from-teal-50 to-emerald-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Booking Details
                    </h3>
                </div>
                <div class="px-6 py-5">
                    <dl class="space-y-4">
                        <div class="flex items-center justify-between">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Date & Time
                            </dt>
                            <dd class="text-sm text-gray-900 font-medium text-right">
                                {{ $booking->formatted_date ?? date('M d, Y', strtotime($booking->date ?? $booking->created_at)) }}
                                @if($booking->formatted_time ?? $booking->time)
                                 at <span class="font-medium">{{ $booking->formatted_time ?? $booking->time }}</span>
                                @endif
                            </dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Participants
                            </dt>
                            <dd class="text-sm text-gray-900 font-medium text-right">{{ $booking->participants ?? 'N/A' }}</dd>
                        </div>
                        <div class="pt-4 border-t border-gray-200">
                            <dt class="text-sm font-medium text-gray-500 flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Total Price
                            </dt>
                            <dd class="text-2xl font-bold text-teal-600 text-right">
                                RM {{ number_format($booking->total_price ?? 0, 2) }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Customer Card --}}
            <div class="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                <div class="px-6 py-4 bg-gradient-to-r from-teal-50 to-emerald-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Customer Information
                    </h3>
                </div>
                <div class="px-6 py-5">
                    <div class="flex items-center mb-5">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-teal-100 flex items-center justify-center text-teal-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">{{ $booking->user->name ?? 'N/A' }}</h4>
                            <p class="text-sm text-gray-500">Customer since {{ $booking->user->created_at ? date('M Y', strtotime($booking->user->created_at)) : 'N/A' }}</p>
                        </div>
                    </div>
                    <dl class="space-y-3 mt-3">
                        <div class="flex items-center justify-between">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Email
                            </dt>
                            <dd class="text-sm text-gray-900 font-medium text-right">{{ $booking->user->email ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-sm font-medium text-gray-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                Phone
                            </dt>
                            <dd class="text-sm text-gray-900 font-medium text-right">{{ $booking->user->phone ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
