<div
    x-data="{ open: @entangle('open') }"
    x-show="open"
    x-cloak
    class="relative z-[999]"
    aria-labelledby="slide-over-title"
    role="dialog"
    aria-modal="true">

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Background overlay -->
    <div x-show="open"
         x-transition:enter="ease-in-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
                <div x-show="open"
                     x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="pointer-events-auto w-screen max-w-md">

                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-2xl">
                        <!-- Header with gradient background -->
                        <div class="bg-gradient-to-r from-teal-600 to-emerald-700 px-4 py-6 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-xl font-semibold text-white" id="slide-over-title">
                                    Edit Profile
                                </h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button wire:click="close" type="button" class="rounded-md bg-teal-600 bg-opacity-0 text-white hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-white">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-teal-100">
                                {{ $currentSection === 'basic' ? 'Update your personal information' : 'Update your password' }}
                            </p>
                        </div>

                        <div class="relative flex-1 px-4 py-6 sm:px-6">
                            <div class="flex flex-col h-full">
                                <!-- Tab navigation with improved styling -->
                                <div class="border-b border-gray-200">
                                    <nav class="flex -mb-px space-x-8">
                                        <button wire:click="setSection('basic')" class="py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-200 {{ $currentSection === 'basic' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                            Basic Info
                                        </button>
                                        <button wire:click="setSection('password')" class="py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-200 {{ $currentSection === 'password' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                            Password
                                        </button>
                                    </nav>
                                </div>

                                <div class="flex-1 overflow-y-auto py-6">
                                    <form wire:submit.prevent="save">
                                        <div class="space-y-6">
                                            <!-- Basic Info Section -->
                                            @if ($currentSection === 'basic')
                                                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Profile Information</h3>

                                                    <!-- Profile Image -->
                                                    <div class="mb-6">
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">Profile Image</label>
                                                        <div class="flex items-center">
                                                            <div class="relative mr-4">
                                                                <div class="h-24 w-24 rounded-full overflow-hidden bg-gray-100 border border-gray-200 flex items-center justify-center">
                                                                    @if ($profileImage)
                                                                        <img src="{{ $profileImage->temporaryUrl() }}" alt="Profile Preview" class="h-full w-full object-cover">
                                                                    @elseif ($existingProfileImage)
                                                                        <img src="{{ Storage::url($existingProfileImage) }}" alt="Profile Photo" class="h-full w-full object-cover">
                                                                    @else
                                                                        <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                                        </svg>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="flex flex-col space-y-2">
                                                                <label for="profile-upload" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 cursor-pointer">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                    </svg>
                                                                    Upload Image
                                                                </label>
                                                                <input id="profile-upload" type="file" wire:model="profileImage" class="hidden" accept="image/*" />

                                                                @if ($existingProfileImage)
                                                                    <button type="button"
                                                                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-red-600 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                                            wire:click="$set('removeExistingImage', true)">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                        </svg>
                                                                        Remove Image
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @error('profileImage')
                                                            <p class="mt-1 text-sm text-red-600">{{ $message ?? 'Profile image must be valid and under 1MB.' }}</p>
                                                        @enderror
                                                    </div>

                                                    <div class="space-y-4">
                                                        <div>
                                                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                                            <div class="mt-1">
                                                                <input wire:model="name" type="text" id="name" class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="Your full name">
                                                            </div>
                                                            @error('name')
                                                                <p class="mt-1 text-sm text-red-600">{{ $message ?? 'Your name is required.' }}</p>
                                                            @enderror
                                                        </div>

                                                        <div>
                                                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                                            <div class="mt-1">
                                                                <input wire:model="email" type="email" id="email" class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="your.email@example.com">
                                                            </div>
                                                            @error('email')
                                                                <p class="mt-1 text-sm text-red-600">{{ $message ?? 'Please enter a valid email address.' }}</p>
                                                            @enderror
                                                        </div>

                                                        <div>
                                                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                                            <div class="mt-1">
                                                                <input wire:model="username" type="text" id="username" class="block w-full px-4 py-3 text-base rounded-md border-gray-300 bg-gray-50 shadow-sm" readonly disabled>
                                                                <p class="mt-1 text-xs text-gray-500">Username cannot be changed.</p>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                                            <div class="mt-1">
                                                                <input wire:model="phone" type="text" id="phone" class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="+60 12-345-6789">
                                                            </div>
                                                            @error('phone')
                                                                <p class="mt-1 text-sm text-red-600">{{ $message ?? 'Please enter a valid phone number.' }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Password Section -->
                                            @if ($currentSection === 'password')
                                                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Update Password</h3>

                                                    <div class="space-y-4">
                                                        <div>
                                                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                                            <div class="mt-1 relative">
                                                                <input
                                                                    wire:model="currentPassword"
                                                                    type="{{ $showCurrentPassword ? 'text' : 'password' }}"
                                                                    id="current_password"
                                                                    class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                                                    placeholder="Enter your current password"
                                                                >
                                                                <button
                                                                    type="button"
                                                                    wire:click="toggleShowCurrentPassword"
                                                                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                                                >
                                                                    @if ($showCurrentPassword)
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                                        </svg>
                                                                    @else
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                        </svg>
                                                                    @endif
                                                                </button>
                                                            </div>
                                                            @error('currentPassword')
                                                                <p class="mt-1 text-sm text-red-600">{{ $message ?? 'Current password is required.' }}</p>
                                                            @enderror
                                                        </div>

                                                        <div>
                                                            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                                            <div class="mt-1 relative">
                                                                <input
                                                                    wire:model="password"
                                                                    type="{{ $showPassword ? 'text' : 'password' }}"
                                                                    id="password"
                                                                    class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                                                    placeholder="Enter new password"
                                                                >
                                                                <button
                                                                    type="button"
                                                                    wire:click="toggleShowPassword"
                                                                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                                                >
                                                                    @if ($showPassword)
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                                        </svg>
                                                                    @else
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                        </svg>
                                                                    @endif
                                                                </button>
                                                            </div>
                                                            @error('password')
                                                                <p class="mt-1 text-sm text-red-600">{{ $message ?? 'Please enter a valid password (at least 8 characters).' }}</p>
                                                            @enderror
                                                        </div>

                                                        <div>
                                                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                                            <div class="mt-1 relative">
                                                                <input
                                                                    wire:model="passwordConfirmation"
                                                                    type="{{ $showPasswordConfirmation ? 'text' : 'password' }}"
                                                                    id="password_confirmation"
                                                                    class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                                                    placeholder="Confirm new password"
                                                                >
                                                                <button
                                                                    type="button"
                                                                    wire:click="toggleShowPasswordConfirmation"
                                                                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                                                >
                                                                    @if ($showPasswordConfirmation)
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                                        </svg>
                                                                    @else
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                        </svg>
                                                                    @endif
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mt-6 flex items-center justify-end space-x-3 px-6">
                                            @if ($currentSection === 'basic')
                                                <button type="button" wire:click="close" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                                    Continue
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </button>
                                            @endif

                                            @if ($currentSection === 'password')
                                                <button type="button" wire:click="setSection('basic')" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 -ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                                    </svg>
                                                    Back
                                                </button>
                                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 -ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Save Changes
                                                </button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
