<?php
// Enable full error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$host = 'localhost';
$db   = 'eastbizz_dbofys';
$user = 'eastbizz_adofys';
$pass = 'fbi22031978';

echo "<h1>Simple Database Test</h1>";

// Test PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    echo "<p style='color:green'>✓ PDO Connection successful!</p>";
} catch (PDOException $e) {
    echo "<p style='color:red'>✗ PDO Connection failed: " . $e->getMessage() . "</p>";

    // More detailed error info
    echo "<pre>";
    print_r($e);
    echo "</pre>";
}

// Get PHP info about MySQL
echo "<h2>MySQL Info</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";

// Try MySQLi as alternative
if (function_exists('mysqli_connect')) {
    echo "<h2>Testing MySQLi</h2>";
    $mysqli = @mysqli_connect($host, $user, $pass, $db);
    if ($mysqli) {
        echo "<p style='color:green'>✓ MySQLi connection successful!</p>";
        mysqli_close($mysqli);
    } else {
        echo "<p style='color:red'>✗ MySQLi connection failed: " . mysqli_connect_error() . "</p>";
    }
}