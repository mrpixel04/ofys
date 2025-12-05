<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">{{ __('Profil Saya') }}</h1>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    {{ __('Urus maklumat peribadi dan keutamaan anda.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 mb-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Maklumat Peribadi') }}</h2>
                        <form>
                            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Nama Penuh') }}</label>
                                    <div class="mt-1">
                                        <input type="text" name="name" id="name" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" value="{{ $user->name }}">
                                    </div>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Alamat E-mel') }}</label>
                                    <div class="mt-1">
                                        <input type="email" name="email" id="email" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" value="{{ $user->email }}" readonly>
                                    </div>
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('Nombor Telefon') }}</label>
                                    <div class="mt-1">
                                        <input type="tel" name="phone" id="phone" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" placeholder="{{ __('Masukkan nombor telefon anda') }}">
                                    </div>
                                </div>
                                <div>
                                    <label for="username" class="block text-sm font-medium text-gray-700">{{ __('Nama Pengguna') }}</label>
                                    <div class="mt-1">
                                        <input type="text" name="username" id="username" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md" value="{{ $user->username ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    {{ __('Simpan Perubahan') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Tukar Kata Laluan') }}</h2>
                        <form>
                            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700">{{ __('Kata Laluan Semasa') }}</label>
                                    <div class="mt-1">
                                        <input type="password" name="current_password" id="current_password" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                                    </div>
                                </div>
                                <div class="sm:col-span-2"></div>
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700">{{ __('Kata Laluan Baharu') }}</label>
                                    <div class="mt-1">
                                        <input type="password" name="new_password" id="new_password" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                                    </div>
                                </div>
                                <div>
                                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Sahkan Kata Laluan Baharu') }}</label>
                                    <div class="mt-1">
                                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="py-2 px-3 block w-full shadow-sm focus:ring-yellow-500 focus:border-yellow-500 border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    {{ __('Kemaskini Kata Laluan') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
