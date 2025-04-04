<?php
// Laravel Error Checker for Shared Hosting
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laravel Error Diagnostic</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        h1, h2 { color: #333; }
        pre { background: #f5f5f5; padding: 10px; overflow: auto; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Laravel Error Diagnostic</h1>

    <?php
    // Check Laravel installation
    $basePath = __DIR__;
    echo "<h2>1. Checking Laravel Installation</h2>";

    // Check important files
    $requiredFiles = [
        'artisan',
        'public/index.php',
        'app/Http/Kernel.php',
        'bootstrap/app.php',
        '.env'
    ];

    $allFilesExist = true;
    echo "<ul>";
    foreach ($requiredFiles as $file) {
        if (file_exists($basePath . '/' . $file)) {
            echo "<li class='success'>✓ {$file} exists</li>";
        } else {
            echo "<li class='error'>✗ {$file} does not exist</li>";
            $allFilesExist = false;
        }
    }
    echo "</ul>";

    if (!$allFilesExist) {
        echo "<p class='error'>Some required Laravel files are missing. Please check your installation.</p>";
    }

    // Check Laravel error log
    echo "<h2>2. Laravel Error Log</h2>";
    $logFile = $basePath . '/storage/logs/laravel.log';

    if (file_exists($logFile)) {
        echo "<p>Found Laravel log file. Last 20 lines:</p>";
        $log = file($logFile);
        if (count($log) > 0) {
            $lastLines = array_slice($log, -20);
            echo "<pre>";
            foreach ($lastLines as $line) {
                echo htmlspecialchars($line);
            }
            echo "</pre>";
        } else {
            echo "<p>Log file is empty.</p>";
        }
    } else {
        echo "<p class='error'>Laravel log file does not exist or is not accessible.</p>";
        // Try to create the log file
        if (!file_exists($basePath . '/storage/logs')) {
            @mkdir($basePath . '/storage/logs', 0755, true);
        }
        @touch($logFile);
        echo "<p>Attempted to create log file.</p>";
    }

    // Check .env configuration
    echo "<h2>3. Environment Configuration</h2>";
    if (file_exists($basePath . '/.env')) {
        echo "<p class='success'>✓ .env file exists</p>";

        // Check for critical .env values
        $env = file_get_contents($basePath . '/.env');
        $criticalSettings = [
            'APP_KEY' => 'Application key',
            'APP_URL' => 'Application URL',
            'DB_HOST' => 'Database host',
            'DB_DATABASE' => 'Database name',
            'DB_USERNAME' => 'Database username'
        ];

        foreach ($criticalSettings as $key => $label) {
            preg_match('/' . $key . '=(.*)/', $env, $matches);
            $value = isset($matches[1]) ? $matches[1] : 'Not set';
            $value = trim($value);

            if (empty($value) || $value == 'null' || $value == 'Not set') {
                echo "<p class='error'>✗ {$label} ({$key}) is not set properly</p>";
            } else {
                // Mask password if showing it
                if ($key == 'DB_PASSWORD') {
                    $value = '********';
                }

                // For APP_KEY, check if it's a valid format
                if ($key == 'APP_KEY' && strpos($value, 'base64:') !== 0) {
                    echo "<p class='error'>✗ {$label} ({$key}) exists but doesn't have a valid format</p>";
                } else {
                    echo "<p class='success'>✓ {$label} ({$key}) is set: {$value}</p>";
                }
            }
        }
    } else {
        echo "<p class='error'>✗ .env file does not exist. This is critical for Laravel.</p>";
    }

    // Check directory permissions
    echo "<h2>4. Directory Permissions</h2>";
    $directories = [
        'storage/app',
        'storage/framework',
        'storage/framework/cache',
        'storage/framework/sessions',
        'storage/framework/views',
        'storage/logs',
        'bootstrap/cache'
    ];

    foreach ($directories as $dir) {
        $fullPath = $basePath . '/' . $dir;
        if (file_exists($fullPath)) {
            $writable = is_writable($fullPath);
            $perms = substr(sprintf('%o', fileperms($fullPath)), -4);

            if ($writable) {
                echo "<p class='success'>✓ {$dir} is writable (permissions: {$perms})</p>";
            } else {
                echo "<p class='error'>✗ {$dir} is NOT writable (permissions: {$perms})</p>";
            }
        } else {
            echo "<p class='error'>✗ {$dir} does not exist</p>";
        }
    }

    // Check storage link
    echo "<h2>5. Storage Link</h2>";
    if (file_exists($basePath . '/public/storage')) {
        echo "<p class='success'>✓ Storage link exists in public folder</p>";
    } else {
        echo "<p class='error'>✗ Storage link does not exist in public folder</p>";
        echo "<p>You should create a symbolic link or directory at public/storage pointing to storage/app/public</p>";
    }

    // PHP version and extensions
    echo "<h2>6. PHP Environment</h2>";
    echo "<p>PHP Version: " . phpversion() . "</p>";

    $requiredExtensions = [
        'openssl', 'pdo', 'mbstring', 'tokenizer', 'xml', 'ctype',
        'json', 'bcmath', 'fileinfo', 'pdo_mysql'
    ];

    echo "<h3>Required PHP Extensions:</h3>";
    echo "<ul>";
    foreach ($requiredExtensions as $ext) {
        if (extension_loaded($ext)) {
            echo "<li class='success'>✓ {$ext} loaded</li>";
        } else {
            echo "<li class='error'>✗ {$ext} not loaded</li>";
        }
    }
    echo "</ul>";

    // Check .htaccess files
    echo "<h2>7. .htaccess Configuration</h2>";
    $htaccessRoot = $basePath . '/.htaccess';
    $htaccessPublic = $basePath . '/public/.htaccess';

    if (file_exists($htaccessRoot)) {
        echo "<p class='success'>✓ Root .htaccess exists</p>";
    } else {
        echo "<p class='error'>✗ Root .htaccess does not exist</p>";
    }

    if (file_exists($htaccessPublic)) {
        echo "<p class='success'>✓ Public directory .htaccess exists</p>";
    } else {
        echo "<p class='error'>✗ Public directory .htaccess does not exist</p>";
    }

    // Test database connection
    echo "<h2>8. Database Connection Test</h2>";

    if (file_exists($basePath . '/.env')) {
        $env = parse_ini_file($basePath . '/.env');

        if (!empty($env['DB_HOST']) && !empty($env['DB_DATABASE']) &&
            !empty($env['DB_USERNAME'])) {

            try {
                $dbh = new PDO(
                    "mysql:host={$env['DB_HOST']};dbname={$env['DB_DATABASE']}",
                    $env['DB_USERNAME'],
                    $env['DB_PASSWORD'] ?? ''
                );
                echo "<p class='success'>✓ Successfully connected to the database</p>";
            } catch (PDOException $e) {
                echo "<p class='error'>✗ Database connection failed: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p class='error'>✗ Database configuration incomplete in .env file</p>";
        }
    } else {
        echo "<p class='error'>✗ Cannot test database connection: .env file not found</p>";
    }

    echo "<h2>Next Steps</h2>";
    echo "<p>Based on the results above, here are some common fixes:</p>";
    echo "<ol>";
    echo "<li>If Laravel log shows errors, address them specifically</li>";
    echo "<li>If directory permissions are incorrect, run <code>chmod -R 755</code> on those directories</li>";
    echo "<li>If .env file is missing or misconfigured, create or update it</li>";
    echo "<li>If storage link is missing, create public/storage directory or run <code>php artisan storage:link</code></li>";
    echo "<li>If .htaccess files are missing, create them with proper Laravel configuration</li>";
    echo "</ol>";
    ?>
</body>
</html>
