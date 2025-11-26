<x-app-layout>


    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('customer.dashboard', ['tab' => 'bookings']) }}" class="flex items-center text-yellow-500 hover:text-yellow-600">
                    <svg class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Bookings
                </a>
            </div>

            @if(session('success'))
                <div class="rounded-md bg-green-50 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-900">Booking Details</h1>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{
                                $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                ($booking->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                ($booking->status === 'completed' ? 'bg-blue-100 text-blue-800' :
                                ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')))
                            }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Booking Information -->
                        <div class="md:col-span-2">
                            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Activity Information</h2>
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
                                        <dt class="text-sm font-medium text-gray-500">Location</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->activity_details['location'] ?? 'N/A' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Type</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->activity_details['type'] ?? 'N/A' }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Booking Information</h2>
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Booking Reference</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->booking_reference }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Booked On</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->created_at->format('F j, Y, g:i A') }}</dd>
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
                                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($booking->status) }}</dd>
                                    </div>
                                </dl>
                            </div>

                            @if(isset($booking->activity_details['lot']))
                            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Camping Lot Details</h2>
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Lot ID</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->activity_details['lot']['id'] }}</dd>
                                    </div>
                                    @if(!empty($booking->activity_details['lot']['name']))
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Lot Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->activity_details['lot']['name'] }}</dd>
                                    </div>
                                    @endif
                                    @if(!empty($booking->activity_details['lot']['capacity']))
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Capacity</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->activity_details['lot']['capacity'] }} {{ $booking->activity_details['lot']['capacity'] == 1 ? 'person' : 'people' }}</dd>
                                    </div>
                                    @endif
                                    @if(!empty($booking->activity_details['lot']['description']))
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->activity_details['lot']['description'] }}</dd>
                                    </div>
                                    @endif
                                </dl>
                            </div>
                            @endif

                            @if($booking->special_requests)
                                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Special Requests</h2>
                                    <p class="text-sm text-gray-600">{{ $booking->special_requests }}</p>
                                </div>
                            @endif

                            @if($booking->status === 'cancelled' && $booking->cancelation_reason)
                                <div class="bg-red-50 rounded-lg p-6 mb-6">
                                    <h2 class="text-lg font-medium text-red-800 mb-4">Cancellation Information</h2>
                                    <p class="text-sm text-red-600">{{ $booking->cancelation_reason }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Payment Summary -->
                        <div class="md:col-span-1">
                            <div class="bg-gray-50 rounded-lg p-6 sticky top-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Payment Summary</h2>

                                <div class="border-t border-gray-200 py-4">
                                    <dl class="space-y-2">
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-600">Price</dt>
                                            <dd class="text-sm font-medium text-gray-900">
                                                RM{{ number_format($booking->activity_details['price'] ?? 0, 2) }} / {{ $booking->activity_details['price_type'] === 'per_person' ? 'person' : 'session' }}
                                            </dd>
                                        </div>

                                        @if($booking->activity_details['price_type'] === 'per_person')
                                            <div class="flex justify-between">
                                                <dt class="text-sm text-gray-600">Participants</dt>
                                                <dd class="text-sm font-medium text-gray-900">{{ $booking->participants }}</dd>
                                            </div>
                                        @endif
                                    </dl>
                                </div>

                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between font-medium">
                                        <dt class="text-base text-gray-900">Total</dt>
                                        <dd class="text-base text-gray-900">
                                            RM{{ number_format($booking->total_price, 2) }}
                                        </dd>
                                    </div>
                                    <div class="mt-4">
                                        <div class="flex items-center">
                                            <dt class="text-sm text-gray-600 mr-2">Payment Status:</dt>
                                            <dd>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($booking->payment_status) }}
                                                </span>
                                            </dd>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Actions -->
                                @if($booking->payment_status === 'done' || $booking->payment_status === 'paid')
                                    <!-- Payment Successful - Show Receipt Button -->
                                    <div class="mt-6">
                                        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-4">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="text-sm font-semibold text-green-800">Payment Confirmed!</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('payment.receipt', $booking->id) }}" class="w-full inline-flex justify-center items-center px-4 py-3 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-300">
                                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            View Receipt
                                        </a>
                                        <a href="{{ route('payment.status', $booking->id) }}" class="mt-3 w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                            Payment Status
                                        </a>
                                    </div>
                                @elseif($booking->payment_status === 'failed' && $booking->status !== 'cancelled')
                                    <!-- Payment Failed - Show Retry Button -->
                                    <div class="mt-6">
                                        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-4">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                <span class="text-sm font-semibold text-red-800">Payment Failed</span>
                                            </div>
                                            <p class="text-xs text-red-700 mt-1">Your payment could not be processed. Please try again.</p>
                                        </div>
                                        <form action="{{ route('payment.retry', $booking->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transform hover:scale-105 transition-all duration-300">
                                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                Retry Payment
                                                    </button>
                                                </form>
                                        <a href="{{ route('payment.status', $booking->id) }}" class="mt-3 w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                            View Payment Details
                                        </a>
                                    </div>
                                @elseif($booking->status !== 'cancelled')
                                    <!-- Payment Pending - Show Pay Now Button -->
                                    <div class="mt-6">
                                        <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4 mb-4">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="text-sm font-semibold text-yellow-800">Payment Pending</span>
                                            </div>
                                            <p class="text-xs text-yellow-700 mt-1">Complete your payment to confirm this booking.</p>
                                        </div>
                                        <a href="{{ route('payment.initiate', $booking->id) }}" class="w-full inline-flex justify-center items-center px-4 py-3 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            Pay Now with Billplz
                                        </a>
                                        <p class="text-xs text-center text-gray-500 mt-2">
                                            Secure payment via FPX, Credit Card, or E-Wallet
                                        </p>
                                        <a href="{{ route('payment.status', $booking->id) }}" class="mt-3 w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                            Check Payment Status
                                        </a>
                                </div>
                                @endif

                                <!-- Actions -->
                                <div class="mt-6 space-y-3">
                                    <button type="button" onclick="window.print()" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                        Print Details
                                    </button>

                                    @if($booking->status !== 'cancelled' && $booking->status !== 'completed')
                                        <form action="{{ route('customer.bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                            @csrf
                                            <input type="hidden" name="cancelation_reason" value="Customer requested cancellation">
                                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Cancel Booking
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.js-accordion').each(function() {
                const $container = $(this);
                $container.on('click', '.js-accordion-toggle', function() {
                    const target = $(this).data('target');
                    // close all panels
                    $container.find('.js-accordion-panel').addClass('hidden');
                    $container.find('.js-accordion-arrow').removeClass('transform rotate-180');
                    // open selected
                    $container.find(`.js-accordion-panel[data-panel="${target}"]`).toggleClass('hidden');
                    $(this).find('.js-accordion-arrow').toggleClass('transform rotate-180');
                });
            });
        });
    </script>
</x-app-layout>
