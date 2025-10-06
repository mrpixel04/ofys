@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-3">Payment Status</h1>
                <p class="text-xl text-gray-600">Track your payment and booking details</p>
            </div>

            <!-- Status Overview Card -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200 mb-6">
                <!-- Header with Status -->
                <div class="bg-gradient-to-r {{ $booking->isPaid() ? 'from-green-500 to-emerald-600' : ($booking->isFailed() ? 'from-red-500 to-orange-600' : 'from-yellow-500 to-orange-500') }} px-8 py-6">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wide opacity-90">Booking Reference</p>
                            <p class="text-3xl font-bold mt-1">{{ $booking->booking_reference }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold uppercase tracking-wide opacity-90 mb-2">Current Status</p>
                            @if($booking->isPaid())
                                <span class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 rounded-full text-lg font-bold backdrop-blur-sm">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    PAID
                                </span>
                            @elseif($booking->isFailed())
                                <span class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 rounded-full text-lg font-bold backdrop-blur-sm">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    FAILED
                                </span>
                            @else
                                <span class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 rounded-full text-lg font-bold backdrop-blur-sm">
                                    <svg class="w-6 h-6 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    PENDING
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Status Timeline -->
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Payment Timeline
                    </h2>

                    <!-- Timeline -->
                    <div class="relative">
                        <!-- Vertical Line -->
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                        <!-- Timeline Items -->
                        <div class="space-y-8">
                            <!-- Booking Created -->
                            <div class="relative flex items-start">
                                <div class="flex-shrink-0 w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white shadow-lg z-10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <div class="ml-6 flex-1">
                                    <h3 class="text-lg font-bold text-gray-900">Booking Created</h3>
                                    <p class="text-sm text-gray-600">{{ $booking->created_at->format('M d, Y h:i A') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Your booking was successfully created</p>
                                </div>
                            </div>

                            <!-- Payment Initiated -->
                            @if($booking->billplz_bill_id)
                                <div class="relative flex items-start">
                                    <div class="flex-shrink-0 w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center text-white shadow-lg z-10">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-6 flex-1">
                                        <h3 class="text-lg font-bold text-gray-900">Payment Initiated</h3>
                                        <p class="text-sm text-gray-600">{{ $booking->last_payment_attempt ? $booking->last_payment_attempt->format('M d, Y h:i A') : 'Recently' }}</p>
                                        <p class="text-sm text-gray-500 mt-1">Bill ID: <span class="font-mono font-semibold">{{ $booking->billplz_bill_id }}</span></p>
                                    </div>
                                </div>
                            @endif

                            <!-- Payment Status -->
                            @if($booking->isPaid())
                                <div class="relative flex items-start">
                                    <div class="flex-shrink-0 w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white shadow-lg z-10">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-6 flex-1">
                                        <h3 class="text-lg font-bold text-green-600">Payment Successful</h3>
                                        <p class="text-sm text-gray-600">{{ $booking->billplz_paid_at ? $booking->billplz_paid_at->format('M d, Y h:i A') : 'Recently' }}</p>
                                        <p class="text-sm text-gray-500 mt-1">Your payment has been confirmed</p>
                                        @if($booking->billplz_transaction_id)
                                            <p class="text-sm text-gray-500">Transaction ID: <span class="font-mono font-semibold">{{ $booking->billplz_transaction_id }}</span></p>
                                        @endif
                                    </div>
                                </div>
                            @elseif($booking->isFailed())
                                <div class="relative flex items-start">
                                    <div class="flex-shrink-0 w-12 h-12 bg-red-500 rounded-full flex items-center justify-center text-white shadow-lg z-10">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-6 flex-1">
                                        <h3 class="text-lg font-bold text-red-600">Payment Failed</h3>
                                        <p class="text-sm text-gray-600">{{ $booking->last_payment_attempt ? $booking->last_payment_attempt->format('M d, Y h:i A') : 'Recently' }}</p>
                                        <p class="text-sm text-gray-500 mt-1">Your payment could not be processed</p>
                                        @if(isset($booking->payment_gateway_response['error_description']))
                                            <p class="text-sm text-red-600 mt-1">{{ $booking->payment_gateway_response['error_description'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="relative flex items-start">
                                    <div class="flex-shrink-0 w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center text-white shadow-lg z-10 animate-pulse">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-6 flex-1">
                                        <h3 class="text-lg font-bold text-yellow-600">Payment Pending</h3>
                                        <p class="text-sm text-gray-600">Awaiting payment confirmation</p>
                                        <p class="text-sm text-gray-500 mt-1">Please complete your payment to confirm the booking</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Details Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Payment Details
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Amount -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-5 border border-green-200">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Amount</p>
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-3xl font-extrabold text-gray-900">RM {{ number_format($booking->total_price, 2) }}</p>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-5 border border-purple-200">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Payment Method</p>
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <p class="text-xl font-bold text-gray-900">{{ ucfirst($booking->payment_method ?? 'Billplz') }}</p>
                        </div>

                        <!-- Attempts -->
                        <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl p-5 border border-orange-200">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Payment Attempts</p>
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <p class="text-3xl font-extrabold text-gray-900">{{ $booking->payment_attempts }}</p>
                        </div>
                    </div>

                    <!-- Transaction Details -->
                    @if($booking->billplz_bill_id)
                        <div class="mt-6 bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Transaction Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">Bill ID</p>
                                    <p class="text-sm font-mono font-semibold text-gray-900">{{ $booking->billplz_bill_id }}</p>
                                </div>
                                @if($booking->billplz_transaction_id)
                                    <div>
                                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">Transaction ID</p>
                                        <p class="text-sm font-mono font-semibold text-gray-900">{{ $booking->billplz_transaction_id }}</p>
                                    </div>
                                @endif
                                @if($booking->billplz_collection_id)
                                    <div>
                                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">Collection ID</p>
                                        <p class="text-sm font-mono font-semibold text-gray-900">{{ $booking->billplz_collection_id }}</p>
                                    </div>
                                @endif
                                @if($booking->last_payment_attempt)
                                    <div>
                                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">Last Attempt</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $booking->last_payment_attempt->format('M d, Y h:i A') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Booking Details Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 mb-6">
                <div class="bg-gradient-to-r from-teal-600 to-cyan-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Booking Information
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 font-semibold mb-2">Activity</p>
                            <p class="text-xl font-bold text-gray-900">{{ $booking->activity->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold mb-2">Booking Status</p>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold
                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                   ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                   'bg-gray-100 text-gray-800') }}">
                                {{ strtoupper($booking->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold mb-2">Date & Time</p>
                            <p class="text-lg font-bold text-gray-900">{{ $booking->booking_date->format('M d, Y') }}</p>
                            <p class="text-sm text-gray-600">{{ $booking->start_time->format('h:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-semibold mb-2">Participants</p>
                            <p class="text-lg font-bold text-gray-900">{{ $booking->participants }} {{ Str::plural('Person', $booking->participants) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                        @if($booking->isPaid())
                            <a href="{{ route('payment.receipt', $booking->id) }}" class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                View Receipt
                            </a>
                        @elseif($booking->isFailed() || $booking->isPending())
                            <form action="{{ route('payment.retry', $booking->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    {{ $booking->isFailed() ? 'Retry Payment' : 'Complete Payment' }}
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('customer.bookings.show', $booking->id) }}" class="inline-flex items-center justify-center px-8 py-3 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-xl border-2 border-gray-300 transform hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View Booking
                        </a>
                        <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center justify-center px-8 py-3 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-xl border-2 border-gray-300 transform hover:scale-105 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Help Section -->
            @if(!$booking->isPaid())
                <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 rounded-xl p-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-lg font-bold text-blue-900 mb-2">Need Assistance?</h4>
                            <p class="text-sm text-blue-800 mb-3">
                                If you're experiencing issues with your payment or have any questions, our support team is here to help.
                            </p>
                            <p class="text-sm text-blue-800">
                                Contact us at <strong>support@ofys.com</strong> or call <strong>+60 12-345-6789</strong>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
