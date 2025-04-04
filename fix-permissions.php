<?php
// Script to fix Laravel permissions on shared hosting
// Access this file via: https://ofys.eastbizz.com/fix-permissions.php

// Simple security to prevent unauthorized access
$key = isset($_GET['key']) ? $_GET['key'] : '';
if ($key !== '12345') {
    http_response_code(403);
    die('Unauthorized access');
}

header('Content-Type: text/plain');
echo "========================================\n";
echo "Laravel Permission Fixer for Shared Hosting\n";
echo "========================================\n\n";

// Define directories that need write permissions
$directoriesToFix = [
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'bootstrap/cache',
];

// Define the Laravel root path
$basePath = __DIR__;

echo "Base path: $basePath\n\n";

// Function to check and fix directory permissions
function fixDirectoryPermissions($dir, $basePath) {
    $fullPath = $basePath . '/' . $dir;

    echo "Checking directory: $dir\n";

    if (!file_exists($fullPath)) {
        echo "  - Directory does not exist, creating...\n";
        if (mkdir($fullPath, 0755, true)) {
            echo "  - Created successfully\n";
        } else {
            echo "  - Failed to create directory\n";
            return false;
        }
    }

    echo "  - Directory exists\n";

    // Get current permissions
    $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
    echo "  - Current permissions: $perms\n";

    // Try to set permissions
    $result = @chmod($fullPath, 0755);
    if ($result) {
        echo "  - Successfully set permissions to 0755\n";
    } else {
        echo "  - Failed to set permissions (this is normal on some shared hosts)\n";
    }

    // Check if writable
    if (is_writable($fullPath)) {
        echo "  - Directory is writable ✓\n";
    } else {
        echo "  - Directory is NOT writable ✗\n";
    }

    return true;
}

// Fix permissions for each directory
foreach ($directoriesToFix as $dir) {
    fixDirectoryPermissions($dir, $basePath);
    echo "\n";
}

// Create or update .htaccess files in sensitive directories
$htaccessContent = "# Deny access to this directory
<IfModule mod_authz_core.c>
    Require all denied
</IfModule>
<IfModule !mod_authz_core.c>
    Order deny,allow
    Deny from all
</IfModule>
";

$protectedDirs = [
    'storage',
    'bootstrap'
];

foreach ($protectedDirs as $dir) {
    $htaccessPath = $basePath . '/' . $dir . '/.htaccess';
    echo "Creating/updating .htaccess in $dir...\n";
    if (file_put_contents($htaccessPath, $htaccessContent)) {
        echo "  - .htaccess created/updated successfully\n";
    } else {
        echo "  - Failed to create/update .htaccess\n";
    }
}

// Create a symlink between storage/app/public and public/storage if it doesn't exist
echo "\nChecking storage symlink...\n";
$publicStoragePath = $basePath . '/public/storage';
$storageAppPublicPath = $basePath . '/storage/app/public';

if (!file_exists($publicStoragePath)) {
    echo "Storage symlink does not exist, trying to create...\n";

    // Since symlinks often don't work on shared hosting, we'll create a directory
    if (mkdir($publicStoragePath, 0755, true)) {
        echo "  - Created public/storage directory\n";

        // Copy any files from storage/app/public to public/storage
        if (is_dir($storageAppPublicPath)) {
            echo "  - Copying files from storage/app/public to public/storage\n";

            $files = scandir($storageAppPublicPath);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    $sourcePath = $storageAppPublicPath . '/' . $file;
                    $destPath = $publicStoragePath . '/' . $file;

                    if (is_dir($sourcePath)) {
                        // Create directory in destination
                        if (!file_exists($destPath)) {
                            mkdir($destPath, 0755, true);
                        }
                        echo "    - Created directory: $file\n";
                    } else {
                        // Copy file
                        if (copy($sourcePath, $destPath)) {
                            echo "    - Copied file: $file\n";
                        } else {
                            echo "    - Failed to copy file: $file\n";
                        }
                    }
                }
            }
        } else {
            echo "  - storage/app/public doesn't exist, creating empty directory structure\n";
            mkdir($storageAppPublicPath, 0755, true);
        }
    } else {
        echo "  - Failed to create public/storage directory\n";
    }
} else {
    echo "Storage directory exists in public folder\n";
}

echo "\nPermission fix completed!\n";
echo "It's recommended to check storage/logs/laravel.log for any errors after this fix.\n";
echo "Try accessing your Laravel application now.\n";
