<?php
// Fix database configuration in .env file
header('Content-Type: text/plain');

$envPath = __DIR__ . '/.env';

if (!file_exists($envPath)) {
    echo ".env file not found!";
    exit;
}

// Get current .env content
$env = file_get_contents($envPath);

// Database credentials to set or update
$dbConfig = [
    'DB_CONNECTION' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_PORT' => '3306',
    'DB_DATABASE' => 'eastbizz_dbofys',
    'DB_USERNAME' => 'eastbizz_adofys',
    'DB_PASSWORD' => 'REPLACE_WITH_YOUR_ACTUAL_PASSWORD' // Replace this with your actual password
];

// Update the .env file with correct database credentials
foreach ($dbConfig as $key => $value) {
    // Check if the key exists in the .env file
    if (preg_match("/{$key}=(.*)/", $env)) {
        // Replace existing value
        $env = preg_replace("/{$key}=(.*)/", "{$key}={$value}", $env);
    } else {
        // Add new key-value pair
        $env .= "\n{$key}={$value}";
    }
}

// Write the updated content back to the .env file
if (file_put_contents($envPath, $env)) {
    echo "Database configuration updated successfully!\n\n";
    echo "Updated .env file now contains:\n\n";
    echo $env;

    echo "\n\nIMPORTANT: Please edit this file in cPanel File Manager and replace 'REPLACE_WITH_YOUR_ACTUAL_PASSWORD' with your actual database password.";
} else {
    echo "Failed to update .env file. Please check file permissions.";
}
?>
