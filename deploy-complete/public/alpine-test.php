<?php
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alpine.js Diagnostic</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; line-height: 1.6; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin: 20px 0; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .working { background: #e6ffed; border-left: 4px solid #28a745; padding: 10px; }
        .not-working { background: #ffeef0; border-left: 4px solid #d73a49; padding: 10px; }
        .info { background: #f6f8fa; padding: 10px 15px; margin: 10px 0; }
        button { padding: 8px 15px; border-radius: 4px; border: none; background: #0366d6; color: white; cursor: pointer; }
        button:hover { background: #0056b3; }
        code { font-family: monospace; background: #f6f8fa; padding: 2px 4px; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>Alpine.js and Livewire Diagnostic</h1>

    <div class="card">
        <h2>Test 1: Alpine.js Basic Functionality</h2>
        <div x-data="{ count: 0 }">
            <p>Click counter: <span x-text="count" id="click-counter">0</span></p>
            <button @click="count++">Increment</button>
        </div>
        <div class="info">
            <p>This tests if Alpine.js is working correctly. The counter should increment when you click the button.</p>
        </div>
        <div id="test1-result" class="not-working">Not yet tested</div>
    </div>

    <div class="card">
        <h2>Test 2: Alpine.js $persist Plugin</h2>
        <div x-data="{ persistedCount: $persist(0) }">
            <p>Persisted counter: <span x-text="persistedCount" id="persist-counter">0</span></p>
            <button @click="persistedCount++">Increment (Persisted)</button>
            <p><small>This value should persist after page refresh</small></p>
        </div>
        <div class="info">
            <p>This tests if the $persist plugin is working correctly. The counter should increment and keep its value after refresh.</p>
        </div>
        <div id="test2-result" class="not-working">Not yet tested</div>
    </div>

    <div class="card">
        <h2>Alpine.js and Livewire Status</h2>
        <div id="status-info" class="info">Checking status...</div>
    </div>

    <div class="card">
        <h2>Fix Instructions</h2>
        <p>The solution to fix Alpine.js and Livewire duplication issues:</p>
        <ol>
            <li>Make sure Alpine.js is only initialized once</li>
            <li>Register the persist plugin before Alpine.start() is called</li>
            <li>Set alpineInitialized flag to true before any initialization happens</li>
        </ol>
        <p>If you're seeing the "Cannot redefine property: $persist" error, it means the persist plugin is being registered multiple times.</p>
    </div>

    <!-- IMPORTANT: Import Livewire/Alpine only at the very end -->
    <script src="/build/assets/app-Dy3k02EQ.js"></script>

    <script>
        // Check if Alpine and click counter are working
        document.addEventListener('alpine:initialized', function() {
            console.log('Alpine initialized event triggered');

            // Test click counter after a short delay
            setTimeout(function() {
                const clickCounter = document.getElementById('click-counter');
                if (clickCounter && clickCounter.innerText === '0') {
                    document.getElementById('test1-result').className = 'working';
                    document.getElementById('test1-result').innerText = 'Success: Alpine.js is working correctly';
                } else {
                    document.getElementById('test1-result').innerText = 'Error: Alpine.js is not working';
                }

                // Test persist plugin
                try {
                    const persistCounter = document.getElementById('persist-counter');
                    if (persistCounter) {
                        document.getElementById('test2-result').className = 'working';
                        document.getElementById('test2-result').innerText = 'Success: $persist plugin is working correctly';
                    }
                } catch (e) {
                    document.getElementById('test2-result').innerText = 'Error: $persist plugin is not working';
                }

                // Check global flags
                const statusInfo = document.getElementById('status-info');
                statusInfo.innerHTML = `
                    <p><strong>window.Alpine:</strong> ${window.Alpine ? 'Available ✓' : 'Not available ✗'}</p>
                    <p><strong>window.Livewire:</strong> ${window.Livewire ? 'Available ✓' : 'Not available ✗'}</p>
                    <p><strong>window.alpineInitialized:</strong> ${window.alpineInitialized}</p>
                    <p><strong>window.livewireInitialized:</strong> ${window.livewireInitialized}</p>
                `;
            }, 500);
        });
    </script>
</body>
</html>
