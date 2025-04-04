<?php
// Turn on error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Output as HTML
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laravel Hosting Configuration Tester</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        h1 { color: #333; }
        .section { margin: 20px 0; padding: 10px; background: #f5f5f5; border-radius: 5px; }
        .success { color: green; }
        .error { color: red; }
        pre { background: #eee; padding: 10px; overflow: auto; }
    </style>
</head>
<body>
    <h1>Laravel Hosting Configuration Tester</h1>

    <div class="section">
        <h2>1. PHP Information</h2>
        <p>PHP Version: <strong><?php echo phpversion(); ?></strong></p>
        <p>Server Software: <strong><?php echo $_SERVER['SERVER_SOFTWARE']; ?></strong></p>
    </div>

    <div class="section">
        <h2>2. Server Paths</h2>
        <p>Document Root: <strong><?php echo $_SERVER['DOCUMENT_ROOT']; ?></strong></p>
        <p>Script Filename: <strong><?php echo $_SERVER['SCRIPT_FILENAME']; ?></strong></p>
        <p>Current Directory: <strong><?php echo getcwd(); ?></strong></p>
        <p>Parent Directory: <strong><?php echo dirname(__DIR__); ?></strong></p>
    </div>

    <div class="section">
        <h2>3. File Structure Check</h2>
        <?php
        $rootPath = __DIR__;
        $directories = [
            '.' => 'Current Directory',
            'public' => 'Public Directory',
            'storage' => 'Storage Directory',
            'bootstrap' => 'Bootstrap Directory',
            'vendor' => 'Vendor Directory'
        ];

        foreach ($directories as $dir => $label) {
            if (file_exists($rootPath . '/' . $dir)) {
                echo "<p class='success'>✓ {$label} exists</p>";
            } else {
                echo "<p class='error'>✗ {$label} not found</p>";
            }
        }

        // Check key files
        $files = [
            '.env' => '.env File',
            '.htaccess' => 'Root .htaccess',
            'public/.htaccess' => 'Public .htaccess',
            'public/index.php' => 'Public index.php'
        ];

        foreach ($files as $file => $label) {
            if (file_exists($rootPath . '/' . $file)) {
                echo "<p class='success'>✓ {$label} exists</p>";
            } else {
                echo "<p class='error'>✗ {$label} not found</p>";
            }
        }
        ?>
    </div>

    <div class="section">
        <h2>4. Directory Listing</h2>
        <p>Files in the current directory:</p>
        <pre><?php
            $files = scandir($rootPath);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    echo $file . (is_dir($rootPath . '/' . $file) ? ' (Directory)' : ' (File)') . "\n";
                }
            }
        ?></pre>
    </div>

    <div class="section">
        <h2>5. Laravel .env Content Check</h2>
        <?php
        if (file_exists($rootPath . '/.env')) {
            $envContent = file_get_contents($rootPath . '/.env');
            // Extract APP_URL without showing full .env
            preg_match('/APP_URL=(.*)/', $envContent, $matches);
            $appUrl = isset($matches[1]) ? $matches[1] : "Not found";

            echo "<p>APP_URL: <strong>{$appUrl}</strong></p>";

            // Check if debug is enabled
            preg_match('/APP_DEBUG=(.*)/', $envContent, $matches);
            $appDebug = isset($matches[1]) ? $matches[1] : "Not found";

            echo "<p>APP_DEBUG: <strong>{$appDebug}</strong></p>";

            // Database configuration
            preg_match('/DB_HOST=(.*)/', $envContent, $matches);
            $dbHost = isset($matches[1]) ? $matches[1] : "Not found";

            echo "<p>DB_HOST: <strong>{$dbHost}</strong></p>";
        } else {
            echo "<p class='error'>✗ .env file not found!</p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>6. Test .htaccess Effectiveness</h2>
        <p>Trying to read .htaccess file (should be blocked):</p>
        <?php
        $htaccess = @file_get_contents($rootPath . '/.htaccess');
        if ($htaccess === false) {
            echo "<p class='success'>✓ .htaccess is properly secured</p>";
        } else {
            echo "<p class='error'>✗ .htaccess can be read directly, which may indicate Apache mod_rewrite issues</p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>7. Permissions Check</h2>
        <?php
        $directoriesToCheck = [
            'storage/app',
            'storage/framework',
            'storage/logs',
            'bootstrap/cache'
        ];

        foreach ($directoriesToCheck as $dir) {
            $fullPath = $rootPath . '/' . $dir;
            if (file_exists($fullPath)) {
                $permissions = substr(sprintf('%o', fileperms($fullPath)), -4);
                $isWritable = is_writable($fullPath);

                echo "<p>{$dir}: Permissions {$permissions}, ";
                echo "Writable: " . ($isWritable ? "<span class='success'>Yes ✓</span>" : "<span class='error'>No ✗</span>") . "</p>";
            } else {
                echo "<p class='error'>✗ {$dir} does not exist</p>";
            }
        }
        ?>
    </div>
</body>
</html>
