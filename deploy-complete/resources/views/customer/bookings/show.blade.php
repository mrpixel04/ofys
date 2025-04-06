<x-app-layout>
    <!-- Load Alpine.js if not already loaded -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Simple Alpine.js script specifically for the accordion -->
    <script>
        window.setupAccordion = function() {
            return {
                activeTab: null,
                toggleTab(tab) {
                    this.activeTab = this.activeTab === tab ? null : tab;
                }
            }
        }
    </script>

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

                                <!-- Payment Options -->
                                @if($booking->payment_status !== 'paid' && $booking->status !== 'cancelled')
                                <div class="mt-6" x-data="setupAccordion()">
                                    <h3 class="text-base font-medium text-gray-900 mb-3">Payment Options</h3>

                                    <!-- Payment Method Selection -->
                                    <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden mb-4">
                                        <!-- Option 1: Online Transfer -->
                                        <div class="payment-option border-b border-gray-200">
                                            <button type="button"
                                                    @click="toggleTab('transfer')"
                                                    class="w-full px-4 py-3 text-left flex justify-between items-center focus:outline-none">
                                                <span class="font-medium text-gray-800">Bank Transfer</span>
                                                <svg :class="{'rotate-180': activeTab === 'transfer'}" class="h-5 w-5 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <div x-show="activeTab === 'transfer'" x-cloak class="px-4 pb-4">
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
                                                    @click="toggleTab('online')"
                                                    class="w-full px-4 py-3 text-left flex justify-between items-center focus:outline-none">
                                                <span class="font-medium text-gray-800">Online Payment</span>
                                                <svg :class="{'rotate-180': activeTab === 'online'}" class="h-5 w-5 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <div x-show="activeTab === 'online'" x-cloak class="px-4 pb-4">
                                                <p class="text-sm text-gray-600 mb-3">Pay securely using our online payment gateway.</p>
                                                <a href="{{ route('customer.bookings.payment.online', $booking->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                    Proceed to Payment
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Option 3: Pay at Venue -->
                                        <div class="payment-option">
                                            <button type="button"
                                                    @click="toggleTab('cash')"
                                                    class="w-full px-4 py-3 text-left flex justify-between items-center focus:outline-none">
                                                <span class="font-medium text-gray-800">Manual Payment (Cash)</span>
                                                <svg :class="{'rotate-180': activeTab === 'cash'}" class="h-5 w-5 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <div x-show="activeTab === 'cash'" x-cloak class="px-4 pb-4">
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
</x-app-layout>
