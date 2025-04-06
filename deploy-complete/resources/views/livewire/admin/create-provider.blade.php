<div>
    {{-- The Master doesn't talk, he acts. --}}

    <!-- Trigger Button -->
    <button type="button" wire:click="toggleModal"
        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <i class="fa-solid fa-plus mr-1"></i> Add Provider
    </button>

    <!-- Slide Over Panel -->
    <div x-data="{ open: @entangle('open') }"
         x-show="open"
         x-cloak
         @keydown.escape.window="open = false"
         class="relative z-[100]"
         aria-labelledby="slide-over-title"
         role="dialog"
         aria-modal="true">

        <!-- Background backdrop with higher z-index -->
        <div x-show="open"
             x-transition:enter="ease-in-out duration-500"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in-out duration-500"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-[100]"></div>

        <div class="fixed inset-0 overflow-hidden z-[101]">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">

                    <!-- Slide-over panel with higher z-index -->
                    <div x-show="open"
                         x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                         x-transition:enter-start="translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="translate-x-full"
                         class="pointer-events-auto w-screen max-w-xl">

                        <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                            <!-- Header -->
                            <div class="bg-indigo-700 py-6 px-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-xl font-medium text-white" id="slide-over-title">Add New Provider</h2>
                                    <div class="ml-3 flex h-7 items-center">
                                        <button type="button" wire:click="toggleModal"
                                            class="rounded-md bg-indigo-700 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                            <span class="sr-only">Close panel</span>
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <p class="text-sm text-indigo-100">
                                        Fill in the form below to create a new provider account. The provider will complete their profile later.
                                    </p>
                                </div>
                            </div>

                            <!-- Steps Navigation -->
                            <nav class="flex border-b border-gray-200 bg-gray-50">
                                <button
                                    type="button"
                                    wire:click="setSection('profile')"
                                    class="px-6 py-4 text-center text-sm font-medium {{ $currentSection === 'profile' ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-500 hover:border-gray-300 hover:text-gray-700' }} w-1/2">
                                    <span class="text-lg mr-2">1.</span> Company Info
                                </button>
                                <button
                                    type="button"
                                    wire:click="setSection('credentials')"
                                    class="px-6 py-4 text-center text-sm font-medium {{ $currentSection === 'credentials' ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-500 hover:border-gray-300 hover:text-gray-700' }} w-1/2">
                                    <span class="text-lg mr-2">2.</span> Credentials
                                </button>
                            </nav>

                            <!-- Form Content -->
                            <div class="relative flex-1 px-4 sm:px-6">
                                <div class="py-6 space-y-6">
                                    <!-- Error Message -->
                                    <div>
                                        @if (session()->has('error'))
                                            <div class="rounded-md bg-red-50 p-4 mb-4">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h3 class="text-sm font-medium text-red-800">{{ session('error') }}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <form wire:submit.prevent="createProvider" class="space-y-8">
                                        <!-- Profile Section -->
                                        <div class="space-y-6 {{ $currentSection !== 'profile' ? 'hidden' : '' }}">
                                            <h3 class="text-xl font-bold leading-6 text-gray-900 border-b pb-2">Company Info</h3>
                                            <div class="space-y-6">
                                                <!-- Company Name -->
                                                <div>
                                                    <label for="companyName" class="block text-sm font-medium text-gray-700">
                                                        Company Name
                                                    </label>
                                                    <div class="mt-1">
                                                        <input type="text" wire:model="companyName" id="companyName"
                                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-lg p-2.5"
                                                            placeholder="ABC SERVICES SDN BHD" style="text-transform: uppercase;">
                                                    </div>
                                                    @error('companyName') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                                </div>

                                                <!-- Owner Fullname -->
                                                <div>
                                                    <label for="ownerFullname" class="block text-sm font-medium text-gray-700">
                                                        Owner Full Name
                                                    </label>
                                                    <div class="mt-1">
                                                        <input type="text" wire:model="ownerFullname" id="ownerFullname"
                                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-lg p-2.5"
                                                            placeholder="JOHN DOE" style="text-transform: uppercase;">
                                                    </div>
                                                    @error('ownerFullname') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                                </div>

                                                <div class="flex justify-end">
                                                    <button type="button" wire:click="setSection('credentials')"
                                                        class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        Next: Credentials
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Credentials Section -->
                                        <div class="space-y-6 {{ $currentSection !== 'credentials' ? 'hidden' : '' }}">
                                            <h3 class="text-xl font-bold leading-6 text-gray-900 border-b pb-2">Account Credentials</h3>
                                            <div class="space-y-6">
                                                <!-- Email -->
                                                <div>
                                                    <label for="email" class="block text-sm font-medium text-gray-700">
                                                        Email Address
                                                    </label>
                                                    <div class="mt-1">
                                                        <input type="email" wire:model="email" id="email"
                                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-lg p-2.5"
                                                            placeholder="johndoe@example.com">
                                                    </div>
                                                    @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                                </div>

                                                <!-- Password -->
                                                <div>
                                                    <label for="password" class="block text-sm font-medium text-gray-700">
                                                        Password
                                                    </label>
                                                    <div class="mt-1 relative rounded-md shadow-sm">
                                                        <input :type="showPassword ? 'text' : 'password'" wire:model="password" id="password"
                                                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-lg p-2.5 pr-10"
                                                            placeholder="••••••••">
                                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                                            <button type="button" wire:click="toggleShowPassword" class="text-gray-400 hover:text-gray-500">
                                                                <i class="fa-solid text-lg" :class="{ 'fa-eye': !showPassword, 'fa-eye-slash': showPassword }"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                                </div>

                                                <!-- Confirm Password -->
                                                <div>
                                                    <label for="passwordConfirmation" class="block text-sm font-medium text-gray-700">
                                                        Confirm Password
                                                    </label>
                                                    <div class="mt-1 relative rounded-md shadow-sm">
                                                        <input :type="showPasswordConfirmation ? 'text' : 'password'" wire:model="passwordConfirmation" id="passwordConfirmation"
                                                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full text-base border-gray-300 rounded-lg p-2.5 pr-10"
                                                            placeholder="••••••••">
                                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                                            <button type="button" wire:click="toggleShowPasswordConfirmation" class="text-gray-400 hover:text-gray-500">
                                                                <i class="fa-solid text-lg" :class="{ 'fa-eye': !showPasswordConfirmation, 'fa-eye-slash': showPasswordConfirmation }"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @error('passwordConfirmation') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                                                </div>

                                                <!-- Submit Buttons -->
                                                <div class="pt-5 border-t border-gray-200">
                                                    <div class="flex justify-between">
                                                        <div>
                                                            <button type="button" wire:click="setSection('profile')"
                                                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                                                </svg>
                                                                Back: Company Info
                                                            </button>
                                                        </div>
                                                        <div class="flex space-x-3">
                                                            <button type="button" wire:click="toggleModal"
                                                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                                Cancel
                                                            </button>
                                                            <button type="submit"
                                                                class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                                Create Provider
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
