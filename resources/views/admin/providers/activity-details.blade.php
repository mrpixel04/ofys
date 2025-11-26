@extends('layouts.simple-admin')

@section('title', 'Activity Details')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header with back button -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.providers.activities') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-150 ease-in-out">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Activities
        </a>
        <div class="flex space-x-3">
            @if($activity->shopInfo)
                <a href="{{ route('admin.providers.view', $activity->shopInfo->user->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-user mr-2"></i>
                    View Vendor
                </a>
            @endif
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
    <div id="success-message" class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-2"></i>
            <p>{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if (session('error'))
    <div id="error-message" class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm" role="alert">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
            <p>{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <!-- Activity Header with status badge -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                {{ $activity->name }}
                @if($activity->is_active)
                    <span class="ml-2 px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                @else
                    <span class="ml-2 px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Inactive</span>
                @endif
            </h1>
            <div class="mt-2 sm:mt-0 flex space-x-2">
                <a href="{{ route('admin.providers.activities.edit', $activity->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Activity
                </a>
                <button type="button" id="delete-activity-btn" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-trash mr-2"></i>
                    Delete
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Activity Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle text-purple-500 mr-2"></i>
                        Activity Information
                    </h2>
                    @if(isset($activity->images[0]))
                        <img src="{{ asset('storage/' . $activity->images[0]) }}" alt="{{ $activity->name }}" class="w-24 h-24 object-cover rounded-lg shadow-sm">
                    @else
                        <div class="w-24 h-24 bg-purple-100 rounded-lg flex items-center justify-center shadow-sm">
                            <i class="fas fa-mountain text-purple-400 text-3xl"></i>
                        </div>
                    @endif
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Category</p>
                        <p class="font-medium text-gray-900">{{ $activityTypes[$activity->activity_type] ?? ucfirst(str_replace('_', ' ', $activity->activity_type)) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Location</p>
                        <p class="font-medium text-gray-900">{{ $activity->location }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Price</p>
                        <p class="font-medium text-purple-600">RM {{ number_format($activity->price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Price Type</p>
                        <p class="font-medium text-gray-900">{{ $activity->price_type_formatted ?? ucfirst(str_replace('_', ' ', $activity->price_type)) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Participants</p>
                        <p class="font-medium text-gray-900">
                            Min: {{ $activity->min_participants }}
                            @if($activity->max_participants)
                                | Max: {{ $activity->max_participants }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Duration</p>
                        <p class="font-medium text-gray-900">
                            @if($activity->duration_minutes)
                                {{ floor($activity->duration_minutes/60) }}h {{ $activity->duration_minutes % 60 }}m
                            @else
                                Not specified
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Created On</p>
                        <p class="font-medium text-gray-900">{{ $activity->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Last Updated</p>
                        <p class="font-medium text-gray-900">{{ $activity->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Description & Details -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-align-left text-purple-500 mr-2"></i>
                    Description & Details
                </h2>

                <div class="mb-6">
                    <h3 class="text-md font-medium text-gray-700 mb-2">Description</h3>
                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                        <p class="text-gray-700">{{ $activity->description ?: 'No description provided.' }}</p>
                    </div>
                </div>

                @if($activity->requirements)
                <div class="mb-6">
                    <h3 class="text-md font-medium text-gray-700 mb-2">Requirements</h3>
                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                        <p class="text-gray-700">{{ $activity->requirements }}</p>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($activity->included_items && count($activity->included_items) > 0)
                    <div>
                        <h3 class="text-md font-medium text-gray-700 mb-2">Included Items</h3>
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200 h-full">
                            <ul class="list-disc list-inside text-gray-700 space-y-1">
                                @foreach($activity->included_items as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    @if($activity->excluded_items && count($activity->excluded_items) > 0)
                    <div>
                        <h3 class="text-md font-medium text-gray-700 mb-2">Excluded Items</h3>
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200 h-full">
                            <ul class="list-disc list-inside text-gray-700 space-y-1">
                                @foreach($activity->excluded_items as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    @if($activity->amenities && count($activity->amenities) > 0)
                    <div>
                        <h3 class="text-md font-medium text-gray-700 mb-2">Amenities</h3>
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200 h-full">
                            <ul class="list-disc list-inside text-gray-700 space-y-1">
                                @foreach($activity->amenities as $amenity)
                                    <li>{{ $amenity }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    @if($activity->rules && count($activity->rules) > 0)
                    <div>
                        <h3 class="text-md font-medium text-gray-700 mb-2">Rules</h3>
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200 h-full">
                            <ul class="list-disc list-inside text-gray-700 space-y-1">
                                @foreach($activity->rules as $rule)
                                    <li>{{ $rule }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>

                @if($activity->cancelation_policy)
                <div class="mt-6">
                    <h3 class="text-md font-medium text-gray-700 mb-2">Cancellation Policy</h3>
                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                        <p class="text-gray-700">{{ $activity->cancelation_policy }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Image Gallery -->
            @if($activity->images && count($activity->images) > 0)
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-images text-purple-500 mr-2"></i>
                    Image Gallery
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($activity->images as $image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $activity->name }}" class="w-full h-48 object-cover rounded-md border border-gray-200 shadow-sm transition duration-300 ease-in-out hover:shadow-md">
                            <a href="{{ asset('storage/' . $image) }}" target="_blank" class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-md">
                                <i class="fas fa-search-plus text-white text-2xl"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Camping/Glamping Lots -->
            @if(in_array($activity->activity_type, ['camping', 'glamping']) && $activity->lots->count() > 0)
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-campground text-purple-500 mr-2"></i>
                    Camping/Glamping Lots
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($activity->lots as $lot)
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 hover:shadow-md transition-all">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="font-medium text-lg text-gray-900">{{ $lot->name }}</h3>
                            <span class="px-3 py-1 text-xs rounded-full {{ $lot->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $lot->is_available ? 'Available' : 'Unavailable' }}
                            </span>
                        </div>
                        <div class="text-gray-700 space-y-2">
                            <p class="flex items-center">
                                <i class="fas fa-users text-gray-500 mr-2"></i>
                                <span class="font-medium mr-1">Capacity:</span> {{ $lot->capacity }} people
                            </p>
                            @if($lot->description)
                                <p class="flex items-start">
                                    <i class="fas fa-info-circle text-gray-500 mr-2 mt-1"></i>
                                    <span><span class="font-medium">Description:</span> {{ $lot->description }}</span>
                                </p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column: Vendor Info & Stats -->
        <div class="space-y-6">
            <!-- Vendor Info -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user text-purple-500 mr-2"></i>
                    Vendor Information
                </h2>

                @if($activity->shopInfo)
                    <div class="flex items-center mb-6 pb-4 border-b border-gray-200">
                        <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mr-4 shrink-0">
                            <span class="text-purple-700 font-bold text-xl">{{ substr($activity->shopInfo->company_name ?? $activity->shopInfo->user->name ?? 'P', 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-lg">{{ $activity->shopInfo->company_name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-600">{{ $activity->shopInfo->user->name }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <i class="fas fa-envelope text-gray-500 mt-1 mr-3 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-500">Email</p>
                                <p class="text-gray-900">{{ $activity->shopInfo->user->email }}</p>
                            </div>
                        </div>

                        @if($activity->shopInfo->phone)
                        <div class="flex items-start">
                            <i class="fas fa-phone text-gray-500 mt-1 mr-3 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-500">Phone</p>
                                <p class="text-gray-900">{{ $activity->shopInfo->phone }}</p>
                            </div>
                        </div>
                        @endif

                        @if($activity->shopInfo->address)
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-gray-500 mt-1 mr-3 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-500">Address</p>
                                <p class="text-gray-900">{{ $activity->shopInfo->address }}</p>
                            </div>
                        </div>
                        @endif

                        @if($activity->shopInfo->website)
                        <div class="flex items-start">
                            <i class="fas fa-globe text-gray-500 mt-1 mr-3 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-500">Website</p>
                                <p><a href="{{ $activity->shopInfo->website }}" target="_blank" class="text-purple-600 hover:text-purple-900">{{ $activity->shopInfo->website }}</a></p>
                            </div>
                        </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <i class="fas fa-user-slash text-gray-400 text-3xl mb-2"></i>
                        <p class="text-gray-600">Vendor information not available</p>
                    </div>
                @endif
            </div>

            <!-- Activity Stats -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-chart-bar text-purple-500 mr-2"></i>
                    Activity Stats
                </h2>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-center">
                        <p class="text-xs text-gray-500 mb-1">Bookings</p>
                        <p class="text-xl font-bold text-purple-600">{{ $activity->bookings_count ?? 0 }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-center">
                        <p class="text-xs text-gray-500 mb-1">Views</p>
                        <p class="text-xl font-bold text-purple-600">{{ $activity->views_count ?? 0 }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-center">
                        <p class="text-xs text-gray-500 mb-1">Rating</p>
                        <p class="text-xl font-bold text-purple-600">{{ $activity->average_rating ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-center">
                        <p class="text-xs text-gray-500 mb-1">Reviews</p>
                        <p class="text-xl font-bold text-purple-600">{{ $activity->reviews_count ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Activity Actions -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-cog text-purple-500 mr-2"></i>
                    Actions
                </h2>

                <div class="space-y-3">
                    <a href="{{ route('admin.providers.activities.edit', $activity->id) }}"
                       class="flex items-center justify-center w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <i class="fas fa-pencil-alt mr-2"></i>
                        Edit Activity
                    </a>

                    <button type="button" id="toggle-status-button"
                       class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas {{ $activity->is_active ? 'fa-toggle-on text-green-500' : 'fa-toggle-off text-red-500' }} mr-2"></i>
                        {{ $activity->is_active ? 'Deactivate' : 'Activate' }} Activity
                    </button>

                    <button type="button" id="delete-activity-button"
                       class="flex items-center justify-center w-full px-4 py-2 border border-red-300 rounded-md shadow-sm text-base font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Delete Activity
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Delete Activity</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete this activity? This action cannot be undone.
                </p>
            </div>
            <div class="flex justify-center mt-4 space-x-4">
                <button id="cancel-delete" class="px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </button>
                <form action="{{ route('admin.providers.activities.delete', $activity->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Toggle Status Confirmation Modal -->
<div id="toggle-status-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="text-center mb-5">
                <i class="fas {{ $activity->is_active ? 'fa-toggle-off text-red-500' : 'fa-toggle-on text-green-500' }} text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">{{ $activity->is_active ? 'Deactivate' : 'Activate' }} Activity</h3>
                <p class="mt-2 text-gray-500">Are you sure you want to {{ $activity->is_active ? 'deactivate' : 'activate' }} this activity?</p>
            </div>
            <div class="flex justify-end space-x-4">
                <button id="cancel-toggle" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </button>
                <form id="toggle-status-form" action="{{ route('admin.providers.activities.toggle-status', $activity->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-{{ $activity->is_active ? 'red' : 'green' }}-600 hover:bg-{{ $activity->is_active ? 'red' : 'green' }}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $activity->is_active ? 'red' : 'green' }}-500">
                        {{ $activity->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Delete activity modal - both buttons should open the same modal
        $('#delete-activity-btn, #delete-activity-button').click(function() {
            $('#delete-modal').removeClass('hidden');
        });

        $('#cancel-delete').click(function() {
            $('#delete-modal').addClass('hidden');
        });

        // Toggle Status Modal
        $("#toggle-status-button").click(function() {
            $("#toggle-status-modal").removeClass("hidden");
        });

        $("#cancel-toggle").click(function() {
            $("#toggle-status-modal").addClass("hidden");
        });

        // Click outside modals to close
        $(window).click(function(event) {
            if ($(event.target).hasClass('fixed')) {
                $("#delete-modal").addClass("hidden");
                $("#toggle-status-modal").addClass("hidden");
            }
        });

        // Flash message auto-hide
        setTimeout(function() {
            $('#success-message, #error-message').fadeOut(500);
        }, 5000);
    });
</script>
@endsection
