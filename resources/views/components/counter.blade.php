<div class="counter">
    <h3>{{ $title ?? 'Counter' }}</h3>
    <p>Count: <span class="counter-display">{{ $initialValue ?? 0 }}</span></p>
    <button class="counter-button bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
        Increment
    </button>
</div>

@once
<script>
    $(document).ready(function() {
        // This code runs only once per page
        if (!window._counterInitialized) {
            window._counterInitialized = true;

            // Initialize counters
            $('.counter-button').on('click', function() {
                let display = $(this).siblings('p').find('.counter-display');
                let currentCount = parseInt(display.text()) || 0;
                display.text(currentCount + 1);
            });
        }
    });
</script>
@endonce