<div>
    <form wire:submit.prevent="saveShopInfo">
        <div
            x-data="{ activeTab: $persist('basic-info') }"
            class="bg-white rounded-lg shadow-lg overflow-hidden">

            <!-- Form Header -->
            <div class="bg-gradient-to-r from-teal-600 to-emerald-600 px-6 py-5 text-white">
                <h2 class="text-xl font-bold">Company Information</h2>
                <p class="mt-1 text-teal-100 text-sm">Complete your company details to showcase your services</p>
            </div>

            <!-- Tab Navigation -->
            <div class="bg-gray-50 border-b border-gray-200">
                <nav class="flex overflow-x-auto py-2 px-4">
                    <button
                        type="button"
                        @click="activeTab = 'basic-info'"
                        :class="{'text-teal-600 border-teal-600': activeTab === 'basic-info', 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300': activeTab !== 'basic-info'}"
                        class="px-3 py-2 font-medium text-sm border-b-2 transition-colors whitespace-nowrap mr-8">
                        Basic Information
                    </button>
                    <button
                        type="button"
                        @click="activeTab = 'contact'"
                        :class="{'text-teal-600 border-teal-600': activeTab === 'contact', 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300': activeTab !== 'contact'}"
                        class="px-3 py-2 font-medium text-sm border-b-2 transition-colors whitespace-nowrap mr-8">
                        Contact & Location
                    </button>
                    <button
                        type="button"
                        @click="activeTab = 'operations'"
                        :class="{'text-teal-600 border-teal-600': activeTab === 'operations', 'text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300': activeTab !== 'operations'}"
                        class="px-3 py-2 font-medium text-sm border-b-2 transition-colors whitespace-nowrap">
                        Operations & Hours
                    </button>
                </nav>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                @if(session()->has('message'))
                    @php
                        $messageType = session('message_type', 'success');
                        $bgColor = $messageType === 'success' ? 'bg-green-50' : 'bg-red-50';
                        $borderColor = $messageType === 'success' ? 'border-green-400' : 'border-red-400';
                        $textColor = $messageType === 'success' ? 'text-green-700' : 'text-red-700';
                        $iconColor = $messageType === 'success' ? 'text-green-400' : 'text-red-400';
                    @endphp
                    <div class="mb-4 {{ $bgColor }} border-l-4 {{ $borderColor }} p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                @if($messageType === 'success')
                                    <svg class="h-5 w-5 {{ $iconColor }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5 {{ $iconColor }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>
                            <div class="ml-3">
                                <p class="text-sm {{ $textColor }}">{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Tab: Basic Information -->
                <div x-show="activeTab === 'basic-info'" class="space-y-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Company Name -->
                        <div class="col-span-2 sm:col-span-1">
                            <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    id="company_name"
                                    wire:model="company_name"
                                    class="h-11 text-base shadow-sm focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md"
                                    placeholder="Enter your company's official name">
                            </div>
                            @error('company_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Business Type -->
                        <div class="col-span-2 sm:col-span-1">
                            <label for="business_type" class="block text-sm font-medium text-gray-700">Business Type <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <select
                                    id="business_type"
                                    wire:model="business_type"
                                    class="h-11 text-base shadow-sm focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md">
                                    <option value="">Select business type</option>
                                    <option value="outdoor_activity">Outdoor Activity Provider</option>
                                    <option value="camping_site">Camping Site</option>
                                    <option value="glamping">Glamping</option>
                                    <option value="adventure_tour">Adventure Tour</option>
                                    <option value="equipment_rental">Equipment Rental</option>
                                    <option value="guided_tour">Guided Tour Service</option>
                                    <option value="retreat_center">Retreat Center</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            @error('business_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Logo -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Company Logo</label>
                            <div class="mt-1 flex items-center space-x-6">
                                <div class="flex-shrink-0">
                                    <div class="h-32 w-32 rounded-md border border-gray-200 bg-gray-100 flex items-center justify-center">
                                        @if ($logo)
                                            <img src="{{ $logo->temporaryUrl() }}" alt="Logo Preview" class="h-full w-full object-contain rounded-md">
                                        @elseif($existing_logo)
                                            <img src="{{ Storage::url($existing_logo) }}" alt="Company Logo" class="h-full w-full object-contain rounded-md">
                                        @else
                                            <svg class="h-12 w-12 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <label for="logo-upload" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        Upload Logo
                                    </label>
                                    <input id="logo-upload" type="file" wire:model="logo" class="hidden" accept="image/*" />
                                    <p class="mt-1 text-xs text-gray-500">Recommended size: 400x400px. PNG or JPG up to 1MB.</p>
                                </div>
                            </div>
                            @error('logo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Shop Image -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Shop Image</label>
                            <div class="mt-1 flex items-center space-x-6">
                                <div class="flex-shrink-0">
                                    <div class="h-32 w-48 rounded-md border border-gray-200 bg-gray-100 flex items-center justify-center">
                                        @if ($shop_image)
                                            <img src="{{ $shop_image->temporaryUrl() }}" alt="Shop Preview" class="h-full w-full object-cover rounded-md">
                                        @elseif($existing_shop_image)
                                            <img src="{{ Storage::url($existing_shop_image) }}" alt="Shop Image" class="h-full w-full object-cover rounded-md">
                                        @else
                                            <svg class="h-12 w-12 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <label for="shop-image-upload" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        Upload Shop Image
                                    </label>
                                    <input id="shop-image-upload" type="file" wire:model="shop_image" class="hidden" accept="image/*" />
                                    <p class="mt-1 text-xs text-gray-500">Upload a high-quality image of your shop. JPG or PNG up to 2MB.</p>
                                </div>
                            </div>
                            @error('shop_image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Company Description</label>
                            <div class="mt-1">
                                <textarea
                                    id="description"
                                    wire:model="description"
                                    rows="4"
                                    class="text-base shadow-sm focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md"
                                    placeholder="Tell customers about your business, specialties, and the experiences you offer"></textarea>
                            </div>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-5">
                        <button type="button" @click="activeTab = 'contact'" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            Next: Contact & Location
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Tab: Contact & Location -->
                <div x-show="activeTab === 'contact'" class="space-y-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Contact Information -->
                        <div class="col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Contact Information</h3>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-span-2 sm:col-span-1">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    id="phone"
                                    wire:model="phone"
                                    class="h-11 text-base shadow-sm focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md"
                                    placeholder="+60 12-345-6789">
                            </div>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-span-2 sm:col-span-1">
                            <label for="company_email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input
                                    type="email"
                                    id="company_email"
                                    wire:model="company_email"
                                    class="h-11 text-base shadow-sm focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md"
                                    placeholder="company@example.com">
                            </div>
                            @error('company_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Website -->
                        <div class="col-span-2">
                            <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    id="website"
                                    wire:model="website"
                                    class="h-11 text-base shadow-sm focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md"
                                    placeholder="https://www.example.com">
                            </div>
                            @error('website')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location Information -->
                        <div class="col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-6">Location Information</h3>
                        </div>

                        <!-- Address -->
                        <div class="col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    id="address"
                                    wire:model="address"
                                    class="h-11 text-base shadow-sm focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md"
                                    placeholder="Enter your street address">
                            </div>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- City -->
                        <div class="col-span-2 sm:col-span-1">
                            <label for="city" class="block text-sm font-medium text-gray-700">City <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    id="city"
                                    wire:model="city"
                                    class="h-11 text-base shadow-sm focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md"
                                    placeholder="Enter city">
                            </div>
                            @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- State -->
                        <div class="col-span-2 sm:col-span-1">
                            <label for="state" class="block text-sm font-medium text-gray-700">State <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    id="state"
                                    wire:model="state"
                                    class="h-11 text-base shadow-sm focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md"
                                    placeholder="Enter state">
                            </div>
                            @error('state')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Postal Code -->
                        <div class="col-span-2 sm:col-span-1">
                            <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input
                                    type="text"
                                    id="postal_code"
                                    wire:model="postal_code"
                                    class="h-11 text-base shadow-sm focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md"
                                    placeholder="Enter postal code">
                            </div>
                            @error('postal_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Country -->
                        <div class="col-span-2 sm:col-span-1">
                            <label for="country" class="block text-sm font-medium text-gray-700">Country <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <select
                                    id="country"
                                    wire:model="country"
                                    class="h-11 text-base shadow-sm focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md">
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Vietnam">Vietnam</option>
                                    <option value="Brunei">Brunei</option>
                                </select>
                            </div>
                            @error('country')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-between pt-5">
                        <button type="button" @click="activeTab = 'basic-info'" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Previous: Basic Info
                        </button>
                        <button type="button" @click="activeTab = 'operations'" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            Next: Operations & Hours
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Tab: Operations & Hours -->
                <div x-show="activeTab === 'operations'" class="space-y-6">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Operations & Business Hours</h3>
                    <p class="text-sm text-gray-500 mb-4">Set your operating days and hours to let customers know when you're open</p>

                    <div class="space-y-6">
                        @foreach($weekdays as $day)
                            <div class="grid grid-cols-8 gap-4 items-center bg-gray-50 p-3 rounded-md">
                                <div class="col-span-2 sm:col-span-2">
                                    <div class="flex items-center">
                                        <input
                                            id="is-open-{{ strtolower($day) }}"
                                            type="checkbox"
                                            wire:model="opening_hours.{{ $day }}.is_open"
                                            class="h-5 w-5 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                                        <label for="is-open-{{ strtolower($day) }}" class="ml-2 block text-sm font-medium text-gray-700">
                                            {{ $day }}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-3">
                                    <div class="flex items-center">
                                        <span class="text-xs text-gray-500 w-16">Opens at:</span>
                                        <input
                                            type="time"
                                            wire:model="opening_hours.{{ $day }}.open_time"
                                            class="h-10 text-base shadow-sm focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md"
                                            {{ !$opening_hours[$day]['is_open'] ? '' : '' }}>
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-3">
                                    <div class="flex items-center">
                                        <span class="text-xs text-gray-500 w-16">Closes at:</span>
                                        <input
                                            type="time"
                                            wire:model="opening_hours.{{ $day }}.close_time"
                                            class="h-10 text-base shadow-sm focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md"
                                            {{ !$opening_hours[$day]['is_open'] ? '' : '' }}>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Special Instructions for Operations -->
                    <div class="mt-6">
                        <h4 class="text-base font-medium text-gray-900 mb-2">Special Operating Instructions</h4>
                        <div>
                            <textarea
                                wire:model="special_instructions"
                                rows="3"
                                class="text-base shadow-sm focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md"
                                placeholder="Add any special instructions about your operating hours (e.g., 'Closed on public holidays', 'Extended hours during summer', etc.)"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-between pt-5">
                        <button type="button" @click="activeTab = 'contact'" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Previous: Contact & Location
                        </button>
                        <button type="submit" class="ml-3 inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            Save Changes
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
