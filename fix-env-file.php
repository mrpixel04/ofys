<?php

/**
 * .env File Fix Script
 *
 * This script repairs a malformed .env file and creates a correct one
 * with proper syntax and formatting
 */

$basePath = realpath(__DIR__);
echo "Fixing .env file...\n";
echo "Base path: {$basePath}\n\n";

// Create a new clean .env file with correct values
$newEnvContent = <<<'EOL'
APP_NAME=OFYS
APP_ENV=production
APP_KEY=
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
}

// Write the new .env file
file_put_contents($basePath . '/.env', $newEnvContent);
echo "Created new .env file with correct formatting.\n";

// Try to get the app key from the backup
if (file_exists($basePath . '/.env.backup')) {
    $oldEnv = file_get_contents($basePath . '/.env.backup');

    // Extract APP_KEY if it exists
    if (preg_match('/APP_KEY=([^\n\r]+)/', $oldEnv, $matches)) {
        $appKey = $matches[1];

        // Update the new .env file with the extracted key
        $newEnv = file_get_contents($basePath . '/.env');
        $newEnv = preg_replace('/APP_KEY=/', 'APP_KEY=' . $appKey, $newEnv);
        file_put_contents($basePath . '/.env', $newEnv);

        echo "Preserved the existing APP_KEY from backup.\n";
    } else {
        echo "No APP_KEY found in backup. You will need to generate one with 'php artisan key:generate'.\n";
    }

    // Try to extract database credentials
    if (preg_match('/DB_DATABASE=([^\n\r]+)/', $oldEnv, $matches)) {
        $dbName = trim($matches[1]);
        echo "Found DB_DATABASE: {$dbName}\n";

        // Update the new .env
        $newEnv = file_get_contents($basePath . '/.env');
        $newEnv = preg_replace('/DB_DATABASE=eastbizz_ofys/', 'DB_DATABASE=' . $dbName, $newEnv);
        file_put_contents($basePath . '/.env', $newEnv);
    }

    if (preg_match('/DB_USERNAME=([^\n\r]+)/', $oldEnv, $matches)) {
        $dbUser = trim($matches[1]);
        echo "Found DB_USERNAME: {$dbUser}\n";

        // Update the new .env
        $newEnv = file_get_contents($basePath . '/.env');
        $newEnv = preg_replace('/DB_USERNAME=eastbizz_ofys/', 'DB_USERNAME=' . $dbUser, $newEnv);
        file_put_contents($basePath . '/.env', $newEnv);
    }

    if (preg_match('/DB_PASSWORD=([^\n\r]+)/', $oldEnv, $matches)) {
        $dbPass = trim($matches[1]);
        echo "Found DB_PASSWORD: ********\n";

        // Update the new .env
        $newEnv = file_get_contents($basePath . '/.env');
        $newEnv = preg_replace('/DB_PASSWORD=your_password_here/', 'DB_PASSWORD=' . $dbPass, $newEnv);
        file_put_contents($basePath . '/.env', $newEnv);
    }
}

// If no APP_KEY was found, or if you want to generate a new one
echo "\nWould you like to generate a new APP_KEY? (y/n): ";
$handle = fopen("php://stdin", "r");
$line = fgets($handle);
if (trim(strtolower($line)) == 'y') {
    echo "Generating a new APP_KEY...\n";

    // Generate a random 32-character key
    $key = 'base64:' . base64_encode(
        random_bytes(32)
    );

    // Update the .env file with the new key
    $newEnv = file_get_contents($basePath . '/.env');
    $newEnv = preg_replace('/APP_KEY=(.*)/', 'APP_KEY=' . $key, $newEnv);
    file_put_contents($basePath . '/.env', $newEnv);

    echo "Generated new APP_KEY: {$key}\n";
}

echo "\nFix complete! The .env file has been repaired with correct formatting.\n";
echo "Please check the database credentials in .env and update if needed.\n";
echo "Then run 'php artisan config:clear' to clear the config cache.\n";
