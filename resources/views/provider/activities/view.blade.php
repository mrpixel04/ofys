@extends('layouts.provider.simple-app')

@section('header', 'View Activity')

@section('header_actions')
    <div class="flex space-x-3">
        <a href="{{ route('provider.activities') }}"
            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-teal-700 bg-white hover:bg-teal-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Activities
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 bg-gradient-to-r from-teal-600 to-teal-700">
            <h3 class="text-lg leading-6 font-medium text-white">{{ $activity->name }}</h3>
            <p class="mt-1 max-w-2xl text-sm text-teal-100">
                {{ $activityTypes[$activity->activity_type] ?? ucfirst(str_replace('_', ' ', $activity->activity_type)) }}
            </p>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $activity->description }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Location</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $activity->location }}
                        @if($activity->state)
                            , {{ $activity->state }}
                        @endif
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Price</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        RM {{ number_format($activity->price, 2) }}
                        <span class="text-gray-500">
                            @if($activity->price_type == 'per_person')
                                Per Person
                            @elseif($activity->price_type == 'per_hour')
                                Per Hour
                            @elseif($activity->price_type == 'fixed')
                                Fixed Price
                            @else
                                {{ ucfirst(str_replace('_', ' ', $activity->price_type)) }}
                            @endif
                        </span>
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Participants</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        Min: {{ $activity->min_participants }}
                        @if($activity->max_participants)
                            <span class="text-gray-500">|</span> Max: {{ $activity->max_participants }}
                        @endif
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Duration</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($activity->duration_minutes)
                            {{ floor($activity->duration_minutes/60) }} hour(s) {{ $activity->duration_minutes % 60 }} minute(s)
                        @else
                            Not specified
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Requirements</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $activity->requirements ?? 'None specified' }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Equipment</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $activity->includes_gear ? 'Equipment included' : 'No equipment included' }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 sm:mt-0 sm:col-span-2">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $activity->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $activity->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </dd>
                </div>

                @if($activity->images && count($activity->images) > 0)
                <div class="bg-gray-50 px-4 py-5 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500 mb-3">Images</dt>
                    <dd class="mt-1 text-sm text-gray-900 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($activity->images as $image)
                            <div class="relative rounded-md overflow-hidden h-48">
                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $activity->name }}" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </dd>
                </div>
                @endif
            </dl>
        </div>
    </div>

    <div class="mt-6 flex justify-end space-x-4">
        <a href="{{ route('provider.activities') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            Back to List
        </a>
        <a href="{{ route('provider.activities.edit', $activity->id) }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            Edit Activity
        </a>
    </div>
@endsection