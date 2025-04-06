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
        <a href="{{ route('provider.activities.create') }}"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Activity
        </a>
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
                            <a href="{{ route('provider.activities.view', $activity->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                View
                            </a>
                            <a href="{{ route('provider.activities.edit', $activity->id) }}" class="text-teal-600 hover:text-teal-900 mr-3">
                                Edit
                            </a>
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
