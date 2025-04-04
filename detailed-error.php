<?php
// Detailed error logger for Laravel
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laravel Error Detective</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        h1, h2, h3 { color: #333; }
        pre { background: #f5f5f5; padding: 10px; overflow: auto; border-radius: 4px; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        .section { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Laravel Error Detective</h1>

    <div class="section">
        <h2>1. Current Environment</h2>
        <?php
        echo "<p>Current PHP version: " . phpversion() . "</p>";
        echo "<p>Current working directory: " . getcwd() . "</p>";
        echo "<p>Script path: " . __FILE__ . "</p>";

        // Get Laravel root directory
        $laravelRoot = __DIR__;
        echo "<p>Laravel root: " . $laravelRoot . "</p>";
        ?>
    </div>

    <div class="section">
        <h2>2. Error Log Check</h2>
        <?php
        $errorLogPath = $laravelRoot . '/storage/logs/laravel.log';

        if (file_exists($errorLogPath)) {
            echo "<p>Found Laravel log file at: {$errorLogPath}</p>";

            // Get the last 100 lines of the log file to capture more context
            $logContent = file_get_contents($errorLogPath);

            // Parse the log to find the most recent error
            $logEntries = explode('[', $logContent);
            $recentErrors = [];

            // Look for error patterns
            foreach ($logEntries as $entry) {
                if (strpos($entry, 'ERROR') !== false ||
                    strpos($entry, 'Exception') !== false ||
                    strpos($entry, 'Error:') !== false) {
                    $recentErrors[] = '[' . $entry;

                    // Collect up to 5 recent errors
                    if (count($recentErrors) >= 5) {
                        break;
                    }
                }
            }

            if (!empty($recentErrors)) {
                echo "<h3>Most Recent Errors:</h3>";
                echo "<pre>" . htmlspecialchars(implode("\n", $recentErrors)) . "</pre>";
            } else {
                echo "<p>No clear error entries found in the log. Showing last 50 lines:</p>";

                // Get last 50 lines
                $lines = file($errorLogPath);
                $last_lines = array_slice($lines, -50);
                echo "<pre>" . htmlspecialchars(implode("", $last_lines)) . "</pre>";
            }
        } else {
            echo "<p class='error'>Laravel log file not found at: {$errorLogPath}</p>";

            // Check if the storage/logs directory exists and is writable
            $logsDir = $laravelRoot . '/storage/logs';
            if (!file_exists($logsDir)) {
                echo "<p class='error'>The logs directory does not exist: {$logsDir}</p>";

                // Try to create it
                if (mkdir($logsDir, 0755, true)) {
                    echo "<p class='success'>Created logs directory: {$logsDir}</p>";
                } else {
                    echo "<p class='error'>Failed to create logs directory. Check permissions.</p>";
                }
            } elseif (!is_writable($logsDir)) {
                echo "<p class='error'>The logs directory is not writable: {$logsDir}</p>";

                // Try to make it writable
                if (chmod($logsDir, 0755)) {
                    echo "<p class='success'>Made logs directory writable.</p>";
                } else {
                    echo "<p class='error'>Failed to make logs directory writable.</p>";
                }
            }

            // Check PHP error log
            $phpErrorLog = ini_get('error_log');
            if ($phpErrorLog && file_exists($phpErrorLog)) {
                echo "<p>Found PHP error log at: {$phpErrorLog}</p>";

                // Get last 50 lines
                $lines = file($phpErrorLog);
                $last_lines = array_slice($lines, -50);
                echo "<pre>" . htmlspecialchars(implode("", $last_lines)) . "</pre>";
            }
        }
        ?>
    </div>

    <div class="section">
        <h2>3. Testing Laravel Bootstrap</h2>
        <?php
        try {
            // Try to bootstrap Laravel
            require $laravelRoot . '/vendor/autoload.php';
            echo "<p class='success'>✓ Successfully loaded Composer autoloader</p>";

            try {
                $app = require_once $laravelRoot . '/bootstrap/app.php';
                echo "<p class='success'>✓ Successfully bootstrapped Laravel application</p>";

                try {
                    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
                    echo "<p class='success'>✓ Successfully created console kernel</p>";

                    // Get Laravel version
                    echo "<p>Laravel version: " . $app->version() . "</p>";

                    // Check key Laravel services
                    echo "<h3>Checking Laravel Services:</h3>";
                    try {
                        $db = $app->make('db');
                        echo "<p class='success'>✓ Database service available</p>";

                        try {
                            $connection = $db->connection();
                            echo "<p class='success'>✓ Database connection established</p>";
                        } catch (Exception $e) {
                            echo "<p class='error'>✗ Database connection failed: " . $e->getMessage() . "</p>";
                        }
                    } catch (Exception $e) {
                        echo "<p class='error'>✗ Database service not available: " . $e->getMessage() . "</p>";
                    }

                } catch (Exception $e) {
                    echo "<p class='error'>✗ Failed to create console kernel: " . $e->getMessage() . "</p>";
                }

            } catch (Exception $e) {
                echo "<p class='error'>✗ Failed to bootstrap Laravel: " . $e->getMessage() . "</p>";
            }

        } catch (Exception $e) {
            echo "<p class='error'>✗ Failed to load Composer autoloader: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>4. Environment File Check</h2>
        <?php
        $envFile = $laravelRoot . '/.env';
        if (file_exists($envFile)) {
            echo "<p class='success'>✓ .env file exists</p>";

            // Check if key settings are present
            $env = file_get_contents($envFile);
            $necessaryKeys = [
                'APP_KEY' => 'Application encryption key',
                'APP_ENV' => 'Application environment',
                'APP_DEBUG' => 'Debug mode',
                'APP_URL' => 'Application URL',
                'DB_CONNECTION' => 'Database connection type',
                'DB_HOST' => 'Database host',
                'DB_PORT' => 'Database port',
                'DB_DATABASE' => 'Database name',
                'DB_USERNAME' => 'Database username',
                'DB_PASSWORD' => 'Database password'
            ];

            echo "<h3>Key Environment Settings:</h3>";
            echo "<ul>";

            foreach ($necessaryKeys as $key => $description) {
                if (preg_match("/{$key}=(.*)/", $env, $matches)) {
                    $value = $matches[1];

                    // Hide password
                    if ($key === 'DB_PASSWORD') {
                        $value = !empty($value) ? '******** (set)' : '(empty)';
                    }

                    if (!empty($value)) {
                        echo "<li class='success'>{$key}: {$value}</li>";
                    } else {
                        echo "<li class='error'>{$key} is empty</li>";
                    }
                } else {
                    echo "<li class='error'>{$key} is missing</li>";
                }
            }

            echo "</ul>";

        } else {
            echo "<p class='error'>✗ .env file does not exist at {$envFile}</p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>5. Directory Permissions</h2>
        <?php
        $directories = [
            $laravelRoot . '/storage' => 'Main storage directory',
            $laravelRoot . '/storage/app' => 'Application storage',
            $laravelRoot . '/storage/framework' => 'Framework storage',
            $laravelRoot . '/storage/framework/cache' => 'Cache storage',
            $laravelRoot . '/storage/framework/sessions' => 'Sessions storage',
            $laravelRoot . '/storage/framework/views' => 'Views storage',
            $laravelRoot . '/storage/logs' => 'Logs storage',
            $laravelRoot . '/bootstrap/cache' => 'Bootstrap cache'
        ];

        echo "<h3>Directory Permissions:</h3>";
        echo "<ul>";

        foreach ($directories as $directory => $description) {
            if (file_exists($directory)) {
                $permissions = substr(sprintf('%o', fileperms($directory)), -4);
                $isWritable = is_writable($directory);

                if ($isWritable) {
                    echo "<li class='success'>{$directory}: {$permissions} (writable)</li>";
                } else {
                    echo "<li class='error'>{$directory}: {$permissions} (not writable)</li>";
                }
            } else {
                echo "<li class='error'>{$directory}: does not exist</li>";
            }
        }

        echo "</ul>";
        ?>
    </div>

    <div class="section">
        <h2>6. Public Directory Setup</h2>
        <?php
        $publicDir = $laravelRoot . '/public';
        $indexFile = $publicDir . '/index.php';
        $htaccessFile = $publicDir . '/.htaccess';

        if (file_exists($publicDir)) {
            echo "<p class='success'>✓ Public directory exists</p>";

            if (file_exists($indexFile)) {
                echo "<p class='success'>✓ Public index.php exists</p>";
            } else {
                echo "<p class='error'>✗ Public index.php does not exist</p>";
            }

            if (file_exists($htaccessFile)) {
                echo "<p class='success'>✓ Public .htaccess exists</p>";

                // Check if .htaccess contains necessary rewrite rules
                $htaccess = file_get_contents($htaccessFile);
                if (strpos($htaccess, 'RewriteEngine On') !== false) {
                    echo "<p class='success'>✓ .htaccess contains rewrite rules</p>";
                } else {
                    echo "<p class='error'>✗ .htaccess may be missing rewrite rules</p>";
                }
            } else {
                echo "<p class='error'>✗ Public .htaccess does not exist</p>";
            }
        } else {
            echo "<p class='error'>✗ Public directory does not exist</p>";
        }

        // Check root index.php
        $rootIndex = $laravelRoot . '/index.php';
        if (file_exists($rootIndex)) {
            echo "<p class='success'>✓ Root index.php exists (bridge file)</p>";
        } else {
            echo "<p class='error'>✗ Root index.php does not exist (bridge file missing)</p>";
        }

        // Check root .htaccess
        $rootHtaccess = $laravelRoot . '/.htaccess';
        if (file_exists($rootHtaccess)) {
            echo "<p class='success'>✓ Root .htaccess exists</p>";
        } else {
            echo "<p class='error'>✗ Root .htaccess does not exist</p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>7. Required PHP Extensions</h2>
        <?php
        $requiredExtensions = [
            'openssl' => 'OpenSSL for secure communications',
            'pdo' => 'PDO for database access',
            'mbstring' => 'Multibyte String support',
            'tokenizer' => 'Tokenizer for parsing',
            'xml' => 'XML processing',
            'ctype' => 'Character type checking',
            'json' => 'JSON support',
            'bcmath' => 'Arbitrary precision mathematics',
            'fileinfo' => 'File information',
            'pdo_mysql' => 'MySQL database driver'
        ];

        echo "<h3>PHP Extensions:</h3>";
        echo "<ul>";

        foreach ($requiredExtensions as $extension => $description) {
            if (extension_loaded($extension)) {
                echo "<li class='success'>✓ {$extension}: loaded</li>";
            } else {
                echo "<li class='error'>✗ {$extension}: not loaded</li>";
            }
        }

        echo "</ul>";
        ?>
    </div>

    <div class="section">
        <h2>8. Common Fixes</h2>
        <ol>
            <li>Try clearing the Laravel cache with the following script:</li>
        </ol>

        <?php
        // Generate cache clear script
        $cacheClearScript = $laravelRoot . '/clear-cache.php';
        $cacheClearContent = '<?php
// Clear Laravel caches
require __DIR__ . \'/vendor/autoload.php\';
$app = require_once __DIR__ . \'/bootstrap/app.php\';
$kernel = $app->make(Illuminate\\Contracts\\Console\\Kernel::class);

echo "Clearing application cache...\n";
$kernel->call(\'cache:clear\');

echo "Clearing configuration cache...\n";
$kernel->call(\'config:clear\');

echo "Clearing route cache...\n";
$kernel->call(\'route:clear\');

echo "Clearing view cache...\n";
$kernel->call(\'view:clear\');

echo "All caches cleared!\n";
';

        // Write cache clear script to file
        if (file_put_contents($cacheClearScript, $cacheClearContent)) {
            echo "<p class='success'>Created cache clear script: <a href='clear-cache.php'>clear-cache.php</a></p>";
        } else {
            echo "<p class='error'>Failed to create cache clear script.</p>";
        }
        ?>

        <ol start="2">
            <li>Check that your <code>.env</code> file has the correct APP_ENV setting:</li>
            <pre>APP_ENV=production
APP_DEBUG=false</pre>

            <li>Make sure all Laravel directories have correct permissions:</li>
            <pre>chmod -R 755 storage bootstrap/cache</pre>

            <li>Ensure your web server has the correct document root configuration:</li>
            <pre>DocumentRoot /home2/eastbizz/public_html/ofys/public</pre>

            <li>If using shared hosting with a subdomain pointing to public_html/ofys, make sure there's a proper bridge file in the root:</li>
        </ol>
    </div>

    <div class="section">
        <h2>Next Steps</h2>
        <ol>
            <li>Check the detailed error information above to identify the specific issue</li>
            <li>Run the <a href="clear-cache.php">clear-cache.php</a> script to clear Laravel's caches</li>
            <li>Verify your database connection with <a href="test-db.php">test-db.php</a></li>
            <li>Make sure all file permissions are correct</li>
            <li>If all else fails, contact your hosting provider and share this diagnostic information</li>
        </ol>
    </div>
</body>
</html>
