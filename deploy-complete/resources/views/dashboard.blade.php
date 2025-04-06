<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>

                <div class="p-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Test Components</h3>

                    <div class="mt-4 space-y-6">
                        <!-- Regular Counter Component -->
                        <div class="counter">
                            <h4 class="text-md font-medium text-gray-700 mb-2">Regular Counter</h4>
                            <p>Count: <span class="counter-display">0</span></p>
                            <button class="counter-button mt-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                Increment
                            </button>
                        </div>

                        <!-- Persisted Counter Component -->
                        <x-persisted-counter id="dashboard-counter" title="Persisted Counter" :initial-value="0" />

                        <!-- Toggle Component -->
                        <x-toggle show-text="Show Details" hide-text="Hide Details">
                            <div class="p-4 bg-gray-100 rounded">
                                <p>These are some additional details that can be toggled with smooth animation.</p>
                                <p class="mt-2">The content slides up and down with a nice transition.</p>
                            </div>
                        </x-toggle>

                        <!-- Persisted Input Component -->
                        <x-input-persisted
                            name="notes"
                            id="user-notes"
                            label="Your Notes"
                            placeholder="Type something here..."
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize regular counter
            if (!window._dashboardCounterInitialized) {
                window._dashboardCounterInitialized = true;

                $('.counter-button').on('click', function() {
                    let display = $(this).siblings('p').find('.counter-display');
                    let currentCount = parseInt(display.text()) || 0;
                    display.text(currentCount + 1);
                });
            }
        });
    </script>
</x-app-layout>
