<div>
    <!-- Tab Content Section -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">My Dashboard</h1>

                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <button wire:click="setActiveTab('profile')" class="{{$activeTab === 'profile' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'}} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Profile
                            </button>
                            <button wire:click="setActiveTab('bookings')" class="{{$activeTab === 'bookings' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'}} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Bookings
                            </button>
                            <button wire:click="setActiveTab('settings')" class="{{$activeTab === 'settings' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'}} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Settings
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div>
                        <!-- Profile Tab -->
                        @if($activeTab === 'profile')
                            <div>
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">
                                                Manage your personal information and preferences.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 mb-6">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h2>
                                    <form>
                                        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                            <div>
                                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                                <div class="mt-1">
                                                    <input type="text" name="name" id="name" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" value="{{ $user->name }}">
                                                </div>
                                            </div>
                                            <div>
                                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                                <div class="mt-1">
                                                    <input type="email" name="email" id="email" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" value="{{ $user->email }}" readonly>
                                                </div>
                                            </div>
                                            <div>
                                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                                <div class="mt-1">
                                                    <input type="tel" name="phone" id="phone" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" placeholder="Enter your phone number">
                                                </div>
                                            </div>
                                            <div>
                                                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                                <div class="mt-1">
                                                    <input type="text" name="username" id="username" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" value="{{ $user->username ?? '' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-6">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Change Password</h2>
                                    <form>
                                        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                            <div>
                                                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                                <div class="mt-1">
                                                    <input type="password" name="current_password" id="current_password" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                                                </div>
                                            </div>
                                            <div class="sm:col-span-2"></div>
                                            <div>
                                                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                                                <div class="mt-1">
                                                    <input type="password" name="new_password" id="new_password" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                                                </div>
                                            </div>
                                            <div>
                                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                                <div class="mt-1">
                                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-6">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                Update Password
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <!-- Bookings Tab -->
                        @if($activeTab === 'bookings')
                            <div>
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">
                                                View and manage your outdoor activity bookings.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Booking Sub-Tabs -->
                                <div class="border-b border-gray-200 mb-6">
                                    <nav class="-mb-px flex space-x-8">
                                        <a href="#" class="border-yellow-500 text-yellow-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                            All Bookings
                                        </a>
                                    </nav>
                                </div>

                                @if(count($bookings) > 0)
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Participants</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($bookings as $booking)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div>
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $booking->activity_details['name'] ?? $booking->activity->name ?? 'N/A' }}
                                                                </div>
                                                                <div class="text-sm text-gray-500">
                                                                    {{ $booking->activity_details['location'] ?? $booking->activity->location ?? 'N/A' }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-900">
                                                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $booking->participants }} {{ Str::plural('person', $booking->participants) }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                                {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                                                {{ $booking->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}
                                                                {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                                {{ ucfirst($booking->status) }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            RM{{ number_format($booking->total_price, 2) }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            <a href="{{ route('customer.bookings.show', $booking->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">View</a>
                                                            @if($booking->status !== 'cancelled' && $booking->status !== 'completed')
                                                                <a href="#" class="text-red-600 hover:text-red-900">Cancel</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="bg-white p-6 rounded-lg shadow-md text-center border border-gray-200">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings found</h3>
                                        <p class="mt-1 text-sm text-gray-500">You haven't made any bookings yet.</p>
                                        <div class="mt-6">
                                            <a href="{{ route('activities.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                Browse Activities
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Settings Tab -->
                        @if($activeTab === 'settings')
                            <div>
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">
                                                Manage your application settings and preferences.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 mb-6">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Notification Preferences</h2>
                                    <form>
                                        <fieldset>
                                            <legend class="text-sm font-medium text-gray-700 mb-2">Email Notifications</legend>
                                            <div class="space-y-3">
                                                <div class="flex items-start">
                                                    <div class="flex items-center h-5">
                                                        <input id="email_booking" name="email_booking" type="checkbox" class="focus:ring-yellow-500 h-4 w-4 text-yellow-600 border-gray-300 rounded">
                                                    </div>
                                                    <div class="ml-3 text-sm">
                                                        <label for="email_booking" class="font-medium text-gray-700">Booking confirmations</label>
                                                        <p class="text-gray-500">Receive email notifications when your booking is confirmed.</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-start">
                                                    <div class="flex items-center h-5">
                                                        <input id="email_promotion" name="email_promotion" type="checkbox" class="focus:ring-yellow-500 h-4 w-4 text-yellow-600 border-gray-300 rounded">
                                                    </div>
                                                    <div class="ml-3 text-sm">
                                                        <label for="email_promotion" class="font-medium text-gray-700">Promotional emails</label>
                                                        <p class="text-gray-500">Receive emails about new activities, discounts, and promotions.</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-start">
                                                    <div class="flex items-center h-5">
                                                        <input id="email_reminder" name="email_reminder" type="checkbox" class="focus:ring-yellow-500 h-4 w-4 text-yellow-600 border-gray-300 rounded">
                                                    </div>
                                                    <div class="ml-3 text-sm">
                                                        <label for="email_reminder" class="font-medium text-gray-700">Booking reminders</label>
                                                        <p class="text-gray-500">Receive email reminders before your scheduled activities.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset class="mt-6">
                                            <legend class="text-sm font-medium text-gray-700 mb-2">Language & Localization</legend>
                                            <div>
                                                <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                                                <select id="language" name="language" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                                                    <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }}>English</option>
                                                    <option value="ms" {{ session('locale') == 'ms' ? 'selected' : '' }}>Bahasa Melayu</option>
                                                </select>
                                            </div>
                                        </fieldset>

                                        <div class="mt-6">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                Save Settings
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Delete Account</h2>
                                    <p class="text-gray-600 mb-4">Permanently delete your account and all associated data.</p>
                                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Delete Account
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
