<div>
    <!-- Search and Filter Section -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <form wire:submit.prevent="search" class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4">
            <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                <label for="activitySearch" class="block text-sm font-medium text-gray-700">Activity</label>
                <div class="mt-1">
                    <input type="text" wire:model.live="activitySearch" id="activitySearch" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" placeholder="Hiking, Camping, Diving...">
                </div>
            </div>

            <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                <label for="locationSearch" class="block text-sm font-medium text-gray-700">Location</label>
                <div class="mt-1">
                    <input type="text" wire:model.live="locationSearch" id="locationSearch" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" placeholder="City, State, or Area">
                </div>
            </div>

            <div class="col-span-1">
                <label for="dateSearch" class="block text-sm font-medium text-gray-700">Date</label>
                <div class="mt-1">
                    <input type="date" wire:model.live="dateSearch" id="dateSearch" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                </div>
            </div>

            <div class="col-span-1">
                <label for="selectedType" class="block text-sm font-medium text-gray-700">Activity Type</label>
                <div class="mt-1">
                    <select wire:model.live="selectedType" id="selectedType" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                        <option value="">All Types</option>
                        @foreach($activityTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-span-1 sm:col-span-2">
                <label for="priceRange" class="block text-sm font-medium text-gray-700">Price Range (RM)</label>
                <div class="mt-1 flex items-center space-x-4">
                    <input type="number" wire:model.live="minPrice" min="0" placeholder="Min" class="py-2 px-3 w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                    <span class="text-gray-500">to</span>
                    <input type="number" wire:model.live="maxPrice" min="0" placeholder="Max" class="py-2 px-3 w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                </div>
            </div>

            <div class="col-span-1 sm:col-span-2 lg:col-span-1 flex items-end">
                <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    Search
                </button>
            </div>

            <div class="col-span-1 flex items-end">
                <button type="button" wire:click="$set('activitySearch', ''); $set('locationSearch', ''); $set('dateSearch', ''); $set('selectedType', ''); $set('minPrice', null); $set('maxPrice', null);" class="w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    Clear Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Activity Results -->
    <div>
        <!-- Results Count and Sorting -->
        <div class="flex justify-between items-center mb-4">
            <p class="text-sm text-gray-700">
                Showing <span class="font-medium">{{ $activities->firstItem() ?? 0 }}</span> to <span class="font-medium">{{ $activities->lastItem() ?? 0 }}</span> of <span class="font-medium">{{ $activities->total() }}</span> activities
            </p>
            <div>
                <!-- Add sorting options here if needed -->
            </div>
        </div>

        <!-- Activity Grid -->
        <div class="grid grid-cols-1 gap-y-8 gap-x-6 sm:grid-cols-2 lg:grid-cols-4">
            @forelse($activities as $activity)
                <div class="group relative bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="relative h-60 w-full overflow-hidden">
                        @if($activity->images && is_array($activity->images) && count($activity->images) > 0)
                            <img src="{{ storage_url($activity->images[0]) }}"
                                 alt="{{ $activity->name }}"
                                 class="h-full w-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        @else
                            <img src="https://via.placeholder.com/400x300?text=No+Image"
                                 alt="No image available"
                                 class="h-full w-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 opacity-60"></div>
                        <div class="absolute bottom-0 left-0 p-4">
                            <span class="inline-block bg-yellow-500 rounded-full px-3 py-1 text-xs font-semibold text-white mr-2 mb-2">
                                {{ $activityTypes[$activity->activity_type] ?? ucfirst($activity->activity_type) }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $activity->name }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ $activity->location }}</p>
                        <p class="mt-2 text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($activity->description, 80) }}</p>
                        <div class="mt-3 flex justify-between items-center">
                            <span class="text-gray-900 font-bold">
                                RM{{ number_format($activity->price, 2) }}
                                <span class="text-sm font-normal text-gray-500">/ {{ $activity->getPriceTypeFormattedAttribute() }}</span>
                            </span>
                            <a href="{{ route('activities.show', $activity->id) }}" class="text-yellow-500 hover:text-yellow-600 font-medium">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No activities found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
                    <div class="mt-6">
                        <button type="button" wire:click="$set('activitySearch', ''); $set('locationSearch', ''); $set('dateSearch', ''); $set('selectedType', ''); $set('minPrice', null); $set('maxPrice', null);" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Clear all filters
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $activities->links() }}
        </div>
    </div>
</div>
