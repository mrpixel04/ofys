<?php
/**
 * Fix script for Alpine.js and Livewire duplication
 */
header('Content-Type: text/html');
?>

<!DOCTYPE html>
<html>
<head>
    <title>JS Fix for Alpine/Livewire</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; max-width: 800px; margin: 0 auto; padding: 20px; }
        pre { background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .success { color: green; }
        .warning { color: orange; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Alpine.js and Livewire Duplication Fix</h1>

    <h2>Issue Description</h2>
    <p>Your site is experiencing errors because multiple instances of Alpine.js and Livewire are being loaded. This causes the "Cannot redefine property: $persist" error and breaks click functionality.</p>

    <h2>Solution</h2>
    <p>Add the following script to your main layout file (<code>resources/views/layouts/app.blade.php</code>) just before your other scripts:</p>

    <pre>&lt;script&gt;
// Prevent duplicate Alpine/Livewire instances
window.Alpine = window.Alpine || {};
window.Livewire = window.Livewire || {};

// Track if libraries are already loaded
window._alpineLoaded = window._alpineLoaded || false;
window._livewireLoaded = window._livewireLoaded || false;

// Create safety function to prevent multiple initializations
window.initializeJSLibraries = function() {
    console.log('Initializing JS libraries safely...');

    // Only initialize Alpine once
    if (!window._alpineLoaded && window.Alpine && typeof window.Alpine.start === 'function') {
        console.log('Starting Alpine safely...');
        window._alpineLoaded = true;
        window.Alpine.start();
    }

    // Only initialize Livewire once
    if (!window._livewireLoaded && window.Livewire && typeof window.Livewire.start === 'function') {
        console.log('Starting Livewire safely...');
        window._livewireLoaded = true;
        window.Livewire.start();
    }
};
&lt;/script&gt;</pre>

    <h2>Next Steps</h2>
    <ol>
        <li>Add the script above to your layout file</li>
        <li>Find and modify your <code>resources/js/app.js</code> file to use the safety function instead of directly calling <code>Livewire.start()</code> and <code>Alpine.start()</code>:</li>
    </ol>

    <pre>import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Make available globally
window.Alpine = Alpine;
window.Livewire = Livewire;

// Use safe initialization function
if (typeof window.initializeJSLibraries === 'function') {
    window.initializeJSLibraries();
} else {
    // Fallback direct initialization
    Livewire.start();
    Alpine.start();
}</pre>

    <h2>Testing</h2>
    <p>After making these changes, refresh your pages and check if the error is gone and click functionality is restored.</p>
</body>
</html>