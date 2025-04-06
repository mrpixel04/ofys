<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">My Account</h1>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Manage your payment methods, billing information, and account settings.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-2">Payment Methods</h2>
                            <p class="text-gray-600 mb-4">Manage your saved payment methods</p>
                            <div class="mt-4">
                                <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    Manage
                                </a>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-2">Billing Address</h2>
                            <p class="text-gray-600 mb-4">Update your billing information</p>
                            <div class="mt-4">
                                <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    Update
                                </a>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-2">Security</h2>
                            <p class="text-gray-600 mb-4">Manage account security settings</p>
                            <div class="mt-4">
                                <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    Settings
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Subscription & Credits</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-md font-medium text-gray-700 mb-2">Current Plan</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-800 font-medium">Free Account</p>
                                    <p class="text-gray-600 text-sm mt-1">Basic access to outdoor activities and bookings</p>
                                    <div class="mt-3">
                                        <a href="#" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium">Upgrade to Premium</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-md font-medium text-gray-700 mb-2">OFYS Credits</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-800 font-medium">0 Credits</p>
                                    <p class="text-gray-600 text-sm mt-1">Earn credits by completing activities and referring friends</p>
                                    <div class="mt-3">
                                        <a href="#" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium">Buy Credits</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
