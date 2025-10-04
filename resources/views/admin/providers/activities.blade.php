@extends('layouts.simple-admin')

@section('title', 'Activities Management')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8 border-b border-gray-200 pb-5">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">Activities Management</h1>
                <p class="mt-1 text-sm text-gray-500">View and manage all activities created by providers on your platform</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.providers.activities.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-plus mr-2"></i>
                    Create New Activity
                </a>
                <a href="{{ route('admin.simple-providers-basic') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <i class="fas fa-users mr-2"></i>
                    Provider List
                </a>
            </div>
        </div>
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

    <!-- Search & Filters -->
    <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden border border-gray-100">
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-gray-800 flex items-center">
                <i class="fas fa-search text-gray-600 mr-2"></i>
                Search & Filter
            </h2>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.providers.activities') }}" method="GET" id="searchForm">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4">
                    <!-- Activity Name Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Activity Name/Location</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="search" name="search" id="search" value="{{ request('search') }}"
                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 py-3 h-12 text-base border-gray-300 rounded-lg"
                                placeholder="Search by name or location...">
                        </div>
                    </div>

                    <!-- Provider Name Search -->
                    <div>
                        <label for="providerSearch" class="block text-sm font-medium text-gray-700 mb-1">Provider Name/Email</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="search" name="providerSearch" id="providerSearch" value="{{ request('providerSearch') }}"
                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 py-3 h-12 text-base border-gray-300 rounded-lg"
                                placeholder="Search by provider...">
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="categoryFilter" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-gray-400"></i>
                            </div>
                            <select name="categoryFilter" id="categoryFilter"
                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 py-3 h-12 text-base border-gray-300 rounded-lg appearance-none">
                                <option value="">All Categories</option>
                                @foreach($activityTypes as $value => $label)
                                    <option value="{{ $value }}" {{ request('categoryFilter') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-check-circle text-gray-400"></i>
                            </div>
                            <select name="statusFilter" id="statusFilter"
                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 py-3 h-12 text-base border-gray-300 rounded-lg appearance-none">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request('statusFilter') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('statusFilter') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                    <button type="submit"
                        class="flex justify-center items-center py-3 px-6 h-12 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-150 ease-in-out">
                        <i class="fas fa-search mr-2"></i>
                        Search
                    </button>
                    <a href="{{ route('admin.providers.activities') }}"
                        class="flex justify-center items-center py-3 px-6 h-12 border border-gray-300 rounded-lg shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Reset Filters
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Activities Cards (Grid View) -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Activity List ({{ $activities->total() }} items)</h2>
        @if($activities->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($activities as $activity)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 transition-all duration-300 hover:shadow-lg relative">
                        <!-- Activity Image or Icon -->
                        <div class="h-48 bg-gray-200 relative">
                            @if(isset($activity->images[0]))
                                <img src="{{ asset('storage/' . $activity->images[0]) }}" alt="{{ $activity->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-purple-100">
                                    <i class="fas fa-mountain text-purple-400 text-5xl"></i>
                                </div>
                            @endif
                            <div class="absolute top-0 right-0 mt-3 mr-3">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $activity->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $activity->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="absolute top-0 left-0 mt-3 ml-3">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                    {{ $activityTypes[$activity->activity_type] ?? ucfirst(str_replace('_', ' ', $activity->activity_type)) }}
                                </span>
                            </div>
                        </div>

                        <!-- Activity Info -->
                        <div class="p-5">
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $activity->name }}</h3>
                                <p class="text-sm text-gray-600 truncate mt-1">
                                    <i class="fas fa-map-marker-alt text-red-500 mr-1"></i> {{ $activity->location }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-2 mb-4">
                                <div>
                                    <p class="text-xs text-gray-500">Price</p>
                                    <p class="text-sm font-medium text-purple-600">RM {{ number_format($activity->price, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Duration</p>
                                    <p class="text-sm">
                                        @if($activity->duration_minutes)
                                            {{ floor($activity->duration_minutes/60) }}h {{ $activity->duration_minutes % 60 }}m
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="mb-4 pb-4 border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center mr-2">
                                        <i class="fas fa-user text-gray-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium">{{ $activity->shopInfo->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ Str::limit($activity->shopInfo->user->email, 20) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ $activity->created_at->format('d M Y') }}
                                </span>
                                <a href="{{ route('admin.providers.activities.show', $activity->id) }}"
                                   class="inline-flex items-center py-2 px-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    <i class="fas fa-eye mr-1"></i>
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $activities->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="mb-4">
                    <i class="fas fa-hiking text-purple-300 text-5xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">No activities found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or search terms.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Auto-submit the form when a filter changes
        $('#categoryFilter, #statusFilter').on('change', function() {
            $('#searchForm').submit();
        });

        // Flash message auto-hide
        setTimeout(function() {
            $('#success-message, #error-message').fadeOut(500);
        }, 5000);
    });
</script>
@endsection
