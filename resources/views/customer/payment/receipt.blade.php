@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-blue-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Print Button (Hidden on Print) -->
            <div class="text-center mb-6 print:hidden">
                <button onclick="window.print()" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    {{ __('Cetak Resit') }}
                </button>
                <a href="{{ route('customer.dashboard') }}" class="ml-3 inline-flex items-center px-8 py-3 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-xl border-2 border-gray-300 transform hover:scale-105 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Kembali ke Papan Pemuka') }}
                </a>
            </div>

            <!-- Receipt Card -->
            <div id="receipt" class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200 print:shadow-none print:border-2">
                <!-- Receipt Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-8 print:bg-blue-600">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <h1 class="text-3xl font-extrabold mb-2">OFYS</h1>
                            <p class="text-sm opacity-90">Platform Tempahan Aktiviti Luar</p>
                        </div>
                        <div class="text-right">
                            <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl px-6 py-3">
                                <p class="text-xs font-semibold uppercase tracking-wide opacity-90">{{ __('Resit') }}</p>
                                <p class="text-2xl font-bold mt-1">#{{ $booking->id }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Receipt Body -->
                <div class="p-8">
                    <!-- Status Badge -->
                    <div class="text-center mb-8">
                        <span class="inline-flex items-center px-6 py-3 bg-green-100 text-green-800 rounded-full text-sm font-bold border-2 border-green-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('PEMBAYARAN DISAHKAN') }}
                        </span>
                    </div>

                    <!-- Customer & Company Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 pb-8 border-b-2 border-gray-200">
                        <!-- Bill To -->
                        <div>
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-3">{{ __('Bil Kepada:') }}</h3>
                            <p class="text-lg font-bold text-gray-900">{{ $booking->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $booking->user->email }}</p>
                            @if($booking->user->phone)
                                <p class="text-sm text-gray-600">{{ $booking->user->phone }}</p>
                            @endif
                        </div>

                        <!-- Receipt Info -->
                        <div class="text-left md:text-right">
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-3">{{ __('Butiran Resit:') }}</h3>
                            <div class="space-y-1">
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold">{{ __('Tarikh Resit:') }}</span> {{ now()->format('M d, Y') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold">{{ __('Rujukan Tempahan:') }}</span> {{ $booking->booking_reference }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold">{{ __('ID Transaksi:') }}</span> {{ $booking->billplz_transaction_id ?? __('Tiada') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold">{{ __('Tarikh Pembayaran:') }}</span> {{ $booking->billplz_paid_at ? $booking->billplz_paid_at->format('M d, Y h:i A') : __('Tiada') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            {{ __('Butiran Aktiviti') }}
                        </h3>
                        <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                            <h4 class="text-xl font-bold text-gray-900 mb-4">{{ $booking->activity->name }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">{{ __('Tarikh') }}</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $booking->booking_date->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">{{ __('Masa') }}</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $booking->start_time->format('h:i A') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">{{ __('Peserta') }}</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $booking->participants }} {{ __('orang') }}</p>
                                </div>
                            </div>
                            @if($booking->activity->location)
                                <div class="mt-4 pt-4 border-t border-blue-200">
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">{{ __('Lokasi') }}</p>
                                    <p class="text-sm text-gray-700">{{ $booking->activity->location }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Breakdown -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('Ringkasan Pembayaran') }}
                        </h3>
                        <div class="bg-gray-50 rounded-xl overflow-hidden border border-gray-200">
                            <table class="w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">{{ __('Penerangan') }}</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">{{ __('Kuantiti') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">{{ __('Harga Seunit') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">{{ __('Jumlah') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $booking->activity->name }}</td>
                                        <td class="px-6 py-4 text-sm text-center text-gray-600">{{ $booking->participants }}</td>
                                        <td class="px-6 py-4 text-sm text-right text-gray-600">RM {{ number_format($booking->total_price / $booking->participants, 2) }}</td>
                                        <td class="px-6 py-4 text-sm text-right font-semibold text-gray-900">RM {{ number_format($booking->total_price, 2) }}</td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-gray-100">
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-gray-900 uppercase">{{ __('Jumlah Dibayar:') }}</td>
                                        <td class="px-6 py-4 text-right text-xl font-extrabold text-green-600">RM {{ number_format($booking->total_price, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            {{ __('Maklumat Pembayaran') }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">{{ __('Kaedah Pembayaran') }}</p>
                                <p class="text-sm font-bold text-gray-900">{{ ucfirst($booking->payment_method ?? 'Billplz') }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">{{ __('Status Pembayaran') }}</p>
                                <p class="text-sm font-bold text-green-600">{{ __('DIBAYAR') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Important Notes -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-xl p-6">
                        <h4 class="text-sm font-bold text-yellow-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Maklumat Penting
                        </h4>
                        <ul class="space-y-2 text-xs text-yellow-800">
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Sila tiba 15 minit sebelum masa yang dijadualkan
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Bawa resit ini atau nombor rujukan tempahan anda
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Untuk pembatalan atau perubahan, hubungi kami sekurang-kurangnya 24 jam lebih awal
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('Resit ini adalah bukti sah pembayaran dan pengesahan tempahan') }}
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Receipt Footer -->
                <div class="bg-gray-100 px-8 py-6 border-t-2 border-gray-200">
                    <div class="text-center text-sm text-gray-600">
                        <p class="font-semibold mb-2">{{ __('Terima kasih kerana memilih OFYS!') }}</p>
                        <p class="text-xs">{{ __('Untuk sokongan, hubungi') }} <strong>support@ofys.com</strong> {{ __('atau telefon') }} <strong>+60 12-345-6789</strong></p>
                        <p class="text-xs mt-2 text-gray-500">{{ __('Ini adalah resit dijana komputer dan tidak memerlukan tandatangan.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons (Hidden on Print) -->
            <div class="text-center mt-6 print:hidden">
                <button onclick="window.print()" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    {{ __('Cetak Resit') }}
                </button>
                <a href="{{ route('customer.bookings.show', $booking->id) }}" class="ml-3 inline-flex items-center px-8 py-3 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-xl border-2 border-gray-300 transform hover:scale-105 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Lihat Tempahan
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
    @media print {
        body {
            background: white !important;
        }
        .print\:hidden {
            display: none !important;
        }
        .print\:shadow-none {
            box-shadow: none !important;
        }
        .print\:border-2 {
            border-width: 2px !important;
        }
        .print\:bg-blue-600 {
            background-color: #2563eb !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        @page {
            margin: 0.5cm;
        }
    }
</style>
@endsection
