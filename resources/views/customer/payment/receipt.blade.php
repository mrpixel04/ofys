<x-app-layout>
<!-- Printable Receipt Container -->
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-white to-blue-50 py-8 print:py-0 print:bg-white">
    <div class="container mx-auto px-4 print:px-0">
        <div class="max-w-3xl mx-auto">

            <!-- Navigation - Hidden on Print -->
            <div class="mb-6 print:hidden">
                <nav class="flex items-center space-x-2 text-sm text-gray-600">
                    <a href="{{ route('customer.dashboard') }}" class="hover:text-yellow-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ route('customer.dashboard', ['tab' => 'bookings']) }}" class="hover:text-yellow-600 transition-colors">{{ __('Tempahan') }}</a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ route('customer.bookings.show', $booking->id) }}" class="hover:text-yellow-600 transition-colors">{{ $booking->booking_reference }}</a>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-gray-900 font-medium">{{ __('Resit') }}</span>
                </nav>
            </div>

            <!-- Action Buttons - Hidden on Print -->
            <div class="flex justify-between items-center mb-6 print:hidden">
                <a href="{{ route('customer.bookings.show', $booking->id) }}" class="inline-flex items-center px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200 font-medium text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Kembali') }}
                </a>
                <button onclick="printReceipt()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    {{ __('Cetak Resit') }}
                </button>
            </div>

            <!-- Receipt Card - This is what gets printed -->
            <div id="printable-receipt" class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 print:shadow-none print:border-2 print:border-gray-300">

                <!-- Receipt Header -->
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-8 py-6 print:bg-yellow-500" style="print-color-adjust: exact; -webkit-print-color-adjust: exact;">
                    <div class="flex items-center justify-between">
                        <div class="text-white">
                            <h1 class="text-2xl font-bold tracking-tight">OFYS</h1>
                            <p class="text-yellow-100 text-sm mt-1">{{ __('Platform Tempahan Aktiviti Luar') }}</p>
                        </div>
                        <div class="text-right text-white">
                            <p class="text-xs font-medium uppercase tracking-wider text-yellow-100">{{ __('Resit Rasmi') }}</p>
                            <p class="text-xl font-bold mt-1">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Status Badge -->
                <div class="px-8 py-4 bg-green-50 border-b border-green-100">
                    <div class="flex items-center justify-center">
                        <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('PEMBAYARAN BERJAYA') }}
                        </span>
                    </div>
                </div>

                <!-- Receipt Body -->
                <div class="p-8">

                    <!-- Customer & Receipt Info Grid -->
                    <div class="grid grid-cols-2 gap-8 mb-8 pb-6 border-b border-gray-200">
                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">{{ __('Maklumat Pelanggan') }}</h3>
                            <p class="text-base font-semibold text-gray-900">{{ $booking->user->name }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $booking->user->email }}</p>
                            @if($booking->user->phone)
                                <p class="text-sm text-gray-600">{{ $booking->user->phone }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">{{ __('Butiran Resit') }}</h3>
                            <div class="space-y-1 text-sm">
                                <p class="text-gray-600"><span class="font-medium">{{ __('Tarikh:') }}</span> {{ now()->format('d M Y') }}</p>
                                <p class="text-gray-600"><span class="font-medium">{{ __('Rujukan:') }}</span> {{ $booking->booking_reference }}</p>
                                <p class="text-gray-600"><span class="font-medium">{{ __('Transaksi:') }}</span> {{ $payment->transaction_id ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Details -->
                    <div class="mb-8">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            {{ __('Butiran Aktiviti') }}
                        </h3>
                        <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">{{ $booking->activity->name }}</h4>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500 text-xs uppercase tracking-wider">{{ __('Tarikh') }}</p>
                                    <p class="font-medium text-gray-900 mt-1">{{ $booking->booking_date->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs uppercase tracking-wider">{{ __('Masa') }}</p>
                                    <p class="font-medium text-gray-900 mt-1">{{ $booking->start_time->format('h:i A') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs uppercase tracking-wider">{{ __('Peserta') }}</p>
                                    <p class="font-medium text-gray-900 mt-1">{{ $booking->participants }} {{ __('orang') }}</p>
                                </div>
                            </div>
                            @if($booking->activity->location)
                                <div class="mt-4 pt-3 border-t border-gray-200">
                                    <p class="text-gray-500 text-xs uppercase tracking-wider">{{ __('Lokasi') }}</p>
                                    <p class="text-sm text-gray-700 mt-1">{{ $booking->activity->location }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Summary Table -->
                    <div class="mb-8">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('Ringkasan Pembayaran') }}
                        </h3>
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Penerangan') }}</th>
                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Kuantiti') }}</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Harga') }}</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('Jumlah') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <tr>
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $booking->activity->name }}</td>
                                        <td class="px-4 py-3 text-center text-gray-600">{{ $booking->participants }}</td>
                                        <td class="px-4 py-3 text-right text-gray-600">RM {{ number_format($booking->total_price / $booking->participants, 2) }}</td>
                                        <td class="px-4 py-3 text-right font-medium text-gray-900">RM {{ number_format($booking->total_price, 2) }}</td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-yellow-50">
                                    <tr>
                                        <td colspan="3" class="px-4 py-4 text-right font-semibold text-gray-900 uppercase text-sm">{{ __('Jumlah Dibayar') }}</td>
                                        <td class="px-4 py-4 text-right text-xl font-bold text-yellow-600">RM {{ number_format($payment->amount ?? $booking->total_price, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Info Grid -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                            <p class="text-xs text-gray-500 uppercase tracking-wider">{{ __('Kaedah Pembayaran') }}</p>
                            <p class="font-semibold text-gray-900 mt-1">{{ ucfirst($payment->gateway ?? 'Billplz') }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                            <p class="text-xs text-gray-500 uppercase tracking-wider">{{ __('Tarikh Pembayaran') }}</p>
                            <p class="font-semibold text-gray-900 mt-1">{{ $payment->paid_at ? $payment->paid_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>

                    <!-- Important Notes -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-r-lg p-4 mb-6">
                        <h4 class="text-sm font-semibold text-blue-900 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('Maklumat Penting') }}
                        </h4>
                        <ul class="space-y-1 text-xs text-blue-800">
                            <li class="flex items-start">
                                <svg class="w-3 h-3 mr-2 mt-0.5 flex-shrink-0 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('Sila tiba 15 minit sebelum masa yang dijadualkan') }}
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 mr-2 mt-0.5 flex-shrink-0 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('Bawa resit ini atau nombor rujukan tempahan anda') }}
                            </li>
                            <li class="flex items-start">
                                <svg class="w-3 h-3 mr-2 mt-0.5 flex-shrink-0 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('Untuk pembatalan, hubungi kami 24 jam lebih awal') }}
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Receipt Footer -->
                <div class="bg-gray-50 px-8 py-5 border-t border-gray-200">
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-700 mb-1">{{ __('Terima kasih kerana memilih OFYS!') }}</p>
                        <p class="text-xs text-gray-500">{{ __('Sokongan:') }} support@ofys.com | +60 12-345-6789</p>
                        <p class="text-xs text-gray-400 mt-2">{{ __('Resit dijana secara automatik dan sah tanpa tandatangan.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Actions - Hidden on Print -->
            <div class="flex justify-center space-x-4 mt-6 print:hidden">
                <button onclick="printReceipt()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    {{ __('Cetak Resit') }}
                </button>
                <a href="{{ route('customer.bookings.show', $booking->id) }}" class="inline-flex items-center px-6 py-3 bg-white text-gray-700 font-semibold rounded-lg border border-gray-300 hover:bg-gray-50 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    {{ __('Lihat Tempahan') }}
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Print-specific styles and script -->
<style>
    @media print {
        /* Hide everything except the receipt */
        body * {
            visibility: hidden;
        }

        #printable-receipt,
        #printable-receipt * {
            visibility: visible;
        }

        #printable-receipt {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 0;
            border: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }

        /* Hide non-printable elements */
        .print\:hidden {
            display: none !important;
        }

        /* Reset backgrounds for printing */
        .print\:bg-white {
            background: white !important;
        }

        /* Ensure colors print */
        .bg-gradient-to-r {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Page settings */
        @page {
            size: A4;
            margin: 10mm;
        }
    }
</style>

<script>
    function printReceipt() {
        window.print();
    }
</script>
</x-app-layout>
