@extends('layouts.simple-admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-4 flex items-center space-x-2">
        <a href="{{ route('admin.bookings') }}" class="text-purple-600 hover:text-purple-900 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Bookings
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white flex justify-between items-center">
            <h1 class="text-xl font-bold">Booking Details: {{ $booking->booking_reference }}</h1>
            <div class="flex space-x-2">
                <span class="px-3 py-1 text-xs rounded-full
                    @if(strtoupper($booking->status) == 'CONFIRMED') bg-green-500 @endif
                    @if(strtoupper($booking->status) == 'PENDING') bg-yellow-500 @endif
                    @if(strtoupper($booking->status) == 'COMPLETED') bg-blue-500 @endif
                    @if(strtoupper($booking->status) == 'CANCELLED') bg-red-500 @endif
                    text-white font-semibold">
                    {{ ucfirst($booking->status) }}
                </span>
                <span class="px-3 py-1 text-xs rounded-full
                    @if(strtoupper($booking->payment_status) == 'PAID') bg-green-500 @endif
                    @if(strtoupper($booking->payment_status) == 'PENDING') bg-yellow-500 @endif
                    @if(strtoupper($booking->payment_status) == 'PROCESSING') bg-blue-500 @endif
                    @if(strtoupper($booking->payment_status) == 'REFUNDED') bg-purple-500 @endif
                    @if(strtoupper($booking->payment_status) == 'FAILED') bg-red-500 @endif
                    text-white font-semibold">
                    Payment: {{ ucfirst($booking->payment_status) }}
                </span>
            </div>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Column: Booking Info -->
            <div class="md:col-span-2 space-y-6">
                <!-- Basic Info -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Booking Information</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Reference</p>
                            <p class="font-medium">{{ $booking->booking_reference }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Created On</p>
                            <p class="font-medium">{{ $booking->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Booking Date</p>
                            <p class="font-medium">{{ $booking->booking_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Time</p>
                            <p class="font-medium">{{ $booking->start_time->format('h:i A') }} - {{ $booking->end_time ? $booking->end_time->format('h:i A') : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Participants</p>
                            <p class="font-medium">{{ $booking->participants }} {{ $booking->participants > 1 ? 'people' : 'person' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Price</p>
                            <p class="font-medium text-purple-600">RM {{ number_format($booking->total_price, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="font-medium">{{ ucfirst($booking->status) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Payment</p>
                            <p class="font-medium">{{ ucfirst($booking->payment_status) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Activity Info -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-medium text-gray-800">Activity Details</h2>
                        @if($booking->activity)
                            <a href="#" class="text-purple-600 hover:text-purple-900 text-sm">View Activity</a>
                        @endif
                    </div>

                    @if($booking->activity)
                        <div class="flex mb-4">
                            @if($booking->activity->image_url)
                                <img src="{{ $booking->activity->image_url }}" alt="{{ $booking->activity->name }}" class="w-24 h-24 object-cover rounded-lg mr-4">
                            @else
                                <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $booking->activity->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $booking->activity->location }}</p>
                                <p class="text-sm text-gray-500">Type: {{ ucfirst($booking->activity->activity_type) }}</p>
                                <p class="text-sm text-gray-500">Duration: {{ $booking->activity->duration_minutes }} minutes</p>
                            </div>
                        </div>

                        @if($booking->activity->activity_type == 'camping' || $booking->activity->activity_type == 'glamping')
                            @if($booking->lot)
                                <div class="bg-gray-100 p-3 rounded-lg mb-3">
                                    <h4 class="font-medium text-gray-800 mb-2">Lot Assignment</h4>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <p class="text-xs text-gray-500">Lot Name</p>
                                            <p class="text-sm">{{ $booking->lot->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Capacity</p>
                                            <p class="text-sm">{{ $booking->lot->capacity }} people</p>
                                        </div>
                                    </div>
                                    @if($booking->lot->description)
                                        <div class="mt-2">
                                            <p class="text-xs text-gray-500">Description</p>
                                            <p class="text-sm">{{ $booking->lot->description }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endif

                        @if($booking->special_requests)
                            <div>
                                <p class="text-sm font-medium text-gray-700">Special Requests:</p>
                                <p class="text-sm text-gray-600 italic">{{ $booking->special_requests }}</p>
                            </div>
                        @endif
                    @else
                        <p class="text-sm text-gray-500">Activity information not available.</p>
                    @endif
                </div>
            </div>

            <!-- Right Column: Customer and Payment -->
            <div class="space-y-6">
                <!-- Customer Info -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-medium text-gray-800">Customer</h2>
                        @if($booking->user)
                            <a href="{{ route('admin.customers') }}" class="text-purple-600 hover:text-purple-900 text-sm">View Profile</a>
                        @endif
                    </div>

                    @if($booking->user)
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-purple-700 font-medium text-lg">{{ substr($booking->user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $booking->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $booking->user->email }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-3">
                            @if($booking->user->phone)
                                <div>
                                    <p class="text-xs text-gray-500">Phone</p>
                                    <p class="text-sm">{{ $booking->user->phone }}</p>
                                </div>
                            @endif
                            <div>
                                <p class="text-xs text-gray-500">Member Since</p>
                                <p class="text-sm">{{ $booking->user->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">Customer information not available.</p>
                    @endif
                </div>

                <!-- Vendor Info -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-medium text-gray-800">Vendor</h2>
                        @if($booking->activity && $booking->activity->shopInfo)
                            <a href="{{ route('admin.providers') }}" class="text-purple-600 hover:text-purple-900 text-sm">View Vendor</a>
                        @endif
                    </div>

                    @if($booking->activity && $booking->activity->shopInfo)
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-teal-700 font-medium text-lg">{{ substr($booking->activity->shopInfo->company_name ?? $booking->activity->shopInfo->user->name ?? 'P', 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $booking->activity->shopInfo->company_name ?? $booking->activity->shopInfo->user->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-500">{{ $booking->activity->shopInfo->user->email ?? 'N/A' }}</p>
                            </div>
                        </div>

                        @if($booking->activity->shopInfo->phone)
                            <div>
                                <p class="text-xs text-gray-500">Contact</p>
                                <p class="text-sm">{{ $booking->activity->shopInfo->phone }}</p>
                            </div>
                        @endif
                    @else
                        <p class="text-sm text-gray-500">Vendor information not available.</p>
                    @endif
                </div>

                <!-- Payment Info -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Payment Details</h2>

                    <div class="mb-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-gray-600">Subtotal:</span>
                            <span class="text-sm">RM {{ number_format($booking->total_price, 2) }}</span>
                        </div>
                        <div class="flex justify-between font-medium">
                            <span class="text-sm text-gray-800">Total:</span>
                            <span class="text-sm text-purple-600">RM {{ number_format($booking->total_price, 2) }}</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-sm font-medium text-gray-800 mb-2">Payment Method</h3>
                        <p class="text-sm text-gray-600 mb-2">
                            @if($booking->payment_method)
                                {{ ucfirst($booking->payment_method) }}
                            @else
                                No payment method recorded
                            @endif
                        </p>

                        @if($booking->payment_id)
                            <div class="mb-2">
                                <p class="text-xs text-gray-500">Transaction ID</p>
                                <p class="text-sm font-mono">{{ $booking->payment_id }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Management Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white">
            <h2 class="text-lg font-medium">Manage Payment</h2>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Manual Bank Transfer -->
                <div class="bg-white p-4 rounded-lg border border-gray-200 hover:shadow-md transition-all">
                    <h3 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Pay Manual (Bank Transfer)
                    </h3>
                    <form id="bank-transfer-form" action="{{ route('admin.bookings.payment', $booking->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="payment_method" value="bank_transfer">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Amount (RM)</label>
                            <input type="number" name="payment_amount" step="0.01" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 py-3 px-4 text-base" value="{{ $booking->total_price }}">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Receipt Image</label>
                            <input type="file" name="receipt_image" class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:border-0 file:rounded-md file:text-sm file:font-medium file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 py-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea name="payment_notes" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 py-3 px-4 text-base" rows="2" placeholder="Any payment notes"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-6 rounded-md transition-colors text-base">
                            Confirm Payment
                        </button>
                    </form>
                </div>

                <!-- Pay On Site -->
                <div class="bg-white p-4 rounded-lg border border-gray-200 hover:shadow-md transition-all">
                    <h3 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Pay On Site (Cash)
                    </h3>
                    <form id="cash-payment-form" action="{{ route('admin.bookings.payment', $booking->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="payment_method" value="cash">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Amount Received (RM)</label>
                            <input type="number" name="payment_amount" step="0.01" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-3 px-4 text-base" value="{{ $booking->total_price }}">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea name="payment_notes" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 py-3 px-4 text-base" rows="2" placeholder="Any payment notes"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-md transition-colors text-base">
                            Record Cash Payment
                        </button>
                    </form>
                </div>

                <!-- Online Payment -->
                <div class="bg-white p-4 rounded-lg border border-gray-200 hover:shadow-md transition-all">
                    <h3 class="text-md font-medium text-gray-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Online Payment Details
                    </h3>
                    <form id="online-payment-form" action="{{ route('admin.bookings.payment', $booking->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="payment_method" value="online">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gateway</label>
                            <input type="text" name="payment_notes" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-3 px-4 text-base" placeholder="e.g. Toyyibpay">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Transaction ID</label>
                            <input type="text" name="payment_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-3 px-4 text-base" placeholder="e.g. TYP12345678">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Amount Paid (RM)</label>
                            <input type="number" name="payment_amount" step="0.01" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-3 px-4 text-base" value="{{ $booking->total_price }}">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-md transition-colors text-base">
                            Record Online Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Section -->
    <div class="mt-6 flex flex-wrap justify-end space-x-4">
        @if(strtoupper($booking->status) != 'CANCELLED')
            <button type="button" id="cancel-booking-btn" class="bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-6 rounded-md transition-colors text-base">
                Cancel Booking
            </button>
        @endif
    </div>

    <!-- Cancel Booking Modal -->
    <div id="cancel-booking-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-xl font-medium text-gray-900">Cancel Booking</h3>
            </div>
            <form id="cancel-booking-form" action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST">
                @csrf
                <div class="px-6 py-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cancellation Reason</label>
                        <textarea name="cancelation_reason" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 py-3 px-4 text-base" rows="3" placeholder="Why is this booking being cancelled?" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="issue_refund" class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Issue Refund (if applicable)</span>
                        </label>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3 rounded-b-lg">
                    <button type="button" id="close-cancel-modal" class="bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 px-4 py-2 rounded-md text-sm font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Confirm Cancellation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Handle Cancel Booking Modal
        $('#cancel-booking-btn').click(function() {
            $('#cancel-booking-modal').removeClass('hidden');
        });

        $('#close-cancel-modal').click(function() {
            $('#cancel-booking-modal').addClass('hidden');
        });

        // Close modal when clicking outside
        $(window).click(function(event) {
            if ($(event.target).is('#cancel-booking-modal')) {
                $('#cancel-booking-modal').addClass('hidden');
            }
        });

        // Form submission with AJAX (optional)
        // You can uncomment this section if you want to handle form submissions with AJAX
        /*
        $('#bank-transfer-form, #cash-payment-form, #online-payment-form').submit(function(e) {
            e.preventDefault();
            const form = $(this);
            const formData = new FormData(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('Payment processed successfully');
                    window.location.reload();
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'There was a problem processing the payment:';
                    for (const key in errors) {
                        errorMessage += '\n- ' + errors[key][0];
                    }
                    alert(errorMessage);
                }
            });
        });

        $('#cancel-booking-form').submit(function(e) {
            e.preventDefault();
            const form = $(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    alert('Booking cancelled successfully');
                    window.location.reload();
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'There was a problem cancelling the booking:';
                    for (const key in errors) {
                        errorMessage += '\n- ' + errors[key][0];
                    }
                    alert(errorMessage);
                }
            });
        });
        */
    });
</script>
@endsection
