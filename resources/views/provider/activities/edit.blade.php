@extends('layouts.provider.simple-app')

@section('header', 'Edit Activity')

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
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Activity Form Stub</h3>
        <p class="text-sm text-gray-500 mb-4">This is a placeholder for the activity edit form that will be implemented next.</p>

        <div class="flex items-center justify-between">
            <span class="text-teal-600">Editing: {{ $activity->name }}</span>
            <a href="{{ route('provider.activities.view', $activity->id) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                View Activity
            </a>
        </div>
    </div>
@endsection
