<?php

/**
 * Laravel Production Path Fix Script
 *
 * This script fixes hard-coded local development paths in your Laravel application
 * when deployed to a production environment.
 *
 * Usage:
 * 1. Upload this file to your production server
 * 2. Run: php final-fix.php
 */

// Get the base path
$basePath = realpath(__DIR__);
$localPath = '/Users/mrpixel/Documents/web/ofys';

echo "Laravel Path Fix Tool\n";
echo "====================\n";
echo "Base path: {$basePath}\n";
echo "Replacing: {$localPath}\n\n";

// Function to recursively find and replace in PHP files
function findAndReplacePaths($directory, $search, $replace) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    $count = 0;
    $filesFixed = [];

    foreach ($iterator as $file) {
        // Only process PHP files
        if ($file->getExtension() != 'php') {
            continue;
        }

        // Skip vendor directory to avoid breaking dependencies
        if (strpos($file->getPathname(), '/vendor/') !== false) {
            continue;
        }

        // Read the file content
        $content = file_get_contents($file->getPathname());

        // Check if the file contains the search string
        if (strpos($content, $search) !== false) {
            // Replace the paths
            $newContent = str_replace($search, $replace, $content);

            // Save the modified file
            file_put_contents($file->getPathname(), $newContent);

            // Add to list of fixed files
            $filesFixed[] = str_replace($replace, '', $file->getPathname());
            $count++;
        }
    }

    return [
        'count' => $count,
        'files' => $filesFixed
    ];
}

// 1. Fix paths in PHP files
echo "Fixing paths in PHP files...\n";
$result = findAndReplacePaths($basePath, $localPath, $basePath);
echo "Fixed {$result['count']} files.\n";

if ($result['count'] > 0) {
    echo "Files fixed:\n";
    foreach ($result['files'] as $file) {
        echo "- {$file}\n";
    }
}

// 2. Fix bootstrap/cache directory
echo "\nClearing bootstrap/cache directory...\n";
$cacheFiles = glob($basePath . '/bootstrap/cache/*.php');
if (!empty($cacheFiles)) {
    array_map('unlink', $cacheFiles);
    echo count($cacheFiles) . " cache files removed.\n";
} else {
    echo "No cache files found.\n";
}

// 3. Create a custom index.php
echo "\nCreating custom index.php...\n";
$indexContent = <<<'EOL'
<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 * Modified index.php to handle production environment
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
EOL;

// Backup the original index.php
if (file_exists($basePath . '/public/index.php')) {
    copy($basePath . '/public/index.php', $basePath . '/public/index.php.bak');
    echo "Original index.php backed up to index.php.bak\n";
}

// Write the new index.php
file_put_contents($basePath . '/public/index.php', $indexContent);
echo "Custom index.php created.\n";

// 4. Fix the .env file
echo "\nChecking .env file...\n";
if (file_exists($basePath . '/.env')) {
    $envContent = file_get_contents($basePath . '/.env');

    // Fix APP_URL
    if (strpos($envContent, 'APP_URL=https://eastbizz.com/ofys') === false) {
        $envContent = preg_replace('/APP_URL=.*/', 'APP_URL=https://eastbizz.com/ofys', $envContent);
        file_put_contents($basePath . '/.env', $envContent);
        echo "APP_URL updated in .env file.\n";
    } else {
        echo "APP_URL already correctly set.\n";
    }

    // Set to production
    if (strpos($envContent, 'APP_ENV=production') === false) {
        $envContent = preg_replace('/APP_ENV=.*/', 'APP_ENV=production', $envContent);
        file_put_contents($basePath . '/.env', $envContent);
        echo "APP_ENV set to production in .env file.\n";
    } else {
        echo "APP_ENV already set to production.\n";
    }

    // Disable debug mode
    if (strpos($envContent, 'APP_DEBUG=false') === false) {
        $envContent = preg_replace('/APP_DEBUG=.*/', 'APP_DEBUG=false', $envContent);
        file_put_contents($basePath . '/.env', $envContent);
        echo "APP_DEBUG set to false in .env file.\n";
    } else {
        echo "APP_DEBUG already set to false.\n";
    }
} else {
    echo ".env file not found. Please create one.\n";
}

// 5. Final steps
echo "\nFix completed! Please run the following commands to clear all caches:\n";
echo "php artisan config:clear\n";
echo "php artisan cache:clear\n";
echo "php artisan view:clear\n";
echo "php artisan route:clear\n";
echo "\nYour application should now be working correctly on the production server.\n";
