@extends('layouts.provider.app')

@section('header', 'Dashboard Overview')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-gray-900">My Services</h2>
                <span class="p-2 bg-teal-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </span>
            </div>
            <p class="text-gray-600 mb-4">Manage your outdoor activity services</p>
            <div class="mt-4">
                <a href="{{ route('provider.activities') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors">
                    View Services
                </a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-gray-900">Bookings</h2>
                <span class="p-2 bg-emerald-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </span>
            </div>
            <p class="text-gray-600 mb-4">Manage customer bookings and schedule</p>
            <div class="mt-4">
                <a href="{{ route('provider.bookings') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                    View Bookings
                </a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-gray-900">Pricing</h2>
                <span class="p-2 bg-teal-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <p class="text-gray-600 mb-4">Manage your service pricing</p>
            <div class="mt-4">
                <a href="{{ route('provider.pricing') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors">
                    Manage Pricing
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-teal-500 to-emerald-600 p-6 rounded-lg shadow-sm text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-teal-100 text-sm">Total Bookings</p>
                    <h3 class="text-2xl font-bold mt-1">42</h3>
                </div>
                <div class="p-3 bg-white bg-opacity-30 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-teal-100">
                    <span class="text-teal-50 font-medium">↑ 12%</span> from last month
                </span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Pending Bookings</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">8</h3>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500">
                    Requires attention
                </span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Active Services</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">5</h3>
                </div>
                <div class="p-3 bg-teal-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500">
                    Available to customers
                </span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Total Revenue</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">RM 8,542</h3>
                </div>
                <div class="p-3 bg-emerald-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-gray-500">
                    <span class="text-emerald-600 font-medium">↑ 18%</span> from last month
                </span>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-gray-900">Recent Bookings</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Example booking records -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Hiking Tour</div>
                            <div class="text-sm text-gray-500">Mount Kinabalu</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">John Doe</div>
                            <div class="text-sm text-gray-500">john@example.com</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">June 15, 2023</div>
                            <div class="text-sm text-gray-500">09:30 AM</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Confirmed
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <a href="#" class="text-teal-600 hover:text-teal-900 mr-3">View</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Camping Trip</div>
                            <div class="text-sm text-gray-500">Taman Negara</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Jane Smith</div>
                            <div class="text-sm text-gray-500">jane@example.com</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">June 20, 2023</div>
                            <div class="text-sm text-gray-500">08:00 AM</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <a href="#" class="text-teal-600 hover:text-teal-900 mr-3">View</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Fishing Tour</div>
                            <div class="text-sm text-gray-500">Kuala Selangor</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Mike Johnson</div>
                            <div class="text-sm text-gray-500">mike@example.com</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">June 22, 2023</div>
                            <div class="text-sm text-gray-500">14:00 PM</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Confirmed
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <a href="#" class="text-teal-600 hover:text-teal-900 mr-3">View</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
            <a href="{{ route('provider.bookings') }}" class="text-sm font-medium text-teal-600 hover:text-teal-500">View all bookings →</a>
        </div>
    </div>
@endsection
