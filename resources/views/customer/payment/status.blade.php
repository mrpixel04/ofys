<x-app-layout>
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-white to-blue-50 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">

            <!-- Navigation Breadcrumb -->
            <div class="mb-6">
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
                    <span class="text-gray-900 font-medium">{{ __('Status Pembayaran') }}</span>
                </nav>
            </div>

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('Status Pembayaran') }}</h1>
                    <p class="text-gray-600 mt-1">{{ __('Rujukan:') }} {{ $booking->booking_reference }}</p>
                </div>
                <a href="{{ route('customer.bookings.show', $booking->id) }}" class="inline-flex items-center px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200 font-medium text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Kembali') }}
                </a>
            </div>

            <!-- Status Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-6">
                <!-- Status Header -->
                <div class="px-6 py-5 {{ $booking->isPaid() ? 'bg-gradient-to-r from-green-500 to-green-600' : ($booking->isFailed() ? 'bg-gradient-to-r from-red-500 to-red-600' : 'bg-gradient-to-r from-yellow-500 to-yellow-600') }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-white">
                            @if($booking->isPaid())
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium opacity-90">{{ __('Status Pembayaran') }}</p>
                                    <p class="text-xl font-bold">{{ __('BERJAYA') }}</p>
                                </div>
                            @elseif($booking->isFailed())
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium opacity-90">{{ __('Status Pembayaran') }}</p>
                                    <p class="text-xl font-bold">{{ __('GAGAL') }}</p>
                                </div>
                            @else
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium opacity-90">{{ __('Status Pembayaran') }}</p>
                                    <p class="text-xl font-bold">{{ __('MENUNGGU') }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="text-right text-white">
                            <p class="text-sm font-medium opacity-90">{{ __('Jumlah') }}</p>
                            <p class="text-2xl font-bold">RM {{ number_format($booking->total_price, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Timeline -->
                <div class="p-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('Garis Masa Pembayaran') }}
                    </h3>

                    <div class="relative pl-8 space-y-6">
                        <!-- Vertical Line -->
                        <div class="absolute left-3 top-2 bottom-2 w-0.5 bg-gray-200"></div>

                        <!-- Step 1: Booking Created -->
                        <div class="relative flex items-start">
                            <div class="absolute -left-5 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center ring-4 ring-white">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-900">{{ __('Tempahan Dicipta') }}</p>
                                <p class="text-sm text-gray-500">{{ $booking->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Step 2: Payment Initiated -->
                        @if($payment && $payment->bill_id)
                        <div class="relative flex items-start">
                            <div class="absolute -left-5 w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center ring-4 ring-white">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-900">{{ __('Pembayaran Dimulakan') }}</p>
                                <p class="text-sm text-gray-500">{{ __('ID Bil:') }} {{ $payment->bill_id }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Step 3: Payment Status -->
                        @if($booking->isPaid())
                        <div class="relative flex items-start">
                            <div class="absolute -left-5 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center ring-4 ring-white">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-green-600">{{ __('Pembayaran Berjaya') }}</p>
                                <p class="text-sm text-gray-500">{{ $payment && $payment->paid_at ? $payment->paid_at->format('d M Y, h:i A') : __('Baru sahaja') }}</p>
                                @if($payment && $payment->transaction_id)
                                    <p class="text-xs text-gray-400 mt-1">{{ __('Transaksi:') }} {{ $payment->transaction_id }}</p>
                                @endif
                            </div>
                        </div>
                        @elseif($booking->isFailed())
                        <div class="relative flex items-start">
                            <div class="absolute -left-5 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center ring-4 ring-white">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-red-600">{{ __('Pembayaran Gagal') }}</p>
                                <p class="text-sm text-gray-500">{{ $payment && $payment->last_attempt_at ? $payment->last_attempt_at->format('d M Y, h:i A') : __('Baru sahaja') }}</p>
                                @if($payment && $payment->failure_reason)
                                    <p class="text-xs text-red-500 mt-1">{{ $payment->failure_reason }}</p>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="relative flex items-start">
                            <div class="absolute -left-5 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center ring-4 ring-white animate-pulse">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-yellow-600">{{ __('Menunggu Pembayaran') }}</p>
                                <p class="text-sm text-gray-500">{{ __('Sila selesaikan pembayaran anda') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Payment Information -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600">
                        <h3 class="text-white font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            {{ __('Maklumat Pembayaran') }}
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">{{ __('Kaedah Pembayaran') }}</span>
                            <span class="font-medium text-gray-900">{{ ucfirst($payment->gateway ?? 'Billplz') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">{{ __('Jumlah Bayaran') }}</span>
                            <span class="font-bold text-yellow-600 text-lg">RM {{ number_format($booking->total_price, 2) }}</span>
                        </div>
                        @if($payment && $payment->bill_id)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">{{ __('ID Bil') }}</span>
                            <span class="font-mono text-sm text-gray-900">{{ $payment->bill_id }}</span>
                        </div>
                        @endif
                        @if($payment && $payment->transaction_id)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">{{ __('ID Transaksi') }}</span>
                            <span class="font-mono text-sm text-gray-900">{{ $payment->transaction_id }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-500">{{ __('Cubaan Pembayaran') }}</span>
                            <span class="font-medium text-gray-900">{{ $payment->attempts ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Booking Information -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                        <h3 class="text-white font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            {{ __('Maklumat Tempahan') }}
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">{{ __('Aktiviti') }}</span>
                            <span class="font-medium text-gray-900 text-right max-w-[60%] truncate">{{ $booking->activity->name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">{{ __('Tarikh') }}</span>
                            <span class="font-medium text-gray-900">{{ $booking->booking_date->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">{{ __('Masa') }}</span>
                            <span class="font-medium text-gray-900">{{ $booking->start_time->format('h:i A') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">{{ __('Peserta') }}</span>
                            <span class="font-medium text-gray-900">{{ $booking->participants }} {{ __('orang') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-500">{{ __('Status Tempahan') }}</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ strtoupper($booking->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-center items-center space-y-3 sm:space-y-0 sm:space-x-4">
                        @if($booking->isPaid())
                            <a href="{{ route('payment.receipt', $booking->id) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                {{ __('Lihat Resit') }}
                            </a>
                        @elseif($booking->isFailed() || $booking->isPending())
                            <form action="{{ route('payment.retry', $booking->id) }}" method="POST" class="w-full sm:w-auto">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    {{ $booking->isFailed() ? __('Cuba Semula') : __('Bayar Sekarang') }}
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('customer.bookings.show', $booking->id) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-white text-gray-700 font-semibold rounded-lg border border-gray-300 hover:bg-gray-50 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ __('Lihat Tempahan') }}
                        </a>
                        <a href="{{ route('customer.dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-white text-gray-700 font-semibold rounded-lg border border-gray-300 hover:bg-gray-50 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            {{ __('Papan Pemuka') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Help Section (if not paid) -->
            @if(!$booking->isPaid())
            <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 rounded-r-xl p-5">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-blue-900 mb-2">{{ __('Perlukan Bantuan?') }}</h4>
                        <p class="text-sm text-blue-800 mb-2">
                            {{ __('Jika anda menghadapi masalah dengan pembayaran, pasukan sokongan kami sedia membantu.') }}
                        </p>
                        <p class="text-sm text-blue-800">
                            {{ __('Hubungi:') }} <strong>support@ofys.com</strong> | <strong>+60 12-345-6789</strong>
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</x-app-layout>
