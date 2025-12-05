<x-admin-layout>
    <div class="container mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
            <p class="text-gray-600">Welcome back, Admin. Here's what's happening with your platform.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 border-t-4 border-purple-500 overflow-hidden relative">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-purple-600/5 pointer-events-none"></div>
                <div class="flex items-center relative">
                    <div class="p-3 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 mr-4 shadow-md">
                        <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Customers</p>
                        <p class="text-2xl font-bold text-gray-800">{{ \App\Models\User::where('role', 'CUSTOMER')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 border-t-4 border-teal-500 overflow-hidden relative">
                <div class="absolute inset-0 bg-gradient-to-br from-teal-500/5 to-teal-600/5 pointer-events-none"></div>
                <div class="flex items-center relative">
                    <div class="p-3 rounded-full bg-gradient-to-br from-teal-400 to-teal-600 mr-4 shadow-md">
                        <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Vendors</p>
                        <p class="text-2xl font-bold text-gray-800">{{ \App\Models\User::where('role', 'PROVIDER')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 border-t-4 border-amber-500 overflow-hidden relative">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-amber-600/5 pointer-events-none"></div>
                <div class="flex items-center relative">
                    <div class="p-3 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 mr-4 shadow-md">
                        <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Bookings</p>
                        <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Booking::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6 border-t-4 border-fuchsia-500 overflow-hidden relative">
                <div class="absolute inset-0 bg-gradient-to-br from-fuchsia-500/5 to-fuchsia-600/5 pointer-events-none"></div>
                <div class="flex items-center relative">
                    <div class="p-3 rounded-full bg-gradient-to-br from-fuchsia-400 to-fuchsia-600 mr-4 shadow-md">
                        <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Revenue</p>
                        <p class="text-2xl font-bold text-gray-800">RM {{ number_format(\App\Models\Booking::where('status', 'COMPLETED')->where('payment_status', 'PAID')->sum('total_price'), 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue Chart -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-800">Monthly Revenue (2025)</h2>
            </div>
            <div class="p-6">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-800">Recent Bookings</h2>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
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
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->activity->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') : 'N/A' }}</td>
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
                                    <td class="px-6 py-4 whitespace-nowrap">RM {{ number_format($booking->total_price, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No bookings found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-right">
                    <a href="{{ route('admin.bookings') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium inline-flex items-center">
                        View all bookings
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const ctx = document.getElementById('revenueChart').getContext('2d');

            // Get actual revenue data
            const revenueData = [
                @for($i = 1; $i <= 12; $i++)
                    {{ \App\Models\Booking::where('status', 'COMPLETED')
                        ->where('payment_status', 'PAID')
                        ->whereYear('booking_date', 2025)
                        ->whereMonth('booking_date', $i)
                        ->sum('total_price') }}{{ $i < 12 ? ',' : '' }}
                @endfor
            ];

            // Create gradient background
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(147, 51, 234, 0.7)');
            gradient.addColorStop(1, 'rgba(147, 51, 234, 0.1)');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Monthly Revenue (RM)',
                        data: revenueData,
                        backgroundColor: [
                            'rgba(139, 92, 246, 0.7)',  // Jan (purple)
                            'rgba(147, 51, 234, 0.7)',  // Feb (purple)
                            'rgba(168, 85, 247, 0.7)',  // Mar (purple)
                            'rgba(192, 132, 252, 0.7)', // Apr (purple)
                            'rgba(216, 180, 254, 0.7)', // May (lighter purple)
                            'rgba(14, 165, 233, 0.7)',  // Jun (blue)
                            'rgba(56, 189, 248, 0.7)',  // Jul (blue)
                            'rgba(125, 211, 252, 0.7)', // Aug (light blue)
                            'rgba(186, 230, 253, 0.7)', // Sep (lighter blue)
                            'rgba(239, 68, 68, 0.7)',   // Oct (red)
                            'rgba(248, 113, 113, 0.7)', // Nov (light red)
                            'rgba(252, 165, 165, 0.7)'  // Dec (lighter red)
                        ],
                        borderColor: 'rgba(147, 51, 234, 1)',
                        borderWidth: 1,
                        borderRadius: 5,
                        hoverBackgroundColor: 'rgba(147, 51, 234, 0.9)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#6B7280',
                            bodyColor: '#374151',
                            bodyFont: {
                                weight: 'bold'
                            },
                            borderColor: '#E5E7EB',
                            borderWidth: 1,
                            cornerRadius: 8,
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'RM ' + context.parsed.y.toFixed(2);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false,
                                color: 'rgba(229, 231, 235, 0.5)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'RM ' + value;
                                },
                                font: {
                                    family: 'Inter, sans-serif'
                                },
                                color: '#6B7280'
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    family: 'Inter, sans-serif'
                                },
                                color: '#6B7280'
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
