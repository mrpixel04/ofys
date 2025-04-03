<?php

/**
 * Simple .env File Fix Script
 *
 * This script repairs a malformed .env file without requiring interactive input
 */

$basePath = realpath(__DIR__);
echo "Fixing .env file...\n";
echo "Base path: {$basePath}\n\n";

// Create a new clean .env file with correct values
$newEnvContent = <<<'EOL'
APP_NAME=OFYS
APP_ENV=production
APP_KEY=base64:wLdHnNCWXnQC/f/ZKGiHe13bfTYCe6sPlazTlCu5n9Y=
APP_DEBUG=false
APP_URL=https://eastbizz.com/ofys
ASSET_URL=https://eastbizz.com/ofys

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eastbizz_ofys
DB_USERNAME=eastbizz_ofys
DB_PASSWORD=your_password_here

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

VITE_APP_NAME="${APP_NAME}"
EOL;

// Backup the current .env file if it exists
if (file_exists($basePath . '/.env')) {
    copy($basePath . '/.env', $basePath . '/.env.backup');
    echo "Created backup of current .env file at .env.backup\n";

    // Try to extract important values from the backup
    $oldEnv = file_get_contents($basePath . '/.env.backup');

    // Extract APP_KEY if it exists
    if (preg_match('/APP_KEY=([^\n\r]+)/', $oldEnv, $matches)) {
        $appKey = trim($matches[1]);
        if (!empty($appKey)) {
            echo "Found existing APP_KEY: " . substr($appKey, 0, 10) . "...\n";
            // Update the template with the existing key
            $newEnvContent = preg_replace('/APP_KEY=.*/', 'APP_KEY=' . $appKey, $newEnvContent);
        }
    }

    // Try to extract database credentials
    $dbCredentials = [
        'DB_DATABASE' => 'eastbizz_ofys',
        'DB_USERNAME' => 'eastbizz_ofys',
        'DB_PASSWORD' => 'your_password_here'
    ];

    foreach ($dbCredentials as $key => $defaultValue) {
        if (preg_match('/' . $key . '=([^\n\r]+)/', $oldEnv, $matches)) {
            $value = trim($matches[1]);
            if (!empty($value)) {
                echo "Found {$key}: " . ($key === 'DB_PASSWORD' ? '********' : $value) . "\n";
                // Update the template
                $newEnvContent = preg_replace('/' . $key . '=.*/', $key . '=' . $value, $newEnvContent);
            }
        }
    }
}

// Write the new .env file
file_put_contents($basePath . '/.env', $newEnvContent);
echo "Created new .env file with correct formatting.\n";

// Generate a new app key if needed (if none was found in the backup)
if (strpos($newEnvContent, 'APP_KEY=base64:wLdHnNCWXnQC/f/ZKGiHe13bfTYCe6sPlazTlCu5n9Y=') !== false) {
    echo "Note: Using a default APP_KEY. For security, you should run 'php artisan key:generate' after this fix.\n";
}

echo "\nFix complete! The .env file has been repaired with correct formatting.\n";
echo "Now run these commands to clear the cache:\n";
echo "1. php artisan config:clear\n";
echo "2. php artisan cache:clear\n";
echo "3. php artisan view:clear\n";
echo "4. php artisan route:clear\n";

// Create a simple cache clear script
$cacheScript = <<<'EOL'
<?php

/**
 * Simple Cache Clear Script
 *
 * This script clears Laravel caches without requiring artisan
 */

$basePath = realpath(__DIR__);
echo "Clearing Laravel caches...\n";

// Clear bootstrap/cache files
$cacheFiles = glob($basePath . '/bootstrap/cache/*.php');
if (!empty($cacheFiles)) {
    array_map('unlink', $cacheFiles);
    echo "Cleared " . count($cacheFiles) . " cache files from bootstrap/cache.\n";
} else {
    echo "No cache files found in bootstrap/cache.\n";
}

// Clear view cache
$viewCacheFiles = glob($basePath . '/storage/framework/views/*');
if (!empty($viewCacheFiles)) {
    foreach ($viewCacheFiles as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "Cleared view cache files.\n";
} else {
    echo "No view cache files found.\n";
}

echo "\nCache clearing complete!\n";
echo "Try accessing your site now.\n";
EOL;

// Save the cache clear script
file_put_contents($basePath . '/clear-cache.php', $cacheScript);
echo "Created a simple cache clearing script at clear-cache.php\n";
echo "Run it with: php clear-cache.php\n";
