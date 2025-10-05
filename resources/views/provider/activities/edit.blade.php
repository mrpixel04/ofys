@extends('layouts.provider.simple-app')

@section('header', 'Edit Activity')

@section('breadcrumbs')
    @include('layouts.partials.breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('provider.dashboard')],
            ['label' => 'Activities & Services', 'url' => route('provider.activities')],
            ['label' => 'Edit Activity'],
        ],
    ])
@endsection

@section('header_subtitle')
    Update your outdoor experience details, refresh media, and manage available lots.
@endsection

@section('header_actions')
    <div class="flex space-x-3">
        <a href="{{ route('provider.activities.view', $activity->id) }}"
           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-teal-700 bg-white hover:bg-teal-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Details
        </a>
        <a href="{{ route('provider.activities') }}"
           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            All Activities
        </a>
    </div>
@endsection

@php
    $selectedActivityType = old('activity_type', $activity->activity_type);
    $selectedPriceType = old('price_type', $activity->price_type);
    $statesList = $states ?? \App\Models\Activity::getMalaysianStates();
    $priceTypeOptions = $priceTypes ?? \App\Models\Activity::getPriceTypes();
    $includedOptions = \App\Models\Activity::getIncludedItemOptions();
    $excludedOptions = \App\Models\Activity::getExcludedItemOptions();
    $amenityOptions = \App\Models\Activity::getAmenityOptions();
    $ruleOptions = \App\Models\Activity::getRuleOptions();

    $includedItems = old('included_items', $activity->included_items ?? []);
    if (is_string($includedItems)) {
        $includedItems = explode(',', $includedItems);
    }

    $excludedItems = old('excluded_items', $activity->excluded_items ?? []);
    if (is_string($excludedItems)) {
        $excludedItems = explode(',', $excludedItems);
    }

    $amenities = old('amenities', $activity->amenities ?? []);
    if (is_string($amenities)) {
        $amenities = explode(',', $amenities);
    }

    $rules = old('rules', $activity->rules ?? []);
    if (is_string($rules)) {
        $rules = explode(',', $rules);
    }

    $durationMinutes = $activity->duration_minutes ?? 0;
    $defaultDurationDays = old('duration_days', $durationMinutes ? intdiv($durationMinutes, 1440) : null);
    $defaultDurationHours = old('duration_hours', $durationMinutes ? intdiv($durationMinutes % 1440, 60) : null);

    $existingLots = old('lots');
    if (!is_array($existingLots)) {
        $existingLots = $activity->lots->map(function ($lot) {
            return [
                'id' => $lot->id,
                'name' => $lot->name,
                'capacity' => $lot->capacity,
                'description' => $lot->description,
            ];
        })->toArray();
    }
@endphp

@section('content')
    <div class="max-w-6xl mx-auto">
        <form method="POST" action="{{ route('provider.activities.update', $activity->id) }}" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 bg-teal-600 rounded-md flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <label for="activity_type" class="block text-sm font-semibold text-gray-700 mb-3">Activity Type *</label>
                        <select name="activity_type" id="activity_type" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900">
                            <option value="">Select Activity Type</option>
                            @foreach($activityTypes as $key => $label)
                                <option value="{{ $key }}" {{ $selectedActivityType === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('activity_type')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">Activity Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $activity->name) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900"
                               placeholder="Enter an exciting activity name">
                        @error('name')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-3">Price (RM) *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">RM</span>
                            <input type="number" name="price" id="price" value="{{ old('price', $activity->price) }}" required step="0.01" min="0"
                                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900"
                                   placeholder="0.00">
                        </div>
                        @error('price')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price_type" class="block text-sm font-semibold text-gray-700 mb-3">Price Type *</label>
                        <select name="price_type" id="price_type" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900">
                            <option value="">Select Price Type</option>
                            @foreach($priceTypeOptions as $value => $label)
                                <option value="{{ $value }}" {{ $selectedPriceType === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('price_type')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="lg:col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">Description</label>
                        <textarea name="description" id="description" rows="5"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900 resize-none"
                                  placeholder="Describe your activity...">{{ old('description', $activity->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Location & Participants -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-8">
                    <div class="w-8 h-8 bg-teal-600 rounded-md flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Location & Participants</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <label for="location" class="block text-sm font-semibold text-gray-700 mb-3">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $activity->location) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900"
                               placeholder="Enter location">
                        @error('location')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-semibold text-gray-700 mb-3">State</label>
                        <select name="state" id="state" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900">
                            <option value="">Select State</option>
                            @foreach($statesList as $state)
                                <option value="{{ $state }}" {{ old('state', $activity->state) === $state ? 'selected' : '' }}>{{ $state }}</option>
                            @endforeach
                        </select>
                        @error('state')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="min_participants" class="block text-sm font-semibold text-gray-700 mb-3">Min Participants *</label>
                        <input type="number" name="min_participants" id="min_participants" value="{{ old('min_participants', $activity->min_participants) }}" required min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900"
                               placeholder="1">
                        @error('min_participants')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="max_participants" class="block text-sm font-semibold text-gray-700 mb-3">Max Participants</label>
                        <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants', $activity->max_participants) }}" min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900"
                               placeholder="Leave empty for unlimited">
                        @error('max_participants')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Duration</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="duration_days" class="block text-xs text-gray-600 mb-1">Days</label>
                                <input type="number" name="duration_days" id="duration_days" value="{{ $defaultDurationDays }}" min="0" max="365"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900"
                                       placeholder="0">
                            </div>
                            <div>
                                <label for="duration_hours" class="block text-xs text-gray-600 mb-1">Hours</label>
                                <input type="number" name="duration_hours" id="duration_hours" value="{{ $defaultDurationHours }}" min="0" max="23"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900"
                                       placeholder="0">
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Leave blank if duration is not fixed.</p>
                        @error('duration_days')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                        @error('duration_hours')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Included Items -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <label class="block text-sm font-semibold text-gray-700 mb-4">What's Included</label>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach($includedOptions as $key => $label)
                        <label class="flex items-center p-3 bg-teal-50 rounded-md border border-teal-200 hover:bg-teal-100 transition-colors cursor-pointer">
                            <input type="checkbox" name="included_items[]" value="{{ $key }}"
                                   {{ in_array($key, $includedItems ?? [], true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                @error('included_items')
                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Excluded Items -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <label class="block text-sm font-semibold text-gray-700 mb-4">What's NOT Included</label>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach($excludedOptions as $key => $label)
                        <label class="flex items-center p-3 bg-red-50 rounded-lg border border-red-200 hover:bg-red-100 transition-colors cursor-pointer">
                            <input type="checkbox" name="excluded_items[]" value="{{ $key }}"
                                   {{ in_array($key, $excludedItems ?? [], true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                @error('excluded_items')
                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Amenities -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <label class="block text-sm font-semibold text-gray-700 mb-4">Available Amenities</label>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach($amenityOptions as $key => $label)
                        <label class="flex items-center p-3 bg-teal-50 rounded-md border border-teal-200 hover:bg-teal-100 transition-colors cursor-pointer">
                            <input type="checkbox" name="amenities[]" value="{{ $key }}"
                                   {{ in_array($key, $amenities ?? [], true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                @error('amenities')
                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rules -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <label class="block text-sm font-semibold text-gray-700 mb-4">Rules & Policies</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($ruleOptions as $key => $label)
                        <label class="flex items-center p-3 bg-yellow-50 rounded-lg border border-yellow-200 hover:bg-yellow-100 transition-colors cursor-pointer">
                            <input type="checkbox" name="rules[]" value="{{ $key }}"
                                   {{ in_array($key, $rules ?? [], true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                @error('rules')
                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Equipment Toggle -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <label class="flex items-center space-x-3">
                    <input type="checkbox" name="includes_gear" value="1" {{ old('includes_gear', $activity->includes_gear) ? 'checked' : '' }}
                           class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                    <span class="text-sm font-medium text-gray-700">Equipment / gear included for participants</span>
                </label>
            </div>

            <!-- Upload Images -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 bg-teal-600 rounded-md flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Activity Images</h2>
                </div>

                @if(!empty($activity->images))
                    <div class="mb-6">
                        <p class="text-sm font-medium text-gray-700 mb-3">Current Images</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($activity->images as $imagePath)
                                <div class="relative group border border-gray-200 rounded-xl overflow-hidden">
                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $activity->name }}" class="h-40 w-full object-cover">
                                    <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <label class="absolute bottom-3 left-3 inline-flex items-center px-3 py-1 bg-white/90 rounded-full text-xs font-medium text-red-600 shadow-sm cursor-pointer">
                                        <input type="checkbox" name="remove_images[]" value="{{ $imagePath }}" class="mr-2 rounded border-gray-300 text-red-500 focus:ring-red-500">
                                        Remove
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-teal-400 transition-colors">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="text-center">
                        <label for="images" class="cursor-pointer">
                            <span class="mt-2 block text-lg font-semibold text-gray-900">Upload Additional Images</span>
                            <span class="mt-2 block text-sm text-gray-500">PNG, JPG, JPEG up to 4MB each</span>
                            <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden">
                        </label>
                        <div class="mt-4">
                            <button type="button" onclick="document.getElementById('images').click()" class="inline-flex items-center px-6 py-3 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition-all duration-200 shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Choose Images
                            </button>
                        </div>
                    </div>
                </div>
                <div id="image-preview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                @error('images.*')
                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lots (Dynamic) -->
            <div id="lots-section" class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 hover:shadow-2xl transition-shadow duration-300 hidden">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Lots (for Camping/Glamping)</h2>
                    </div>
                    <button type="button" id="add-lot" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Lot
                    </button>
                </div>

                <div id="lots-container" class="space-y-6"></div>
                @error('lots')
                    <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                @enderror
                @error('lots.*.name')
                    <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                @enderror
                @error('lots.*.capacity')
                    <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6">
                <a href="{{ route('provider.activities.view', $activity->id) }}"
                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-all duration-200 text-sm font-medium">Cancel</a>
                <button type="submit" class="inline-flex items-center px-7 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-all duration-200 shadow-sm text-base font-semibold">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function () {
        const requiresLotsTypes = ['camping', 'glamping'];
        const initialLots = @json(array_values($existingLots));
        let lotCounter = 0;

        const renderLotsSection = () => {
            const activityType = $('#activity_type').val();
            if (requiresLotsTypes.includes(activityType)) {
                $('#lots-section').slideDown(200);
            } else {
                $('#lots-section').slideUp(200, function () {
                    $('#lots-container').empty();
                });
            }
        };

        const createLotRow = (data = {}) => {
            lotCounter += 1;
            const lotKey = `lot_${lotCounter}`;
            const lotId = data.id ? `<input type="hidden" name="lots[${lotKey}][id]" value="${data.id}">` : '';
            const name = data.name ? data.name.replace(/"/g, '&quot;') : '';
            const capacity = data.capacity ?? '';
            const description = data.description ? data.description.replace(/</g, '&lt;').replace(/>/g, '&gt;') : '';

            return `
                <div class="lot-item bg-gradient-to-r from-teal-50 to-cyan-50 border-2 border-teal-200 rounded-2xl p-6 hover:shadow-lg transition-all duration-200">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <span class="w-8 h-8 bg-teal-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">${lotCounter}</span>
                            Lot ${lotCounter}
                        </h3>
                        <button type="button" class="remove-lot text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        ${lotId}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Lot Name *</label>
                            <input type="text" name="lots[${lotKey}][name]" value="${name}" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-teal-100 focus:border-teal-500 transition-all duration-200 text-gray-900 font-medium"
                                   placeholder="e.g., Premium Lot A">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Capacity *</label>
                            <input type="number" name="lots[${lotKey}][capacity]" value="${capacity}" required min="1"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-teal-100 focus:border-teal-500 transition-all duration-200 text-gray-900 font-medium"
                                   placeholder="4">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Description</label>
                            <textarea name="lots[${lotKey}][description]" rows="3"
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-teal-100 focus:border-teal-500 transition-all duration-200 text-gray-900 resize-none"
                                      placeholder="Optional description for this lot...">${description}</textarea>
                        </div>
                    </div>
                </div>
            `;
        };

        $('#activity_type').on('change', function () {
            renderLotsSection();
            if (!requiresLotsTypes.includes($(this).val())) {
                lotCounter = 0;
            }
        });

        $('#add-lot').on('click', function () {
            $('#lots-container').append(createLotRow());
        });

        $('#lots-container').on('click', '.remove-lot', function () {
            $(this).closest('.lot-item').remove();
        });

        $('#images').on('change', function () {
            const files = this.files;
            const preview = $('#image-preview');
            preview.empty();

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function (e) {
                    const imageDiv = $(`
                        <div class="relative group">
                            <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border-2 border-gray-200 group-hover:border-teal-400 transition-colors">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 rounded-lg"></div>
                            <div class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="bg-teal-500 text-white text-xs px-2 py-1 rounded">${file.name.substring(0, 10)}...</span>
                            </div>
                        </div>
                    `);
                    preview.append(imageDiv);
                };

                reader.readAsDataURL(file);
            }
        });

        const initialiseLots = () => {
            if (Array.isArray(initialLots) && initialLots.length) {
                initialLots.forEach(lot => {
                    $('#lots-container').append(createLotRow(lot));
                });
            }
        };

        renderLotsSection();
        if (requiresLotsTypes.includes($('#activity_type').val())) {
            $('#lots-section').show();
            initialiseLots();
        }
    });
</script>
@endpush
