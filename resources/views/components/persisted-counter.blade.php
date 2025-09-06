<div class="persisted-counter" data-id="{{ $id ?? 'default' }}">
    <h3>{{ $title ?? 'Persisted Counter' }}</h3>
    <p>Count: <span class="persisted-counter-display">{{ $initialValue ?? 0 }}</span></p>
    <button class="persisted-increment-button bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
        Increment
    </button>
</div>

@once
<script>
    $(document).ready(function() {
        // This code runs only once per page
        if (!window._persistedCounterInitialized) {
            window._persistedCounterInitialized = true;

            // Initialize persisted counters
            $('.persisted-counter').each(function() {
                const $counter = $(this);
                const counterId = $counter.data('id');
                const $display = $counter.find('.persisted-counter-display');

                // Load value from localStorage if it exists
                const savedValue = localStorage.getItem('counter-' + counterId);
                if (savedValue !== null) {
                    $display.text(savedValue);
                }

                // Set up increment button
                $counter.find('.persisted-increment-button').on('click', function() {
                    let currentCount = parseInt($display.text()) || 0;
                    currentCount += 1;
                    $display.text(currentCount);

                    // Save to localStorage
                    localStorage.setItem('counter-' + counterId, currentCount);
                });
            });
        }
    });
</script>
@endonce
