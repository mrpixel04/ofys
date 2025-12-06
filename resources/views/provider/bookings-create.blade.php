@extends('layouts.provider.simple-app')

@section('header', 'Create Walk-In Booking')

@section('breadcrumbs')
    @include('layouts.partials.breadcrumbs', [
        'breadcrumbs' => [
            ['label' => 'Dashboard', 'url' => route('provider.dashboard')],
            ['label' => 'Bookings', 'url' => route('provider.bookings')],
            ['label' => 'Walk-In Booking'],
        ],
    ])
@endsection

@section('header_subtitle')
    Capture walk-in customers quickly and keep your availability accurate in real time.
@endsection

@section('content')
    <div class="max-w-5xl space-y-8">
        <div class="bg-white shadow-sm border border-gray-200 rounded-xl">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">Booking Details</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Link the booking to an existing activity, capture customer info, and confirm payment status.
                </p>
            </div>

            <form method="POST" action="{{ route('provider.bookings.walk-in.store') }}" class="px-6 py-6 space-y-8">
                @csrf

                @if(session('error'))
                    <div class="rounded-md bg-red-50 p-4 border border-red-100 text-red-700 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-5">
                        <h3 class="text-sm font-semibold text-slate-800 uppercase tracking-wide">Customer Information</h3>
                        <p class="text-sm text-slate-500 mt-1">Only basic details are required. An account will be created automatically.</p>

                        <div class="mt-6 space-y-5">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                                @error('customer_name')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="customer_email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="customer@email.com">
                                @error('customer_email')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="+60 12 345 6789">
                                @error('customer_phone')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="customer_notes" class="block text-sm font-medium text-gray-700">Customer Notes</label>
                                <textarea id="customer_notes" name="customer_notes" rows="3" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="Any additional context for this walk-in?">{{ old('customer_notes') }}</textarea>
                                @error('customer_notes')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-5">
                        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Activity Selection</h3>
                        <p class="text-sm text-gray-500 mt-1">Only your activities are listed. Prices update automatically.</p>

                        <div class="mt-6 space-y-5">
                            <div>
                                <label for="activity_id" class="block text-sm font-medium text-gray-700">Activity <span class="text-red-500">*</span></label>
                                <select id="activity_id" name="activity_id" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                                    <option value="">Select an activity</option>
                                    @foreach($activities as $activity)
                                        <option value="{{ $activity->id }}"
                                                data-price="{{ $activity->price }}"
                                                data-price-type="{{ $activity->price_type }}"
                                                data-location="{{ $activity->location }}"
                                                data-min="{{ $activity->min_participants ?? 1 }}"
                                                data-max="{{ $activity->max_participants ?? 50 }}"
                                                @selected(old('activity_id') == $activity->id)>
                                            {{ $activity->name }} — RM {{ number_format($activity->price, 2) }} ({{ ucfirst(str_replace('_', ' ', $activity->price_type)) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('activity_id')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="activity_summary" class="hidden rounded-md border border-dashed border-teal-200 bg-teal-50 p-4 text-sm text-teal-900">
                                <p class="font-medium" id="summary_name">—</p>
                                <p class="mt-1 flex items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span id="summary_location">—</span>
                                </p>
                                <p class="mt-1 text-xs text-teal-700" id="summary_capacity"></p>
                            </div>

                            <div>
                                <label for="lot_id" class="block text-sm font-medium text-gray-700">Assign Lot (Optional)</label>
                                <select id="lot_id" name="lot_id" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                    <option value="">No specific lot</option>
                                    @foreach($activities as $activity)
                                        @foreach($activity->lots as $lot)
                                            <option value="{{ $lot->id }}"
                                                    data-activity="{{ $activity->id }}"
                                                    @selected(old('lot_id') == $lot->id)>
                                                {{ $activity->name }} — {{ $lot->name }} ({{ $lot->capacity ?? 'N/A' }} pax)
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                                @error('lot_id')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Only lots belonging to the selected activity can be chosen.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white border border-gray-200 rounded-lg p-5 space-y-5">
                        <div>
                            <label for="booking_date" class="block text-sm font-medium text-gray-700">Booking Date <span class="text-red-500">*</span></label>
                            <input type="date" id="booking_date" name="booking_date" value="{{ old('booking_date', now()->format('Y-m-d')) }}" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                            @error('booking_date')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time <span class="text-red-500">*</span></label>
                                <input type="time" id="start_time" name="start_time" value="{{ old('start_time', now()->format('H:00')) }}" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                                @error('start_time')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                                <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                @error('end_time')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="participants" class="block text-sm font-medium text-gray-700">Participants <span class="text-red-500">*</span></label>
                            <input type="number" id="participants" name="participants" value="{{ old('participants', 1) }}" min="1" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                            @error('participants')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="special_requests" class="block text-sm font-medium text-gray-700">Special Requests</label>
                            <textarea id="special_requests" name="special_requests" rows="3" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="Dietary restrictions, arrival notes, etc.">{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-5 space-y-5">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Booking Status</label>
                            <select id="status" name="status" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                @foreach(['confirmed' => 'Confirmed', 'pending' => 'Pending', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status', 'confirmed') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="payment_status" class="block text-sm font-medium text-gray-700">Payment Status</label>
                            <select id="payment_status" name="payment_status" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                @foreach(['pending' => 'Pending', 'processing' => 'Processing', 'done' => 'Paid', 'refunded' => 'Refunded', 'failed' => 'Failed'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('payment_status', 'pending') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('payment_status')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                            <input type="text" id="payment_method" name="payment_method" value="{{ old('payment_method', 'walk_in') }}" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="cash, card, transfer...">
                            @error('payment_method')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="total_price" class="block text-sm font-medium text-gray-700">Total Amount (RM)</label>
                            <input type="number" step="0.01" min="0" id="total_price" name="total_price" value="{{ old('total_price') }}" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm bg-gray-50 focus:border-teal-500 focus:ring-teal-500" placeholder="Auto-calculated from activity" readonly>
                            @error('total_price')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Automatically calculated using the activity price and total participants.</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between border-t border-gray-100 pt-6">
                    <a href="{{ route('provider.bookings') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-5 py-3 border border-transparent text-sm font-semibold rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        Create Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function waitForjQuery(callback) {
        if (window.jQuery) {
            callback(window.jQuery);
        } else {
            setTimeout(function () {
                waitForjQuery(callback);
            }, 50);
        }
    })(function ($) {
        const activityMeta = @json($activityMeta ?? []);

        function filterLots() {
            const activityId = $('#activity_id').val();
            let hasVisibleLots = false;

            $('#lot_id option[data-activity]').each(function () {
                const option = $(this);
                if (activityId && option.data('activity').toString() === activityId) {
                    option.show().prop('disabled', false);
                    hasVisibleLots = true;
                } else {
                    option.hide().prop('disabled', true);
                }
            });

            if (!hasVisibleLots) {
                $('#lot_id').val('');
            }
        }

        function updateSummary() {
            const activityId = $('#activity_id').val();
            if (!activityId || !activityMeta[activityId]) {
                $('#activity_summary').addClass('hidden');
                return;
            }

            const meta = activityMeta[activityId];
            $('#summary_name').text(meta.name);
            $('#summary_location').text(meta.location || 'No location provided');

            let capacityText = 'Recommended capacity not defined';
            if (meta.min && meta.max) {
                capacityText = `Recommended ${meta.min} - ${meta.max} participants`;
            } else if (meta.max) {
                capacityText = `Maximum ${meta.max} participants`;
            } else if (meta.min) {
                capacityText = `Minimum ${meta.min} participants`;
            }

            $('#summary_capacity').text(capacityText);
            $('#activity_summary').removeClass('hidden');
        }

        function autoPrice() {
            const activityId = $('#activity_id').val();
            if (!activityId || !activityMeta[activityId]) {
                return;
            }

            const meta = activityMeta[activityId];
            const participants = parseInt($('#participants').val(), 10) || 1;
            let calculated = meta.price;

            if (['per_person', 'per_pack'].includes(meta.price_type)) {
                calculated = meta.price * participants;
            }

            $('#total_price').val(calculated.toFixed(2));
        }

        $('#activity_id').on('change', function () {
            filterLots();
            updateSummary();
            autoPrice();
        });

        $('#participants').on('input change', function () {
            autoPrice();
        });

        // Initialize view state
        filterLots();
        updateSummary();
        autoPrice();
    });
</script>
@endpush
