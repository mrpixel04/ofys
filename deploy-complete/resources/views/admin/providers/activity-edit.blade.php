@extends('layouts.simple-admin')

@section('title', 'Edit Activity')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header with back button -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.providers.activities') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:purple-purple-500 transition duration-150 ease-in-out">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Activities
        </a>
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

    <!-- Form Errors -->
    @if ($errors->any())
    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm" role="alert">
        <p class="font-medium">Please fix the following errors:</p>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Activity Edit Form -->
    <form action="{{ route('admin.providers.activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Info Card -->
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-info-circle text-purple-500 mr-2"></i>
                Basic Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Provider Info (Read-only) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provider</label>
                    <div class="mt-1 flex items-center bg-gray-50 p-3 rounded-md border border-gray-200">
                        <i class="fas fa-store text-gray-500 mr-2"></i>
                        <span class="text-gray-700">{{ $activity->shopInfo->company_name ?? $activity->shopInfo->user->name }} ({{ $activity->shopInfo->user->email }})</span>
                    </div>
                    <input type="hidden" name="shop_info_id" value="{{ $activity->shop_info_id }}">
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Activity Name <span class="text-red-600">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $activity->name) }}" required
                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>

                <!-- Activity Type -->
                <div>
                    <label for="activity_type" class="block text-sm font-medium text-gray-700 mb-1">Activity Type <span class="text-red-600">*</span></label>
                    <select name="activity_type" id="activity_type" required
                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        @foreach($activityTypes as $value => $label)
                            <option value="{{ $value }}" {{ old('activity_type', $activity->activity_type) == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (RM) <span class="text-red-600">*</span></label>
                    <input type="number" name="price" id="price" min="0" step="0.01" value="{{ old('price', $activity->price) }}" required
                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>

                <!-- Price Type -->
                <div>
                    <label for="price_type" class="block text-sm font-medium text-gray-700 mb-1">Price Type <span class="text-red-600">*</span></label>
                    <select name="price_type" id="price_type" required
                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        <option value="per_person" {{ old('price_type', $activity->price_type) == 'per_person' ? 'selected' : '' }}>Per Person</option>
                        <option value="per_group" {{ old('price_type', $activity->price_type) == 'per_group' ? 'selected' : '' }}>Per Group</option>
                        <option value="per_day" {{ old('price_type', $activity->price_type) == 'per_day' ? 'selected' : '' }}>Per Day</option>
                        <option value="per_night" {{ old('price_type', $activity->price_type) == 'per_night' ? 'selected' : '' }}>Per Night</option>
                    </select>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location <span class="text-red-600">*</span></label>
                    <input type="text" name="location" id="location" value="{{ old('location', $activity->location) }}" required
                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>

                <!-- State -->
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State <span class="text-red-600">*</span></label>
                    <select name="state" id="state" required
                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        @foreach($malaysianStates as $value => $label)
                            <option value="{{ $value }}" {{ old('state', $activity->state) == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Min Participants -->
                <div>
                    <label for="min_participants" class="block text-sm font-medium text-gray-700 mb-1">Minimum Participants <span class="text-red-600">*</span></label>
                    <input type="number" name="min_participants" id="min_participants" min="1" value="{{ old('min_participants', $activity->min_participants) }}" required
                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>

                <!-- Max Participants -->
                <div>
                    <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-1">Maximum Participants</label>
                    <input type="number" name="max_participants" id="max_participants" min="1" value="{{ old('max_participants', $activity->max_participants) }}"
                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                    <p class="text-xs text-gray-500 mt-1">Leave empty if there is no maximum limit</p>
                </div>

                <!-- Duration -->
                <div>
                    <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes)</label>
                    <input type="number" name="duration_minutes" id="duration_minutes" min="0" value="{{ old('duration_minutes', $activity->duration_minutes) }}"
                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                    <p class="text-xs text-gray-500 mt-1">E.g. 120 for 2 hours</p>
                </div>

                <!-- Status -->
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $activity->is_active) ? 'checked' : '' }}
                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Activity is active and visible to customers
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description & Details -->
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-align-left text-purple-500 mr-2"></i>
                Description & Details
            </h2>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-600">*</span></label>
                <textarea name="description" id="description" rows="5" required
                    class="block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">{{ old('description', $activity->description) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Provide a detailed description of your activity</p>
            </div>

            <!-- Requirements -->
            <div class="mb-6">
                <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">Requirements</label>
                <textarea name="requirements" id="requirements" rows="3"
                    class="block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">{{ old('requirements', $activity->requirements) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Specify any requirements for participants (age, fitness level, etc.)</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Included Items -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Included Items</label>
                    <div id="included-items-container" class="space-y-2">
                        @if(old('included_items', $activity->included_items))
                            @foreach(old('included_items', $activity->included_items ?? []) as $index => $item)
                                <div class="flex items-center space-x-2">
                                    <input type="text" name="included_items[]" value="{{ $item }}"
                                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                    <button type="button" class="remove-item text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-center space-x-2">
                                <input type="text" name="included_items[]"
                                    class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                <button type="button" class="remove-item text-red-500 hover:text-red-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-included-item" class="mt-2 text-sm text-purple-600 hover:text-purple-900">
                        <i class="fas fa-plus mr-1"></i> Add Item
                    </button>
                </div>

                <!-- Excluded Items -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Excluded Items</label>
                    <div id="excluded-items-container" class="space-y-2">
                        @if(old('excluded_items', $activity->excluded_items))
                            @foreach(old('excluded_items', $activity->excluded_items ?? []) as $index => $item)
                                <div class="flex items-center space-x-2">
                                    <input type="text" name="excluded_items[]" value="{{ $item }}"
                                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                    <button type="button" class="remove-item text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-center space-x-2">
                                <input type="text" name="excluded_items[]"
                                    class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                <button type="button" class="remove-item text-red-500 hover:text-red-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-excluded-item" class="mt-2 text-sm text-purple-600 hover:text-purple-900">
                        <i class="fas fa-plus mr-1"></i> Add Item
                    </button>
                </div>

                <!-- Amenities -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Amenities</label>
                    <div id="amenities-container" class="space-y-2">
                        @if(old('amenities', $activity->amenities))
                            @foreach(old('amenities', $activity->amenities ?? []) as $index => $item)
                                <div class="flex items-center space-x-2">
                                    <input type="text" name="amenities[]" value="{{ $item }}"
                                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                    <button type="button" class="remove-item text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-center space-x-2">
                                <input type="text" name="amenities[]"
                                    class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                <button type="button" class="remove-item text-red-500 hover:text-red-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-amenity" class="mt-2 text-sm text-purple-600 hover:text-purple-900">
                        <i class="fas fa-plus mr-1"></i> Add Amenity
                    </button>
                </div>

                <!-- Rules -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rules</label>
                    <div id="rules-container" class="space-y-2">
                        @if(old('rules', $activity->rules))
                            @foreach(old('rules', $activity->rules ?? []) as $index => $item)
                                <div class="flex items-center space-x-2">
                                    <input type="text" name="rules[]" value="{{ $item }}"
                                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                    <button type="button" class="remove-item text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-center space-x-2">
                                <input type="text" name="rules[]"
                                    class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                <button type="button" class="remove-item text-red-500 hover:text-red-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-rule" class="mt-2 text-sm text-purple-600 hover:text-purple-900">
                        <i class="fas fa-plus mr-1"></i> Add Rule
                    </button>
                </div>
            </div>

            <!-- Cancellation Policy -->
            <div class="mt-6">
                <label for="cancelation_policy" class="block text-sm font-medium text-gray-700 mb-1">Cancellation Policy</label>
                <textarea name="cancelation_policy" id="cancelation_policy" rows="3"
                    class="block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">{{ old('cancelation_policy', $activity->cancelation_policy) }}</textarea>
            </div>
        </div>

        <!-- Images -->
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-images text-purple-500 mr-2"></i>
                Images
            </h2>

            <!-- Current Images -->
            @if($activity->images && count($activity->images) > 0)
            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Current Images</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($activity->images as $index => $image)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $image) }}" alt="Activity Image" class="h-32 w-full object-cover rounded-md border border-gray-200">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <div class="flex space-x-2">
                                <button type="button" class="text-white bg-red-500 hover:bg-red-600 rounded-full p-1" onclick="document.getElementById('remove_image_{{ $index }}').checked = true; this.closest('.relative').classList.add('opacity-50');">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <input type="checkbox" name="remove_images[]" id="remove_image_{{ $index }}" value="{{ $image }}" class="hidden">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Upload New Images -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload New Images</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <i class="fas fa-upload text-gray-400 text-3xl mb-2"></i>
                        <div class="flex text-sm text-gray-600">
                            <label for="activity_images" class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500">
                                <span>Upload files</span>
                                <input id="activity_images" name="activity_images[]" type="file" class="sr-only" multiple accept="image/*">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>
                <div id="image-preview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
            </div>
        </div>

        <!-- Camping/Glamping Lots Section -->
        <div id="lots-section" class="bg-white p-6 rounded-lg shadow-md border border-gray-200 {{ !in_array(old('activity_type', $activity->activity_type), ['camping', 'glamping']) ? 'hidden' : '' }}">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-campground text-purple-500 mr-2"></i>
                Camping/Glamping Lots
            </h2>

            <p class="text-sm text-gray-600 mb-4">Define the different camping or glamping lots available for this activity.</p>

            <div id="lots-container">
                @if(count($activity->lots) > 0)
                    @foreach($activity->lots as $index => $lot)
                        <div class="lot-item bg-gray-50 p-4 rounded-md mb-4 border border-gray-200">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="font-medium text-gray-900">Lot #{{ $index + 1 }}</h3>
                                <button type="button" class="remove-lot text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </div>

                            <input type="hidden" name="lots[{{ $index }}][id]" value="{{ $lot->id }}">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Lot Name <span class="text-red-600">*</span></label>
                                    <input type="text" name="lots[{{ $index }}][name]" value="{{ $lot->name }}" required
                                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Capacity <span class="text-red-600">*</span></label>
                                    <input type="number" name="lots[{{ $index }}][capacity]" value="{{ $lot->capacity }}" min="1" required
                                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="lots[{{ $index }}][description]" rows="2"
                                    class="block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">{{ $lot->description }}</textarea>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="lots[{{ $index }}][is_available]" id="lot-available-{{ $index }}" value="1" {{ $lot->is_available ? 'checked' : '' }}
                                    class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="lot-available-{{ $index }}" class="ml-2 block text-sm text-gray-700">
                                    This lot is available for booking
                                </label>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="lot-item bg-gray-50 p-4 rounded-md mb-4 border border-gray-200">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="font-medium text-gray-900">Lot #1</h3>
                            <button type="button" class="remove-lot text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lot Name <span class="text-red-600">*</span></label>
                                <input type="text" name="lots[0][name]" required
                                    class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Capacity <span class="text-red-600">*</span></label>
                                <input type="number" name="lots[0][capacity]" min="1" value="1" required
                                    class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="lots[0][description]" rows="2"
                                class="block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm"></textarea>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="lots[0][is_available]" id="lot-available-0" value="1" checked
                                class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <label for="lot-available-0" class="ml-2 block text-sm text-gray-700">
                                This lot is available for booking
                            </label>
                        </div>
                    </div>
                @endif
            </div>

            <button type="button" id="add-lot" class="mt-4 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                <i class="fas fa-plus mr-2"></i>
                Add Another Lot
            </button>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.providers.activities.show', $activity->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                <i class="fas fa-save mr-2"></i>
                Update Activity
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Flash message auto-hide
        setTimeout(function() {
            $('#success-message, #error-message').fadeOut(500);
        }, 5000);

        // Add item handlers
        $('#add-included-item').click(function() {
            addItem('#included-items-container', 'included_items[]');
        });

        $('#add-excluded-item').click(function() {
            addItem('#excluded-items-container', 'excluded_items[]');
        });

        $('#add-amenity').click(function() {
            addItem('#amenities-container', 'amenities[]');
        });

        $('#add-rule').click(function() {
            addItem('#rules-container', 'rules[]');
        });

        // Remove item handler - using event delegation
        $(document).on('click', '.remove-item', function() {
            const container = $(this).closest('div').parent();
            $(this).closest('div').remove();

            // If the container is empty now, add an empty item
            if (container.children().length === 0) {
                const nameAttr = container.attr('id') === 'included-items-container' ? 'included_items[]' :
                                 container.attr('id') === 'excluded-items-container' ? 'excluded_items[]' :
                                 container.attr('id') === 'amenities-container' ? 'amenities[]' : 'rules[]';
                addItem('#' + container.attr('id'), nameAttr);
            }
        });

        // Function to add new item
        function addItem(container, nameAttr) {
            $(container).append(`
                <div class="flex items-center space-x-2">
                    <input type="text" name="${nameAttr}"
                        class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                    <button type="button" class="remove-item text-red-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `);
        }

        // Image preview
        $('#activity_images').change(function() {
            const preview = $('#image-preview');
            preview.empty();

            const files = this.files;
            if (files) {
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.append(`
                            <div class="relative">
                                <img src="${e.target.result}" alt="Preview" class="h-32 w-full object-cover rounded-md border border-gray-200">
                                <div class="absolute top-0 right-0 mt-1 mr-1">
                                    <button type="button" class="remove-preview bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        `);
                    }

                    reader.readAsDataURL(file);
                }
            }
        });

        // Remove image preview
        $(document).on('click', '.remove-preview', function() {
            $(this).closest('div').parent().remove();
        });

        // Handle activity type changes - show/hide camping lots section
        $('#activity_type').change(function() {
            const activityType = $(this).val();
            if (activityType === 'camping' || activityType === 'glamping') {
                $('#lots-section').removeClass('hidden');
            } else {
                $('#lots-section').addClass('hidden');
            }
        });

        // Handle camping/glamping lots
        let lotCounter = $('#lots-container .lot-item').length;

        // Add new lot
        $('#add-lot').click(function() {
            lotCounter++;
            const newLotHtml = `
                <div class="lot-item bg-gray-50 p-4 rounded-md mb-4 border border-gray-200">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-medium text-gray-900">Lot #${lotCounter}</h3>
                        <button type="button" class="remove-lot text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lot Name <span class="text-red-600">*</span></label>
                            <input type="text" name="lots[${lotCounter-1}][name]" required
                                class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Capacity <span class="text-red-600">*</span></label>
                            <input type="number" name="lots[${lotCounter-1}][capacity]" min="1" value="1" required
                                class="block w-full h-10 px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="lots[${lotCounter-1}][description]" rows="2"
                            class="block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm"></textarea>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="lots[${lotCounter-1}][is_available]" id="lot-available-${lotCounter-1}" value="1" checked
                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="lot-available-${lotCounter-1}" class="ml-2 block text-sm text-gray-700">
                            This lot is available for booking
                        </label>
                    </div>
                </div>
            `;

            $('#lots-container').append(newLotHtml);
        });

        // Remove lot - using event delegation
        $(document).on('click', '.remove-lot', function() {
            // Don't remove if it's the last lot
            if ($('#lots-container .lot-item').length > 1) {
                $(this).closest('.lot-item').remove();

                // Reindex the remaining lots
                $('#lots-container .lot-item').each(function(index) {
                    const newIndex = index;

                    // Update lot number in heading
                    $(this).find('h3').text(`Lot #${newIndex + 1}`);

                    // Update input names
                    $(this).find('input[name^="lots["][name$="][name]"]').attr('name', `lots[${newIndex}][name]`);
                    $(this).find('input[name^="lots["][name$="][capacity]"]').attr('name', `lots[${newIndex}][capacity]`);
                    $(this).find('textarea[name^="lots["][name$="][description]"]').attr('name', `lots[${newIndex}][description]`);

                    // Update checkbox
                    const checkbox = $(this).find('input[type="checkbox"]');
                    checkbox.attr('name', `lots[${newIndex}][is_available]`);
                    checkbox.attr('id', `lot-available-${newIndex}`);
                    $(this).find('label[for^="lot-available-"]').attr('for', `lot-available-${newIndex}`);
                });

                // Update counter
                lotCounter = $('#lots-container .lot-item').length;
            } else {
                alert('At least one lot is required for camping/glamping activities.');
            }
        });
    });
</script>
@endsection
