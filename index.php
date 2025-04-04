<?php
/**
 * Laravel - A PHP Framework For Web Artisans
 * Bridge file for shared hosting environments
 */

// Check if we're in a development environment
$isDevelopment = false;

// Set paths to Laravel directories - adjust paths if needed
$laravelPath = __DIR__;  // If Laravel is in the current directory
$publicPath = $laravelPath . '/public';

// Define the Laravel PUBLIC_PATH constant if it's not defined
if (!defined('PUBLIC_PATH')) {
    define('PUBLIC_PATH', $publicPath);
}

// Show detailed errors in development
if ($isDevelopment) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Check if Laravel's public/index.php exists
if (file_exists($publicPath . '/index.php')) {
    // Forward to Laravel's index.php
    require $publicPath . '/index.php';
} else {
    // Show an error if Laravel's public/index.php doesn't exist
    http_response_code(500);
    echo '<h1>Laravel Setup Error</h1>';
    echo '<p>Could not find Laravel\'s public/index.php file.</p>';
    echo '<p>Current path: ' . $laravelPath . '</p>';
    echo '<p>Public path: ' . $publicPath . '</p>';
    echo '<p>Please ensure Laravel is properly installed.</p>';

    // Debug information
    echo '<h2>Directory Contents:</h2>';
    echo '<pre>';
    if (is_dir($laravelPath)) {
        $files = scandir($laravelPath);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                echo $file . (is_dir($laravelPath . '/' . $file) ? ' [Directory]' : ' [File]') . PHP_EOL;
            }
        }
    } else {
        echo 'Laravel directory not found.';
    }
    echo '</pre>';
}
