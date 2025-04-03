#!/bin/bash

# Script to fix hard-coded paths in Laravel application
echo "Fixing hard-coded paths in Laravel application..."

# Path variables
SERVER_PATH="/home/eastbizzcom/public_html/ofys"
LOCAL_PATH="/Users/mrpixel/Documents/web/ofys"

# Create a backup of index.php
cp public/index.php public/index.php.bak

# Create a custom index.php for production
cat > public/index.php << 'EOL'
<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 */

// Define the application base path
$basePath = __DIR__.'/../';

// Register the auto loader
require $basePath.'vendor/autoload.php';

// Bootstrap the application
$app = require_once $basePath.'bootstrap/app.php';

// Fix application base path - IMPORTANT
$app->useStoragePath($basePath . 'storage');
$app->setBasePath($basePath);

// Handle the request
$kernel = $app->make(Illuminate\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
EOL

# Create a new bootstrap file
mkdir -p temp/bootstrap
cat > temp/bootstrap/fix-paths.php << 'EOL'
<?php

// This file is used to fix hard-coded paths in the Laravel application

// Get the base path
$basePath = realpath(__DIR__ . '/../');

// Find all PHP files in the bootstrap directory
$bootstrapFiles = glob($basePath . '/bootstrap/*.php');

// Process each file
foreach ($bootstrapFiles as $file) {
    $content = file_get_contents($file);

    // Replace hard-coded paths
    $content = str_replace('/Users/mrpixel/Documents/web/ofys', $basePath, $content);

    // Save the modified file
    file_put_contents($file, $content);

    echo "Fixed paths in: " . basename($file) . PHP_EOL;
}

echo "All bootstrap files have been updated with correct paths." . PHP_EOL;
EOL

echo "Files created successfully."
echo "Upload these files to your server and run the following commands:"
echo "1. cp public/index.php.bak public/index.php.original"
echo "2. cp public/index.php public/index.php.new"
echo "3. php temp/bootstrap/fix-paths.php"
echo "4. Remember to check if your .env file has the correct APP_URL setting:"
echo "   APP_URL=https://eastbizz.com/ofys"
