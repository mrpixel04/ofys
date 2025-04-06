<div>
    <!-- Success Message -->
    @if (session('success'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 5000)"
             x-show="show"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed top-16 right-4 z-50 rounded-md bg-green-50 p-4 shadow-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button @click="show = false" type="button" class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Profile Header -->
    <div class="relative pb-32 bg-gradient-to-r from-teal-500 to-emerald-600">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-10" src="{{ asset('images/pattern.png') }}" alt="Background pattern">
            <div class="absolute inset-0 bg-gradient-to-r from-teal-500 to-emerald-600 mix-blend-multiply" aria-hidden="true"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white md:text-5xl lg:text-6xl">Profile</h1>
            <p class="mt-6 max-w-3xl text-xl text-teal-100">Manage your account details and personal information.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="relative -mt-32">
        <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-xl">
                <div class="p-6 sm:p-8 md:p-10">
                    <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                        <!-- Left Column: Profile Card -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                <div class="px-4 py-5 sm:p-6 flex flex-col items-center">
                                    <div class="relative">
                                        <div class="h-32 w-32 rounded-full overflow-hidden bg-gray-100 border border-gray-200 flex items-center justify-center">
                                            @if ($user->profile_image)
                                                <img src="{{ Storage::url($user->profile_image) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                                            @else
                                                <svg class="h-20 w-20 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <button
                                            wire:click="$dispatch('openEditProfile')"
                                            type="button"
                                            class="absolute bottom-0 right-0 inline-flex items-center p-2 border border-transparent rounded-full shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <h3 class="text-xl font-medium text-gray-900">{{ $user->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $user->username }}</p>
                                    </div>

                                    <div class="mt-5 w-full">
                                        <div class="mt-3 flex items-center text-sm text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ $user->email }}</span>
                                        </div>

                                        @if ($user->phone)
                                        <div class="mt-3 flex items-center text-sm text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            <span>{{ $user->phone }}</span>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="mt-6">
                                        <button
                                            wire:click="$dispatch('openEditProfile')"
                                            type="button"
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit Profile
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Account Activity & Shop Info -->
                        <div class="mt-8 lg:mt-0 lg:col-span-2">
                            <div class="space-y-6">
                                <!-- Account Activity -->
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                    <div class="px-4 py-5 sm:p-6">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">Account Activity</h3>
                                        <div class="mt-5 border-t border-gray-200 pt-5">
                                            <dl class="divide-y divide-gray-200">
                                                <div class="py-3 flex justify-between">
                                                    <dt class="text-sm font-medium text-gray-500">Account Created</dt>
                                                    <dd class="text-sm text-gray-900">{{ $user->created_at->format('F j, Y') }}</dd>
                                                </div>
                                                <div class="py-3 flex justify-between">
                                                    <dt class="text-sm font-medium text-gray-500">Last Profile Update</dt>
                                                    <dd class="text-sm text-gray-900">{{ $user->updated_at->format('F j, Y') }}</dd>
                                                </div>
                                                <div class="py-3 flex justify-between">
                                                    <dt class="text-sm font-medium text-gray-500">Account Status</dt>
                                                    <dd class="text-sm flex items-center">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                                <circle cx="4" cy="4" r="3" />
                                                            </svg>
                                                            Active
                                                        </span>
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shop Info Summary -->
                                @if($user->shopInfo)
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                    <div class="px-4 py-5 sm:p-6">
                                        <div class="flex justify-between items-center">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900">Shop Information</h3>
                                            <a href="{{ route('provider.shop-info') }}" class="text-sm font-medium text-teal-600 hover:text-teal-500">
                                                View Details
                                                <span aria-hidden="true"> &rarr;</span>
                                            </a>
                                        </div>
                                        <div class="mt-5 border-t border-gray-200 pt-5">
                                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Company Name</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->shopInfo->company_name }}</dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Country</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->shopInfo->country ?? 'Not specified' }}</dd>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        {{ $user->shopInfo->description ?? 'No description provided.' }}
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="bg-yellow-50 rounded-lg shadow-sm border border-yellow-200 overflow-hidden">
                                    <div class="px-4 py-5 sm:p-6">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-yellow-800">Shop Information Missing</h3>
                                                <div class="mt-2 text-sm text-yellow-700">
                                                    <p>
                                                        Your shop information is not set up yet. Please complete your shop profile to start offering services.
                                                    </p>
                                                </div>
                                                <div class="mt-4">
                                                    <a href="{{ route('provider.shop-info') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                        Set Up Shop Info
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Slide-over -->
    <livewire:provider.edit-profile />
</div>
