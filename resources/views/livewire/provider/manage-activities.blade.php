<div class="p-6">
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

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manage Activities</h1>
            <p class="text-gray-600">Create and manage activities your business offers to customers.</p>
        </div>
        <button wire:click="toggleCreateModal"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Activity
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="p-4 bg-gray-50 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between space-y-3 md:space-y-0">
                <div class="relative flex-1 max-w-xs">
                    <input type="text" wire:model.debounce.300ms="searchTerm"
                        class="w-full pr-10 pl-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                        placeholder="Search activities...">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <div class="flex space-x-2">
                    <select wire:model="filterActivityType"
                        class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500">
                        <option value="">All Activity Types</option>
                        @foreach($activityTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name & Type
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pricing
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Participants
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activitiesList as $activity)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $activity->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $activityTypes[$activity->activity_type] ?? $activity->activity_type }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">RM {{ number_format($activity->price, 2) }}</div>
                            <div class="text-sm text-gray-500">{{ $activity->price_type_formatted }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                Min: {{ $activity->min_participants }}
                                @if($activity->max_participants)
                                    <span class="text-gray-500">|</span> Max: {{ $activity->max_participants }}
                                @endif
                            </div>
                            <div class="text-sm text-gray-500">
                                @if($activity->duration_minutes)
                                    {{ floor($activity->duration_minutes/60) }}h {{ $activity->duration_minutes % 60 }}m
                                @else
                                    Duration not specified
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $activity->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $activity->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button type="button" wire:click="viewActivity({{ $activity->id }})" class="text-blue-600 hover:text-blue-900 mr-3">
                                View
                            </button>
                            <button type="button" wire:click="editActivity({{ $activity->id }})" class="text-teal-600 hover:text-teal-900 mr-3">
                                Edit
                            </button>
                            <button type="button" wire:click="confirmDelete({{ $activity->id }})"
                                class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            No activities found. Click "Add New Activity" to create your first activity.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $activitiesList->links() }}
        </div>
    </div>

    @if($showCreateModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <form wire:submit.prevent="saveActivity">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="mb-5 flex justify-between items-center">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ $activityId ? 'Edit Activity' : 'Create New Activity' }}
                            </h3>
                            <button type="button" wire:click="toggleCreateModal" class="text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <!-- Activity Type & Name -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="activityType" class="block text-sm font-medium text-gray-700">Activity Type</label>
                                    <select id="activityType" wire:model="activityType"
                                        class="mt-1 block w-full border-gray-300 focus:outline-none focus:ring-teal-500 focus:border-teal-500 rounded-md px-4 py-3 text-base">
                                        <option value="">Select Type</option>
                                        @foreach($activityTypes as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('activityType')<span class="text-red-500 text-xs">{{ $message ?? 'This field is required' }}</span>@enderror
                                </div>

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Activity Name</label>
                                    <input type="text" id="name" wire:model="name"
                                        class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm border-gray-300 rounded-md px-4 py-3 text-base">
                                    @error('name')<span class="text-red-500 text-xs">{{ $message ?? 'This field is required' }}</span>@enderror
                                </div>
                            </div>

                            <!-- Description & Location -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="description" wire:model="description" rows="4"
                                        class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm border-gray-300 rounded-md px-4 py-3 text-base"></textarea>
                                </div>

                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                    <input type="text" id="location" wire:model="location"
                                        class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm border-gray-300 rounded-md px-4 py-3 text-base">

                                    <label for="requirements" class="block text-sm font-medium text-gray-700 mt-4">Requirements</label>
                                    <textarea id="requirements" wire:model="requirements" rows="2"
                                        class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm border-gray-300 rounded-md px-4 py-3 text-base"></textarea>
                                </div>
                            </div>

                            <!-- Participants & Duration -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="minParticipants" class="block text-sm font-medium text-gray-700">Min Participants</label>
                                    <input type="number" id="minParticipants" wire:model="minParticipants" min="1"
                                        class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm border-gray-300 rounded-md px-4 py-3 text-base">
                                    @error('minParticipants')<span class="text-red-500 text-xs">{{ $message ?? 'This field is required' }}</span>@enderror
                                </div>

                                <div>
                                    <label for="maxParticipants" class="block text-sm font-medium text-gray-700">Max Participants</label>
                                    <input type="number" id="maxParticipants" wire:model="maxParticipants" min="1"
                                        class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm border-gray-300 rounded-md px-4 py-3 text-base">
                                </div>

                                <div>
                                    <label for="durationMinutes" class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                                    <input type="number" id="durationMinutes" wire:model="durationMinutes" min="0"
                                        class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm border-gray-300 rounded-md px-4 py-3 text-base">
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700">Price (RM)</label>
                                    <input type="number" id="price" wire:model="price" min="0" step="0.01"
                                        class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm border-gray-300 rounded-md px-4 py-3 text-base">
                                    @error('price')<span class="text-red-500 text-xs">{{ $message ?? 'This field is required' }}</span>@enderror
                                </div>

                                <div>
                                    <label for="priceType" class="block text-sm font-medium text-gray-700">Price Type</label>
                                    <select id="priceType" wire:model="priceType"
                                        class="mt-1 block w-full border-gray-300 focus:outline-none focus:ring-teal-500 focus:border-teal-500 rounded-md px-4 py-3 text-base">
                                        @foreach($priceTypes as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('priceType')<span class="text-red-500 text-xs">{{ $message ?? 'This field is required' }}</span>@enderror
                                </div>

                                <div class="flex items-center mt-7">
                                    <input id="includesGear" wire:model="includesGear" type="checkbox"
                                        class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                                    <label for="includesGear" class="ml-2 block text-sm text-gray-700">
                                        Includes Gear/Equipment
                                    </label>
                                </div>
                            </div>

                            <!-- Included & Excluded Items -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Included Items</label>
                                    <div class="flex">
                                        <input type="text" wire:model="newIncludedItem" wire:keydown.enter="addIncludedItem"
                                            class="flex-1 focus:ring-teal-500 focus:border-teal-500 block shadow-sm border-gray-300 rounded-l-md px-4 py-3 text-base">
                                        <button type="button" wire:click="addIncludedItem"
                                            class="inline-flex items-center px-4 py-3 border border-l-0 border-gray-300 text-base font-medium rounded-r-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                            Add
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        @forelse($includedItems as $index => $item)
                                            <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded my-1">
                                                <span>{{ $item }}</span>
                                                <button type="button" wire:click="removeIncludedItem({{ $index }})" class="text-red-500 hover:text-red-700">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-500 mt-2">No included items added yet.</p>
                                        @endforelse
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Excluded Items</label>
                                    <div class="flex">
                                        <input type="text" wire:model="newExcludedItem" wire:keydown.enter="addExcludedItem"
                                            class="flex-1 focus:ring-teal-500 focus:border-teal-500 block shadow-sm border-gray-300 rounded-l-md px-4 py-3 text-base">
                                        <button type="button" wire:click="addExcludedItem"
                                            class="inline-flex items-center px-4 py-3 border border-l-0 border-gray-300 text-base font-medium rounded-r-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                            Add
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        @forelse($excludedItems as $index => $item)
                                            <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded my-1">
                                                <span>{{ $item }}</span>
                                                <button type="button" wire:click="removeExcludedItem({{ $index }})" class="text-red-500 hover:text-red-700">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-500 mt-2">No excluded items added yet.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <!-- Rules & Amenities -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rules</label>
                                    <div class="flex">
                                        <input type="text" wire:model="newRule" wire:keydown.enter="addRule"
                                            class="flex-1 focus:ring-teal-500 focus:border-teal-500 block shadow-sm border-gray-300 rounded-l-md px-4 py-3 text-base">
                                        <button type="button" wire:click="addRule"
                                            class="inline-flex items-center px-4 py-3 border border-l-0 border-gray-300 text-base font-medium rounded-r-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                            Add
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        @forelse($rules as $index => $rule)
                                            <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded my-1">
                                                <span>{{ $rule }}</span>
                                                <button type="button" wire:click="removeRule({{ $index }})" class="text-red-500 hover:text-red-700">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-500 mt-2">No rules added yet.</p>
                                        @endforelse
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Amenities</label>
                                    <div class="flex">
                                        <input type="text" wire:model="newAmenity" wire:keydown.enter="addAmenity"
                                            class="flex-1 focus:ring-teal-500 focus:border-teal-500 block shadow-sm border-gray-300 rounded-l-md px-4 py-3 text-base">
                                        <button type="button" wire:click="addAmenity"
                                            class="inline-flex items-center px-4 py-3 border border-l-0 border-gray-300 text-base font-medium rounded-r-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                            Add
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        @forelse($amenities as $index => $amenity)
                                            <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded my-1">
                                                <span>{{ $amenity }}</span>
                                                <button type="button" wire:click="removeAmenity({{ $index }})" class="text-red-500 hover:text-red-700">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-500 mt-2">No amenities added yet.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <!-- Cancelation Policy & Status -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="cancelationPolicy" class="block text-sm font-medium text-gray-700">Cancelation Policy</label>
                                    <textarea id="cancelationPolicy" wire:model="cancelationPolicy" rows="3"
                                        class="mt-1 focus:ring-teal-500 focus:border-teal-500 block w-full shadow-sm border-gray-300 rounded-md px-4 py-3 text-base"></textarea>
                                </div>

                                <div class="flex items-center">
                                    <input id="isActive" wire:model="isActive" type="checkbox"
                                        class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                                    <label for="isActive" class="ml-2 block text-sm text-gray-700">
                                        Activity is Active (visible to customers)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-6 py-3 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:ml-3 sm:w-auto">
                            {{ $activityId ? 'Update Activity' : 'Create Activity' }}
                        </button>
                        <button type="button" wire:click="toggleCreateModal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:ml-3 sm:w-auto">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    @if($showViewModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="mb-5 flex justify-between items-center border-b pb-4">
                        <h3 class="text-xl leading-6 font-medium text-gray-900" id="modal-title">
                            Activity Details
                        </h3>
                        <button type="button" wire:click="toggleViewModal" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-6">
                        @if($viewActivity)
                        <!-- Activity Header -->
                        <div class="bg-gradient-to-r from-teal-500 to-blue-500 p-4 rounded-lg text-white">
                            <h2 class="text-2xl font-bold mb-1">{{ $viewActivity->name }}</h2>
                            <div class="flex items-center text-teal-100">
                                <span class="px-2 py-1 bg-teal-800 bg-opacity-50 rounded-full text-xs font-semibold mr-2">
                                    {{ $activityTypes[$viewActivity->activity_type] ?? $viewActivity->activity_type }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $viewActivity->location ?: 'No location specified' }}
                                </span>
                            </div>
                        </div>

                        <!-- Activity Info Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Price Card -->
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                                <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                                    <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Pricing
                                </h3>
                                <div class="mt-1">
                                    <p class="text-2xl font-bold text-gray-800">RM {{ number_format($viewActivity->price, 2) }}</p>
                                    <p class="text-sm text-gray-500">{{ $viewActivity->price_type_formatted }}</p>
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
                                        Min: <span class="font-semibold">{{ $viewActivity->min_participants }}</span>
                                        @if($viewActivity->max_participants)
                                            <span class="mx-1">|</span> Max: <span class="font-semibold">{{ $viewActivity->max_participants }}</span>
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
                                    @if($viewActivity->duration_minutes)
                                        <p class="text-gray-800 font-semibold">
                                            {{ floor($viewActivity->duration_minutes/60) }}h {{ $viewActivity->duration_minutes % 60 }}m
                                        </p>
                                    @else
                                        <p class="text-gray-500 italic">Not specified</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        @if($viewActivity->description)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                            <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Description
                            </h3>
                            <p class="text-gray-700">{{ $viewActivity->description }}</p>
                        </div>
                        @endif

                        <!-- Requirements -->
                        @if($viewActivity->requirements)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                            <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Requirements
                            </h3>
                            <p class="text-gray-700">{{ $viewActivity->requirements }}</p>
                        </div>
                        @endif

                        <!-- Activity Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Included Items -->
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                                <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                                    <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    What's Included
                                </h3>
                                @if(!empty($viewActivity->included_items))
                                    <ul class="mt-2 space-y-1">
                                        @foreach($viewActivity->included_items as $item)
                                            <li class="flex items-center text-gray-700">
                                                <svg class="h-4 w-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                {{ $item }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500 italic mt-2">No included items specified</p>
                                @endif
                            </div>

                            <!-- Excluded Items -->
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                                <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                                    <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    What's Not Included
                                </h3>
                                @if(!empty($viewActivity->excluded_items))
                                    <ul class="mt-2 space-y-1">
                                        @foreach($viewActivity->excluded_items as $item)
                                            <li class="flex items-center text-gray-700">
                                                <svg class="h-4 w-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                {{ $item }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500 italic mt-2">No excluded items specified</p>
                                @endif
                            </div>
                        </div>

                        <!-- Cancelation Policy -->
                        @if($viewActivity->cancelation_policy)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                            <h3 class="font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Cancelation Policy
                            </h3>
                            <p class="text-gray-700">{{ $viewActivity->cancelation_policy }}</p>
                        </div>
                        @endif
                        @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Activity data not available. This is likely a bug.
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                    <button type="button" wire:click="toggleViewModal"
                        class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($showDeleteModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Delete Activity
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete this activity? This action cannot be undone and all associated bookings and data will be permanently removed.
                                </p>
                                @if($activityToDelete)
                                <div class="mt-3 p-3 bg-gray-50 rounded-md">
                                    <p class="font-medium text-gray-800">{{ $activityToDelete->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $activityTypes[$activityToDelete->activity_type] ?? $activityToDelete->activity_type }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="deleteActivity({{ $activityToDelete ? $activityToDelete->id : '' }})"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button type="button" wire:click="cancelDelete"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
