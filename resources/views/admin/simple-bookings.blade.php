@extends('layouts.simple-admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-indigo-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Enhanced Header with Animation -->
        <div class="mb-8 animate-fade-in">
            <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 mb-2">
                Bookings Management
            </h1>
            <p class="text-gray-600 text-lg flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Manage all customer bookings from this page
            </p>
        </div>

        <!-- Enhanced Key Statistics -->
        <div class="mb-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Bookings Card -->
            <div class="stat-card group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-purple-600 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide mb-2">Total Bookings</p>
                        <p class="text-4xl font-extrabold text-gray-900 counter" data-target="{{ $stats['total_bookings'] ?? $bookings->total() }}">0</p>
                        <p class="mt-2 text-sm text-purple-600 font-medium">All bookings in system</p>
                    </div>
                    <div class="p-4 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Confirmed Bookings Card -->
            <div class="stat-card group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-green-600 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide mb-2">Confirmed</p>
                        <p class="text-4xl font-extrabold text-gray-900 counter" data-target="{{ $stats['confirmed_bookings'] ?? \App\Models\Booking::where('status', 'CONFIRMED')->count() }}">0</p>
                        <p class="mt-2 text-sm text-green-600 font-medium">Successfully confirmed</p>
                    </div>
                    <div class="p-4 rounded-full bg-gradient-to-br from-green-500 to-green-600 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Bookings Card -->
            <div class="stat-card group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-amber-600 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide mb-2">Pending</p>
                        <p class="text-4xl font-extrabold text-gray-900 counter" data-target="{{ $stats['pending_bookings'] ?? \App\Models\Booking::where('status', 'PENDING')->count() }}">0</p>
                        <p class="mt-2 text-sm text-amber-600 font-medium">Awaiting confirmation</p>
                    </div>
                    <div class="p-4 rounded-full bg-gradient-to-br from-amber-500 to-amber-600 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Revenue Card -->
            <div class="stat-card group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-indigo-600 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide mb-2">Total Revenue</p>
                        <p class="text-4xl font-extrabold text-gray-900">RM {{ number_format($stats['total_revenue'] ?? \App\Models\Booking::where('payment_status', 'PAID')->sum('total_price'), 2) }}</p>
                        <p class="mt-2 text-sm text-indigo-600 font-medium">From paid bookings</p>
                    </div>
                    <div class="p-4 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
    </div>

        <!-- Enhanced Search and Filter Section -->
        <div class="bg-white rounded-2xl shadow-2xl mb-8 overflow-hidden border border-purple-100">
            <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-600 p-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-white opacity-10 transform -skew-x-12"></div>
                <div class="relative">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Search & Filter Bookings
                    </h2>
                </div>
            </div>
            <div class="p-6 bg-gradient-to-br from-white to-purple-50">
            <form action="{{ route('admin.bookings') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-4">
                    <!-- Customer Name Search -->
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 py-2 sm:text-sm border-gray-300 rounded-md"
                                placeholder="Search customer name...">
                        </div>
                    </div>

                    <!-- Date Range - From -->
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 py-2 sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <!-- Date Range - To -->
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 py-2 sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Booking Status</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <select id="status" name="status"
                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 py-2 sm:text-sm border-gray-300 rounded-md">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <!-- Payment Status Filter -->
                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <select id="payment_status" name="payment_status"
                                class="focus:ring-purple-500 focus:border-purple-500 block w-full pl-10 py-2 sm:text-sm border-gray-300 rounded-md">
                                <option value="">All Payment Statuses</option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ request('payment_status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                    </div>
                </div>

                    <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('admin.bookings') }}"
                            class="flex justify-center items-center py-3 px-8 h-12 border border-purple-200 rounded-xl shadow-md text-base font-semibold text-purple-600 bg-white hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reset Filters
                        </a>
                        <button type="submit"
                            class="flex justify-center items-center py-3 px-8 h-12 border border-transparent rounded-xl shadow-lg text-base font-bold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transform hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search Bookings
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced Bookings List -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-purple-100 mb-8">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-5 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    All Bookings
                </h2>
                <div class="text-sm text-white bg-white bg-opacity-20 px-4 py-2 rounded-xl backdrop-blur-sm">
                    Total: <span class="font-bold">{{ $bookings->total() ?? 0 }}</span> bookings
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-purple-50 to-indigo-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                    Reference
                                </div>
                            </th>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Activity
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Date
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    Payment
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Amount
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
                        @forelse($bookings as $index => $booking)
                        <tr class="booking-row hover:bg-purple-50 transition-all duration-300 transform hover:scale-[1.01]">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $booking->booking_reference }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $booking->user->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $booking->activity->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(strtoupper($booking->status) == 'CONFIRMED')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmed</span>
                            @elseif(strtoupper($booking->status) == 'PENDING')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">Pending</span>
                            @elseif(strtoupper($booking->status) == 'COMPLETED')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Completed</span>
                            @elseif(strtoupper($booking->status) == 'CANCELLED')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $booking->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(strtoupper($booking->payment_status) == 'PAID')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                            @elseif(strtoupper($booking->payment_status) == 'PENDING')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">Pending</span>
                            @elseif(strtoupper($booking->payment_status) == 'PROCESSING')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Processing</span>
                            @elseif(strtoupper($booking->payment_status) == 'REFUNDED')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Refunded</span>
                            @elseif(strtoupper($booking->payment_status) == 'FAILED')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Failed</span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $booking->payment_status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            RM {{ number_format($booking->total_price, 2) }}
                        </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300 shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-24 h-24 text-purple-200 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-gray-900 text-2xl font-bold mb-2">No bookings found</p>
                                    <p class="text-gray-500 text-lg mb-6">Try adjusting your search filters or check back later.</p>
                                    <a href="{{ route('admin.bookings') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
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
            <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-indigo-50 border-t border-purple-100">
                {{ $bookings->links() }}
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

    @keyframes pulse-scale {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    .animate-slide-in {
        animation: slideIn 0.5s ease-out;
    }

    .stat-card {
        animation: fadeIn 0.5s ease-out;
        animation-fill-mode: both;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }

    .booking-row {
        animation: fadeIn 0.4s ease-out;
        animation-fill-mode: both;
    }

    .booking-row:nth-child(1) { animation-delay: 0.05s; }
    .booking-row:nth-child(2) { animation-delay: 0.1s; }
    .booking-row:nth-child(3) { animation-delay: 0.15s; }
    .booking-row:nth-child(4) { animation-delay: 0.2s; }
    .booking-row:nth-child(5) { animation-delay: 0.25s; }
    .booking-row:nth-child(6) { animation-delay: 0.3s; }
    .booking-row:nth-child(7) { animation-delay: 0.35s; }
    .booking-row:nth-child(8) { animation-delay: 0.4s; }
    .booking-row:nth-child(9) { animation-delay: 0.45s; }
    .booking-row:nth-child(10) { animation-delay: 0.5s; }
</style>

<script>
    $(document).ready(function() {
        // Counter Animation
        $('.counter').each(function() {
            const $this = $(this);
            const countTo = parseInt($this.attr('data-target'));

            $({ countNum: 0 }).animate({
                countNum: countTo
            }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.floor(this.countNum));
                },
                complete: function() {
                    $this.text(this.countNum);
                }
            });
        });

        // Filter form submission enhancement
        $('#status, #payment_status').on('change', function() {
            $(this).closest('form').submit();
        });
    });
</script>
@endsection
