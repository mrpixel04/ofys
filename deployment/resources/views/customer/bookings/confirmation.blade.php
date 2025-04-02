<x-app-layout>
    <!-- Add Alpine.js script for accordion -->
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <script>
        window.paymentAccordion = function() {
            return {
                activePanel: null,
                setActivePanel(panel) {
                    this.activePanel = this.activePanel === panel ? null : panel;
                }
            }
        }
    </script>

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
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Payment Information</h2>

                            <div class="rounded-md bg-yellow-50 p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            Your booking is confirmed! Please select a payment method below.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2 mb-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($booking->payment_status) }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>

                            <!-- Payment Options -->
                            @if($booking->payment_status !== 'paid' && $booking->status !== 'cancelled')
                            <div x-data="paymentAccordion()">
                                <h3 class="text-base font-medium text-gray-900 mb-3">Payment Options</h3>

                                <!-- Payment Method Selection -->
                                <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden mb-4">
                                    <!-- Option 1: Online Transfer -->
                                    <div class="payment-option border-b border-gray-200">
                                        <button type="button"
                                                @click="setActivePanel('transfer')"
                                                class="w-full px-4 py-3 text-left flex justify-between items-center focus:outline-none">
                                            <span class="font-medium text-gray-800">Bank Transfer</span>
                                            <svg :class="{'rotate-180': activePanel === 'transfer'}" class="h-5 w-5 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <div x-show="activePanel === 'transfer'" x-cloak class="px-4 pb-4">
                                            <div class="bg-gray-50 p-3 rounded-md mb-3">
                                                <p class="text-sm text-gray-600 mb-1"><strong>Bank:</strong> Maybank</p>
                                                <p class="text-sm text-gray-600 mb-1"><strong>Account Number:</strong> 1234 5678 9012</p>
                                                <p class="text-sm text-gray-600"><strong>Account Name:</strong> OFYS Outdoor Adventures</p>
                                            </div>
                                            <p class="text-sm text-gray-600 mb-3">Please upload your receipt after making the transfer:</p>

                                            <form action="{{ route('customer.bookings.payment.transfer', $booking->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="receipt" class="block text-sm font-medium text-gray-700 mb-1">Upload Receipt</label>
                                                    <input type="file" name="receipt" id="receipt" accept="image/*,.pdf"
                                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" required>
                                                    <p class="mt-1 text-xs text-gray-500">Upload JPG, PNG or PDF (max 2MB)</p>
                                                </div>
                                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                    Confirm Payment
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Option 2: Payment Gateway -->
                                    <div class="payment-option border-b border-gray-200">
                                        <button type="button"
                                                @click="setActivePanel('online')"
                                                class="w-full px-4 py-3 text-left flex justify-between items-center focus:outline-none">
                                            <span class="font-medium text-gray-800">Online Payment</span>
                                            <svg :class="{'rotate-180': activePanel === 'online'}" class="h-5 w-5 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <div x-show="activePanel === 'online'" x-cloak class="px-4 pb-4">
                                            <p class="text-sm text-gray-600 mb-3">Pay securely using our online payment gateway.</p>
                                            <a href="{{ route('customer.bookings.payment.online', $booking->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                Proceed to Payment
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Option 3: Pay at Venue -->
                                    <div class="payment-option">
                                        <button type="button"
                                                @click="setActivePanel('cash')"
                                                class="w-full px-4 py-3 text-left flex justify-between items-center focus:outline-none">
                                            <span class="font-medium text-gray-800">Manual Payment (Cash)</span>
                                            <svg :class="{'rotate-180': activePanel === 'cash'}" class="h-5 w-5 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <div x-show="activePanel === 'cash'" x-cloak class="px-4 pb-4">
                                            <p class="text-sm text-gray-600 mb-3">Pay with cash at the venue before your activity starts.</p>
                                            <form action="{{ route('customer.bookings.payment.cash', $booking->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                    Pay at Site
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
