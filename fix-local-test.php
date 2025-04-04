<?php
// Output as plain text
header('Content-Type: text/plain');

echo "PHP Version: " . phpversion() . "\n\n";

// Check PHP extensions
$requiredExtensions = [
    'BCMath', 'Ctype', 'Fileinfo', 'JSON', 'Mbstring',
    'OpenSSL', 'PDO', 'Tokenizer', 'XML', 'pdo_mysql'
];

echo "Checking Required PHP Extensions:\n";
foreach ($requiredExtensions as $extension) {
    echo $extension . ": " . (extension_loaded(strtolower($extension)) ? "Loaded ✓" : "Not Loaded ✗") . "\n";
}

echo "\nChecking Directory Permissions:\n";
$directories = [
    'storage/app',
    'storage/framework',
    'storage/logs',
    'bootstrap/cache'
];

foreach ($directories as $directory) {
    if (file_exists($directory)) {
        echo "$directory: Exists, ";
        echo "Writable: " . (is_writable($directory) ? "Yes ✓" : "No ✗") . "\n";
    } else {
        echo "$directory: Does not exist ✗\n";
    }
}

// Check for .env file
echo "\nChecking Configuration Files:\n";
echo ".env file: " . (file_exists('.env') ? "Exists ✓" : "Missing ✗") . "\n";

// Check for storage symlink
echo "Storage symlink: " . (file_exists('public/storage') ? "Exists ✓" : "Missing ✗") . "\n";

// Check if there's a Laravel error log we can access
echo "\nLatest Laravel Error (if available):\n";
if (file_exists('storage/logs/laravel.log')) {
    $log = file_get_contents('storage/logs/laravel.log');
    $lines = array_slice(explode("\n", $log), -20); // Get last 20 lines
    echo implode("\n", $lines);
} else {
    echo "No Laravel error log found\n";
}

echo "\n\nServer Information:\n";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
