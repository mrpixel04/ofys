<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('activities.show', $activity->id) }}" class="flex items-center text-yellow-500 hover:text-yellow-600">
                    <svg class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to activity details
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Book {{ $activity->name }}</h1>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Booking Form -->
                        <div class="md:col-span-2">
                            <form action="{{ route('customer.bookings.store', $activity->id) }}" method="POST">
                                @csrf

                                <!-- Date & Time Selection -->
                                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Select Date & Time</h2>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="booking_date" class="block text-sm font-medium text-gray-700">Date</label>
                                            <div class="mt-1 w-full">
                                                <input type="date" name="booking_date" id="booking_date" min="{{ date('Y-m-d') }}" required
                                                    class="w-full h-10 px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                                            </div>
                                            @error('booking_date')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                                            <div class="mt-1 w-full">
                                                <select name="start_time" id="start_time" required
                                                    class="w-full h-10 px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                                                    <option value="">Select a time</option>
                                                    @for ($hour = 8; $hour <= 17; $hour++)
                                                        <option value="{{ sprintf('%02d', $hour) }}:00">{{ sprintf('%02d', $hour) }}:00</option>
                                                        @if ($hour < 17)
                                                            <option value="{{ sprintf('%02d', $hour) }}:30">{{ sprintf('%02d', $hour) }}:30</option>
                                                        @endif
                                                    @endfor
                                                </select>
                                            </div>
                                            @error('start_time')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Lot Selection for Camping/Glamping -->
                                @if(in_array($activity->activity_type, ['camping', 'glamping']))
                                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Select Camping Lot</h2>

                                    @if($activity->lots->count() > 0)
                                        <div class="grid grid-cols-1 gap-4">
                                            @foreach($activity->lots as $lot)
                                                <div class="border rounded-md p-4 {{ $lot->is_available ? 'bg-white' : 'bg-gray-100' }}">
                                                    <div class="flex justify-between items-start">
                                                        <div class="flex items-start space-x-3">
                                                            @if($lot->is_available)
                                                            <input type="radio" name="lot_id" id="lot_{{ $lot->id }}" value="{{ $lot->id }}"
                                                                   class="mt-1 focus:ring-yellow-500 h-4 w-4 text-yellow-500 border-gray-300"
                                                                   {{ $loop->first && $lot->is_available ? 'checked' : '' }}
                                                                   {{ !$lot->is_available ? 'disabled' : '' }}>
                                                            @endif
                                                            <div>
                                                                <label for="lot_{{ $lot->id }}" class="block text-sm font-medium text-gray-900">
                                                                    Lot {{ $lot->id }} {{ $lot->name ? '- ' . $lot->name : '' }}
                                                                </label>
                                                                @if($lot->description)
                                                                    <p class="text-sm text-gray-500">{{ $lot->description }}</p>
                                                                @endif
                                                                <p class="text-sm text-gray-500">Capacity: {{ $lot->capacity }}
                                                                    {{ $lot->capacity == 1 ? 'person' : 'people' }}</p>
                                                            </div>
                                                        </div>
                                                        <span class="inline-flex items-center {{ $lot->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} px-2.5 py-0.5 rounded-full text-xs font-medium">
                                                            {{ $lot->is_available ? 'Available' : 'Booked' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('lot_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $errors->first('lot_id') }}</p>
                                        @enderror
                                    @else
                                        <p class="text-sm text-gray-500 italic">No camping lots are available for this activity. Please contact the provider.</p>
                                    @endif
                                </div>
                                @endif

                                <!-- Participant Information -->
                                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Participants</h2>

                                    <div>
                                        <label for="participants" class="block text-sm font-medium text-gray-700">Number of Participants</label>
                                        <div class="mt-1 w-full">
                                            <select name="participants" id="participants" required
                                                class="w-full h-10 px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm">
                                                @for($i = $activity->min_participants; $i <= $activity->max_participants; $i++)
                                                    <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'person' : 'people' }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        @error('participants')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Special Requests -->
                                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Special Requests</h2>

                                    <div>
                                        <label for="special_requests" class="block text-sm font-medium text-gray-700">Any special requests or requirements?</label>
                                        <div class="mt-1 w-full">
                                            <textarea name="special_requests" id="special_requests" rows="3"
                                                class="w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"
                                                placeholder="E.g., food allergies, accessibility needs, etc."></textarea>
                                        </div>
                                        @error('special_requests')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        Continue to Payment
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Booking Summary -->
                        <div class="md:col-span-1">
                            <div class="bg-gray-50 rounded-lg p-6 sticky top-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Booking Summary</h2>

                                <div class="mb-4">
                                    <div class="aspect-w-16 aspect-h-9 mb-4">
                                        @if($activity->images && is_array($activity->images) && count($activity->images) > 0)
                                            <img src="{{ asset('storage/' . $activity->images[0]) }}"
                                                alt="{{ $activity->name }}"
                                                class="object-cover rounded-lg">
                                        @else
                                            <img src="https://via.placeholder.com/300x200?text=No+Image"
                                                alt="No image available"
                                                class="object-cover rounded-lg">
                                        @endif
                                    </div>

                                    <h3 class="text-base font-medium text-gray-900">{{ $activity->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $activity->location }}</p>
                                </div>

                                <div class="border-t border-gray-200 py-4">
                                    <dl class="space-y-2">
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-600">Price</dt>
                                            <dd class="text-sm font-medium text-gray-900">
                                                RM{{ number_format($activity->price, 2) }} / {{ $activity->getPriceTypeFormattedAttribute() }}
                                            </dd>
                                        </div>

                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-600">Duration</dt>
                                            <dd class="text-sm font-medium text-gray-900">
                                                {{ floor($activity->duration_minutes / 60) }} hrs {{ $activity->duration_minutes % 60 }} mins
                                            </dd>
                                        </div>

                                        @if($activity->includes_gear)
                                            <div class="flex justify-between">
                                                <dt class="text-sm text-gray-600">Equipment</dt>
                                                <dd class="text-sm font-medium text-gray-900">Included</dd>
                                            </div>
                                        @endif
                                    </dl>
                                </div>

                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between font-medium">
                                        <dt class="text-base text-gray-900">Total</dt>
                                        <dd class="text-base text-gray-900" id="total-price">
                                            RM{{ number_format($activity->price, 2) }}
                                        </dd>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Final price will be calculated based on number of participants
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const participantsSelect = document.getElementById('participants');
            const totalPriceElement = document.getElementById('total-price');
            const basePrice = {{ $activity->price }};
            const priceType = '{{ $activity->price_type }}';

            // Update total price when number of participants changes
            if (participantsSelect && totalPriceElement) {
                participantsSelect.addEventListener('change', function() {
                    let total = basePrice;

                    // If price is per person, multiply by number of participants
                    if (priceType === 'per_person') {
                        total = basePrice * parseInt(this.value);
                    }

                    // Update the display
                    totalPriceElement.textContent = 'RM' + total.toFixed(2);
                });
            }
        });
    </script>
</x-app-layout>
