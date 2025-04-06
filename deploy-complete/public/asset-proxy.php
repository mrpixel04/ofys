<?php
/**
 * Asset proxy script to handle JS and CSS requests
 * This script will serve the correct file with the proper Content-Type
 */

$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$filePath = '';
$contentType = '';

// FORCE PUBLIC PREFIX - always use public directory
$publicBasePath = dirname(__DIR__) . '/public';

// Determine what file is being requested
if (strpos($requestUri, '/js/app.js') !== false) {
    // Handle JS file request
    $filePath = $publicBasePath . '/build/assets/app-BPKtxCGZ.js'; // Update this hash if needed
    $contentType = 'application/javascript';
} elseif (strpos($requestUri, '/css/app.css') !== false) {
    // Handle CSS file request
    $filePath = $publicBasePath . '/build/assets/app-CFTAco04.css'; // Update this hash if needed
    $contentType = 'text/css';
} elseif (strpos($requestUri, '/storage/') !== false) {
    // Handle storage file requests
    $storagePath = str_replace('/storage/', '', $requestUri);
    $filePath = $publicBasePath . '/storage/' . $storagePath;

    // Determine content type based on file extension
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    switch (strtolower($extension)) {
        case 'jpg':
        case 'jpeg':
            $contentType = 'image/jpeg';
            break;
        case 'png':
            $contentType = 'image/png';
            break;
        case 'gif':
            $contentType = 'image/gif';
            break;
        case 'svg':
            $contentType = 'image/svg+xml';
            break;
        case 'pdf':
            $contentType = 'application/pdf';
            break;
        default:
            $contentType = 'application/octet-stream';
    }
} else {
    // Not a handled file
    header('HTTP/1.0 404 Not Found');
    echo "File not found or not handled by this proxy";
    exit;
}

// Check if file exists
if (!file_exists($filePath)) {
    // Try to find alternative paths with manifest
    if (strpos($filePath, '/build/assets/') !== false) {
        // Check if manifest exists and get proper file path
        $manifestPath = $publicBasePath . '/build/manifest.json';
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);

            $key = strpos($requestUri, '/js/') !== false ? 'resources/js/app.js' : 'resources/css/app.css';

            if (isset($manifest[$key])) {
                $filePath = $publicBasePath . '/build/' . $manifest[$key]['file'];
            }
        }
    }

    // If still not found
    if (!file_exists($filePath)) {
        // Try one more location - in the root public folder
        $rootFilePath = __DIR__ . str_replace('/public', '', $requestUri);
        if (file_exists($rootFilePath)) {
            $filePath = $rootFilePath;
        } else {
            header('HTTP/1.0 404 Not Found');
            echo "File not found: " . basename($filePath) . " - Checked in /public path and root path";
            exit;
        }
    }
}

// Set proper content type
header('Content-Type: ' . $contentType);

// Set caching headers for assets but not for storage files
if (!strpos($requestUri, '/storage/')) {
    header('Cache-Control: public, max-age=31536000');
} else {
    header('Cache-Control: public, max-age=86400'); // 1 day for storage files
}

// Output the file content
readfile($filePath);
exit;
