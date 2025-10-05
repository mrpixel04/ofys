<x-app-layout>


    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center my-8">
                        <svg class="mx-auto h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h1 class="mt-4 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">Booking Confirmed!</h1>
                        <p class="mt-2 text-lg text-gray-500">
                            Your booking reference is <span class="font-medium text-yellow-600">{{ $booking->booking_reference }}</span>
                        </p>
                    </div>

                    <div class="max-w-3xl mx-auto">
                        <!-- Booking Details -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Booking Details</h2>

                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Activity</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->activity_details['name'] ?? 'N/A' }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Provider</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->activity_details['provider'] ?? 'N/A' }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->booking_date->format('F j, Y') }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Time</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->start_time->format('g:i A') }} - {{ $booking->end_time->format('g:i A') }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Participants</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->participants }} {{ $booking->participants === 1 ? 'person' : 'people' }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Location</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $booking->activity_details['location'] ?? 'N/A' }}</dd>
                                </div>

                                @if(isset($booking->activity_details['lot']))
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Camping Lot</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        Lot {{ $booking->activity_details['lot']['id'] }}
                                        @if(!empty($booking->activity_details['lot']['name']))
                                            - {{ $booking->activity_details['lot']['name'] }}
                                        @endif
                                        @if(!empty($booking->activity_details['lot']['description']))
                                            <span class="block text-sm text-gray-500">{{ $booking->activity_details['lot']['description'] }}</span>
                                        @endif
                                    </dd>
                                </div>
                                @endif

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Price</dt>
                                    <dd class="mt-1 text-sm font-bold text-gray-900">RM{{ number_format($booking->total_price, 2) }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Payment Information -->
                        <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl p-6 mb-6 border-2 border-yellow-200">
                            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Complete Your Payment
                            </h2>

                            <div class="bg-white rounded-lg p-5 mb-5 shadow-sm">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Payment Required</h3>
                                        <p class="text-sm text-gray-700 mb-3">
                                            Your booking has been created successfully! Please complete the payment to confirm your reservation.
                                        </p>
                                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                                            <span class="text-sm font-medium text-gray-600">Payment Status:</span>
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-300">
                                                {{ strtoupper($booking->payment_status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Billplz Payment Button -->
                            @if($booking->payment_status !== 'done' && $booking->payment_status !== 'paid' && $booking->status !== 'cancelled')
                                <a href="{{ route('payment.initiate', $booking->id) }}" class="block w-full mb-4">
                                    <button type="button" class="w-full inline-flex items-center justify-center px-6 py-4 border-2 border-transparent text-lg font-bold rounded-xl text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 transform hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-2xl">
                                        <svg class="-ml-1 mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        Pay Now with Billplz
                                        <svg class="ml-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </a>
                                
                                <div class="bg-white rounded-lg p-4 shadow-sm">
                                    <p class="text-xs text-center text-gray-600 mb-2 font-semibold">Secure Payment Methods Available:</p>
                                    <div class="flex items-center justify-center space-x-4 text-xs text-gray-500">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>FPX Banking</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                            </svg>
                                            <span>Credit/Debit Card</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>E-Wallets</span>
                                        </div>
                                    </div>
                                </div>
                            @elseif($booking->payment_status === 'done' || $booking->payment_status === 'paid')
                                <div class="bg-green-50 border-2 border-green-300 rounded-lg p-5">
                                    <div class="flex items-center">
                                        <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <h3 class="text-lg font-bold text-green-800">Payment Completed!</h3>
                                            <p class="text-sm text-green-700">Your booking is confirmed and paid.</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('payment.receipt', $booking->id) }}" class="mt-4 block w-full text-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors">
                                        View Receipt
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row sm:justify-between mt-8">
                            <button type="button" onclick="window.print()" class="mb-4 sm:mb-0 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Print Confirmation
                            </button>

                            <div class="flex space-x-4">
                                <a href="{{ route('customer.dashboard', ['tab' => 'bookings']) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    View My Bookings
                                </a>

                                <a href="{{ route('activities.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-yellow-700 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    Browse More Activities
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
