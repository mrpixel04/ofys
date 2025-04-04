<?php
// Display current PHP version
echo "<h1>PHP Version Check for Laravel 12</h1>";
echo "<p>Current PHP version: " . phpversion() . "</p>";

// Required PHP version for Laravel 12
$requiredPhpVersion = '8.2.0';
echo "<p>Required PHP version for Laravel 12: " . $requiredPhpVersion . "</p>";

// Check if current PHP version meets Laravel 12 requirements
if (version_compare(PHP_VERSION, $requiredPhpVersion, '>=')) {
    echo "<p style='color: green; font-weight: bold;'>✅ Your PHP version is compatible with Laravel 12</p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>❌ Your PHP version is NOT compatible with Laravel 12</p>";
    echo "<p>Please upgrade to PHP " . $requiredPhpVersion . " or higher.</p>";
}

// Check for required extensions
echo "<h2>Required PHP Extensions</h2>";
$requiredExtensions = [
    'bcmath', 'ctype', 'fileinfo', 'json', 'mbstring',
    'openssl', 'pdo', 'pdo_mysql', 'tokenizer', 'xml'
];

echo "<ul>";
foreach ($requiredExtensions as $extension) {
    if (extension_loaded($extension)) {
        echo "<li style='color: green;'>✓ $extension</li>";
    } else {
        echo "<li style='color: red;'>✗ $extension (missing)</li>";
    }
}
echo "</ul>";

// Display all loaded extensions
echo "<h2>All Loaded Extensions</h2>";
echo "<pre>";
print_r(get_loaded_extensions());
echo "</pre>";

// Display full PHP info
echo "<h2>Full PHP Info</h2>";
phpinfo();
?>
