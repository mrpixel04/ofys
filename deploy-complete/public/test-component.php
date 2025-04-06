<?php
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jQuery Component Test</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hidden {
            display: none;
        }
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            padding: 20px;
        }
        .component-section {
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-8">jQuery Component Test Page</h1>

        <div class="component-section">
            <h2 class="text-xl font-semibold mb-4">Regular Counter</h2>
            <div class="counter">
                <h3>Test Counter</h3>
                <p>Count: <span class="counter-display">0</span></p>
                <button class="counter-button bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Increment
                </button>
            </div>
        </div>

        <div class="component-section">
            <h2 class="text-xl font-semibold mb-4">Persisted Counter</h2>
            <div class="persisted-counter" data-id="test-counter">
                <h3>Persisted Counter</h3>
                <p>Count: <span class="persisted-counter-display">0</span></p>
                <button class="persisted-increment-button bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    Increment
                </button>
            </div>
        </div>

        <div class="component-section">
            <h2 class="text-xl font-semibold mb-4">Dropdown</h2>
            <div class="dropdown relative">
                <div class="dropdown-trigger cursor-pointer inline-block bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">
                    Open Menu
                </div>

                <div class="dropdown-content absolute right-0 mt-2 py-2 bg-white shadow-lg rounded-lg w-48 hidden">
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-indigo-100">Option 1</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-indigo-100">Option 2</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-indigo-100">Option 3</a>
                </div>
            </div>
        </div>

        <div class="component-section">
            <h2 class="text-xl font-semibold mb-4">Toggle</h2>
            <div class="toggle-component">
                <button class="toggle-button bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">
                    <span class="toggle-text-show">Show Content</span>
                    <span class="toggle-text-hide hidden">Hide Content</span>
                </button>

                <div class="toggle-content" style="display: none; overflow: hidden;">
                    <div class="mt-4 p-4 bg-gray-100 rounded">
                        <p>This is the hidden content that can be toggled with smooth animation.</p>
                        <p class="mt-2">The content slides up and down with a nice transition.</p>
                        <div class="mt-4 bg-white p-3 rounded border border-gray-200">
                            <p>You can include any content here!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="component-section">
            <h2 class="text-xl font-semibold mb-4">Persisted Input</h2>
            <div class="persisted-input" data-key="test-input">
                <label for="test-input" class="block text-sm font-medium text-gray-700 mb-1">
                    Persisted Input
                </label>

                <input
                    type="text"
                    name="test-input"
                    id="test-input"
                    class="persisted-input-field w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Type something here..."
                    value=""
                >
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Counter initialization
            if (!window._counterInitialized) {
                window._counterInitialized = true;

                $('.counter-button').on('click', function() {
                    let display = $(this).siblings('p').find('.counter-display');
                    let currentCount = parseInt(display.text()) || 0;
                    display.text(currentCount + 1);
                });
            }

            // Persisted counter initialization
            if (!window._persistedCounterInitialized) {
                window._persistedCounterInitialized = true;

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

            // Dropdown initialization
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

            // Toggle initialization
            if (!window._toggleInitialized) {
                window._toggleInitialized = true;

                $('.toggle-button').on('click', function() {
                    const $component = $(this).closest('.toggle-component');
                    const $toggleContent = $component.find('.toggle-content');
                    const $showText = $(this).find('.toggle-text-show');
                    const $hideText = $(this).find('.toggle-text-hide');

                    // Toggle visibility with slide animation
                    if ($toggleContent.is(':visible')) {
                        $toggleContent.slideUp(300);
                        $showText.removeClass('hidden');
                        $hideText.addClass('hidden');
                    } else {
                        $toggleContent.slideDown(300);
                        $showText.addClass('hidden');
                        $hideText.removeClass('hidden');
                    }

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

            // Persisted input initialization
            if (!window._persistedInputInitialized) {
                window._persistedInputInitialized = true;

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
</body>
</html>
