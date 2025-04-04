<?php

// This file is used to fix hard-coded paths in the Laravel application's cache files

// Get the base path
$basePath = realpath(__DIR__ . '/../..');

// Define paths
$localPath = '/Users/mrpixel/Documents/web/ofys';
$serverPath = $basePath;

echo "Fixing paths in bootstrap/cache directory...\n";
echo "Base path: {$basePath}\n";

// Find all PHP files in the bootstrap/cache directory
$cacheFiles = glob($basePath . '/bootstrap/cache/*.php');

if (empty($cacheFiles)) {
    echo "No cache files found. This is normal if you've just deployed.\n";
} else {
    // Process each file
    foreach ($cacheFiles as $file) {
        $content = file_get_contents($file);

        // Replace hard-coded paths
        $content = str_replace($localPath, $serverPath, $content);

        // Save the modified file
        file_put_contents($file, $content);

        echo "Fixed paths in: bootstrap/cache/" . basename($file) . "\n";
    }
}

// Clear the cache files (alternative approach)
echo "\nClearing cache files...\n";
array_map('unlink', glob($basePath . '/bootstrap/cache/*.php'));
echo "Cache cleared. Laravel will regenerate these files with correct paths.\n";

echo "\nPath fix completed. Please run the following artisan commands:\n";
echo "php artisan config:clear\n";
echo "php artisan cache:clear\n";
echo "php artisan view:clear\n";
echo "php artisan route:clear\n";
