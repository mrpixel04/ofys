<x-admin-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="mb-4 flex items-center space-x-2">
            <a href="{{ route('admin.providers.activities') }}" class="text-purple-600 hover:text-purple-900 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Activities
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white flex justify-between items-center">
                <h1 class="text-xl font-bold">Activity Details</h1>
                <div class="flex space-x-2">
                    <span class="px-3 py-1 text-xs rounded-full {{ $activity->is_active ? 'bg-green-500' : 'bg-red-500' }} text-white font-semibold">
                        {{ $activity->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column: Activity Info -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Basic Info -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="flex justify-between items-start mb-4">
                            <h2 class="text-lg font-medium text-gray-800">Activity Information</h2>
                            @if(isset($activity->images[0]))
                                <img src="{{ asset('storage/' . $activity->images[0]) }}" alt="{{ $activity->name }}" class="w-24 h-24 object-cover rounded-lg">
                            @else
                                <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="font-medium">{{ $activity->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Category</p>
                                <p class="font-medium">{{ $activityTypes[$activity->activity_type] ?? ucfirst(str_replace('_', ' ', $activity->activity_type)) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Location</p>
                                <p class="font-medium">{{ $activity->location }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Price</p>
                                <p class="font-medium text-purple-600">RM {{ number_format($activity->price, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Price Type</p>
                                <p class="font-medium">{{ $activity->price_type_formatted ?? ucfirst(str_replace('_', ' ', $activity->price_type)) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Participants</p>
                                <p class="font-medium">
                                    Min: {{ $activity->min_participants }}
                                    @if($activity->max_participants)
                                        | Max: {{ $activity->max_participants }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Duration</p>
                                <p class="font-medium">
                                    @if($activity->duration_minutes)
                                        {{ floor($activity->duration_minutes/60) }}h {{ $activity->duration_minutes % 60 }}m
                                    @else
                                        Not specified
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Created On</p>
                                <p class="font-medium">{{ $activity->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Description, Requirements, etc. -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-medium text-gray-800 mb-4">Description & Details</h2>

                        <div class="mb-4">
                            <h3 class="text-md font-medium text-gray-700 mb-2">Description</h3>
                            <p class="text-sm text-gray-600">{{ $activity->description ?: 'No description provided.' }}</p>
                        </div>

                        @if($activity->requirements)
                        <div class="mb-4">
                            <h3 class="text-md font-medium text-gray-700 mb-2">Requirements</h3>
                            <p class="text-sm text-gray-600">{{ $activity->requirements }}</p>
                        </div>
                        @endif

                        @if($activity->included_items && count($activity->included_items) > 0)
                        <div class="mb-4">
                            <h3 class="text-md font-medium text-gray-700 mb-2">Included Items</h3>
                            <ul class="list-disc list-inside text-sm text-gray-600">
                                @foreach($activity->included_items as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if($activity->excluded_items && count($activity->excluded_items) > 0)
                        <div class="mb-4">
                            <h3 class="text-md font-medium text-gray-700 mb-2">Excluded Items</h3>
                            <ul class="list-disc list-inside text-sm text-gray-600">
                                @foreach($activity->excluded_items as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if($activity->amenities && count($activity->amenities) > 0)
                        <div class="mb-4">
                            <h3 class="text-md font-medium text-gray-700 mb-2">Amenities</h3>
                            <ul class="list-disc list-inside text-sm text-gray-600">
                                @foreach($activity->amenities as $amenity)
                                    <li>{{ $amenity }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if($activity->rules && count($activity->rules) > 0)
                        <div class="mb-4">
                            <h3 class="text-md font-medium text-gray-700 mb-2">Rules</h3>
                            <ul class="list-disc list-inside text-sm text-gray-600">
                                @foreach($activity->rules as $rule)
                                    <li>{{ $rule }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if($activity->cancelation_policy)
                        <div class="mb-4">
                            <h3 class="text-md font-medium text-gray-700 mb-2">Cancellation Policy</h3>
                            <p class="text-sm text-gray-600">{{ $activity->cancelation_policy }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Image Gallery -->
                    @if($activity->images && count($activity->images) > 0)
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-medium text-gray-800 mb-4">Image Gallery</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($activity->images as $image)
                                <div class="relative bg-white p-1 border border-gray-200 rounded-lg shadow-sm">
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $activity->name }}" class="w-full h-48 object-cover rounded-md">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Camping/Glamping Lots -->
                    @if(in_array($activity->activity_type, ['camping', 'glamping']) && $activity->lots->count() > 0)
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-medium text-gray-800 mb-4">Camping/Glamping Lots</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($activity->lots as $lot)
                            <div class="bg-white p-4 rounded-lg border border-gray-200 hover:shadow-md transition-all">
                                <div class="flex justify-between items-center mb-3">
                                    <h3 class="font-medium text-lg text-gray-900">{{ $lot->name }}</h3>
                                    <span class="px-3 py-1 text-sm rounded-full {{ $lot->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $lot->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
                                </div>
                                <div class="text-gray-600 space-y-2">
                                    <p class="text-base"><span class="font-medium">Capacity:</span> {{ $lot->capacity }} people</p>
                                    @if($lot->description)
                                        <p class="text-base"><span class="font-medium">Description:</span> {{ $lot->description }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column: Provider Info -->
                <div class="space-y-6">
                    <!-- Provider Info -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-medium text-gray-800">Provider</h2>
                            @if($activity->shopInfo)
                                <a href="{{ route('admin.providers.view', $activity->shopInfo->user->id) }}" class="text-purple-600 hover:text-purple-900 text-sm">View Provider</a>
                            @endif
                        </div>

                        @if($activity->shopInfo)
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-purple-700 font-medium text-lg">{{ substr($activity->shopInfo->company_name ?? $activity->shopInfo->user->name ?? 'P', 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $activity->shopInfo->company_name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $activity->shopInfo->user->name }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-3">
                                <div>
                                    <p class="text-xs text-gray-500">Email</p>
                                    <p class="text-sm">{{ $activity->shopInfo->user->email }}</p>
                                </div>
                                @if($activity->shopInfo->phone)
                                <div>
                                    <p class="text-xs text-gray-500">Phone</p>
                                    <p class="text-sm">{{ $activity->shopInfo->phone }}</p>
                                </div>
                                @endif
                                @if($activity->shopInfo->address)
                                <div>
                                    <p class="text-xs text-gray-500">Address</p>
                                    <p class="text-sm">{{ $activity->shopInfo->address }}</p>
                                </div>
                                @endif
                                @if($activity->shopInfo->website)
                                <div>
                                    <p class="text-xs text-gray-500">Website</p>
                                    <p class="text-sm"><a href="{{ $activity->shopInfo->website }}" target="_blank" class="text-purple-600 hover:text-purple-900">{{ $activity->shopInfo->website }}</a></p>
                                </div>
                                @endif
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Provider information not available.</p>
                        @endif
                    </div>

                    <!-- Activity Stats -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h2 class="text-lg font-medium text-gray-800 mb-4">Activity Stats</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white p-3 rounded-lg border border-gray-200">
                                <p class="text-xs text-gray-500">Bookings</p>
                                <p class="text-lg font-medium text-purple-600">0</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-gray-200">
                                <p class="text-xs text-gray-500">Views</p>
                                <p class="text-lg font-medium text-purple-600">0</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-gray-200">
                                <p class="text-xs text-gray-500">Revenue</p>
                                <p class="text-lg font-medium text-purple-600">RM 0.00</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border border-gray-200">
                                <p class="text-xs text-gray-500">Rating</p>
                                <p class="text-lg font-medium text-purple-600">N/A</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
