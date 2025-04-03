<?php

/**
 * Laravel Diagnostic Script
 *
 * This script helps diagnose issues with Laravel installation on shared hosting.
 * It isolates PHP functionality from Laravel to identify if the problem is with
 * PHP configuration or Laravel itself.
 */

// Basic PHP check
echo "<h1>Laravel Diagnostic Tool</h1>";
echo "<h2>PHP Version: " . PHP_VERSION . "</h2>";

// Check for required extensions
$requiredExtensions = [
    'openssl',
    'pdo',
    'mbstring',
    'tokenizer',
    'xml',
    'ctype',
    'json',
    'fileinfo',
    'curl'
];

echo "<h2>PHP Extensions</h2>";
echo "<ul>";
foreach ($requiredExtensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<li>✅ {$ext} - Installed</li>";
    } else {
        echo "<li>❌ {$ext} - Missing (Required by Laravel)</li>";
    }
}
echo "</ul>";

// Check if we can access the file system
echo "<h2>File System Access</h2>";

$basePath = realpath(__DIR__ . '/..');
echo "<p>Base path: {$basePath}</p>";

$checkDirs = [
    'storage' => $basePath . '/storage',
    'bootstrap/cache' => $basePath . '/bootstrap/cache',
    'vendor' => $basePath . '/vendor',
    'public' => $basePath . '/public',
];

echo "<ul>";
foreach ($checkDirs as $name => $path) {
    if (is_dir($path)) {
        echo "<li>✅ {$name} directory exists at {$path}</li>";
        if (is_writable($path)) {
            echo "<li>✅ {$name} directory is writable</li>";
        } else {
            echo "<li>❌ {$name} directory is not writable (This may cause issues)</li>";
        }
    } else {
        echo "<li>❌ {$name} directory does not exist at {$path} (This will cause issues)</li>";
    }
}
echo "</ul>";

// Check server configuration
echo "<h2>Server Configuration</h2>";
echo "<ul>";
echo "<li>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</li>";
echo "<li>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</li>";
echo "<li>Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "</li>";
echo "<li>Request URI: " . $_SERVER['REQUEST_URI'] . "</li>";
echo "</ul>";

// Try to load key Laravel files
echo "<h2>Laravel Core Files</h2>";
echo "<ul>";

$laravelFiles = [
    'Autoloader' => $basePath . '/vendor/autoload.php',
    'Application' => $basePath . '/bootstrap/app.php',
    'Kernel' => $basePath . '/app/Http/Kernel.php',
    '.env file' => $basePath . '/.env',
];

foreach ($laravelFiles as $name => $path) {
    if (file_exists($path)) {
        echo "<li>✅ {$name} exists at {$path}</li>";
    } else {
        echo "<li>❌ {$name} does not exist at {$path} (This will cause issues)</li>";
    }
}
echo "</ul>";

// Check for .htaccess files
echo "<h2>Web Server Configuration</h2>";
echo "<ul>";
if (file_exists($basePath . '/.htaccess')) {
    echo "<li>✅ Root .htaccess file exists</li>";
} else {
    echo "<li>❌ Root .htaccess file is missing</li>";
}

if (file_exists($basePath . '/public/.htaccess')) {
    echo "<li>✅ Public .htaccess file exists</li>";
} else {
    echo "<li>❌ Public .htaccess file is missing</li>";
}
echo "</ul>";

echo "<h2>Recommendations</h2>";
echo "<p>Based on the diagnostics:</p>";
echo "<ol>";
echo "<li>Check your server error logs for specific error messages</li>";
echo "<li>Ensure your .env file contains the correct database credentials and app URL (APP_URL=https://eastbizz.com/ofys)</li>";
echo "<li>Try accessing the application without index.php in the URL</li>";
echo "<li>If the issue persists, try with the following URL format: https://eastbizz.com/ofys/public/index.php</li>";
echo "</ol>";

echo "<p><strong>Note:</strong> This diagnostic tool is only for identifying server configuration issues.
It does not diagnose Laravel application code issues.</p>";

// End of diagnostic script
