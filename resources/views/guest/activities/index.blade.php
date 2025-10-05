<x-app-layout>
    <!-- Hero Section with Search -->
    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Browse Activities</h1>
                <p class="text-xl text-yellow-50 max-w-3xl mx-auto">Discover and book amazing outdoor activities, workshops, and adventures.</p>
            </div>
        </div>
    </div>

    <!-- Advanced Filter Section -->
    <div class="bg-white shadow-lg -mt-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <form id="filter-form" class="space-y-4">
                <!-- Search Bar -->
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text"
                                   id="search-input"
                                   name="search"
                                   placeholder="Search activities, locations, or keywords..."
                                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-gray-900 placeholder-gray-500"
                                   value="{{ request('search') }}">
                            <div class="absolute left-4 top-3.5">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <button type="button"
                            id="toggle-filters"
                            class="md:w-auto px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-150 flex items-center justify-center gap-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                        <span>Filters</span>
                    </button>
                </div>

                <!-- Advanced Filters (Collapsible) -->
                <div id="advanced-filters" class="hidden grid grid-cols-1 md:grid-cols-4 gap-4 pt-4 border-t border-gray-200">
                    <!-- Location Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <input type="text"
                               id="location-filter"
                               name="location"
                               placeholder="Any location"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                               value="{{ request('location') }}">
                    </div>

                    <!-- Activity Type Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Activity Type</label>
                        <select id="type-filter"
                                name="type"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            <option value="">All Types</option>
                            @foreach(App\Models\Activity::getActivityTypes() as $value => $label)
                                <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Min Price (RM)</label>
                        <input type="number"
                               id="min-price"
                               name="min_price"
                               placeholder="0"
                               min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                               value="{{ request('min_price') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Max Price (RM)</label>
                        <input type="number"
                               id="max-price"
                               name="max_price"
                               placeholder="1000"
                               min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                               value="{{ request('max_price') }}">
                    </div>
                </div>

                <!-- Filter Actions -->
                <div id="filter-actions" class="hidden flex gap-3 pt-2">
                    <button type="button"
                            id="apply-filters"
                            class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition duration-150">
                        Apply Filters
                    </button>
                    <button type="button"
                            id="clear-filters"
                            class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition duration-150">
                        Clear All
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Results Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        <span id="results-count">{{ $activities->total() }}</span> Activities Found
                    </h2>
                    <p class="text-gray-600 mt-1">Showing {{ $activities->firstItem() ?? 0 }} - {{ $activities->lastItem() ?? 0 }} of {{ $activities->total() }}</p>
                </div>

                <!-- View Toggle & Sort -->
                <div class="flex items-center gap-4">
                    <!-- Sort Dropdown -->
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-medium text-gray-700">Sort by:</label>
                        <select id="sort-select" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm">
                            <option value="newest">Newest First</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="name">Name: A-Z</option>
                        </select>
                    </div>

                    <!-- View Toggle -->
                    <div class="flex items-center bg-white border border-gray-300 rounded-lg p-1">
                        <button id="grid-view-btn"
                                class="view-toggle active px-3 py-2 rounded-md transition duration-150"
                                data-view="grid">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </button>
                        <button id="list-view-btn"
                                class="view-toggle px-3 py-2 rounded-md transition duration-150"
                                data-view="list">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Activities Grid/List Container -->
            <div id="activities-container">
                @forelse($activities as $activity)
                    <!-- Grid View Card -->
                    <div class="activity-card grid-card"
                         data-name="{{ strtolower($activity->name) }}"
                         data-location="{{ strtolower($activity->location) }}"
                         data-type="{{ $activity->activity_type }}"
                         data-price="{{ $activity->price }}">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                            <!-- Image -->
                            <div class="relative h-56 overflow-hidden group">
                                @if($activity->images && count($activity->images) > 0)
                                    <img src="{{ asset('storage/' . $activity->images[0]) }}"
                                         alt="{{ $activity->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                        <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <!-- Badge -->
                                <div class="absolute top-4 right-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-500 text-white shadow-lg">
                                        {{ \App\Models\Activity::getActivityTypes()[$activity->activity_type] ?? ucfirst($activity->activity_type) }}
                                    </span>
                                </div>
                                <!-- Overlay on hover -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>

                            <!-- Content -->
                            <div class="p-5">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-1">{{ $activity->name }}</h3>

                                <div class="flex items-center text-gray-600 text-sm mb-3">
                                    <svg class="h-4 w-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="line-clamp-1">{{ $activity->location }}</span>
                                </div>

                                <p class="text-gray-700 text-sm mb-4 line-clamp-2 leading-relaxed">{{ Str::limit($activity->description, 100) }}</p>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Starting from</p>
                                        <p class="text-2xl font-bold text-yellow-600">RM {{ number_format($activity->price, 2) }}</p>
                                    </div>
                                    <a href="{{ route('activities.show', $activity->id) }}"
                                       class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg transition duration-150 shadow-md hover:shadow-lg">
                                        View Details
                                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- List View Card (Hidden by default) -->
                    <div class="activity-card list-card hidden"
                         data-name="{{ strtolower($activity->name) }}"
                         data-location="{{ strtolower($activity->location) }}"
                         data-type="{{ $activity->activity_type }}"
                         data-price="{{ $activity->price }}">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300">
                            <div class="flex flex-col md:flex-row">
                                <!-- Image -->
                                <div class="md:w-80 h-64 md:h-auto relative overflow-hidden group flex-shrink-0">
                                    @if($activity->images && count($activity->images) > 0)
                                        <img src="{{ asset('storage/' . $activity->images[0]) }}"
                                             alt="{{ $activity->name }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                            <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <!-- Badge -->
                                    <div class="absolute top-4 right-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-500 text-white shadow-lg">
                                            {{ \App\Models\Activity::getActivityTypes()[$activity->activity_type] ?? ucfirst($activity->activity_type) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 p-6 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $activity->name }}</h3>

                                        <div class="flex items-center text-gray-600 text-sm mb-4">
                                            <svg class="h-4 w-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>{{ $activity->location }}</span>
                                        </div>

                                        <p class="text-gray-700 mb-4 leading-relaxed">{{ Str::limit($activity->description, 200) }}</p>
                                    </div>

                                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Starting from</p>
                                            <p class="text-3xl font-bold text-yellow-600">RM {{ number_format($activity->price, 2) }}</p>
                                        </div>
                                        <a href="{{ route('activities.show', $activity->id) }}"
                                           class="inline-flex items-center px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition duration-150 shadow-md hover:shadow-lg">
                                            View Details
                                            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">No activities found</h3>
                        <p class="text-gray-500 mb-6">Try adjusting your search or filter criteria</p>
                        <button id="reset-search" class="inline-flex items-center px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition duration-150">
                            Clear All Filters
                        </button>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($activities->hasPages())
                <div class="mt-12">
                    {{ $activities->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Styles -->
    <style>
        /* Grid View */
        #activities-container.grid-view {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.5rem;
        }

        @media (min-width: 640px) {
            #activities-container.grid-view {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            #activities-container.grid-view {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1280px) {
            #activities-container.grid-view {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        #activities-container.grid-view .list-card {
            display: none;
        }

        #activities-container.grid-view .grid-card {
            display: block;
        }

        /* List View */
        #activities-container.list-view {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        #activities-container.list-view .grid-card {
            display: none;
        }

        #activities-container.list-view .list-card {
            display: block;
        }

        /* View Toggle Active State */
        .view-toggle {
            color: #6B7280;
        }

        .view-toggle.active {
            background-color: #EAB308;
            color: white;
        }

        /* Line clamp utilities */
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize view as grid
            $('#activities-container').addClass('grid-view');

            // Toggle Filters
            $('#toggle-filters').click(function() {
                $('#advanced-filters').slideToggle(300);
                $('#filter-actions').slideToggle(300);
            });

            // View Toggle
            $('.view-toggle').click(function() {
                const view = $(this).data('view');
                $('.view-toggle').removeClass('active');
                $(this).addClass('active');

                $('#activities-container').removeClass('grid-view list-view').addClass(view + '-view');

                // Reapply filters to the new view
                filterActivities();
            });

            // Apply Filters
            $('#apply-filters').click(function() {
                filterActivities();
            });

            // Clear Filters
            $('#clear-filters, #reset-search').click(function() {
                $('#search-input').val('');
                $('#location-filter').val('');
                $('#type-filter').val('');
                $('#min-price').val('');
                $('#max-price').val('');

                // Show all cards for current view only
                const isGridView = $('#activities-container').hasClass('grid-view');
                if (isGridView) {
                    $('.activity-card.grid-card').show();
                } else {
                    $('.activity-card.list-card').show();
                }

                updateResultsCount();
            });

            // Real-time search
            let searchTimeout;
            $('#search-input').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(filterActivities, 300);
            });

            // Filter on change
            $('#location-filter, #type-filter, #min-price, #max-price').on('change', filterActivities);

            // Sort functionality
            $('#sort-select').on('change', function() {
                sortActivities($(this).val());
            });

            function filterActivities() {
                const search = $('#search-input').val().toLowerCase();
                const location = $('#location-filter').val().toLowerCase();
                const type = $('#type-filter').val().toLowerCase();
                const minPrice = parseFloat($('#min-price').val()) || 0;
                const maxPrice = parseFloat($('#max-price').val()) || Infinity;

                // Determine current view mode
                const isGridView = $('#activities-container').hasClass('grid-view');
                const cardSelector = isGridView ? '.activity-card.grid-card' : '.activity-card.list-card';

                // Filter only the cards for the current view
                $(cardSelector).each(function() {
                    const $card = $(this);
                    const name = $card.data('name');
                    const cardLocation = $card.data('location');
                    const cardType = $card.data('type').toLowerCase();
                    const price = parseFloat($card.data('price'));

                    const matchesSearch = !search || name.includes(search) || cardLocation.includes(search);
                    const matchesLocation = !location || cardLocation.includes(location);
                    const matchesType = !type || cardType === type;
                    const matchesPrice = price >= minPrice && price <= maxPrice;

                    if (matchesSearch && matchesLocation && matchesType && matchesPrice) {
                        $card.show();
                    } else {
                        $card.hide();
                    }
                });

                updateResultsCount();
            }

            function sortActivities(sortBy) {
                const $container = $('#activities-container');
                const $cards = $('.activity-card.grid-card').get();

                $cards.sort(function(a, b) {
                    switch(sortBy) {
                        case 'price-low':
                            return $(a).data('price') - $(b).data('price');
                        case 'price-high':
                            return $(b).data('price') - $(a).data('price');
                        case 'name':
                            return $(a).data('name').localeCompare($(b).data('name'));
                        case 'newest':
                        default:
                            return 0;
                    }
                });

                $.each($cards, function(idx, card) {
                    $container.append(card);
                    // Also move corresponding list card
                    const listCard = $(card).next('.list-card');
                    if (listCard.length) {
                        $container.append(listCard);
                    }
                });
            }

            function updateResultsCount() {
                // Count visible cards based on current view
                const isGridView = $('#activities-container').hasClass('grid-view');
                const visibleCount = isGridView
                    ? $('.activity-card.grid-card:visible').length
                    : $('.activity-card.list-card:visible').length;
                $('#results-count').text(visibleCount);
            }
        });
    </script>
</x-app-layout>
