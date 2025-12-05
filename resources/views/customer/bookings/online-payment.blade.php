<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('customer.bookings.show', $booking->id) }}" class="flex items-center text-yellow-500 hover:text-yellow-600">
                    <svg class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Kembali ke Tempahan') }}
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center mb-6">
                        <svg class="mx-auto h-12 w-12 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h2 class="mt-2 text-2xl font-bold text-gray-900">{{ __('Pembayaran Dalam Talian') }}</h2>
                        <p class="mt-1 text-gray-500">{{ __('Buat pembayaran selamat untuk tempahan anda') }}</p>
                    </div>

                    <div class="max-w-md mx-auto">
                        <div class="bg-yellow-50 rounded-lg p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-yellow-800">
                                        {{ __('Ini hanyalah contoh untuk integrasi gerbang pembayaran. Dalam persekitaran produksi, anda akan dialihkan ke halaman pembayaran selamat.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Ringkasan Pembayaran') }}</h3>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600">{{ __('Rujukan Tempahan') }}</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $booking->booking_reference }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600">{{ __('Aktiviti') }}</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $booking->activity_details['name'] }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600">{{ __('Tarikh') }}</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $booking->booking_date->format('F j, Y') }}</dd>
                                </div>
                                <div class="border-t border-gray-200 pt-2 mt-2">
                                    <div class="flex justify-between font-medium">
                                        <dt class="text-base text-gray-900">{{ __('Jumlah Bayaran') }}</dt>
                                        <dd class="text-base text-gray-900">RM{{ number_format($booking->total_price, 2) }}</dd>
                                    </div>
                                </div>
                            </dl>
                        </div>

                        <!-- Payment Form Placeholder -->
                        <div class="space-y-4">
                            <div>
                                <label for="card_number" class="block text-sm font-medium text-gray-700">{{ __('Nombor Kad') }}</label>
                                <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="expiry_date" class="block text-sm font-medium text-gray-700">{{ __('Tarikh Luput') }}</label>
                                    <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                                </div>
                                <div>
                                    <label for="cvv" class="block text-sm font-medium text-gray-700">{{ __('CVV') }}</label>
                                    <input type="text" id="cvv" name="cvv" placeholder="123" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                                </div>
                            </div>
                            <div>
                                <label for="name_on_card" class="block text-sm font-medium text-gray-700">{{ __('Nama pada Kad') }}</label>
                                <input type="text" id="name_on_card" name="name_on_card" placeholder="Ali Bin Ahmad" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500">
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="button" onclick="window.location='{{ route('customer.bookings.show', $booking->id) }}?payment=success'" class="w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                {{ __('Bayar') }} RM{{ number_format($booking->total_price, 2) }}
                            </button>
                            <p class="mt-2 text-xs text-center text-gray-500">
                                {{ __('Ini halaman demo pembayaran. Tiada pembayaran sebenar akan diproses.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
