<div>
    {{-- In work, do what you enjoy. --}}
    <form wire:submit.prevent="register" class="space-y-6">
        @if($errors->has('general'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            {{ $errors->first('general') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Penuh</label>
            <div class="mt-1">
                <input wire:model.live="name" id="name" type="text" autocomplete="name" required
                    class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
            </div>
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Alamat E-mel</label>
            <div class="mt-1">
                <input wire:model.live="email" id="email" type="email" autocomplete="email" required
                    class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="username" class="block text-sm font-medium text-gray-700">Nama Pengguna <span class="text-xs text-gray-500">(Pilihan - akan dijana dari e-mel jika kosong)</span></label>
            <div class="mt-1">
                <input wire:model.live="username" id="username" type="text" autocomplete="username"
                    class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
            </div>
            @error('username')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Kata Laluan</label>
            <div class="mt-1 relative" x-data="{show: false}">
                <input
                    wire:model.live="password"
                    id="password"
                    :type="show ? 'text' : 'password'"
                    autocomplete="new-password"
                    required
                    class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">

                <!-- Password Toggle Icon -->
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                    <button
                        type="button"
                        @click="show = !show"
                        class="text-gray-500 focus:outline-none focus:text-gray-600"
                    >
                        <svg x-show="!show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                        <svg x-show="show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                            <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                        </svg>
                    </button>
                </div>
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Sahkan Kata Laluan</label>
            <div class="mt-1 relative" x-data="{show: false}">
                <input
                    wire:model.live="password_confirmation"
                    id="password_confirmation"
                    :type="show ? 'text' : 'password'"
                    autocomplete="new-password"
                    required
                    class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">

                <!-- Password Toggle Icon -->
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                    <button
                        type="button"
                        @click="show = !show"
                        class="text-gray-500 focus:outline-none focus:text-gray-600"
                    >
                        <svg x-show="!show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                        <svg x-show="show" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                            <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="flex items-center">
            <input wire:model.live="terms" id="terms" type="checkbox" required
                class="h-4 w-4 text-yellow-500 focus:ring-yellow-500 border-gray-300 rounded">
            <label for="terms" class="ml-2 block text-sm text-gray-700">
                Saya bersetuju dengan <a href="#" class="text-yellow-500 hover:text-yellow-600">Terma Perkhidmatan</a> dan <a href="#" class="text-yellow-500 hover:text-yellow-600">Dasar Privasi</a>
            </label>
        </div>
        @error('terms')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-2xl shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                <span wire:loading.remove wire:target="register">Daftar Sekarang</span>
                <span wire:loading wire:target="register" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Mendaftar...
                </span>
            </button>
        </div>
    </form>

    <!-- Success Notification -->
    <div x-data="{ show: false }"
         x-init="
            window.addEventListener('registered', (event) => {
                show = true;
                setTimeout(() => { show = false }, 2000)
            })
         "
         x-show="show"
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-0 inset-x-0 px-4 pb-6 sm:px-6 sm:pb-8 z-50 pointer-events-none"
         style="display: none;">
        <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto overflow-hidden mx-auto">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-medium text-gray-900">Pendaftaran Berjaya!</p>
                        <p class="mt-1 text-sm text-gray-500">Akaun anda telah berjaya didaftarkan! Anda akan dialihkan ke halaman log masuk.</p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false" class="inline-flex text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Tutup</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Notification -->
    <div x-data="{ show: false, message: '' }"
         x-init="
            window.addEventListener('registrationError', (event) => {
                show = true;
                message = event.detail ? event.detail.message : 'Ralat semasa pendaftaran. Sila cuba lagi.';
                setTimeout(() => { show = false }, 3000)
            })
         "
         x-show="show"
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-0 inset-x-0 px-4 pb-6 sm:px-6 sm:pb-8 z-50 pointer-events-none"
         style="display: none;">
        <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto overflow-hidden mx-auto">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-medium text-gray-900">Ralat Pendaftaran</p>
                        <p class="mt-1 text-sm text-gray-500" x-text="message"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false" class="inline-flex text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Tutup</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for handling redirect after registration -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('registrationSuccess', event => {
                setTimeout(function() {
                    window.location.href = "{{ route('login') }}";
                }, 2000);
            });
        });
    </script>
</div>
