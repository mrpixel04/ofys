<?php
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alpine.js Fix Test</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        button { padding: 8px 15px; background: #0366d6; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .counter { padding: 15px; border: 1px solid #ddd; margin: 15px 0; border-radius: 4px; }
    </style>

    <!-- DIRECT FIX for Alpine $persist error -->
    <script>
        // Patch Object.defineProperty to prevent $persist redefinition
        (function() {
            // Save original method
            const originalDefineProperty = Object.defineProperty;
            let persistDefined = false;

            // Override to catch $persist definition
            Object.defineProperty = function(obj, prop, descriptor) {
                // Only prevent $persist from being redefined
                if (prop === '$persist') {
                    if (persistDefined) {
                        console.log('Prevented $persist redefinition');
                        return obj;
                    }
                    persistDefined = true;
                }
                return originalDefineProperty.call(this, obj, prop, descriptor);
            };

            console.log('Alpine $persist protection installed');
        })();
    </script>
</head>
<body>
    <h1>Alpine.js Fix Test</h1>

    <p>This page tests if the Alpine.js and Livewire fix works properly.</p>

    <div class="counter" x-data="{ count: 0 }">
        <h3>Basic Counter</h3>
        <p>Current count: <span x-text="count">0</span></p>
        <button @click="count++">Increment</button>
    </div>

    <div class="counter" x-data="{ persistedCount: $persist(0) }">
        <h3>Persisted Counter</h3>
        <p>This value persists after refresh: <span x-text="persistedCount">0</span></p>
        <button @click="persistedCount++">Increment Persisted</button>
    </div>

    <p>If you can click the buttons and the numbers increment without errors, the fix is working!</p>

    <!-- Load Alpine & Livewire from the compiled bundle -->
    <script src="/build/assets/app-CwZwSUVa.js"></script>

    <!-- Let's load Alpine a second time to verify our fix handles duplicate loads -->
    <script>
        // Wait a bit then try to load Alpine again
        setTimeout(() => {
            console.log('Attempting to load Alpine.js a second time...');
            try {
                // This should be prevented by our fix
                if (window.Alpine) {
                    console.log('Alpine already exists, trying to start it again');
                    window.Alpine.start();
                }
            } catch (e) {
                console.error('Error when trying to start Alpine again:', e);
            }
        }, 1000);
    </script>
</body>
</html>
