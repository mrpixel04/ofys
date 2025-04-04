<?php
// Enable full error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>PHP Version Selector</h1>";

echo "<h2>Current PHP Version</h2>";
echo "PHP Version: " . phpversion() . "<br>";

// Check for common PHP version paths on shared hosting
$possiblePaths = [
    '/usr/local/bin/php',
    '/usr/bin/php',
    '/opt/cpanel/ea-php74/root/usr/bin/php',
    '/opt/cpanel/ea-php80/root/usr/bin/php',
    '/opt/cpanel/ea-php81/root/usr/bin/php',
    '/opt/cpanel/ea-php82/root/usr/bin/php',
    '/opt/cpanel/ea-php83/root/usr/bin/php',
    '/opt/php74/bin/php',
    '/opt/php80/bin/php',
    '/opt/php81/bin/php',
    '/opt/php82/bin/php',
    '/opt/php83/bin/php'
];

echo "<h2>Available PHP Versions</h2>";

foreach ($possiblePaths as $path) {
    if (function_exists('shell_exec')) {
        $result = @shell_exec("$path -v 2>&1");
        if ($result && strpos($result, 'PHP') !== false) {
            echo "<p>Found: $path - $result</p>";
        }
    }
}

// Function to check if we can create .htaccess file
echo "<h2>PHP Handler Information</h2>";
echo "Server API: " . php_sapi_name() . "<br>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";

echo "<h2>cPanel PHP Information</h2>";
echo "Look for these files in cPanel to change PHP version:<br>";
echo "- /home/[username]/public_html/.htaccess<br>";
echo "- /home/[username]/.php/phprc<br>";
echo "- /home/[username]/.php.ini<br>";

echo "<h2>How to Switch PHP Version</h2>";
echo "<p>For cPanel hosting:</p>";
echo "<ol>";
echo "<li>Login to cPanel</li>";
echo "<li>Look for 'MultiPHP Manager' or 'Select PHP Version'</li>";
echo "<li>Choose PHP 8.2 or higher for your domain</li>";
echo "<li>Make sure PDO and PDO_MySQL extensions are enabled</li>";
echo "</ol>";

echo "<p>If you can't find these options, contact your hosting provider.</p>";
