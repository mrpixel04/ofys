@extends('layouts.provider.simple-app')

@section('header', 'Create New Activity')

@section('header_actions')
    <div class="flex space-x-3">
        <a href="{{ route('provider.activities') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-teal-700 bg-white hover:bg-teal-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Activities
        </a>
    </div>
@endsection

@section('content')
<div>
    <div class="max-w-6xl mx-auto">
        <!-- Form -->
        <form action="{{ route('provider.activities.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 bg-teal-600 rounded-md flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Activity Type -->
                    <div>
                        <label for="activity_type" class="block text-sm font-semibold text-gray-700 mb-3">Activity Type *</label>
                        <select name="activity_type" id="activity_type" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900">
                            <option value="">Select Activity Type</option>
                            @foreach($activityTypes as $key => $label)
                                <option value="{{ $key }}" {{ old('activity_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('activity_type')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Activity Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">Activity Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900"
                               placeholder="Enter an exciting activity name">
                        @error('name')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-3">Price (RM) *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">RM</span>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" required step="0.01" min="0"
                                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900"
                                   placeholder="0.00">
                        </div>
                        @error('price')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price Type -->
                    <div>
                        <label for="price_type" class="block text-sm font-semibold text-gray-700 mb-3">Price Type *</label>
                        <select name="price_type" id="price_type" required class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900">
                            <option value="">Select Price Type</option>
                            @foreach($priceTypes as $key => $label)
                                <option value="{{ $key }}" {{ old('price_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('price_type')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-8">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">Description</label>
                    <textarea name="description" id="description" rows="5"
                            class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-teal-100 focus:border-teal-500 transition-all duration-200 text-gray-900 resize-none"
                              placeholder="Describe your amazing activity in detail...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Location & Participants -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-8">
                    <div class="w-8 h-8 bg-teal-600 rounded-md flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Location & Participants</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-semibold text-gray-700 mb-3">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900"
                               placeholder="Enter location">
                        @error('location')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- State -->
                    <div>
                        <label for="state" class="block text-sm font-semibold text-gray-700 mb-3">State</label>
                        <select name="state" id="state" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900">
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                            @endforeach
                        </select>
                        @error('state')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Min Participants -->
                    <div>
                        <label for="min_participants" class="block text-sm font-semibold text-gray-700 mb-3">Min Participants *</label>
                        <input type="number" name="min_participants" id="min_participants" value="{{ old('min_participants') }}" required min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900"
                               placeholder="1">
                        @error('min_participants')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Participants -->
                    <div>
                        <label for="max_participants" class="block text-sm font-semibold text-gray-700 mb-3">Max Participants</label>
                        <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants') }}" min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900"
                               placeholder="Leave empty for unlimited">
                        @error('max_participants')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Duration</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="duration_days" class="block text-xs text-gray-600 mb-1">Days</label>
                                <input type="number" name="duration_days" id="duration_days" value="{{ old('duration_days', 0) }}" min="0" max="365"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900"
                                       placeholder="0">
                            </div>
                            <div>
                                <label for="duration_hours" class="block text-xs text-gray-600 mb-1">Hours</label>
                                <input type="number" name="duration_hours" id="duration_hours" value="{{ old('duration_hours', 0) }}" min="0" max="23"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900"
                                       placeholder="0">
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Enter the total duration of your activity</p>
                        @error('duration_days')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                        @error('duration_hours')
                            <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Additional Details -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 hover:shadow-2xl transition-shadow duration-300">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 bg-teal-600 rounded-md flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Additional Details</h2>
                </div>

                <!-- Requirements -->
                <div class="mb-8">
                    <label for="requirements" class="block text-sm font-semibold text-gray-700 mb-3">Requirements</label>
                    <textarea name="requirements" id="requirements" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 text-gray-900 resize-none"
                              placeholder="Any special requirements for participants...">{{ old('requirements') }}</textarea>
                    @error('requirements')
                        <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Includes Gear -->
                <div class="mb-8">
                    <label class="flex items-center p-3 bg-teal-50 rounded-md border border-teal-100 hover:border-teal-200 transition-colors cursor-pointer">
                        <input type="checkbox" name="includes_gear" value="1" {{ old('includes_gear') ? 'checked' : '' }}
                               class="w-4 h-4 text-teal-600 border border-gray-300 rounded focus:ring-teal-500">
                        <span class="ml-3 text-base font-semibold text-gray-800">🎒 Includes Gear & Equipment</span>
                    </label>
                </div>

                <!-- Included Items -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-4">What's Included</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @php
                            $includedOptions = [
                                'tent' => '⛺ Tent',
                                'sleeping_bag' => '🛌 Sleeping Bag',
                                'backpack' => '🎒 Backpack',
                                'hiking_boots' => '🥾 Hiking Boots',
                                'helmet' => '⛑️ Safety Helmet',
                                'life_jacket' => '🦺 Life Jacket',
                                'rope' => '🪢 Climbing Rope',
                                'harness' => '🔗 Safety Harness',
                                'flashlight' => '🔦 Flashlight',
                                'first_aid' => '🏥 First Aid Kit',
                                'water_bottle' => '💧 Water Bottle',
                                'map_compass' => '🧭 Map & Compass',
                                'fishing_gear' => '🎣 Fishing Gear',
                                'camping_chair' => '🪑 Camping Chair',
                                'portable_stove' => '🔥 Portable Stove',
                                'cooler' => '🧊 Cooler Box'
                            ];
                            $oldIncluded = old('included_items', []);
                            if (is_string($oldIncluded)) {
                                $oldIncluded = explode(',', $oldIncluded);
                            }
                        @endphp
                        @foreach($includedOptions as $key => $label)
                            <label class="flex items-center p-3 bg-teal-50 rounded-md border border-teal-200 hover:bg-teal-100 transition-colors cursor-pointer">
                                <input type="checkbox" name="included_items[]" value="{{ $key }}"
                                       {{ in_array($key, $oldIncluded) ? 'checked' : '' }}
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
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-4">What's NOT Included</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @php
                            $excludedOptions = [
                                'food' => '🍽️ Food & Meals',
                                'transport' => '🚗 Transportation',
                                'insurance' => '🛡️ Travel Insurance',
                                'personal_items' => '🧳 Personal Items',
                                'alcohol' => '🍺 Alcoholic Drinks',
                                'souvenirs' => '🎁 Souvenirs',
                                'laundry' => '🧺 Laundry Service',
                                'wifi' => '📶 WiFi Access',
                                'tips' => '💰 Tips & Gratuities',
                                'parking' => '🅿️ Parking Fees',
                                'entrance_fees' => '🎫 Entrance Fees',
                                'medical' => '💊 Medical Expenses'
                            ];
                            $oldExcluded = old('excluded_items', []);
                            if (is_string($oldExcluded)) {
                                $oldExcluded = explode(',', $oldExcluded);
                            }
                        @endphp
                        @foreach($excludedOptions as $key => $label)
                            <label class="flex items-center p-3 bg-red-50 rounded-lg border border-red-200 hover:bg-red-100 transition-colors cursor-pointer">
                                <input type="checkbox" name="excluded_items[]" value="{{ $key }}"
                                       {{ in_array($key, $oldExcluded) ? 'checked' : '' }}
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
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-4">Available Amenities</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @php
                            $amenityOptions = [
                                'wifi' => '📶 WiFi',
                                'parking' => '🅿️ Free Parking',
                                'restroom' => '🚻 Clean Restrooms',
                                'shower' => '🚿 Hot Showers',
                                'restaurant' => '🍴 On-site Restaurant',
                                'shop' => '🛒 Convenience Store',
                                'laundry' => '🧺 Laundry Facilities',
                                'bbq' => '🔥 BBQ Area',
                                'playground' => '🛝 Kids Playground',
                                'pool' => '🏊 Swimming Pool',
                                'gym' => '💪 Fitness Center',
                                'spa' => '🧘 Spa Services'
                            ];
                            $oldAmenities = old('amenities', []);
                            if (is_string($oldAmenities)) {
                                $oldAmenities = explode(',', $oldAmenities);
                            }
                        @endphp
                        @foreach($amenityOptions as $key => $label)
                            <label class="flex items-center p-3 bg-teal-50 rounded-md border border-teal-200 hover:bg-teal-100 transition-colors cursor-pointer">
                                <input type="checkbox" name="amenities[]" value="{{ $key }}"
                                       {{ in_array($key, $oldAmenities) ? 'checked' : '' }}
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
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-4">Rules & Policies</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @php
                            $ruleOptions = [
                                'no_smoking' => '🚭 No Smoking',
                                'no_pets' => '🐕‍🦺 No Pets Allowed',
                                'no_alcohol' => '🚫 No Alcohol',
                                'quiet_hours' => '🤫 Quiet Hours (10 PM - 6 AM)',
                                'age_restriction' => '🔞 Age Restrictions Apply',
                                'fitness_required' => '💪 Good Physical Fitness Required',
                                'weather_dependent' => '🌤️ Weather Dependent Activity',
                                'advance_booking' => '📅 Advance Booking Required'
                            ];
                            $oldRules = old('rules', []);
                            if (is_string($oldRules)) {
                                $oldRules = explode(',', $oldRules);
                            }
                        @endphp
                        @foreach($ruleOptions as $key => $label)
                            <label class="flex items-center p-3 bg-yellow-50 rounded-lg border border-yellow-200 hover:bg-yellow-100 transition-colors cursor-pointer">
                                <input type="checkbox" name="rules[]" value="{{ $key }}"
                                       {{ in_array($key, $oldRules) ? 'checked' : '' }}
                                       class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('rules')
                        <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Upload Images -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-8">
                    <div class="w-8 h-8 bg-teal-600 rounded-md flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Activity Images</h2>
                </div>

                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-teal-400 transition-colors">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="text-center">
                        <label for="images" class="cursor-pointer">
                            <span class="mt-2 block text-lg font-semibold text-gray-900">Upload Activity Images</span>
                            <span class="mt-2 block text-sm text-gray-500">PNG, JPG, JPEG up to 4MB each</span>
                            <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden">
                        </label>
                        <div class="mt-4">
                            <button type="button" onclick="document.getElementById('images').click()" class="inline-flex items-center px-6 py-3 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition-all duration-200 shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
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

            <!-- Lots (Dynamic - only for camping/glamping) -->
            <div id="lots-section" class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 hover:shadow-2xl transition-shadow duration-300" style="display: none;">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Lots (for Camping/Glamping)</h2>
                    </div>
                    <button type="button" id="add-lot" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add New Lot
                    </button>
                </div>

                <div id="lots-container" class="space-y-6">
                    <!-- Lots will be added here dynamically -->
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6">
                <a href="{{ route('provider.activities') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-all duration-200 text-sm font-medium">Cancel</a>
                <button type="submit" class="inline-flex items-center px-7 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-all duration-200 shadow-sm text-base font-semibold">Create Activity</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    // Show/hide lots section based on activity type
    $('#activity_type').change(function() {
        const activityType = $(this).val();
        if (activityType === 'camping' || activityType === 'glamping') {
            $('#lots-section').slideDown(300);
        } else {
            $('#lots-section').slideUp(300);
            $('#lots-container').empty();
        }
    });

    // Image preview functionality
    $('#images').change(function() {
        const files = this.files;
        const preview = $('#image-preview');
        preview.empty();

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
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

    // Add lot functionality
    let lotCounter = 0;
    $('#add-lot').click(function() {
        lotCounter++;
        const lotHtml = `
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
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Lot Name *</label>
                        <input type="text" name="lots[${lotCounter}][name]" required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-teal-100 focus:border-teal-500 transition-all duration-200 text-gray-900 font-medium"
                               placeholder="e.g., Premium Lot A">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Capacity *</label>
                        <input type="number" name="lots[${lotCounter}][capacity]" required min="1"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-teal-100 focus:border-teal-500 transition-all duration-200 text-gray-900 font-medium"
                               placeholder="4">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Description</label>
                        <textarea name="lots[${lotCounter}][description]" rows="3"
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-teal-100 focus:border-teal-500 transition-all duration-200 text-gray-900 resize-none"
                                  placeholder="Optional description for this lot..."></textarea>
                    </div>
                </div>
            </div>
        `;
        $('#lots-container').append(lotHtml);

        // Animate the new lot
        $('.lot-item').last().hide().slideDown(300);
    });

    // Remove lot functionality
    $(document).on('click', '.remove-lot', function() {
        const lotItem = $(this).closest('.lot-item');
        lotItem.slideUp(300, function() {
            lotItem.remove();
        });
    });

    // Trigger change on page load to handle old values
    $('#activity_type').trigger('change');
});
</script>
@endpush
@endsection
