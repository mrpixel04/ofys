<?php
$title = "Laravel URL Format Test";
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

function testUrl($url, $timeout = 2) {
    $context = stream_context_create([
        'http' => ['timeout' => $timeout]
    ]);

    $result = @file_get_contents($url, false, $context);
    $success = $result !== false;

    // Create simple status indicator
    if ($success) {
        $status = 200;
        $message = "Success";
    } else {
        $error = error_get_last();
        $status = 404;
        $message = $error ? $error['message'] : "Failed";
    }

    return [
        'url' => $url,
        'status' => $status,
        'message' => $message,
        'success' => $success
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
        .alert { padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .alert-info { background-color: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $title ?></h1>

        <div class="alert alert-info">
            <p><strong>Problem Diagnosis:</strong> Testing URL formats with and without <code>/index.php/</code> in the path.</p>
            <p>When using PHP's built-in development server (<code>php artisan serve</code>), URLs must include <code>/index.php/</code>.</p>
            <p>On production servers with proper URL rewriting (Apache/Nginx), the <code>/index.php/</code> part should be optional.</p>
        </div>

        <div class="test-section">
            <h2>URL Format Test for Provider Routes</h2>

            <?php
            $routes = [
                'Home' => '/',
                'Provider Dashboard' => '/provider/dashboard',
                'Provider Activities' => '/provider/activities',
                'Simple Activities' => '/provider/simple-activities',
            ];

            echo "<table>";
            echo "<tr>
                <th>Page</th>
                <th>Normal URL</th>
                <th>Status</th>
                <th>With index.php</th>
                <th>Status</th>
            </tr>";

            foreach ($routes as $name => $path) {
                $normalUrl = $baseUrl . $path;
                $indexUrl = $baseUrl . '/index.php' . $path;

                $normalTest = testUrl($normalUrl);
                $indexTest = testUrl($indexUrl);

                echo "<tr>";
                echo "<td>$name</td>";
                echo "<td><code>" . htmlspecialchars($normalUrl) . "</code></td>";
                echo "<td class='" . ($normalTest['success'] ? 'success' : 'failure') . "'>" .
                     $normalTest['status'] . "</td>";
                echo "<td><code>" . htmlspecialchars($indexUrl) . "</code></td>";
                echo "<td class='" . ($indexTest['success'] ? 'success' : 'failure') . "'>" .
                     $indexTest['status'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            ?>
        </div>

        <div class="test-section">
            <h2>Asset URLs (should work without index.php)</h2>

            <?php
            $assets = [
                'CSS' => '/css/app.css',
                'JavaScript' => '/js/app.js',
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
                     $test['status'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            ?>
        </div>

        <div class="test-section">
            <h2>Recommendation</h2>
            <p>Based on the test results:</p>
            <ul>
                <li>For your <strong>localhost development</strong>: Use URLs with <code>/index.php/</code></li>
                <li>For your <strong>production server</strong>: Configure URL rewriting properly to make URLs work without <code>/index.php/</code></li>
            </ul>
            <p>On your provider pages, make sure forms and links use the correct URL format for the environment.</p>
        </div>
    </div>
</body>
</html>
