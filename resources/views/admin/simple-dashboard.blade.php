@extends('layouts.simple-admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-indigo-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Welcome Header with Animation -->
        <div class="mb-8 animate-fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 mb-2">
                        Dashboard Overview
                    </h1>
                    <p class="text-gray-600 text-lg">Welcome back, <span class="font-semibold text-purple-600">{{ Auth::user()->name }}</span>. Here's what's happening with your platform.</p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white rounded-full p-4 shadow-lg">
                        <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards with Hover Effects & Animations -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users Card -->
            <div class="stat-card group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-purple-600 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide mb-2">Total Users</p>
                        <p class="text-4xl font-extrabold text-gray-900 counter" data-target="{{ \App\Models\User::count() }}">0</p>
                        <div class="mt-2 flex items-center text-sm">
                            <span class="text-green-600 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                All users
                            </span>
                        </div>
                    </div>
                    <div class="p-4 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Activities Card -->
            <div class="stat-card group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-indigo-600 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide mb-2">Total Activities</p>
                        <p class="text-4xl font-extrabold text-gray-900 counter" data-target="{{ \App\Models\Activity::count() }}">0</p>
                        <div class="mt-2 flex items-center text-sm">
                            <span class="text-indigo-600 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Active listings
                            </span>
                        </div>
                    </div>
                    <div class="p-4 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Bookings Card -->
            <div class="stat-card group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-blue-600 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide mb-2">Total Bookings</p>
                        <p class="text-4xl font-extrabold text-gray-900 counter" data-target="{{ \App\Models\Booking::count() }}">0</p>
                        <div class="mt-2 flex items-center text-sm">
                            <span class="text-blue-600 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                All time
                            </span>
                        </div>
                    </div>
                    <div class="p-4 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Revenue Card -->
            <div class="stat-card group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-l-4 border-green-600 transform hover:-translate-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide mb-2">Total Revenue</p>
                        <p class="text-4xl font-extrabold text-gray-900">RM {{ number_format(\App\Models\Booking::where('payment_status', 'paid')->sum('total_price'), 2) }}</p>
                        <div class="mt-2 flex items-center text-sm">
                            <span class="text-green-600 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Paid bookings
                            </span>
                        </div>
                    </div>
                    <div class="p-4 rounded-full bg-gradient-to-br from-green-500 to-green-600 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
    </div>

        <!-- Recent Data Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Recent Bookings -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-[1.02] transition-all duration-300">
                <div class="px-6 py-5 bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-600 text-white relative overflow-hidden">
                    <div class="absolute inset-0 bg-white opacity-10 transform -skew-x-12"></div>
                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h2 class="text-xl font-bold">Recent Bookings</h2>
                        </div>
                        <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-semibold">Latest 5</span>
                    </div>
                </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $recentBookings = \App\Models\Booking::with(['user', 'activity'])
                                    ->latest()
                                    ->take(5)
                                    ->get();
                            @endphp

                            @forelse($recentBookings as $booking)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $booking->booking_reference }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $booking->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(strtolower($booking->status) == 'confirmed')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Confirmed
                                        </span>
                                    @elseif(strtolower($booking->status) == 'pending')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif(strtolower($booking->status) == 'cancelled')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Cancelled
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">RM {{ number_format($booking->total_price, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No recent bookings found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                    <div class="mt-6 text-right">
                        <a href="{{ route('admin.bookings') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm font-semibold rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 shadow-md hover:shadow-lg">
                            View All Bookings
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-[1.02] transition-all duration-300">
                <div class="px-6 py-5 bg-gradient-to-r from-indigo-600 via-purple-700 to-purple-600 text-white relative overflow-hidden">
                    <div class="absolute inset-0 bg-white opacity-10 transform skew-x-12"></div>
                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <h2 class="text-xl font-bold">Recent Activities</h2>
                        </div>
                        <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-semibold">Latest 5</span>
                    </div>
                </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendor</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $recentActivities = \App\Models\Activity::with(['shopInfo.user'])
                                    ->latest()
                                    ->take(5)
                                    ->get();
                            @endphp

                            @forelse($recentActivities as $activity)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $activity->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $activity->shopInfo->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($activity->activity_type) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">RM {{ number_format($activity->price, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No recent activities found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                    <div class="mt-6 text-right">
                        <a href="{{ route('admin.providers.activities') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-md hover:shadow-lg">
                            View All Activities
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
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

    .stat-card {
        animation: slideIn 0.5s ease-out;
        animation-fill-mode: both;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }

    .pulse-scale {
        animation: pulse-scale 2s ease-in-out infinite;
    }
</style>

<!-- Counter Animation Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Counter Animation
        const counters = document.querySelectorAll('.counter');

        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 2000; // 2 seconds
            const increment = target / (duration / 16); // 60fps
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.textContent = Math.ceil(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };

            // Start animation after a short delay
            setTimeout(() => {
                updateCounter();
            }, 500);
        });
    });
</script>
@endsection
