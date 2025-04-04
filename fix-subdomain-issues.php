<?php
/**
 * Deployment Helper for Laravel on Shared Hosting
 *
 * This script helps resolve common issues when deploying Laravel to a subdomain
 * on shared hosting.
 */

// Exit if run from command line
if (php_sapi_name() === 'cli') {
    echo "This script should be run through a web browser.\n";
    exit(1);
}

// Security check - add a secret key to prevent unauthorized access
$key = isset($_GET['key']) ? $_GET['key'] : '';
if ($key !== '12345') { // Change this to your own secret key
    http_response_code(403);
    echo "Unauthorized";
    exit(1);
}

// Output as plain text
header('Content-Type: text/plain');

// Define root path
$rootPath = __DIR__;

echo "==========================================\n";
echo "Laravel Subdomain Deployment Fix Tool\n";
echo "==========================================\n\n";

echo "Running in: " . $rootPath . "\n";
echo "PHP Version: " . phpversion() . "\n\n";

// Function to check and fix directories
function checkAndFixDirectory($dir, $permissions = 0755) {
    global $rootPath;
    $fullPath = $rootPath . '/' . $dir;

    echo "Checking directory: $dir\n";

    if (!file_exists($fullPath)) {
        if (mkdir($fullPath, $permissions, true)) {
            echo "✓ Created directory: $dir\n";
        } else {
            echo "✗ Failed to create directory: $dir\n";
        }
    } else {
        echo "✓ Directory exists: $dir\n";
    }

    try {
        if (@chmod($fullPath, $permissions)) {
            echo "✓ Set permissions for directory: $dir\n";
        } else {
            echo "✗ Failed to set permissions for directory: $dir (this is often OK on shared hosting)\n";
        }
    } catch (Exception $e) {
        echo "✗ Error setting permissions: " . $e->getMessage() . "\n";
    }
}

// Function to check and create .htaccess file
function createHtaccess($path, $content) {
    global $rootPath;
    $fullPath = $rootPath . '/' . $path;

    echo "Checking .htaccess: $path\n";

    if (file_exists($fullPath)) {
        echo "✓ .htaccess exists: $path\n";
        // Check if content is correct
        if (md5_file($fullPath) !== md5($content)) {
            if (file_put_contents($fullPath, $content)) {
                echo "✓ Updated .htaccess with correct content: $path\n";
            } else {
                echo "✗ Failed to update .htaccess: $path\n";
            }
        }
    } else {
        if (file_put_contents($fullPath, $content)) {
            echo "✓ Created .htaccess: $path\n";
        } else {
            echo "✗ Failed to create .htaccess: $path\n";
        }
    }
}

// Function to check and update environment file
function checkAndUpdateEnvFile() {
    global $rootPath;
    $envPath = $rootPath . '/.env';

    echo "Checking .env file\n";

    if (file_exists($envPath)) {
        echo "✓ .env file exists\n";

        // Read the content
        $envContent = file_get_contents($envPath);
        $updated = false;

        // Check and update APP_URL if necessary
        if (strpos($envContent, 'APP_URL=https://ofys.eastbizz.com') === false) {
            echo "✗ APP_URL is not set correctly\n";
            $envContent = preg_replace('/APP_URL=.*/', 'APP_URL=https://ofys.eastbizz.com', $envContent);
            $updated = true;
        } else {
            echo "✓ APP_URL is set correctly\n";
        }

        // Check APP_DEBUG (should be false in production)
        if (strpos($envContent, 'APP_DEBUG=true') !== false) {
            echo "✗ APP_DEBUG is set to true (should be false in production)\n";
            $envContent = preg_replace('/APP_DEBUG=true/', 'APP_DEBUG=false', $envContent);
            $updated = true;
        } else {
            echo "✓ APP_DEBUG is set correctly\n";
        }

        // Update DB_HOST to localhost if it's 127.0.0.1
        if (strpos($envContent, 'DB_HOST=127.0.0.1') !== false) {
            echo "✗ DB_HOST is set to 127.0.0.1 (changing to localhost for shared hosting)\n";
            $envContent = preg_replace('/DB_HOST=127.0.0.1/', 'DB_HOST=localhost', $envContent);
            $updated = true;
        }

        // Check if database credentials are default/empty
        if (preg_match('/DB_DATABASE=dbofys/', $envContent) &&
            preg_match('/DB_USERNAME=root/', $envContent) &&
            preg_match('/DB_PASSWORD=/', $envContent)) {
            echo "✗ WARNING: Database credentials appear to be default values. Please update them!\n";
        }

        // Save updated content if changes were made
        if ($updated) {
            if (file_put_contents($envPath, $envContent)) {
                echo "✓ Updated .env file with correct settings\n";
            } else {
                echo "✗ Failed to update .env file\n";
            }
        }
    } else {
        echo "✗ .env file does not exist - this is a critical error!\n";
        // Try to copy from .env.example if it exists
        if (file_exists($rootPath . '/.env.example')) {
            if (copy($rootPath . '/.env.example', $envPath)) {
                echo "✓ Created .env file from .env.example\n";
                echo "! IMPORTANT: You need to configure your .env file with proper settings!\n";
            } else {
                echo "✗ Failed to create .env file from .env.example\n";
            }
        } else {
            echo "✗ No .env.example file found to create .env from\n";
        }
    }
}

// Check for Laravel error log
function checkLaravelLogs() {
    global $rootPath;
    $logPath = $rootPath . '/storage/logs/laravel.log';

    echo "Checking Laravel error logs\n";

    if (file_exists($logPath)) {
        echo "✓ Laravel log file exists\n";
        echo "Recent errors (last 10 lines):\n";

        $log = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($log) {
            $lastLines = array_slice($log, max(0, count($log) - 10));
            foreach ($lastLines as $line) {
                echo "  " . $line . "\n";
            }
        } else {
            echo "  No errors found in log file\n";
        }
    } else {
        echo "✗ Laravel log file does not exist\n";

        // Try to create the log file
        $logsDir = $rootPath . '/storage/logs';
        if (!file_exists($logsDir)) {
            mkdir($logsDir, 0755, true);
        }

        if (touch($logPath) && chmod($logPath, 0644)) {
            echo "✓ Created empty log file\n";
        } else {
            echo "✗ Failed to create log file\n";
        }
    }
}

// Check required PHP extensions
function checkPhpExtensions() {
    $requiredExtensions = [
        'BCMath', 'Ctype', 'Fileinfo', 'JSON', 'Mbstring',
        'OpenSSL', 'PDO', 'Tokenizer', 'XML', 'pdo_mysql'
    ];

    echo "Checking required PHP extensions:\n";
    $allLoaded = true;

    foreach ($requiredExtensions as $extension) {
        $loaded = extension_loaded(strtolower($extension));
        echo $extension . ": " . ($loaded ? "Loaded ✓" : "Not Loaded ✗") . "\n";
        if (!$loaded) {
            $allLoaded = false;
        }
    }

    if (!$allLoaded) {
        echo "✗ Some required PHP extensions are missing. Please contact your hosting provider.\n";
    } else {
        echo "✓ All required PHP extensions are loaded\n";
    }
}

// Function to clear Laravel cache
function clearLaravelCache() {
    global $rootPath;

    echo "Clearing Laravel cache files\n";

    $cacheFiles = [
        '/bootstrap/cache/config.php',
        '/bootstrap/cache/routes.php',
        '/bootstrap/cache/services.php',
        '/bootstrap/cache/packages.php',
    ];

    foreach ($cacheFiles as $file) {
        $fullPath = $rootPath . $file;
        if (file_exists($fullPath)) {
            if (unlink($fullPath)) {
                echo "✓ Removed cache file: $file\n";
            } else {
                echo "✗ Failed to remove cache file: $file\n";
            }
        } else {
            echo "- Cache file does not exist (OK): $file\n";
        }
    }
}

// Check key directories
echo "=== Checking Key Directories ===\n";
checkAndFixDirectory('storage/app/public');
checkAndFixDirectory('storage/framework/cache');
checkAndFixDirectory('storage/framework/cache/data');
checkAndFixDirectory('storage/framework/sessions');
checkAndFixDirectory('storage/framework/views');
checkAndFixDirectory('storage/logs');
checkAndFixDirectory('bootstrap/cache');
echo "\n";

// Check public/storage symlink
echo "=== Checking Storage Symlink ===\n";
if (!file_exists($rootPath . '/public/storage')) {
    if (is_dir($rootPath . '/storage/app/public')) {
        // Cannot create real symlinks on shared hosting, so create a directory copy instead
        echo "Creating storage directory copy (symlink alternative)...\n";
        if (!is_dir($rootPath . '/public/storage')) {
            mkdir($rootPath . '/public/storage', 0755, true);
        }

        // Copy files from storage/app/public to public/storage
        $srcDir = $rootPath . '/storage/app/public';
        $destDir = $rootPath . '/public/storage';

        if (is_dir($srcDir)) {
            $files = scandir($srcDir);
            foreach($files as $file) {
                if ($file != "." && $file != "..") {
                    if (is_dir("$srcDir/$file")) {
                        if (!is_dir("$destDir/$file")) {
                            mkdir("$destDir/$file", 0755, true);
                        }
                        echo "✓ Created directory: public/storage/$file\n";
                    } else {
                        if (copy("$srcDir/$file", "$destDir/$file")) {
                            echo "✓ Copied file: public/storage/$file\n";
                        } else {
                            echo "✗ Failed to copy file: public/storage/$file\n";
                        }
                    }
                }
            }
        }
    } else {
        echo "Storage/app/public directory does not exist\n";
        checkAndFixDirectory('public/storage');
    }
} else {
    echo "✓ Storage symlink or directory exists\n";
}
echo "\n";

// Check .htaccess files
echo "=== Checking .htaccess Files ===\n";
// Root .htaccess
$rootHtaccess = <<<'EOL'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
EOL;
createHtaccess('.htaccess', $rootHtaccess);

// Public .htaccess
$publicHtaccess = <<<'EOL'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOL;
createHtaccess('public/.htaccess', $publicHtaccess);
echo "\n";

// Check PHP extensions
echo "=== Checking PHP Extensions ===\n";
checkPhpExtensions();
echo "\n";

// Clear Laravel cache
echo "=== Clearing Laravel Cache ===\n";
clearLaravelCache();
echo "\n";

// Check .env file
echo "=== Checking Environment File ===\n";
checkAndUpdateEnvFile();
echo "\n";

// Check Laravel error logs
echo "=== Checking Laravel Error Logs ===\n";
checkLaravelLogs();
echo "\n";

// Check for Vite assets
echo "=== Checking Vite Assets ===\n";
if (is_dir($rootPath . '/public/build')) {
    echo "✓ Vite build directory exists\n";

    // Check for manifest file
    if (file_exists($rootPath . '/public/build/manifest.json')) {
        echo "✓ Vite manifest.json exists\n";
    } else {
        echo "✗ Vite manifest.json does not exist\n";
        echo "  This may indicate that assets were not built correctly before deployment\n";
    }
} else {
    echo "✗ Vite build directory does not exist\n";
    echo "  This is a critical error - Laravel won't be able to load frontend assets\n";
    echo "  Make sure to run 'npm run build' before deploying\n";
}
echo "\n";

echo "=== Server Information ===\n";
echo "PHP Version: " . phpversion() . "\n";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "\n";

echo "=== Summary ===\n";
echo "If you see issues above, you can manually fix them using cPanel's File Manager.\n";
echo "Remember to check your database configuration in the .env file.\n";
echo "Your site should be accessible at: https://ofys.eastbizz.com\n";
echo "\n";
echo "If you're still having issues, visit Laravel at https://ofys.eastbizz.com and check for errors\n";
echo "You can also try to create a custom php.ini file if your hosting supports it.\n";
