<div class="toggle-component" data-target="{{ $target ?? '' }}">
    <button class="toggle-button {{ $class ?? 'bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded' }}">
        <span class="toggle-text-show">{{ $showText ?? 'Show' }}</span>
        <span class="toggle-text-hide hidden">{{ $hideText ?? 'Hide' }}</span>
    </button>

    <div class="toggle-content" style="display: none; overflow: hidden;">
        {{ $slot }}
    </div>
</div>

@once
<script>
    $(document).ready(function() {
        // This code runs only once per page
        if (!window._toggleInitialized) {
            window._toggleInitialized = true;

            // Initialize toggles
            $('.toggle-button').on('click', function() {
                const $component = $(this).closest('.toggle-component');
                const $toggleContent = $component.find('.toggle-content');
                const $showText = $(this).find('.toggle-text-show');
                const $hideText = $(this).find('.toggle-text-hide');

                // Toggle visibility
                $toggleContent.toggleClass('hidden');
                $showText.toggleClass('hidden');
                $hideText.toggleClass('hidden');

                // If there's a target specified, animate that element too
                const targetSelector = $component.data('target');
                if (targetSelector) {
                    const $target = $(targetSelector);
                    if ($target.is(':visible')) {
                        $target.slideUp(300);
                    } else {
                        $target.slideDown(300);
                    }
                }
            });
        }
    });
</script>
@endonce
