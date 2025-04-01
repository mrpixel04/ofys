<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="bg-gradient-to-r from-teal-600 to-blue-500 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">
                {{ $activityId ? 'Edit Activity' : 'Create New Activity' }}
            </h1>
            <a href="{{ route('provider.activities') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-teal-700 bg-white hover:bg-teal-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Activities
            </a>
        </div>
        <p class="mt-1 text-teal-100">
            Fill in the details below to {{ $activityId ? 'update' : 'create' }} your activity.
        </p>
    </div>

    <form wire:submit.prevent="saveActivity" class="p-6">
        @if($successMessage)
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p>{{ $successMessage }}</p>
            </div>
        </div>
        @endif

        <div class="space-y-8">
            <!-- Activity Basic Info Section -->
            <div>
                <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Basic Information</h2>
                <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="activityType" class="block text-base font-medium text-gray-700">Activity Type</label>
                        <select id="activityType" wire:model="activityType"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 text-base">
                            <option value="">Select Type</option>
                            @foreach($activityTypes as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('activityType')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="name" class="block text-base font-medium text-gray-700">Activity Name</label>
                        <input type="text" id="name" wire:model="name"
                            class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm border-gray-300 rounded-md px-4 py-3 text-base">
                        @error('name')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="block text-base font-medium text-gray-700">Description</label>
                        <textarea id="description" wire:model="description" rows="4"
                            class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm border-gray-300 rounded-md px-4 py-3 text-base"></textarea>
                        @error('description')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="location" class="block text-base font-medium text-gray-700">Location</label>
                        <input type="text" id="location" wire:model="location"
                            class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm border-gray-300 rounded-md px-4 py-3 text-base">
                        @error('location')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="requirements" class="block text-base font-medium text-gray-700">Requirements</label>
                        <textarea id="requirements" wire:model="requirements" rows="3"
                            class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm border-gray-300 rounded-md px-4 py-3 text-base"></textarea>
                        @error('requirements')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <!-- Capacity & Duration Section -->
            <div>
                <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Capacity & Duration</h2>
                <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                    <div>
                        <label for="minParticipants" class="block text-base font-medium text-gray-700">Min Participants</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" id="minParticipants" wire:model="minParticipants" min="1"
                                class="focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md px-4 py-3 text-base">
                        </div>
                        @error('minParticipants')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="maxParticipants" class="block text-base font-medium text-gray-700">Max Participants</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" id="maxParticipants" wire:model="maxParticipants" min="1"
                                class="focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md px-4 py-3 text-base">
                        </div>
                        @error('maxParticipants')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="duration" class="block text-base font-medium text-gray-700">Duration</label>
                        <div class="mt-1 grid grid-cols-2 gap-3">
                            <div>
                                <label for="durationHours" class="block text-base text-gray-500 mb-1">Hours</label>
                                <div class="relative rounded-md shadow-sm">
                                    <input type="number" id="durationHours" wire:model="durationHours" min="0" max="24"
                                        class="focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md px-4 py-3 text-base">
                                </div>
                            </div>
                            <div>
                                <label for="durationMinutes" class="block text-base text-gray-500 mb-1">Minutes</label>
                                <div class="relative rounded-md shadow-sm">
                                    <input type="number" id="durationMinutes" wire:model="durationMinutes" min="0" max="59"
                                        class="focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md px-4 py-3 text-base">
                                </div>
                            </div>
                        </div>
                        @error('durationHours')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                        @error('durationMinutes')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <!-- Pricing Section -->
            <div>
                <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Pricing</h2>
                <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                    <div>
                        <label for="price" class="block text-base font-medium text-gray-700">Price (RM)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-base">RM</span>
                            </div>
                            <input type="number" id="price" wire:model="price" min="0" step="0.01"
                                class="pl-12 focus:ring-teal-500 focus:border-teal-500 block w-full border-gray-300 rounded-md px-4 py-3 text-base">
                        </div>
                        @error('price')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label for="priceType" class="block text-base font-medium text-gray-700">Price Type</label>
                        <select id="priceType" wire:model="priceType"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 text-base">
                            @foreach($priceTypes as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('priceType')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div class="flex items-start pt-6">
                        <div class="flex items-center h-5">
                            <input id="includesGear" wire:model="includesGear" type="checkbox"
                                class="focus:ring-teal-500 h-4 w-4 text-teal-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-base">
                            <label for="includesGear" class="font-medium text-gray-700">Includes Gear/Equipment</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- What's Included & Excluded Section -->
            <div>
                <h2 class="text-lg font-medium text-gray-900 border-b pb-2">What's Included & Excluded</h2>
                <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <!-- Included Items -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-1">Included Items</label>
                        <div class="flex">
                            <input type="text" wire:model="newIncludedItem" wire:keydown.enter.prevent="addIncludedItem"
                                class="focus:ring-teal-500 focus:border-teal-500 flex-1 block rounded-none rounded-l-md border-gray-300 px-4 py-3 text-base">
                            <button type="button" wire:click="addIncludedItem"
                                class="-ml-px relative inline-flex items-center px-4 py-3 border border-gray-300 text-base font-medium rounded-r-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                Add
                            </button>
                        </div>
                        <div class="mt-2 space-y-2 max-h-60 overflow-y-auto p-2">
                            @forelse($includedItems as $index => $item)
                                <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded-md shadow-sm">
                                    <span class="text-base text-gray-700">{{ $item }}</span>
                                    <button type="button" wire:click="removeIncludedItem({{ $index }})" class="text-red-500 hover:text-red-700">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @empty
                                <div class="text-base text-gray-500 italic">No included items added yet.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Excluded Items -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-1">Excluded Items</label>
                        <div class="flex">
                            <input type="text" wire:model="newExcludedItem" wire:keydown.enter.prevent="addExcludedItem"
                                class="focus:ring-teal-500 focus:border-teal-500 flex-1 block rounded-none rounded-l-md border-gray-300 px-4 py-3 text-base">
                            <button type="button" wire:click="addExcludedItem"
                                class="-ml-px relative inline-flex items-center px-4 py-3 border border-gray-300 text-base font-medium rounded-r-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                Add
                            </button>
                        </div>
                        <div class="mt-2 space-y-2 max-h-60 overflow-y-auto p-2">
                            @forelse($excludedItems as $index => $item)
                                <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded-md shadow-sm">
                                    <span class="text-base text-gray-700">{{ $item }}</span>
                                    <button type="button" wire:click="removeExcludedItem({{ $index }})" class="text-red-500 hover:text-red-700">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @empty
                                <div class="text-base text-gray-500 italic">No excluded items added yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Amenities & Rules Section -->
            <div>
                <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Amenities & Rules</h2>
                <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <!-- Amenities -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-1">Amenities</label>
                        <div class="flex">
                            <input type="text" wire:model="newAmenity" wire:keydown.enter.prevent="addAmenity"
                                class="focus:ring-teal-500 focus:border-teal-500 flex-1 block rounded-none rounded-l-md border-gray-300 px-4 py-3 text-base">
                            <button type="button" wire:click="addAmenity"
                                class="-ml-px relative inline-flex items-center px-4 py-3 border border-gray-300 text-base font-medium rounded-r-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                Add
                            </button>
                        </div>
                        <div class="mt-2 space-y-2 max-h-60 overflow-y-auto p-2">
                            @forelse($amenities as $index => $amenity)
                                <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded-md shadow-sm">
                                    <span class="text-base text-gray-700">{{ $amenity }}</span>
                                    <button type="button" wire:click="removeAmenity({{ $index }})" class="text-red-500 hover:text-red-700">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @empty
                                <div class="text-base text-gray-500 italic">No amenities added yet.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Rules -->
                    <div>
                        <label class="block text-base font-medium text-gray-700 mb-1">Rules</label>
                        <div class="flex">
                            <input type="text" wire:model="newRule" wire:keydown.enter.prevent="addRule"
                                class="focus:ring-teal-500 focus:border-teal-500 flex-1 block rounded-none rounded-l-md border-gray-300 px-4 py-3 text-base">
                            <button type="button" wire:click="addRule"
                                class="-ml-px relative inline-flex items-center px-4 py-3 border border-gray-300 text-base font-medium rounded-r-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                Add
                            </button>
                        </div>
                        <div class="mt-2 space-y-2 max-h-60 overflow-y-auto p-2">
                            @forelse($rules as $index => $rule)
                                <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded-md shadow-sm">
                                    <span class="text-base text-gray-700">{{ $rule }}</span>
                                    <button type="button" wire:click="removeRule({{ $index }})" class="text-red-500 hover:text-red-700">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @empty
                                <div class="text-base text-gray-500 italic">No rules added yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cancellation Policy & Status -->
            <div>
                <h2 class="text-lg font-medium text-gray-900 border-b pb-2">Cancellation Policy & Status</h2>
                <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="cancelationPolicy" class="block text-base font-medium text-gray-700">Cancellation Policy</label>
                        <textarea id="cancelationPolicy" wire:model="cancelationPolicy" rows="3"
                            class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm border-gray-300 rounded-md px-4 py-3 text-base"></textarea>
                        @error('cancelationPolicy')<span class="text-red-500 text-sm mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div class="flex items-start pt-5">
                        <div class="flex items-center h-5">
                            <input id="isActive" wire:model="isActive" type="checkbox"
                                class="focus:ring-teal-500 h-4 w-4 text-teal-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-base">
                            <label for="isActive" class="font-medium text-gray-700">Activity is Active (visible to customers)</label>
                            <p class="text-gray-500">When active, this activity will be visible to customers and available for booking.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="mt-8 pt-5 border-t border-gray-200">
            <div class="flex justify-end">
                <a href="{{ route('provider.activities') }}" class="bg-white py-3 px-6 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    Cancel
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    {{ $activityId ? 'Update Activity' : 'Create Activity' }}
                </button>
            </div>
        </div>
    </form>
</div>
