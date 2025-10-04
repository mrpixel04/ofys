@extends('layouts.provider.simple-app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Page Header -->
        <div class="bg-gradient-to-r from-teal-600 to-emerald-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-bold text-white">
                    Activity Details
                </h1>
                <a href="{{ route('provider.activities') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-teal-700 bg-white hover:bg-teal-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Activities
                </a>
            </div>
        </div>

        <div class="p-6">
            <!-- Activity Header -->
            <div class="bg-gradient-to-r from-teal-500 to-emerald-600 p-4 rounded-lg text-white mb-6">
                <h2 class="text-2xl font-bold mb-1">{{ $activity->name }}</h2>
                <div class="flex items-center text-teal-100">
                    <span class="px-2 py-1 bg-teal-800 bg-opacity-50 rounded-full text-xs font-semibold mr-2">
                        {{ $activityTypes[$activity->activity_type] ?? $activity->activity_type }}
                    </span>
                    <span class="flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        @if($activity->location || $activity->state)
                            {{ $activity->location }}
                            @if($activity->location && $activity->state), @endif
                            @if($activity->state)
                                {{ $malaysianStates[$activity->state] ?? $activity->state }}
                            @endif
                        @else
                            No location specified
                        @endif
                    </span>
                </div>
            </div>

            <!-- Activity Status Banner -->
            <div class="mb-6 p-4 {{ $activity->is_active ? 'bg-green-50 border-green-500 text-green-700' : 'bg-red-50 border-red-500 text-red-700' }} rounded-md border-l-4">
                <div class="flex items-center">
                    @if($activity->is_active)
                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p><span class="font-semibold">Active</span> - This activity is visible to customers and available for booking.</p>
                    @else
                        <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <p><span class="font-semibold">Inactive</span> - This activity is not visible to customers and cannot be booked.</p>
                    @endif
                </div>
            </div>

            <!-- Activity Images Gallery -->
            @if(count($activity->images ?? []) > 0)
            <div class="mb-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center">
                    <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Activity Images
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($activity->images as $image)
                        <div class="relative group rounded-lg overflow-hidden bg-gray-100 shadow-sm">
                            <div class="aspect-w-16 aspect-h-9">
                                <img src="{{ asset('storage/' . $image) }}" alt="Activity image" class="w-full h-full object-cover">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="space-y-6">
                <!-- Activity Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <!-- Price Card -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                        <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pricing
                        </h3>
                        <div class="mt-1">
                            <p class="text-2xl font-bold text-gray-800">RM {{ number_format($activity->price, 2) }}</p>
                            <p class="text-sm text-gray-500">{{ $priceTypes[$activity->price_type] ?? 'Standard Price' }}</p>
                        </div>
                    </div>

                    <!-- Participants Card -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                        <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Participants
                        </h3>
                        <div class="mt-1">
                            <p class="text-gray-800">
                                Min: <span class="font-semibold">{{ $activity->min_participants }}</span>
                                @if($activity->max_participants)
                                    <span class="mx-1">|</span> Max: <span class="font-semibold">{{ $activity->max_participants }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Duration Card -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                        <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Duration
                        </h3>
                        <div class="mt-1">
                            @if($activity->duration_minutes)
                                <p class="text-gray-800 font-semibold">
                                    {{ floor($activity->duration_minutes/60) }}h {{ $activity->duration_minutes % 60 }}m
                                </p>
                            @else
                                <p class="text-gray-500 italic">Not specified</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($activity->description)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 mb-6">
                    <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Description
                    </h3>
                    <p class="text-gray-700">{{ $activity->description }}</p>
                </div>
                @endif

                <!-- Requirements -->
                @if($activity->requirements)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 mb-6">
                    <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Requirements
                    </h3>
                    <p class="text-gray-700">{{ $activity->requirements }}</p>
                </div>
                @endif

                <!-- Items Grid: Included & Excluded -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Included Items -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                        <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            What's Included
                        </h3>
                        @if(count($activity->included_items ?? []))
                            <ul class="mt-2 space-y-1">
                                @foreach($activity->included_items as $item)
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-gray-700">{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 italic mt-2">No items specified</p>
                        @endif
                    </div>

                    <!-- Excluded Items -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                        <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            What's Excluded
                        </h3>
                        @if(count($activity->excluded_items ?? []))
                            <ul class="mt-2 space-y-1">
                                @foreach($activity->excluded_items as $item)
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span class="text-gray-700">{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 italic mt-2">No items specified</p>
                        @endif
                    </div>
                </div>

                <!-- Items Grid: Amenities & Rules -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Amenities -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                        <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                            Amenities
                        </h3>
                        @if(count($activity->amenities ?? []))
                            <ul class="mt-2 space-y-1">
                                @foreach($activity->amenities as $item)
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-teal-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-gray-700">{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 italic mt-2">No amenities specified</p>
                        @endif
                    </div>

                    <!-- Rules -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                        <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Rules
                        </h3>
                        @if(count($activity->rules ?? []))
                            <ul class="mt-2 space-y-1">
                                @foreach($activity->rules as $item)
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        <span class="text-gray-700">{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 italic mt-2">No rules specified</p>
                        @endif
                    </div>
                </div>

                <!-- Lot Locations Section (Only for Camping and Glamping) -->
                @if(in_array($activity->activity_type, ['camping', 'glamping']))
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 mb-6">
                    <h3 class="font-semibold text-gray-700 mb-4 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Lot Locations
                    </h3>

                    @if($activity->lots->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($activity->lots as $lot)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="text-lg font-medium text-gray-900">{{ $lot->name }}</h4>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $lot->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $lot->is_available ? 'Available' : 'Not Available' }}
                                        </span>
                                    </div>
                                    @if($lot->description)
                                        <p class="text-gray-600 mb-2">{{ $lot->description }}</p>
                                    @endif
                                    <div class="flex items-center text-gray-700">
                                        <svg class="h-5 w-5 mr-1 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Capacity: <span class="font-medium ml-1">{{ $lot->capacity }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="mt-2 text-base font-medium text-gray-900">No lots available</h3>
                            <p class="mt-1 text-base text-gray-500">No lot locations have been added to this activity yet.</p>
                        </div>
                    @endif
                </div>
                @endif

                <!-- Cancellation Policy -->
                @if($activity->cancelation_policy)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 mb-6">
                    <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Cancellation Policy
                    </h3>
                    <p class="text-gray-700">{{ $activity->cancelation_policy }}</p>
                </div>
                @endif

                <!-- Equipment Flag -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 mb-6">
                    <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path>
                        </svg>
                        Equipment
                    </h3>
                    <p class="text-gray-700">
                        @if($activity->includes_gear)
                            <span class="inline-flex items-center text-green-800">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                This activity includes gear/equipment
                            </span>
                        @else
                            <span class="inline-flex items-center text-gray-500">
                                <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                This activity does not include gear/equipment
                            </span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 pt-5 border-t border-gray-200">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('provider.activities') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        Back to Activities
                    </a>
                    <a href="{{ route('provider.activities.edit', $activity->id) }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        Edit Activity
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
