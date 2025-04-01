<x-admin-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Activity Management</h1>
            <p class="text-lg text-gray-600">View all activities created by providers on your platform.</p>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search & Filter
                </h2>
            </div>
            <div class="p-8">
                <form action="#" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-x-8 gap-y-6">
                        <!-- Activity Name Search -->
                        <div>
                            <label for="activity_name" class="block text-sm font-medium text-gray-700 mb-2">Activity Name</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <input type="text" name="activity_name" id="activity_name"
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 py-3 sm:text-base border-gray-300 rounded-lg"
                                    placeholder="Search by activity name...">
                            </div>
                        </div>

                        <!-- Provider Name Search -->
                        <div>
                            <label for="provider_name" class="block text-sm font-medium text-gray-700 mb-2">Provider Name</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" name="provider_name" id="provider_name"
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 py-3 sm:text-base border-gray-300 rounded-lg"
                                    placeholder="Search by provider name...">
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <select id="category" name="category"
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 py-3 sm:text-base border-gray-300 rounded-lg">
                                    <option value="">All Categories</option>
                                    <option value="hiking">Hiking</option>
                                    <option value="camping">Camping</option>
                                    <option value="rock-climbing">Rock Climbing</option>
                                    <option value="kayaking">Kayaking</option>
                                    <option value="fishing">Fishing</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <select id="status" name="status"
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 py-3 sm:text-base border-gray-300 rounded-lg">
                                    <option value="">All Statuses</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                        <button type="button"
                            class="flex justify-center items-center py-3 px-6 border border-gray-300 rounded-lg shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset Filters
                        </button>
                        <button type="submit"
                            class="flex justify-center items-center py-3 px-6 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Search Activities
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Livewire Component for Provider Activities -->
        @livewire('admin.provider-activities-list')
    </div>
</x-admin-layout>
