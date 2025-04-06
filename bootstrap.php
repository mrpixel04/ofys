<?php
/**
 * Laravel Shared Hosting Helper
 *
 * This script helps Laravel run correctly on shared hosting environments.
 * Run this file via: https://eastbizz.com/bootstrap.php?key=12345
 */

// Simple security check
$key = isset($_GET['key']) ? $_GET['key'] : '';
if ($key !== '12345') {
    http_response_code(403);
    die('Unauthorized access');
}

// Output as plain text
header('Content-Type: text/plain');

echo "================================================\n";
echo "LARAVEL SHARED HOSTING BOOTSTRAP HELPER\n";
echo "================================================\n\n";

// Start with environment check
echo "Checking environment...\n";
echo "PHP Version: " . phpversion() . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Current Path: " . __DIR__ . "\n\n";

// Laravel directories to create/check
$directories = [
    'storage/app/public',
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'bootstrap/cache',
    'public/storage',
];

echo "Checking Laravel directories...\n";
foreach ($directories as $dir) {
    if (file_exists(__DIR__ . '/' . $dir)) {
        echo "✓ $dir exists\n";

        // Try to make it writable
        @chmod(__DIR__ . '/' . $dir, 0755);
    } else {
        echo "✗ $dir doesn't exist, creating...\n";
        if (mkdir(__DIR__ . '/' . $dir, 0755, true)) {
            echo "  - Created successfully\n";
        } else {
            echo "  - Creation failed\n";
        }
    }
}
echo "\n";

// Generate app key if needed
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $env = file_get_contents($envFile);
    if (strpos($env, 'APP_KEY=base64:') === false || strpos($env, 'APP_KEY=') === false) {
        echo "APP_KEY is missing, attempting to generate one...\n";

        try {
            // Generate a random key
            $key = 'base64:' . base64_encode(random_bytes(32));

            // Update the .env file
            $env = preg_replace('/APP_KEY=.*/', "APP_KEY=$key", $env);
            if (file_put_contents($envFile, $env)) {
                echo "✓ APP_KEY generated and saved\n";
            } else {
                echo "✗ Failed to save APP_KEY to .env file\n";
            }
        } catch (Exception $e) {
            echo "✗ Error generating APP_KEY: " . $e->getMessage() . "\n";
        }
    } else {
        echo "✓ APP_KEY exists in .env file\n";
    }
} else {
    echo "✗ .env file not found!\n";
}

// Check for storage link
$publicStorage = __DIR__ . '/public/storage';
$appPublicStorage = __DIR__ . '/storage/app/public';

echo "\nChecking storage link...\n";
if (!file_exists($publicStorage)) {
    echo "Creating public/storage directory...\n";
    if (mkdir($publicStorage, 0755, true)) {
        echo "✓ Created successfully\n";
    } else {
        echo "✗ Failed to create public/storage\n";
    }
} else {
    echo "✓ public/storage exists\n";
}

// Create a simple script to update the storage directory
$storageHelperPath = __DIR__ . '/storage-sync.php';
$storageHelperContent = <<<'EOD'
<?php
// Simple script to sync storage/app/public to public/storage
// Access via: https://eastbizz.com/storage-sync.php?key=12345

$key = isset($_GET['key']) ? $_GET['key'] : '';
if ($key !== '12345') {
    http_response_code(403);
    die('Unauthorized access');
}

header('Content-Type: text/plain');
echo "Syncing storage/app/public to public/storage...\n\n";

$sourcePath = __DIR__ . '/storage/app/public';
$destPath = __DIR__ . '/public/storage';

// Create destination if it doesn't exist
if (!file_exists($destPath)) {
    mkdir($destPath, 0755, true);
    echo "Created public/storage directory\n";
}

// Function to recursively copy files
function copyDir($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst);

    while (($file = readdir($dir)) !== false) {
        if ($file != '.' && $file != '..') {
            if (is_dir("$src/$file")) {
                copyDir("$src/$file", "$dst/$file");
            } else {
                copy("$src/$file", "$dst/$file");
                echo "Copied: $src/$file -> $dst/$file\n";
            }
        }
    }

    closedir($dir);
}

// Perform the copy
if (is_dir($sourcePath)) {
    copyDir($sourcePath, $destPath);
    echo "\nStorage sync completed successfully!\n";
} else {
    echo "Error: Source directory $sourcePath doesn't exist\n";
}
EOD;

echo "\nCreating storage sync helper...\n";
if (file_put_contents($storageHelperPath, $storageHelperContent)) {
    echo "✓ Created storage-sync.php helper\n";
} else {
    echo "✗ Failed to create storage-sync.php helper\n";
}

// Clear bootstrap/cache files
echo "\nClearing cache files...\n";
$cacheFiles = glob(__DIR__ . '/bootstrap/cache/*.php');
foreach ($cacheFiles as $file) {
    if (unlink($file)) {
        echo "✓ Deleted: " . basename($file) . "\n";
    } else {
        echo "✗ Failed to delete: " . basename($file) . "\n";
    }
}

echo "\nBootstrap process completed!\n";
echo "Your Laravel application should now work correctly on shared hosting.\n";
echo "Access your site at: https://eastbizz.com\n";
echo "\nIf you still encounter issues, check the Laravel log file at:\n";
echo "storage/logs/laravel.log\n";
