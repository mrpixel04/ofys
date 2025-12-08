<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-900">{{ __('Customer Dashboard') }}</h1>
                        <p class="mt-2 text-lg text-gray-600">{{ __('Welcome back, :name!', ['name' => $user->name]) }}</p>
                    </div>

                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <a href="{{ route('customer.dashboard', ['tab' => 'profile']) }}" class="{{ ($activeTab ?? $tab ?? 'profile') === 'profile' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">{{ __('Profile') }}</a>
                            <a href="{{ route('customer.dashboard', ['tab' => 'bookings']) }}" class="{{ ($activeTab ?? $tab ?? 'profile') === 'bookings' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">{{ __('Bookings') }}</a>
                            <a href="{{ route('customer.dashboard', ['tab' => 'settings']) }}" class="{{ ($activeTab ?? $tab ?? 'profile') === 'settings' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">{{ __('Settings') }}</a>
                        </nav>
                    </div>

                    @php
                        $currentTab = $activeTab ?? $tab ?? 'profile';
                    @endphp

                    <!-- Profile Section -->
                    @if($currentTab === 'profile')
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6 border-b border-gray-200 pb-2">{{ __('Personal Information') }}</h2>
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 mb-6">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Personal Information') }}</h2>
                            <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Full Name') }}</label>
                                        <div class="mt-1">
                                            <input type="text" name="name" id="name" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" value="{{ $user->name }}">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                                        <div class="mt-1">
                                            <input type="email" id="email" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md bg-gray-100" value="{{ $user->email }}" readonly>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('Phone Number') }}</label>
                                        <div class="mt-1">
                                            <input type="tel" name="phone" id="phone" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" value="{{ old('phone', $user->phone) }}" placeholder="{{ __('Enter your phone number') }}">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="profile_image" class="block text-sm font-medium text-gray-700">{{ __('Profile Image') }}</label>
                                        <input type="file" name="profile_image" id="profile_image" class="mt-1 block w-full text-sm text-gray-600" accept="image/*">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="address" class="block text-sm font-medium text-gray-700">{{ __('Address') }}</label>
                                        <div class="mt-1">
                                            <textarea name="address" id="address" rows="3" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" placeholder="{{ __('Enter your address') }}">{{ old('address', $user->address) }}</textarea>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">{{ __('Date of Birth') }}</label>
                                        <div class="mt-1">
                                            <input type="date" name="date_of_birth" id="date_of_birth" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" value="{{ old('date_of_birth', $user->date_of_birth ? \Illuminate\Support\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '') }}">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="gender" class="block text-sm font-medium text-gray-700">{{ __('Gender') }}</label>
                                        <div class="mt-1">
                                            <select name="gender" id="gender" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                                                <option value="">{{ __('Select Gender') }}</option>
                                                <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                                <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        {{ __('Save Changes') }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Change Password') }}</h2>
                            <form method="POST" action="{{ route('customer.account.password.update') }}">
                                @csrf
                                @method('PUT')
                                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700">{{ __('Current Password') }}</label>
                                        <input type="password" name="current_password" id="current_password" class="mt-1 py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="new_password" class="block text-sm font-medium text-gray-700">{{ __('New Password') }}</label>
                                        <input type="password" name="new_password" id="new_password" class="mt-1 py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Confirm New Password') }}</label>
                                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="mt-1 py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        {{ __('Update Password') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                    <!-- Bookings Section -->
                    @if($currentTab === 'bookings')
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6 border-b border-gray-200 pb-2">{{ __('Your Bookings') }}</h2>
                        @php
                            $bookingGroups = ($bookings ?? null) instanceof \Illuminate\Support\Collection
                                ? $bookings
                                : collect($bookings ?? []);
                            $bookingSections = [
                                'active' => [
                                    'title' => __('Active Bookings'),
                                    'items' => $bookingGroups->get('active', collect()),
                                ],
                                'past' => [
                                    'title' => __('Past Bookings'),
                                    'items' => $bookingGroups->get('past', collect()),
                                ],
                                'cancelled' => [
                                    'title' => __('Cancelled Bookings'),
                                    'items' => $bookingGroups->get('cancelled', collect()),
                                ],
                            ];
                        @endphp

                        @foreach($bookingSections as $sectionKey => $section)
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 mb-6 last:mb-0">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-medium text-gray-900">{{ $section['title'] }}</h2>
                                @if($section['items']->isNotEmpty())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-700">
                                        {{ $section['items']->count() }} {{ __('Bookings') }}
                                    </span>
                                @endif
                            </div>

                            @if($section['items']->isNotEmpty())
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Activities') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date & Time') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Participants') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Amount') }}</th>
                                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($section['items'] as $booking)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">{{ $booking->activity->name ?? ($booking->activity_details['name'] ?? __('None')) }}</div>
                                                        <div class="text-sm text-gray-500">{{ $booking->activity->location ?? ($booking->activity_details['location'] ?? __('None')) }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</div>
                                                        <div class="text-sm text-gray-500">{{ Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $booking->participants }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                            {{ in_array($booking->status, ['pending', 'active']) ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                            {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                                            {{ $booking->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}
                                                            {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                            {{ ucfirst($booking->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">RM{{ number_format($booking->total_price, 2) }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('customer.bookings.show', $booking->id) }}" class="text-yellow-600 hover:text-yellow-900">{{ __('View') }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <p class="text-gray-500">{{ __('No bookings found in this section.') }}</p>
                                    @if($sectionKey === 'active')
                                    <div class="mt-4">
                                        <a href="{{ route('activities.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">{{ __('Explore Activities') }}</a>
                                    </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Settings Section -->
                    @if($currentTab === 'settings')
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6 border-b border-gray-200 pb-2">{{ __('Account Settings') }}</h2>
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Preferences') }}</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ __('Email Notifications') }}</h4>
                                        <p class="text-sm text-gray-500">{{ __('Receive booking confirmations and updates via email') }}</p>
                                    </div>
                                    <input type="checkbox" class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded" checked>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ __('SMS Notifications') }}</h4>
                                        <p class="text-sm text-gray-500">{{ __('Receive booking reminders via SMS') }}</p>
                                    </div>
                                    <input type="checkbox" class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ __('Marketing Updates') }}</h4>
                                        <p class="text-sm text-gray-500">{{ __('Receive information about new activities and promotions') }}</p>
                                    </div>
                                    <input type="checkbox" class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    {{ __('Save Preferences') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
