<?php
// Path Test for OFYS Server Tests
?>
<!DOCTYPE html>
<html>
<head>
    <title>OFYS Server Tests - Path Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2, h3 {
            color: #333;
        }
        pre {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
        code {
            background-color: #f5f5f5;
            padding: 2px 4px;
            border-radius: 3px;
        }
        .test-section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .success {
            color: green;
        }
        .warning {
            color: orange;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>OFYS Server Tests - Path Test</h1>

    <div class="test-section">
        <h2>Server Information</h2>
        <table>
            <tr>
                <th>Item</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>PHP Version</td>
                <td><?php echo phpversion(); ?></td>
            </tr>
            <tr>
                <td>Server Software</td>
                <td><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Not available'; ?></td>
            </tr>
            <tr>
                <td>Operating System</td>
                <td><?php echo PHP_OS; ?></td>
            </tr>
            <tr>
                <td>Server Name</td>
                <td><?php echo $_SERVER['SERVER_NAME'] ?? 'Not available'; ?></td>
            </tr>
            <tr>
                <td>Server IP</td>
                <td><?php echo $_SERVER['SERVER_ADDR'] ?? 'Not available'; ?></td>
            </tr>
            <tr>
                <td>Remote IP</td>
                <td><?php echo $_SERVER['REMOTE_ADDR'] ?? 'Not available'; ?></td>
            </tr>
        </table>
    </div>

    <div class="test-section">
        <h2>Path Information</h2>
        <table>
            <tr>
                <th>Path</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Current Script Path</td>
                <td><?php echo $_SERVER['SCRIPT_FILENAME'] ?? 'Not available'; ?></td>
            </tr>
            <tr>
                <td>Document Root</td>
                <td><?php echo $_SERVER['DOCUMENT_ROOT'] ?? 'Not available'; ?></td>
            </tr>
            <tr>
                <td>Current Working Directory</td>
                <td><?php echo getcwd(); ?></td>
            </tr>
            <tr>
                <td>Request URI</td>
                <td><?php echo $_SERVER['REQUEST_URI'] ?? 'Not available'; ?></td>
            </tr>
            <tr>
                <td>Script Name</td>
                <td><?php echo $_SERVER['SCRIPT_NAME'] ?? 'Not available'; ?></td>
            </tr>
            <tr>
                <td>PHP_SELF</td>
                <td><?php echo $_SERVER['PHP_SELF'] ?? 'Not available'; ?></td>
            </tr>
            <tr>
                <td>Directory of this script</td>
                <td><?php echo dirname(__FILE__); ?></td>
            </tr>
            <tr>
                <td>Parent directory</td>
                <td><?php echo dirname(dirname(__FILE__)); ?></td>
            </tr>
        </table>
    </div>

    <div class="test-section">
        <h2>Directory Structure</h2>
        <?php
        // Function to display directory structure
        function displayDirectoryStructure($dir, $indent = 0, $maxDepth = 3, $currentDepth = 0) {
            if ($currentDepth > $maxDepth) {
                echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $indent) . "... (max depth reached)\n";
                return;
            }

            if (!is_dir($dir)) {
                echo "<div class='error'>Error: $dir is not a valid directory</div>";
                return;
            }

            try {
                $files = scandir($dir);

                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        $fullPath = $dir . '/' . $file;

                        echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $indent);

                        if (is_dir($fullPath)) {
                            echo "📁 <strong>$file</strong><br>";

                            // Don't go into vendor, node_modules, or storage directories
                            if ($file != 'vendor' && $file != 'node_modules' && $file != 'storage' && $currentDepth < $maxDepth) {
                                displayDirectoryStructure($fullPath, $indent + 1, $maxDepth, $currentDepth + 1);
                            } else if ($file == 'vendor' || $file == 'node_modules' || $file == 'storage') {
                                echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $indent + 1) . "... (directory skipped)\n<br>";
                            }
                        } else {
                            echo "📄 $file<br>";
                        }
                    }
                }
            } catch (Exception $e) {
                echo "<div class='error'>Error: " . $e->getMessage() . "</div>";
            }
        }

        // Get parent directory of the current script
        $baseDir = dirname(dirname(__FILE__));
        echo "<h3>Project Structure (max depth: 3)</h3>";
        echo "<pre style='font-family: monospace;'>";
        echo "📁 <strong>" . basename($baseDir) . "</strong><br>";
        displayDirectoryStructure($baseDir, 1);
        echo "</pre>";
        ?>
    </div>

    <div class="test-section">
        <h2>File Permissions</h2>
        <?php
        // Check important Laravel directories
        $directoriesToCheck = [
            'storage' => dirname(dirname(__FILE__)) . '/storage',
            'bootstrap/cache' => dirname(dirname(__FILE__)) . '/bootstrap/cache',
            'public' => dirname(dirname(__FILE__)) . '/public',
        ];

        echo "<table>";
        echo "<tr><th>Directory</th><th>Exists</th><th>Permissions</th><th>Writable</th></tr>";

        foreach ($directoriesToCheck as $name => $path) {
            $exists = is_dir($path);
            $permissions = $exists ? substr(sprintf('%o', fileperms($path)), -4) : 'N/A';
            $writable = $exists ? is_writable($path) : false;

            echo "<tr>";
            echo "<td>$name</td>";
            echo "<td>" . ($exists ? '<span class="success">Yes</span>' : '<span class="error">No</span>') . "</td>";
            echo "<td>$permissions</td>";
            echo "<td>" . ($writable ? '<span class="success">Yes</span>' : '<span class="error">No</span>') . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        ?>
    </div>

    <div class="test-section">
        <h2>URL Information</h2>
        <?php
        // Function to get full URL
        function getCurrentUrl() {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $uri = $_SERVER['REQUEST_URI'] ?? '';
            return $protocol . $host . $uri;
        }

        $currentUrl = getCurrentUrl();
        $parsedUrl = parse_url($currentUrl);
        ?>

        <table>
            <tr>
                <th>Component</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Full URL</td>
                <td><?php echo $currentUrl; ?></td>
            </tr>
            <tr>
                <td>Protocol</td>
                <td><?php echo $parsedUrl['scheme']; ?></td>
            </tr>
            <tr>
                <td>Host</td>
                <td><?php echo $parsedUrl['host']; ?></td>
            </tr>
            <tr>
                <td>Port</td>
                <td><?php echo isset($parsedUrl['port']) ? $parsedUrl['port'] : 'Default'; ?></td>
            </tr>
            <tr>
                <td>Path</td>
                <td><?php echo $parsedUrl['path']; ?></td>
            </tr>
            <tr>
                <td>Query</td>
                <td><?php echo isset($parsedUrl['query']) ? $parsedUrl['query'] : 'None'; ?></td>
            </tr>
        </table>
    </div>

    <div class="test-section">
        <h2>Laravel Specific Information</h2>
        <?php
        // Check if this is a Laravel installation by looking for key files
        $laravelFiles = [
            'artisan' => dirname(dirname(__FILE__)) . '/artisan',
            'composer.json' => dirname(dirname(__FILE__)) . '/composer.json',
            '.env' => dirname(dirname(__FILE__)) . '/.env',
            'app/Providers/AppServiceProvider.php' => dirname(dirname(__FILE__)) . '/app/Providers/AppServiceProvider.php',
        ];

        $isLaravel = true;
        foreach ($laravelFiles as $file) {
            if (!file_exists($file)) {
                $isLaravel = false;
                break;
            }
        }

        if ($isLaravel) {
            echo "<div class='success'>Laravel installation detected!</div>";

            // Try to check Laravel version if composer.json exists
            $composerJson = dirname(dirname(__FILE__)) . '/composer.json';
            if (file_exists($composerJson)) {
                $composer = json_decode(file_get_contents($composerJson), true);
                $laravelVersion = $composer['require']['laravel/framework'] ?? 'Unknown';
                echo "<p>Laravel version (from composer.json): $laravelVersion</p>";
            }

            // Try to get .env APP_URL
            $envFile = dirname(dirname(__FILE__)) . '/.env';
            if (file_exists($envFile)) {
                $envContents = file_get_contents($envFile);
                preg_match('/APP_URL=(.*)/', $envContents, $matches);
                $appUrl = $matches[1] ?? 'Not set';
                echo "<p>APP_URL in .env: $appUrl</p>";

                // Check if APP_URL matches current URL
                $currentHost = $parsedUrl['host'];
                if (strpos($appUrl, $currentHost) === false) {
                    echo "<p class='warning'>Warning: Your APP_URL ($appUrl) doesn't match your current host ($currentHost). This might cause issues with asset loading.</p>";
                }
            }
        } else {
            echo "<div class='warning'>This doesn't appear to be a Laravel installation.</div>";
        }
        ?>
    </div>

    <div class="test-section">
        <h2>Recommendations</h2>
        <?php
        // Provide recommendations based on findings
        $recommendations = [];

        // Check document root vs script location
        $scriptDir = dirname(dirname(__FILE__));
        $docRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';

        if (strpos($scriptDir, $docRoot) === 0) {
            // The script is within document root
            $publicPath = $scriptDir . '/public';
            if (is_dir($publicPath)) {
                $recommendations[] = "Your Laravel installation's 'public' directory is not your document root. For security, consider setting your web server's document root to: $publicPath";
            }
        }

        // Check storage permissions
        $storagePath = $scriptDir . '/storage';
        if (is_dir($storagePath) && !is_writable($storagePath)) {
            $recommendations[] = "The storage directory is not writable. Run: chmod -R 775 $storagePath";
        }

        // Check bootstrap/cache permissions
        $cachePath = $scriptDir . '/bootstrap/cache';
        if (is_dir($cachePath) && !is_writable($cachePath)) {
            $recommendations[] = "The bootstrap/cache directory is not writable. Run: chmod -R 775 $cachePath";
        }

        // Check .env file
        $envFile = $scriptDir . '/.env';
        if (!file_exists($envFile)) {
            $recommendations[] = "The .env file is missing. Create one from .env.example with: cp .env.example .env";
        }

        if (empty($recommendations)) {
            echo "<p class='success'>No specific path-related issues detected.</p>";
        } else {
            echo "<ul>";
            foreach ($recommendations as $recommendation) {
                echo "<li>$recommendation</li>";
            }
            echo "</ul>";
        }
        ?>
    </div>

    <!-- Navigation -->
    <hr>
    <h3>Navigation</h3>
    <ul>
        <li><a href="asset-test.php">Asset Test</a></li>
        <li><a href="path-test.php">Path Test</a></li>
        <li><a href="mime-test.php">MIME Test</a></li>
        <li><a href="htaccess-test.php">Htaccess Test</a></li>
        <li><a href="asset-proxy-test.php">Asset Proxy Test</a></li>
        <li><a href="instructions.php">Instructions</a></li>
    </ul>
</body>
</html>
