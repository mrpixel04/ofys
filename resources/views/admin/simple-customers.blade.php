@extends('layouts.simple-admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-indigo-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Enhanced Header with Animation -->
        <div class="mb-8 animate-fade-in">
            <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 mb-2">
                Customer Management
            </h1>
            <p class="text-gray-600 text-lg flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                View and manage all customer accounts on your platform
            </p>
        </div>

        <!-- Enhanced Flash Messages -->
        @if(session('success'))
        <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-lg animate-slide-in">
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

        @if(session('error'))
        <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-lg animate-slide-in">
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

        <!-- Enhanced Search and Filter Section -->
        <div class="bg-white rounded-2xl shadow-2xl mb-8 overflow-hidden border border-purple-100">
            <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-600 p-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-white opacity-10 transform -skew-x-12"></div>
                <div class="relative">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Search & Filter Customers
                    </h2>
                </div>
            </div>
            <div class="p-8 bg-gradient-to-br from-white to-purple-50">
            <form id="searchForm" action="{{ route('admin.customers') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6">
                    <!-- Customer Name Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Customer Name or Email</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request()->search }}"
                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 py-3 sm:text-base border-gray-300 rounded-lg"
                                placeholder="Search by name or email...">
                        </div>
                    </div>

                    <!-- Registration Date Filter -->
                    <div>
                        <label for="date_filter" class="block text-sm font-medium text-gray-700 mb-2">Registration Date</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <select id="date_filter" name="date_filter"
                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 py-3 sm:text-base border-gray-300 rounded-lg">
                                <option value="">All Time</option>
                                <option value="today" {{ request()->date_filter == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="week" {{ request()->date_filter == 'week' ? 'selected' : '' }}>This Week</option>
                                <option value="month" {{ request()->date_filter == 'month' ? 'selected' : '' }}>This Month</option>
                                <option value="year" {{ request()->date_filter == 'year' ? 'selected' : '' }}>This Year</option>
                            </select>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Account Status</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <select id="status" name="status"
                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 py-3 sm:text-base border-gray-300 rounded-lg">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request()->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="blocked" {{ request()->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                            </select>
                        </div>
                    </div>
                </div>

                    <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                        <button type="button" id="resetFilters"
                            class="flex justify-center items-center py-3 px-8 h-12 border border-purple-200 rounded-xl shadow-md text-base font-semibold text-purple-600 bg-white hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reset Filters
                        </button>
                        <button type="submit"
                            class="flex justify-center items-center py-3 px-8 h-12 border border-transparent rounded-xl shadow-lg text-base font-bold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search Customers
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced Customers List -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-purple-100">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-5">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        All Customers
                    </h2>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-3">
                        <div class="text-sm text-white bg-white bg-opacity-20 px-4 py-2 rounded-xl backdrop-blur-sm">
                            Total: <span class="font-bold">{{ $customers->total() }}</span> customers
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="exportToExcel()" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Export Excel
                            </button>
                            <button onclick="exportToCSV()" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Export CSV
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-purple-50 to-indigo-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Customer
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        Contact
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Status
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Registered On
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-purple-700 uppercase tracking-wider">
                                    <div class="flex items-center justify-end">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                        </svg>
                                        Actions
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($customers as $index => $customer)
                            <tr class="customer-row hover:bg-purple-50 transition-all duration-300 transform hover:scale-[1.01]">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($customer->profile_image)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $customer->profile_image) }}" alt="{{ $customer->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-xl">
                                                    {{ substr($customer->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $customer->username ?? 'No username' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $customer->email }}</div>
                                    @if($customer->phone)
                                        <div class="text-sm text-gray-500">{{ $customer->phone }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(isset($customer->status))
                                        @if($customer->status === 'active')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>Active
                                            </span>
                                        @elseif($customer->status === 'inactive')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>Inactive
                                            </span>
                                        @elseif($customer->status === 'blocked')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-ban mr-1"></i>Blocked
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-question-circle mr-1"></i>{{ $customer->status }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Active
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $customer->created_at->format('d M Y') }}
                                </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button data-id="{{ $customer->id }}" class="view-customer inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-300 shadow-md hover:shadow-lg">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                View
                                            </button>
                                            <button data-id="{{ $customer->id }}" class="delete-customer inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-pink-600 text-white font-semibold rounded-xl hover:from-red-700 hover:to-pink-700 transform hover:scale-105 transition-all duration-300 shadow-md hover:shadow-lg">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-24 h-24 text-purple-200 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        <p class="text-gray-900 text-2xl font-bold mb-2">No customers found</p>
                                        <p class="text-gray-500 text-lg mb-6">Try adjusting your search filters or check back later.</p>
                                        <a href="{{ route('admin.customers') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Clear All Filters
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Enhanced Pagination -->
                @if($customers->count() > 0)
                <div class="mt-6 bg-gradient-to-r from-purple-50 to-indigo-50 p-4 rounded-xl border border-purple-100">
                    {{ $customers->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
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

    .customer-row {
        animation: fadeIn 0.4s ease-out;
        animation-fill-mode: both;
    }

    .customer-row:nth-child(1) { animation-delay: 0.05s; }
    .customer-row:nth-child(2) { animation-delay: 0.1s; }
    .customer-row:nth-child(3) { animation-delay: 0.15s; }
    .customer-row:nth-child(4) { animation-delay: 0.2s; }
    .customer-row:nth-child(5) { animation-delay: 0.25s; }
    .customer-row:nth-child(6) { animation-delay: 0.3s; }
    .customer-row:nth-child(7) { animation-delay: 0.35s; }
    .customer-row:nth-child(8) { animation-delay: 0.4s; }
    .customer-row:nth-child(9) { animation-delay: 0.45s; }
    .customer-row:nth-child(10) { animation-delay: 0.5s; }
</style>

<!-- View Customer Modal -->
<div id="viewCustomerModal" class="fixed inset-0 z-[200] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" aria-hidden="true"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
            <!-- Header with gradient -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white flex items-center" id="modal-title">
                    <i class="fas fa-user-circle mr-2"></i>
                    Customer Details
                </h3>
                <button type="button" id="closeCustomerModal" class="text-white hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <div class="bg-white px-6 py-4">
                <!-- Customer Avatar and Basic Info -->
                <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
                    <div id="customerAvatar" class="flex-shrink-0 h-16 w-16 mr-4"></div>
                    <div>
                        <h4 id="customerName" class="text-xl font-semibold text-gray-800"></h4>
                        <p id="customerUsername" class="text-sm text-gray-500"></p>
                    </div>
                </div>

                <!-- Customer Details -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center mr-3">
                            <i class="fas fa-envelope text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Email Address</p>
                            <p id="customerEmail" class="font-medium text-gray-700"></p>
                        </div>
                    </div>

                    <div id="customerPhoneContainer" class="flex items-center hidden">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-50 flex items-center justify-center mr-3">
                            <i class="fas fa-phone-alt text-green-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Phone Number</p>
                            <p id="customerPhone" class="font-medium text-gray-700"></p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center mr-3">
                            <i class="fas fa-shield-alt text-purple-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Account Status</p>
                            <div id="customerStatus"></div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center mr-3">
                            <i class="fas fa-calendar-alt text-amber-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Registration Date</p>
                            <p id="customerRegisteredOn" class="font-medium text-gray-700"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button type="button" class="inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-sm transition duration-150 ease-in-out" onclick="$('#viewCustomerModal').addClass('hidden')">
                    <i class="fas fa-times mr-2"></i>
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmationModal" class="fixed inset-0 z-[200] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" aria-hidden="true"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
            <!-- Header with gradient -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white flex items-center" id="modal-title">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Delete Customer
                </h3>
                <button type="button" id="cancelDelete" class="text-white hover:text-gray-200 focus:outline-none">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <div class="bg-white px-6 py-5">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-50 flex items-center justify-center mr-4">
                        <i class="fas fa-user-times text-red-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-gray-800 font-medium mb-2">Are you sure you want to delete this customer?</p>
                        <p class="text-sm text-gray-600">
                            All of their data will be permanently removed from the system.
                            This action cannot be undone.
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                <button type="button" class="inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 shadow-sm transition duration-150 ease-in-out" id="cancelDeleteBtn">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </button>
                <form id="deleteCustomerForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm transition duration-150 ease-in-out">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Reset filters button
        $('#resetFilters').on('click', function() {
            $('#search').val('');
            $('#date_filter').val('');
            $('#status').val('');
            $('#searchForm').submit();
        });

        // Auto-submit the form when a filter changes
        $('#date_filter, #status').on('change', function() {
            $('#searchForm').submit();
        });

        // View customer modal
        $('.view-customer').on('click', function() {
            const customerId = $(this).data('id');

            // Show loading state
            $('#customerName').html('<div class="animate-pulse h-5 w-24 bg-gray-200 rounded"></div>');
            $('#customerUsername').html('<div class="animate-pulse h-5 w-16 bg-gray-200 rounded"></div>');
            $('#customerEmail').html('<div class="animate-pulse h-5 w-32 bg-gray-200 rounded"></div>');
            $('#customerStatus').html('<div class="animate-pulse h-5 w-20 bg-gray-200 rounded"></div>');
            $('#customerRegisteredOn').html('<div class="animate-pulse h-5 w-24 bg-gray-200 rounded"></div>');

            // Show the modal
            $('#viewCustomerModal').removeClass('hidden');

            // Fetch customer data via AJAX
            $.ajax({
                url: `{{ route('admin.customers') }}/${customerId}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Check if we have a customer object directly or nested in response.customer
                    const customer = response.customer || response;

                    // Update modal content
                    $('#customerName').text(customer.name);
                    $('#customerUsername').text(customer.username || 'No username');
                    $('#customerEmail').text(customer.email);

                    // Handle phone display
                    if (customer.phone) {
                        $('#customerPhone').text(customer.phone);
                        $('#customerPhoneContainer').removeClass('hidden');
                    } else {
                        $('#customerPhoneContainer').addClass('hidden');
                    }

                    // Handle status badge with modern design
                    let statusBadge = '';
                    if (customer.status === 'active') {
                        statusBadge = '<div class="flex items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i>Active</span></div>';
                    } else if (customer.status === 'inactive') {
                        statusBadge = '<div class="flex items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"><i class="fas fa-clock mr-1"></i>Inactive</span></div>';
                    } else if (customer.status === 'blocked') {
                        statusBadge = '<div class="flex items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800"><i class="fas fa-ban mr-1"></i>Blocked</span></div>';
                    } else {
                        statusBadge = '<div class="flex items-center"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i>Active</span></div>';
                    }
                    $('#customerStatus').html(statusBadge);

                    // Format and display registration date
                    const registerDate = new Date(customer.created_at);
                    const formattedDate = registerDate.toLocaleDateString('en-US', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                    $('#customerRegisteredOn').text(formattedDate);

                    // Handle avatar
                    if (customer.profile_image) {
                        $('#customerAvatar').html(`<img class="h-16 w-16 rounded-full object-cover ring-2 ring-purple-500" src="/storage/${customer.profile_image}" alt="${customer.name}">`);
                    } else {
                        const initial = customer.name.charAt(0).toUpperCase();
                        $('#customerAvatar').html(`<div class="h-16 w-16 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold text-2xl ring-2 ring-purple-300">${initial}</div>`);
                    }
                },
                error: function(error) {
                    console.error('Error fetching customer data:', error);
                    $('#viewCustomerModal').addClass('hidden');
                    alert('Error fetching customer details. Please try again.');
                }
            });
        });

        // Close view customer modal
        $('#closeCustomerModal').on('click', function() {
            $('#viewCustomerModal').addClass('hidden');
        });

        // Delete customer - Show confirmation modal
        $('.delete-customer').on('click', function() {
            const customerId = $(this).data('id');
            $('#deleteCustomerForm').attr('action', `/admin/customers/${customerId}`);
            $('#deleteConfirmationModal').removeClass('hidden');
        });

        // Cancel delete
        $('#cancelDelete, #cancelDeleteBtn').on('click', function() {
            $('#deleteConfirmationModal').addClass('hidden');
        });

        // Close modals when clicking outside
        $(window).on('click', function(event) {
            if ($(event.target).hasClass('fixed') && $(event.target).hasClass('inset-0')) {
                $('#viewCustomerModal').addClass('hidden');
                $('#deleteConfirmationModal').addClass('hidden');
            }
        });

        // Export to Excel function
        window.exportToExcel = function() {
            // Get all customer data from the table
            const customers = [];

            $('tbody tr.customer-row').each(function() {
                const row = $(this);
                const name = row.find('td:eq(0) .text-sm.font-medium').text().trim();
                const username = row.find('td:eq(0) .text-xs').text().trim();
                const email = row.find('td:eq(1) .text-sm.font-medium').text().trim();
                const phone = row.find('td:eq(1) .text-xs').text().trim();
                const status = row.find('td:eq(2) span').text().trim();
                const registeredOn = row.find('td:eq(3)').text().trim();

                customers.push({
                    'Name': name,
                    'Username': username,
                    'Email': email,
                    'Phone': phone,
                    'Status': status,
                    'Registered On': registeredOn
                });
            });

            // Convert to Excel format using SheetJS (if available) or fallback to CSV
            if (typeof XLSX !== 'undefined') {
                const ws = XLSX.utils.json_to_sheet(customers);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Customers');
                XLSX.writeFile(wb, 'customers_' + new Date().toISOString().slice(0,10) + '.xlsx');
            } else {
                // Fallback to CSV if XLSX library not available
                console.warn('XLSX library not found, falling back to CSV export');
                exportToCSV();
            }
        };

        // Export to CSV function
        window.exportToCSV = function() {
            // Get all customer data from the table
            const rows = [];

            // Add header row
            rows.push(['Name', 'Username', 'Email', 'Phone', 'Status', 'Registered On']);

            // Add data rows
            $('tbody tr.customer-row').each(function() {
                const row = $(this);
                const name = row.find('td:eq(0) .text-sm.font-medium').text().trim();
                const username = row.find('td:eq(0) .text-xs').text().trim();
                const email = row.find('td:eq(1) .text-sm.font-medium').text().trim();
                const phone = row.find('td:eq(1) .text-xs').text().trim();
                const status = row.find('td:eq(2) span').text().trim();
                const registeredOn = row.find('td:eq(3)').text().trim();

                rows.push([name, username, email, phone, status, registeredOn]);
            });

            // Convert to CSV
            let csvContent = rows.map(row =>
                row.map(cell => {
                    // Escape quotes and wrap in quotes if contains comma
                    const escaped = String(cell).replace(/"/g, '""');
                    return escaped.includes(',') || escaped.includes('\n') ? `"${escaped}"` : escaped;
                }).join(',')
            ).join('\n');

            // Create download link
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);

            link.setAttribute('href', url);
            link.setAttribute('download', 'customers_' + new Date().toISOString().slice(0,10) + '.csv');
            link.style.visibility = 'hidden';

            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        };
    });
</script>

<!-- SheetJS Library for Excel Export (Optional - loads from CDN) -->
<script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>

@endsection
