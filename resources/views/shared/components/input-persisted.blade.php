<div class="persisted-input" data-key="{{ $storageKey ?? $id ?? $name }}">
    @if(isset($label))
    <label for="{{ $id ?? $name }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
    </label>
    @endif

    <input
        type="{{ $type ?? 'text' }}"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        class="persisted-input-field w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 {{ $class ?? '' }}"
        placeholder="{{ $placeholder ?? '' }}"
        value="{{ $value ?? '' }}"
        {{ isset($required) && $required ? 'required' : '' }}
        {{ isset($autofocus) && $autofocus ? 'autofocus' : '' }}
        {{ isset($disabled) && $disabled ? 'disabled' : '' }}
        {{ $attributes ?? '' }}
    >
</div>

@once
<script>
    $(document).ready(function() {
        // This code runs only once per page
        if (!window._persistedInputInitialized) {
            window._persistedInputInitialized = true;

            // Load saved values from localStorage
            $('.persisted-input').each(function() {
                const $container = $(this);
                const $input = $container.find('.persisted-input-field');
                const storageKey = $container.data('key');

                // Skip if no storage key
                if (!storageKey) return;

                // Load from localStorage if exists
                const savedValue = localStorage.getItem('input-' + storageKey);
                if (savedValue !== null) {
                    $input.val(savedValue);
                }

                // Save on input change
                $input.on('input change', function() {
                    localStorage.setItem('input-' + storageKey, $(this).val());
                });
            });
        }
    });
</script>
@endonce