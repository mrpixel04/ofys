<?php
// Debugging script to test asset paths
header('Content-Type: text/html');

$requested_path = $_SERVER['REQUEST_URI'] ?? 'Unknown';
$server_root = $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown';
$full_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

echo "<h1>Path Debugging for eastbizz.com</h1>";
echo "<h2>Server Information</h2>";
echo "<ul>";
echo "<li>Current time: " . date('Y-m-d H:i:s') . "</li>";
echo "<li>Request URI: " . htmlspecialchars($requested_path) . "</li>";
echo "<li>Full URL: " . htmlspecialchars($full_url) . "</li>";
echo "<li>Document Root: " . htmlspecialchars($server_root) . "</li>";
echo "</ul>";

echo "<h2>File Existence Checks</h2>";
echo "<ul>";

// Check critical files
$filesToCheck = [
    '/js/app.js',
    '/css/app.css',
    '/build/assets/app-BPKtxCGZ.js',
    '/build/assets/app-CFTAco04.css',
    '/build/manifest.json'
];

foreach ($filesToCheck as $file) {
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $file;
    $exists = file_exists($fullPath);
    $readable = is_readable($fullPath);

    echo "<li>" . htmlspecialchars($file) . ": " .
         ($exists ? "<span style='color:green'>Exists</span>" : "<span style='color:red'>Missing</span>") .
         " | Readable: " . ($readable ? "<span style='color:green'>Yes</span>" : "<span style='color:red'>No</span>") . "</li>";

    // If manifest exists, show its content
    if ($exists && $file == '/build/manifest.json') {
        $content = file_get_contents($fullPath);
        echo "<li style='margin-left: 20px;'>Manifest Content: <pre>" . htmlspecialchars($content) . "</pre></li>";
    }
}

echo "</ul>";

echo "<h2>Real File Paths</h2>";
echo "<ul>";

foreach ($filesToCheck as $file) {
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $file;
    if (file_exists($fullPath)) {
        $realPath = realpath($fullPath);
        echo "<li>" . htmlspecialchars($file) . " => " . htmlspecialchars($realPath) . "</li>";
    }
}

echo "</ul>";

echo "<h2>Directory Structure</h2>";
$directories = [
    '/public',
    '/public/js',
    '/public/css',
    '/public/build',
    '/public/build/assets'
];

echo "<ul>";
foreach ($directories as $dir) {
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $dir;
    echo "<li>" . htmlspecialchars($dir) . ": " .
         (is_dir($fullPath) ? "<span style='color:green'>Exists</span>" : "<span style='color:red'>Missing</span>") . "</li>";

    // List files in directory if it exists
    if (is_dir($fullPath)) {
        echo "<ul>";
        $files = scandir($fullPath);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                echo "<li>" . htmlspecialchars($file) . "</li>";
            }
        }
        echo "</ul>";
    }
}
echo "</ul>";
