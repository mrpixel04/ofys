<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$host = 'localhost';
$db   = 'eastbizz_dbofys';
$user = 'eastbizz_adofys';
$pass = 'fbi22031978';

echo "<h1>MySQLi Connection Test</h1>";

echo "<h2>PHP Info</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "MySQLi Extension: " . (extension_loaded('mysqli') ? 'Enabled' : 'Not enabled') . "<br>";
echo "MySQL Extension: " . (extension_loaded('mysql') ? 'Enabled' : 'Not enabled') . "<br>";

// Test connection with MySQLi
echo "<h2>Testing connection with MySQLi</h2>";
if (function_exists('mysqli_connect')) {
    $mysqli = @mysqli_connect($host, $user, $pass, $db);
    if ($mysqli) {
        echo "<p style='color:green'>✓ Connection successful!</p>";

        // Test a simple query
        $result = mysqli_query($mysqli, "SELECT NOW() as time");
        $row = mysqli_fetch_assoc($result);
        echo "<p>Current database time: " . $row['time'] . "</p>";

        mysqli_close($mysqli);
    } else {
        echo "<p style='color:red'>✗ Connection failed: " . mysqli_connect_error() . "</p>";
    }
} else {
    echo "<p style='color:red'>✗ MySQLi extension not available</p>";
}

// List loaded extensions
echo "<h2>Loaded PHP Extensions</h2>";
echo "<pre>";
print_r(get_loaded_extensions());
echo "</pre>";
