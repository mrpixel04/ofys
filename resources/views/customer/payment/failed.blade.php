@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-orange-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Failed Icon with Animation -->
            <div class="text-center mb-8 animate-shake">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-red-500 to-orange-600 rounded-full shadow-2xl mb-6 animate-scale-in">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-900 mb-3">{{ __('Pembayaran Gagal') }}</h1>
                <p class="text-xl text-gray-600">{{ __('Kami tidak dapat memproses pembayaran anda') }}</p>
            </div>

            <!-- Main Failed Card -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-red-100 mb-6 animate-slide-up">
                <!-- Header with Gradient -->
                <div class="bg-gradient-to-r from-red-500 to-orange-600 px-8 py-6">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wide opacity-90">{{ __('Rujukan Tempahan') }}</p>
                            <p class="text-3xl font-bold mt-1">{{ $booking->booking_reference }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold uppercase tracking-wide opacity-90">{{ __('Status Pembayaran') }}</p>
                            <span class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 rounded-full text-sm font-bold mt-1 backdrop-blur-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                {{ __('GAGAL') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Error Details -->
                <div class="p-8">
                    <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-6 mb-8">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-red-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="text-lg font-bold text-red-900 mb-2">{{ __('Mengapa perkara ini berlaku?') }}</h3>
                                <p class="text-sm text-red-800 mb-3">
                                    {{ $errorMessage ?? __('Pembayaran anda tidak dapat diselesaikan. Ini mungkin disebabkan baki tidak mencukupi, butiran kad salah, atau isu rangkaian.') }}
                                </p>
                                @if(isset($booking->payment_gateway_response['error_description']))
                                    <p class="text-sm text-red-700 font-semibold">
                                        Error: {{ $booking->payment_gateway_response['error_description'] }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        {{ __('Butiran Tempahan') }}
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Activity Name -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-semibold mb-1">{{ __('Aktiviti') }}</p>
                                <p class="text-lg font-bold text-gray-900">{{ $booking->activity->name }}</p>
                            </div>
                        </div>

                        <!-- Date & Time -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-semibold mb-1">{{ __('Tarikh & Masa') }}</p>
                                <p class="text-lg font-bold text-gray-900">{{ $booking->booking_date->format('M d, Y') }}</p>
                                <p class="text-sm text-gray-600">{{ $booking->start_time->format('h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Participants -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-semibold mb-1">{{ __('Peserta') }}</p>
                                <p class="text-lg font-bold text-gray-900">{{ $booking->participants }} {{ __('orang') }}</p>
                            </div>
                        </div>

                        <!-- Total Amount -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-semibold mb-1">{{ __('Jumlah Perlu Dibayar') }}</p>
                                <p class="text-2xl font-extrabold text-red-600">RM {{ number_format($booking->total_price, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Attempt Information -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('Butiran Cubaan Pembayaran') }}
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 rounded-xl p-6">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">{{ __('ID Bil') }}</p>
                                <p class="text-sm font-mono font-semibold text-gray-900">{{ $booking->billplz_bill_id ?? __('Tiada') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">{{ __('Cubaan Terakhir') }}</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $booking->last_payment_attempt ? $booking->last_payment_attempt->format('M d, Y h:i A') : __('Baru sahaja') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">{{ __('Jumlah Cubaan') }}</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $booking->payment_attempts }} {{ __('cubaan') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">{{ __('Status Tempahan') }}</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                    {{ strtoupper($booking->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                        <form action="{{ route('payment.retry', $booking->id) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white font-bold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                {{ __('Cuba Semula Pembayaran') }}
                            </button>
                        </form>
                        <a href="{{ route('payment.status', $booking->id) }}" class="inline-flex items-center justify-center px-8 py-3 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-xl border-2 border-gray-300 transform hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            {{ __('Semak Status') }}
                        </a>
                        <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center justify-center px-8 py-3 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-xl border-2 border-gray-300 transform hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            {{ __('Papan Pemuka') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Help & Support -->
            <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-xl p-6 mb-6 animate-fade-in">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-lg font-bold text-yellow-900 mb-2">Perlukan Bantuan?</h4>
                        <ul class="space-y-2 text-sm text-yellow-800">
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Semak butiran kad anda dan pastikan baki mencukupi
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Cuba gunakan kaedah pembayaran lain (FPX, Kad Kredit, E-Wallet)
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Hubungi bank anda jika masalah berterusan
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Hubungi pasukan sokongan kami di <strong>support@ofys.com</strong> atau telefon <strong>+60 12-345-6789</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Booking Still Reserved Notice -->
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-xl p-6 animate-fade-in" style="animation-delay: 0.2s;">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-lg font-bold text-blue-900 mb-2">Tempahan Anda Masih Dipegang</h4>
                        <p class="text-sm text-blue-800">
                            Jangan risau! Tempahan anda <strong>{{ $booking->booking_reference }}</strong> masih disimpan untuk anda.
                            Anda boleh cuba bayar semula pada bila-bila masa sebelum tarikh aktiviti. Slot ini akan dipegang untuk anda dalam tempoh 24 jam akan datang.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Animations -->
<style>
    @keyframes shake {
        0%, 100% {
            transform: translateX(0);
        }
        10%, 30%, 50%, 70%, 90% {
            transform: translateX(-5px);
        }
        20%, 40%, 60%, 80% {
            transform: translateX(5px);
        }
    }

    @keyframes scaleIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .animate-shake {
        animation: shake 0.8s cubic-bezier(.36,.07,.19,.97) both;
    }

    .animate-scale-in {
        animation: scaleIn 0.6s ease-out;
    }

    .animate-slide-up {
        animation: slideUp 0.6s ease-out 0.2s both;
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out 0.4s both;
    }
</style>
@endsection
