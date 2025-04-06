<div>
    <!-- Desktop Filters - Visible on md screens and up -->
    <div class="hidden md:block mb-6">
        <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search & Filter
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4">
                    <!-- Activity Name Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Activity Name/Location</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="search" id="search"
                                class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 py-2 sm:text-sm border-gray-300 rounded-lg"
                                placeholder="Search by name or location...">
                        </div>
                    </div>

                    <!-- Provider Name Search -->
                    <div>
                        <label for="providerSearch" class="block text-sm font-medium text-gray-700 mb-1">Provider Name/Email</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="providerSearch" type="search" id="providerSearch"
                                class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 py-2 sm:text-sm border-gray-300 rounded-lg"
                                placeholder="Search by provider...">
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="categoryFilter" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <select wire:model.live="categoryFilter" id="categoryFilter"
                                class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 py-2 sm:text-sm border-gray-300 rounded-lg">
                                <option value="">All Categories</option>
                                @foreach($activityTypes as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <select wire:model.live="statusFilter" id="statusFilter"
                                class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 py-2 sm:text-sm border-gray-300 rounded-lg">
                                <option value="">All Statuses</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                    <button type="button" wire:click="resetFilters"
                        class="flex justify-center items-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters - For mobile viewing that will show/hide on smaller screens -->
    <div class="md:hidden mb-6">
        <div class="relative">
            <div class="flex items-center">
                <input wire:model.live.debounce.300ms="search" type="search" placeholder="Search activities..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Table -->
    <div class="overflow-x-auto" wire:loading.class="opacity-75">
        <div class="align-middle inline-block min-w-full">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Activity
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Provider
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($activities as $activity)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if(isset($activity->images[0]))
                                                <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $activity->images[0]) }}" alt="{{ $activity->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-md bg-blue-100 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $activity->name }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($activity->location, 30) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $activity->shopInfo->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($activity->shopInfo->user->email, 20) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $activityTypes[$activity->activity_type] ?? ucfirst(str_replace('_', ' ', $activity->activity_type)) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">RM {{ number_format($activity->price, 2) }}</div>
                                    <div class="text-xs text-gray-500">{{ $activity->price_type_formatted }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $activity->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $activity->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $activity->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.providers.activities.show', $activity->id) }}" class="text-purple-600 hover:text-purple-900" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.providers.activities.edit', $activity->id) }}" class="text-blue-600 hover:text-blue-900" title="Edit Activity">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button wire:click="confirmDelete({{ $activity->id }})" class="text-red-600 hover:text-red-900" title="Delete Activity">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button wire:click="toggleStatus({{ $activity->id }})" class="{{ $activity->is_active ? 'text-green-600 hover:text-green-900' : 'text-gray-600 hover:text-gray-900' }}" title="{{ $activity->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-power-off"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No activities found. Try adjusting your filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($activities->count() > 0)
        <div class="bg-white px-4 py-4 flex flex-col sm:flex-row items-center justify-between border-t border-gray-200 sm:px-6 mt-4 rounded-lg shadow-sm">
            <div class="flex items-center mb-4 sm:mb-0">
                <p class="text-sm text-gray-700 mr-4">
                    Showing <span class="font-medium">{{ $activities->firstItem() ?? 0 }}</span> to
                    <span class="font-medium">{{ $activities->lastItem() ?? 0 }}</span> of
                    <span class="font-medium">{{ $activities->total() }}</span> activities
                </p>
                <select wire:model.live="perPage" class="border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 text-base py-2 px-3">
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                    <option value="100">100 per page</option>
                </select>
            </div>
            <div>
                <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                    <div class="flex justify-between flex-1 sm:hidden">
                        @if ($activities->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                Previous
                            </span>
                        @else
                            <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                Previous
                            </button>
                        @endif

                        @if ($activities->hasMorePages())
                            <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                Next
                            </button>
                        @else
                            <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                Next
                            </span>
                        @endif
                    </div>

                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
                        <div>
                            <span class="relative z-0 inline-flex shadow-sm">
                                {{-- Previous Page Link --}}
                                @if ($activities->onFirstPage())
                                    <span aria-disabled="true" aria-label="Previous">
                                        <span class="relative inline-flex items-center px-3 py-2 text-base font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5" aria-hidden="true">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </span>
                                @else
                                    <button wire:click="previousPage" rel="prev" class="relative inline-flex items-center px-3 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-purple-300 focus:shadow-outline-purple active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Previous">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($activities->getUrlRange(1, $activities->lastPage()) as $page => $url)
                                    @if ($page == $activities->currentPage())
                                        <span aria-current="page">
                                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-base font-medium text-white bg-purple-600 border border-purple-600 cursor-default leading-5">{{ $page }}</span>
                                        </span>
                                    @else
                                        <button wire:click="gotoPage({{ $page }})" class="relative inline-flex items-center px-4 py-2 -ml-px text-base font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-purple-300 focus:shadow-outline-purple active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Go to page {{ $page }}">
                                            {{ $page }}
                                        </button>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($activities->hasMorePages())
                                    <button wire:click="nextPage" rel="next" class="relative inline-flex items-center px-3 py-2 -ml-px text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-purple-300 focus:shadow-outline-purple active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150" aria-label="Next">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                @else
                                    <span aria-disabled="true" aria-label="Next">
                                        <span class="relative inline-flex items-center px-3 py-2 -ml-px text-base font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5" aria-hidden="true">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </span>
                                @endif
                            </span>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    @endif

    <!-- View Activity Modal -->
    <div x-data="{ open: @entangle('showViewModal') }"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-[200] overflow-y-auto"
         aria-labelledby="modal-title"
         role="dialog"
         aria-modal="true">

        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                 aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

                @if($viewingActivity)
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Activity Details
                                </h3>
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if(isset($viewingActivity->images[0]))
                                        <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $viewingActivity->images[0]) }}" alt="{{ $viewingActivity->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-md bg-blue-100 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 space-y-3">
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Activity Name</span>
                                    <p class="font-medium">{{ $viewingActivity->name }}</p>
                                </div>
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Provider</span>
                                    <p class="font-medium">{{ $viewingActivity->shopInfo->user->name }}</p>
                                </div>
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Category</span>
                                    <p class="font-medium">
                                        {{ $activityTypes[$viewingActivity->activity_type] ?? ucfirst(str_replace('_', ' ', $viewingActivity->activity_type)) }}
                                    </p>
                                </div>
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Description</span>
                                    <p class="font-medium">{{ $viewingActivity->description ?: 'No description provided' }}</p>
                                </div>
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Location</span>
                                    <p class="font-medium">{{ $viewingActivity->location }}</p>
                                </div>
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Pricing</span>
                                    <p class="font-medium">
                                        RM {{ number_format($viewingActivity->price, 2) }}
                                        ({{ $viewingActivity->price_type_formatted }})
                                    </p>
                                </div>
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Participants</span>
                                    <p class="font-medium">
                                        Min: {{ $viewingActivity->min_participants }}
                                        @if($viewingActivity->max_participants)
                                            | Max: {{ $viewingActivity->max_participants }}
                                        @endif
                                    </p>
                                </div>
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Duration</span>
                                    <p class="font-medium">
                                        @if($viewingActivity->duration_minutes)
                                            {{ floor($viewingActivity->duration_minutes/60) }}h {{ $viewingActivity->duration_minutes % 60 }}m
                                        @else
                                            Not specified
                                        @endif
                                    </p>
                                </div>

                                <!-- Camping/Glamping Lots Information -->
                                @if(in_array($viewingActivity->activity_type, ['camping', 'glamping']) && $viewingActivity->lots->count() > 0)
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500 font-medium">Camping/Glamping Lots</span>
                                    <div class="mt-2 space-y-2">
                                        @foreach($viewingActivity->lots as $lot)
                                            <div class="bg-gray-50 p-2 rounded-md">
                                                <div class="flex justify-between items-center">
                                                    <span class="font-medium">{{ $lot->name }}</span>
                                                    <span class="text-xs {{ $lot->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-2 py-1 rounded-full">
                                                        {{ $lot->is_available ? 'Available' : 'Unavailable' }}
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-600">Capacity: {{ $lot->capacity }} people</p>
                                                @if($lot->description)
                                                    <p class="text-sm text-gray-600 mt-1">{{ $lot->description }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Status</span>
                                    <p>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $viewingActivity->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $viewingActivity->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="border-b pb-2">
                                    <span class="text-sm text-gray-500">Created Date</span>
                                    <p class="font-medium">{{ $viewingActivity->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="closeViewModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" x-show="$wire.showDeleteModal" x-cloak>
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
                    <button wire:click="cancelDelete" class="px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>
                    <button wire:click="deleteActivity" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session()->has('success'))
    <div class="fixed bottom-4 right-4 z-50">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-md" x-data="{show: true}" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    @if(session()->has('error'))
    <div class="fixed bottom-4 right-4 z-50">
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-md" x-data="{show: true}" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif
</div>
