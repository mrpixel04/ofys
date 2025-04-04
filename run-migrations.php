<?php
// Run Laravel migrations
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laravel Migration Runner</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        h1, h2 { color: #333; }
        pre { background: #f5f5f5; padding: 10px; overflow: auto; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
    </style>
</head>
<body>
    <h1>Laravel Migration Runner</h1>

    <?php
    // Security check - consider adding a password protection
    if (!isset($_GET['run']) || $_GET['run'] !== 'yes') {
        echo "<div class='warning'>";
        echo "<p>⚠️ This script will run Laravel migrations on your database.</p>";
        echo "<p>This might alter or delete data. Make sure you have a backup before proceeding.</p>";
        echo "<p><a href='?run=yes' onclick=\"return confirm('Are you sure you want to run migrations? This might alter your database.');\">Run Migrations</a></p>";
        echo "</div>";
        exit;
    }

    echo "<div>";
    echo "<p>Starting migration process...</p>";

    try {
        // Use Laravel's autoloader
        require __DIR__ . '/vendor/autoload.php';

        // Bootstrap Laravel
        $app = require_once __DIR__ . '/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

        // Start output buffering to capture migration output
        ob_start();

        // Run the migrations
        $status = $kernel->call('migrate', ['--force' => true]);

        // Get output and close buffer
        $output = ob_get_clean();

        // Display results
        if ($status === 0) {
            echo "<p class='success'>✓ Migrations completed successfully!</p>";
        } else {
            echo "<p class='error'>✗ Migrations failed (status code: {$status})</p>";
        }

        echo "<h2>Migration Output:</h2>";
        echo "<pre>" . htmlspecialchars($output) . "</pre>";

    } catch (Exception $e) {
        echo "<p class='error'>✗ Error: " . $e->getMessage() . "</p>";

        if ($e instanceof ErrorException && strpos($e->getMessage(), 'proc_open') !== false) {
            echo "<p>Your hosting environment may not allow proc_open. Trying alternative method...</p>";

            try {
                // Alternative approach using direct Artisan access
                define('LARAVEL_START', microtime(true));

                // Use the application autoloader
                require __DIR__ . '/vendor/autoload.php';

                // Load the application
                $app = require_once __DIR__ . '/bootstrap/app.php';

                // Get the Artisan console application
                $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

                // Run the migrations directly
                $status = $kernel->handle(
                    new Symfony\Component\Console\Input\ArrayInput(['command' => 'migrate', '--force' => true]),
                    new Symfony\Component\Console\Output\BufferedOutput()
                );

                // Display result
                if ($status === 0) {
                    echo "<p class='success'>✓ Migrations completed successfully (alternative method)!</p>";
                } else {
                    echo "<p class='error'>✗ Migrations failed (alternative method, status code: {$status})</p>";
                }

            } catch (Exception $e2) {
                echo "<p class='error'>✗ Alternative method also failed: " . $e2->getMessage() . "</p>";
            }
        }
    }
    echo "</div>";

    echo "<h2>Next Steps</h2>";
    echo "<ol>";
    echo "<li>Check that migrations ran successfully.</li>";
    echo "<li>Verify database tables were created using <a href='test-db.php'>database test script</a>.</li>";
    echo "<li>Access your Laravel application at <a href='https://ofys.eastbizz.com'>https://ofys.eastbizz.com</a></li>";
    echo "</ol>";
    ?>
</body>
</html>
