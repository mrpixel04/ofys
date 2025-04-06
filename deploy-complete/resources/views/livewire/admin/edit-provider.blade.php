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
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-4 py-6 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-xl font-semibold text-white" id="slide-over-title">
                                    Edit Provider
                                </h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button wire:click="toggleModal" type="button" class="rounded-md bg-blue-600 bg-opacity-0 text-white hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-white">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-blue-100">
                                Update provider information
                            </p>
                        </div>

                        <div class="relative flex-1 px-4 py-6 sm:px-6">
                            <div class="flex flex-col h-full">
                                <!-- Tab navigation with improved styling -->
                                <div class="border-b border-gray-200">
                                    <nav class="flex -mb-px space-x-8">
                                        <button wire:click="setSection('profile')" class="py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-200 {{ $currentSection === 'profile' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                            Company Info
                                        </button>
                                        <button wire:click="setSection('credentials')" class="py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-200 {{ $currentSection === 'credentials' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                            Credentials
                                        </button>
                                    </nav>
                                </div>

                                <div class="flex-1 overflow-y-auto py-6">
                                    <form wire:submit.prevent="updateProvider">
                                        <div class="space-y-6">
                                            <!-- Company Info Section -->
                                            @if ($currentSection === 'profile')
                                                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Company Information</h3>

                                                    <div class="space-y-4">
                                                        <div>
                                                            <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                                                            <div class="mt-1">
                                                                <input wire:model.blur="companyName" type="text" id="company_name" class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Company name" style="text-transform: uppercase;">
                                                            </div>
                                                            @error('companyName')
                                                                <p class="mt-1 text-sm text-red-600">{{ $errors->first('companyName') }}</p>
                                                            @enderror
                                                        </div>

                                                        <div>
                                                            <label for="owner_fullname" class="block text-sm font-medium text-gray-700">Owner Full Name</label>
                                                            <div class="mt-1">
                                                                <input wire:model.blur="ownerFullname" type="text" id="owner_fullname" class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Owner full name" style="text-transform: uppercase;">
                                                            </div>
                                                            @error('ownerFullname')
                                                                <p class="mt-1 text-sm text-red-600">{{ $errors->first('ownerFullname') }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Credentials Section -->
                                            @if ($currentSection === 'credentials')
                                                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Access Credentials</h3>

                                                    <div class="space-y-4">
                                                        <div>
                                                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                                            <div class="mt-1">
                                                                <input wire:model="email" type="email" id="email" class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Email">
                                                            </div>
                                                            @error('email')
                                                                <p class="mt-1 text-sm text-red-600">{{ $errors->first('email') }}</p>
                                                            @enderror
                                                        </div>

                                                        <div>
                                                            <div class="flex items-center justify-between">
                                                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                                                <span class="text-xs text-gray-500">(Leave blank to keep current password)</span>
                                                            </div>
                                                            <div class="mt-1 relative">
                                                                <input wire:model="password" type="{{ $showPassword ? 'text' : 'password' }}" id="password" class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Password">
                                                                <button type="button" wire:click="toggleShowPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
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
                                                                <p class="mt-1 text-sm text-red-600">{{ $errors->first('password') }}</p>
                                                            @enderror
                                                        </div>

                                                        <div>
                                                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                                            <div class="mt-1 relative">
                                                                <input wire:model="passwordConfirmation" type="{{ $showPasswordConfirmation ? 'text' : 'password' }}" id="password_confirmation" class="block w-full px-4 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Confirm password">
                                                                <button type="button" wire:click="toggleShowPasswordConfirmation" class="absolute inset-y-0 right-0 pr-3 flex items-center">
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
                                                            @error('passwordConfirmation')
                                                                <p class="mt-1 text-sm text-red-600">{{ $errors->first('passwordConfirmation') }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mt-6 flex items-center justify-end space-x-3 px-6">
                                            @if ($currentSection === 'profile')
                                                <button type="button" wire:click="setSection('credentials')" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Next
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </button>
                                            @endif

                                            @if ($currentSection === 'credentials')
                                                <button type="button" wire:click="setSection('profile')" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 -ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                                    </svg>
                                                    Back
                                                </button>
                                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
