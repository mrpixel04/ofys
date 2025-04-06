<div class="dropdown relative">
    <div class="dropdown-trigger cursor-pointer inline-block">
        {{ $trigger }}
    </div>

    <div class="dropdown-content absolute right-0 mt-2 py-2 bg-white shadow-lg rounded-lg w-48 hidden">
        {{ $content }}
    </div>
</div>

@once
<script>
    $(document).ready(function() {
        // This code runs only once per page
        if (!window._dropdownInitialized) {
            window._dropdownInitialized = true;

            // Close dropdowns when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-content').addClass('hidden');
                }
            });

            // Toggle dropdown on click
            $('.dropdown-trigger').on('click', function(e) {
                e.stopPropagation();
                const $dropdown = $(this).siblings('.dropdown-content');

                // Close all other dropdowns
                $('.dropdown-content').not($dropdown).addClass('hidden');

                // Toggle current dropdown
                $dropdown.toggleClass('hidden');
            });
        }
    });
</script>
@endonce