<?php
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clean Alpine.js Test</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .counter { padding: 15px; border: 1px solid #ddd; margin: 15px 0; border-radius: 8px; }
        button { padding: 8px 15px; background: #0366d6; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .status { margin: 20px 0; padding: 15px; border-radius: 8px; }
        .success { background: #e6ffed; border-left: 4px solid #28a745; }
        .error { background: #ffeef0; border-left: 4px solid #d73a49; }
    </style>

    <!-- Load Alpine.js with CDN -->
    <script defer src="https://unpkg.com/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/@alpinejs/persist@3.13.3/dist/cdn.min.js"></script>
</head>
<body>
    <h1>Clean Alpine.js Test</h1>

    <p>This page has just Alpine.js and the persist plugin loaded directly from CDN - no Laravel or custom code.</p>

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

    <div id="status"></div>

    <script>
        document.addEventListener('alpine:initialized', () => {
            const status = document.getElementById('status');
            status.className = 'status success';
            status.innerHTML = '<h3>✅ Alpine initialized successfully!</h3>' +
                '<p>If you can click the buttons and the counters increment, everything is working correctly.</p>';
        });
    </script>
</body>
</html>
