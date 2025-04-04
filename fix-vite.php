<?php
// Fix Vite manifest issue
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fix Vite Manifest Issue</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        h1, h2, h3 { color: #333; }
        pre { background: #f5f5f5; padding: 10px; overflow: auto; border-radius: 4px; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        .section { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Fix Vite Manifest Issue</h1>

    <div class="section">
        <h2>Problem Detected</h2>
        <p>The 500 error is caused by Laravel looking for a Vite manifest file that doesn't exist:</p>
        <pre>Vite manifest not found at: /Users/mrpixel/Documents/web/ofys/public/build/manifest.json</pre>

        <p>This happens when:</p>
        <ol>
            <li>You're using Laravel with Vite for frontend assets</li>
            <li>You deployed the application without running <code>npm run build</code> first</li>
            <li>The built assets (JavaScript, CSS) are missing from the server</li>
        </ol>
    </div>

    <?php
    $rootDir = __DIR__;
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    if ($action === 'fix') {
        echo "<div class='section'>";
        echo "<h2>Fixing the Issue</h2>";

        // Create the build directory if it doesn't exist
        $buildDir = $rootDir . '/public/build';
        if (!file_exists($buildDir)) {
            if (mkdir($buildDir, 0755, true)) {
                echo "<p class='success'>✓ Created build directory: {$buildDir}</p>";
            } else {
                echo "<p class='error'>✗ Failed to create build directory. Check permissions.</p>";
            }
        } else {
            echo "<p>Build directory already exists.</p>";
        }

        // Create an empty manifest.json file
        $manifestFile = $buildDir . '/manifest.json';
        $manifestContent = '{}';

        if (file_put_contents($manifestFile, $manifestContent)) {
            echo "<p class='success'>✓ Created empty manifest.json file</p>";
        } else {
            echo "<p class='error'>✗ Failed to create manifest.json file. Check permissions.</p>";
        }

        // Update resources/views to disable Vite
        // First, find all Blade files that might use Vite
        $viewsDir = $rootDir . '/resources/views';
        $bladeFiles = [];

        function findBladeFiles($dir, &$results) {
            $files = scandir($dir);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                $path = $dir . '/' . $file;
                if (is_dir($path)) {
                    findBladeFiles($path, $results);
                } else if (strpos($file, '.blade.php') !== false) {
                    $results[] = $path;
                }
            }
        }

        if (file_exists($viewsDir)) {
            findBladeFiles($viewsDir, $bladeFiles);

            echo "<h3>Updating Blade Files:</h3>";

            // Create a backup directory
            $backupDir = $rootDir . '/resources/views/backups';
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            // Now update each file to disable Vite
            $updatedFiles = 0;
            foreach ($bladeFiles as $file) {
                $content = file_get_contents($file);

                // Check if file uses Vite
                if (strpos($content, '@vite') !== false) {
                    // Create a backup
                    $backupFile = $backupDir . '/' . basename($file) . '.bak';
                    file_put_contents($backupFile, $content);

                    // Replace @vite directives with static CSS/JS links
                    $newContent = preg_replace('/@vite\(\[(.*?)\]\)/', '<!-- Vite disabled -->', $content);

                    // Add a simple CSS/JS fallback if needed
                    if ($newContent !== $content) {
                        file_put_contents($file, $newContent);
                        echo "<p class='success'>✓ Updated file: " . basename($file) . " (backup created)</p>";
                        $updatedFiles++;
                    }
                }
            }

            if ($updatedFiles === 0) {
                echo "<p>No Blade files with @vite directives found.</p>";
            }
        } else {
            echo "<p class='error'>✗ Views directory not found: {$viewsDir}</p>";
        }

        // Create a simple test blade file that doesn't use Vite
        $testBladePath = $viewsDir . '/test.blade.php';
        $testBladeContent = <<<'EOD'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Test Page</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { background: #f5f5f5; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laravel Test Page</h1>

        <div class="card">
            <h2>Application Works!</h2>
            <p class="success">✓ Your Laravel application is working correctly.</p>
            <p>If you see this page, it means:</p>
            <ol>
                <li>Your Laravel application is running correctly</li>
                <li>The Vite manifest issue has been resolved</li>
                <li>The route to this test page is working</li>
            </ol>
        </div>

        <div class="card">
            <h2>Next Steps</h2>
            <p>To fix this permanently, you have two options:</p>
            <ol>
                <li>Build your frontend assets with <code>npm run build</code> and upload the compiled assets to the server</li>
                <li>Modify your blade templates to not use Vite if you don't need frontend assets</li>
            </ol>
        </div>
    </div>
</body>
</html>
EOD;

        if (file_put_contents($testBladePath, $testBladeContent)) {
            echo "<p class='success'>✓ Created test view file: test.blade.php</p>";
        } else {
            echo "<p class='error'>✗ Failed to create test view file. Check permissions.</p>";
        }

        // Create a route to the test page
        $routesFile = $rootDir . '/routes/web.php';
        if (file_exists($routesFile)) {
            $routesContent = file_get_contents($routesFile);

            // Only add the test route if it doesn't already exist
            if (strpos($routesContent, "Route::get('/test'") === false) {
                $routesContent .= "\n\n// Test route to verify Laravel is working without Vite\nRoute::get('/test', function () {\n    return view('test');\n});\n";

                if (file_put_contents($routesFile, $routesContent)) {
                    echo "<p class='success'>✓ Added test route to routes/web.php</p>";
                } else {
                    echo "<p class='error'>✗ Failed to update routes file. Check permissions.</p>";
                }
            } else {
                echo "<p>Test route already exists in routes/web.php</p>";
            }
        } else {
            echo "<p class='error'>✗ Routes file not found: {$routesFile}</p>";
        }

        // Clear Laravel cache
        echo "<h3>Clearing Laravel Cache:</h3>";

        try {
            // Try to bootstrap Laravel
            require_once $rootDir . '/vendor/autoload.php';
            $app = require_once $rootDir . '/bootstrap/app.php';
            $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

            // Clear various caches
            $kernel->call('cache:clear');
            echo "<p class='success'>✓ Application cache cleared</p>";

            $kernel->call('config:clear');
            echo "<p class='success'>✓ Configuration cache cleared</p>";

            $kernel->call('route:clear');
            echo "<p class='success'>✓ Route cache cleared</p>";

            $kernel->call('view:clear');
            echo "<p class='success'>✓ View cache cleared</p>";

        } catch (Exception $e) {
            echo "<p class='error'>✗ Failed to clear Laravel cache: " . $e->getMessage() . "</p>";
            echo "<p>You may need to manually run clear cache commands.</p>";
        }

        echo "</div>";

        echo "<div class='section'>";
        echo "<h2>Fix Complete!</h2>";
        echo "<p>The Vite manifest issue should now be fixed. Try accessing your Laravel application:</p>";
        echo "<ul>";
        echo "<li><a href='https://ofys.eastbizz.com/test' target='_blank'>Visit test page</a></li>";
        echo "<li><a href='https://ofys.eastbizz.com' target='_blank'>Visit main page</a></li>";
        echo "</ul>";
        echo "</div>";

    } else {
        // Show the fix button
    ?>
    <div class="section">
        <h2>Solution</h2>
        <p>There are two ways to fix this issue:</p>

        <h3>Option 1: Create an empty manifest file (Quick Fix)</h3>
        <p>This will create an empty manifest.json file and disable Vite in your templates:</p>
        <p><a href="?action=fix" class="button">Apply Quick Fix</a></p>
        <p><strong>Note:</strong> This is a temporary solution. Your application will work, but without frontend assets.</p>

        <h3>Option 2: Build and upload frontend assets (Proper Fix)</h3>
        <p>For a proper fix, you should:</p>
        <ol>
            <li>On your local development machine, run <code>npm run build</code></li>
            <li>Upload the generated <code>public/build</code> directory to your server</li>
        </ol>
        <p>This will ensure your application has all required JavaScript and CSS files.</p>
    </div>
    <?php
    }
    ?>

    <div class="section">
        <h2>Additional Information</h2>
        <p>Laravel with Vite requires compiled frontend assets to run properly in production.</p>
        <p>When you use <code>@vite</code> directives in your Blade templates, Laravel looks for a manifest file to determine which assets to load.</p>
        <p>This error occurs because:</p>
        <ul>
            <li>The application is looking for the file at: <code>/Users/mrpixel/Documents/web/ofys/public/build/manifest.json</code></li>
            <li>But this file doesn't exist on your server because frontend assets haven't been built</li>
        </ul>
    </div>
</body>
</html>
