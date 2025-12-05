<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">{{ __('Akaun Saya') }}</h1>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    {{ __('Urus kaedah pembayaran, maklumat bil, dan tetapan akaun anda.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-2">{{ __('Kaedah Pembayaran') }}</h2>
                            <p class="text-gray-600 mb-4">{{ __('Urus kaedah pembayaran yang disimpan') }}</p>
                            <div class="mt-4">
                                <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    {{ __('Urus') }}
                                </a>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-2">{{ __('Alamat Pengebilan') }}</h2>
                            <p class="text-gray-600 mb-4">{{ __('Kemaskini maklumat pengebilan anda') }}</p>
                            <div class="mt-4">
                                <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    {{ __('Kemaskini') }}
                                </a>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-2">{{ __('Keselamatan') }}</h2>
                            <p class="text-gray-600 mb-4">{{ __('Urus tetapan keselamatan akaun') }}</p>
                            <div class="mt-4">
                                <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    {{ __('Tetapan') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Langganan & Kredit') }}</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-md font-medium text-gray-700 mb-2">{{ __('Pelan Semasa') }}</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-800 font-medium">{{ __('Akaun Percuma') }}</p>
                                    <p class="text-gray-600 text-sm mt-1">{{ __('Akses asas ke aktiviti luar dan tempahan') }}</p>
                                    <div class="mt-3">
                                        <a href="#" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium">{{ __('Tingkatkan ke Premium') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-md font-medium text-gray-700 mb-2">{{ __('Kredit OFYS') }}</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-800 font-medium">{{ __('0 Kredit') }}</p>
                                    <p class="text-gray-600 text-sm mt-1">{{ __('Dapatkan kredit dengan melengkapkan aktiviti dan menjemput rakan') }}</p>
                                    <div class="mt-3">
                                        <a href="#" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium">{{ __('Beli Kredit') }}</a>
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
