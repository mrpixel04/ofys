@extends('layouts.simple-admin')

@section('title', 'Activities Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-indigo-50">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Enhanced Header with Animation -->
        <div class="mb-8 animate-fade-in">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 mb-2">
                        Activities Management
                    </h1>
                    <p class="text-gray-600 text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        View and manage all activities created by providers on your platform
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('admin.providers.activities.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 border border-transparent rounded-xl font-bold text-white tracking-wide hover:from-purple-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create New Activity
                    </a>
                    <a href="{{ route('admin.simple-providers-basic') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white border border-purple-200 rounded-xl font-semibold text-purple-600 hover:bg-purple-50 transform hover:scale-105 transition-all duration-300 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Provider List
                    </a>
                </div>
            </div>
        </div>

        <!-- Enhanced Flash Messages -->
        @if (session('success'))
        <div id="success-message" class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-lg animate-slide-in" role="alert">
            <div class="flex items-center">
                <div class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <p class="ml-3 font-semibold">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if (session('error'))
        <div id="error-message" class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-lg animate-slide-in" role="alert">
            <div class="flex items-center">
                <div class="flex-shrink-0 w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <p class="ml-3 font-semibold">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Enhanced Search & Filters -->
        <div class="bg-white rounded-2xl shadow-2xl mb-8 overflow-hidden border border-purple-100">
            <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-600 p-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-white opacity-10 transform -skew-x-12"></div>
                <div class="relative">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Search & Filter Activities
                    </h2>
                </div>
            </div>
            <div class="p-6 bg-gradient-to-br from-white to-purple-50">
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
                            class="flex justify-center items-center py-3 px-8 h-12 border border-transparent rounded-xl shadow-lg text-base font-bold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search
                        </button>
                        <a href="{{ route('admin.providers.activities') }}"
                            class="flex justify-center items-center py-3 px-8 h-12 border border-purple-200 rounded-xl shadow-md text-base font-semibold text-purple-600 bg-white hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reset Filters
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced Activities Header -->
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <span class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 py-2 rounded-xl mr-3 shadow-lg">
                    {{ $activities->total() }}
                </span>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">
                    Activities Found
                </span>
            </h2>
        </div>
        @if($activities->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($activities as $activity)
                    <div class="activity-card bg-white rounded-2xl shadow-lg overflow-hidden border border-purple-100 transition-all duration-300 hover:shadow-2xl hover:scale-105 relative transform">
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
                                <span class="text-xs text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $activity->created_at->format('d M Y') }}
                                </span>
                                <a href="{{ route('admin.providers.activities.show', $activity->id) }}"
                                   class="inline-flex items-center py-2 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform hover:scale-105 transition-all duration-300">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>

            <!-- Enhanced Pagination -->
            <div class="mt-8 bg-white rounded-xl shadow-lg p-4 border border-purple-100">
                {{ $activities->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-2xl shadow-2xl border border-purple-100">
                <div class="mb-6">
                    <svg class="w-24 h-24 text-purple-200 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No activities found</h3>
                <p class="text-gray-500 text-lg mb-6">Try adjusting your filters or search terms.</p>
                <a href="{{ route('admin.providers.activities') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Clear All Filters
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Animations & Styles -->
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    .animate-slide-in {
        animation: slideIn 0.5s ease-out;
    }

    .activity-card {
        animation: fadeIn 0.5s ease-out;
        animation-fill-mode: both;
    }

    .activity-card:nth-child(1) { animation-delay: 0.05s; }
    .activity-card:nth-child(2) { animation-delay: 0.1s; }
    .activity-card:nth-child(3) { animation-delay: 0.15s; }
    .activity-card:nth-child(4) { animation-delay: 0.2s; }
    .activity-card:nth-child(5) { animation-delay: 0.25s; }
    .activity-card:nth-child(6) { animation-delay: 0.3s; }
    .activity-card:nth-child(7) { animation-delay: 0.35s; }
    .activity-card:nth-child(8) { animation-delay: 0.4s; }
    .activity-card:nth-child(9) { animation-delay: 0.45s; }
</style>
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
