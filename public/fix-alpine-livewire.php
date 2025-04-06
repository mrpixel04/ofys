<?php
/**
 * Alpine.js and Livewire Fix Page
 */
header('Content-Type: text/html');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fix Alpine.js and Livewire Duplication</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; line-height: 1.6; }
        .button { display: inline-block; background: #4CAF50; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; margin: 10px 0; }
        pre { background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto; font-size: 14px; }
        .code-block { background: #f0f0f0; border-left: 4px solid #2196F3; padding: 10px 15px; margin: 15px 0; }
        .warning { background: #FFF3CD; border-left: 4px solid #FFD700; padding: 10px 15px; margin: 15px 0; }
        ol li, ul li { margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Fix Alpine.js and Livewire Duplication</h1>

    <div class="warning">
        <h3>🛑 Your Issue</h3>
        <p>Your page is showing these errors in the console:</p>
        <ul>
            <li>Detected multiple instances of Livewire running</li>
            <li>Detected multiple instances of Alpine running</li>
            <li>Uncaught TypeError: Cannot redefine property: $persist</li>
        </ul>
        <p>This happens when Alpine.js and/or Livewire are loaded and initialized more than once on the same page.</p>
    </div>

    <h2>Quick Fix</h2>
    <p>Add this script to your layout file <em>before</em> any other JavaScript:</p>

    <div class="code-block">
        <a href="/fix-script.js" class="button" download>Download fix-script.js</a>
        <p>Add this line to your main layout file (typically <code>resources/views/layouts/app.blade.php</code>):</p>
        <pre>&lt;script src="{{ asset('fix-script.js') }}"&gt;&lt;/script&gt;</pre>
        <p>Place this <strong>before</strong> other scripts in the &lt;head&gt; section.</p>
    </div>

    <h2>Complete Solution</h2>
    <p>For a more permanent solution, follow these steps:</p>

    <ol>
        <li>
            <strong>Edit your layout file:</strong> <code>resources/views/layouts/app.blade.php</code>
            <pre>&lt;!-- Add this BEFORE your other scripts --&gt;
&lt;script&gt;
    // Prevent multiple initialization of Alpine and Livewire
    window._alpineLoaded = false;
    window._livewireLoaded = false;

    window.preventMultipleInitialization = function() {
        // Only initialize once
        if (window.Alpine && !window._alpineLoaded) {
            window._alpineLoaded = true;
        } else if (window.Alpine) {
            console.log('Preventing duplicate Alpine initialization');
            window.Alpine.start = function() { console.log('Alpine start prevented'); };
        }

        if (window.Livewire && !window._livewireLoaded) {
            window._livewireLoaded = true;
        } else if (window.Livewire) {
            console.log('Preventing duplicate Livewire initialization');
            window.Livewire.start = function() { console.log('Livewire start prevented'); };
        }
    };

    // Run immediately and after scripts load
    preventMultipleInitialization();
    document.addEventListener('DOMContentLoaded', preventMultipleInitialization);
&lt;/script&gt;</pre>
        </li>

        <li>
            <strong>Edit your app.js file:</strong> <code>resources/js/app.js</code>
            <pre>import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Make globally available
window.Alpine = Alpine;
window.Livewire = Livewire;

// Register plugins before starting
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
Alpine.plugin(persist);

// Only initialize once using our safety function
if (typeof window.preventMultipleInitialization === 'function') {
    window.preventMultipleInitialization();
}

// Start the frameworks
if (!window._livewireLoaded) {
    window._livewireLoaded = true;
    Livewire.start();
}

if (!window._alpineLoaded) {
    window._alpineLoaded = true;
    Alpine.start();
}</pre>
        </li>
    </ol>

    <h2>Testing</h2>
    <p>After applying either solution, check your browser console for errors. The "Cannot redefine property: $persist" error should be gone, and your click handlers should work properly.</p>

    <script>
        // Check if the Alpine/Livewire errors occur on this page for testing
        window.addEventListener('DOMContentLoaded', function() {
            console.log('Checking for Alpine/Livewire issues...');
            setTimeout(function() {
                const errors = [];

                if (window.Alpine && window._alpineInitialized) {
                    console.log('✅ Alpine is protected from multiple initialization');
                }

                if (window.Livewire && window._livewireInitialized) {
                    console.log('✅ Livewire is protected from multiple initialization');
                }

                console.log('Analysis complete. Check your application after applying the fix.');
            }, 1000);
        });
    </script>

    <!-- Include the fix script -->
    <script src="fix-script.js"></script>
</body>
</html>
