<?php
// Set a reasonable timeout
set_time_limit(60);

$title = "Asset Compatibility Test (Simple)";
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$isLocalhost = (strpos($baseUrl, 'localhost') !== false || strpos($baseUrl, '127.0.0.1') !== false);

function testUrl($url, $timeout = 2) {
    // Simple file_get_contents with a timeout to prevent hanging
    $context = stream_context_create([
        'http' => [
            'timeout' => $timeout
        ]
    ]);

    $result = @file_get_contents($url, false, $context);

    return [
        'url' => $url,
        'status' => $result !== false ? 200 : 404,
        'success' => $result !== false
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        h1, h2, h3 { color: #333; }
        .container { max-width: 1200px; margin: 0 auto; }
        .test-section { margin-bottom: 30px; border: 1px solid #ddd; padding: 20px; border-radius: 5px; }
        .success { color: green; }
        .failure { color: red; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        code { background: #f5f5f5; padding: 2px 5px; border-radius: 3px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $title ?></h1>

        <div class="test-section" style="background-color: #f8d7da; border-color: #f5c6cb;">
            <h2>⚠️ Simplified Test</h2>
            <p>The full test was timing out. This is a simplified version with basic checks.</p>
            <p>Current URL: <code><?= $baseUrl ?></code></p>
        </div>

        <div class="test-section">
            <h2>Basic Route Tests</h2>

            <?php
            $routes = [
                'Home' => '/',
                'Provider Dashboard' => '/provider/dashboard',
                'Provider Profile' => '/provider/profile',
                'Provider Activities' => '/provider/activities',
                'Simple Activities' => '/provider/simple-activities',
            ];

            echo "<table>";
            echo "<tr><th>Page</th><th>URL</th><th>Status</th></tr>";

            foreach ($routes as $name => $path) {
                $url = $baseUrl . $path;
                $test = testUrl($url);

                echo "<tr>";
                echo "<td>$name</td>";
                echo "<td><code>" . htmlspecialchars($url) . "</code></td>";
                echo "<td class='" . ($test['success'] ? 'success' : 'failure') . "'>" .
                     $test['status'] . " " . ($test['success'] ? '✓' : '✗') . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            ?>
        </div>

        <div class="test-section">
            <h2>Basic Asset Tests</h2>

            <?php
            $assets = [
                'CSS' => '/css/app.css',
                'JavaScript' => '/js/app.js',
                'Provider CSS' => '/provider/css/provider.css',
                'Provider JS' => '/provider/js/provider.js',
                'Image' => '/images/logo.png',
            ];

            echo "<table>";
            echo "<tr><th>Asset</th><th>URL</th><th>Status</th></tr>";

            foreach ($assets as $name => $path) {
                $url = $baseUrl . $path;
                $test = testUrl($url);

                echo "<tr>";
                echo "<td>$name</td>";
                echo "<td><code>" . htmlspecialchars($url) . "</code></td>";
                echo "<td class='" . ($test['success'] ? 'success' : 'failure') . "'>" .
                     $test['status'] . " " . ($test['success'] ? '✓' : '✗') . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            ?>
        </div>

        <div class="test-section">
            <h2>Server Environment (Basic)</h2>
            <p>Server software: <code><?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></code></p>
            <p>PHP version: <code><?= phpversion() ?></code></p>
            <p>Document root: <code><?= $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown' ?></code></p>
            <p>Script filename: <code><?= $_SERVER['SCRIPT_FILENAME'] ?? 'Unknown' ?></code></p>
        </div>
    </div>
</body>
</html>