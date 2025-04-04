<?php
// Enable full error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials from .env
$host = 'localhost';
$db   = 'eastbizz_dbofys';
$user = 'eastbizz_adofys';
$pass = 'fbi22031978';
$port = 3306;

// Set execution time limit higher
ini_set('max_execution_time', 60); // 60 seconds

echo "<h1>Database Connection Test</h1>";

// Try connecting with localhost
try {
    echo "<h2>Testing connection with host='localhost'...</h2>";
    $pdo = new PDO("mysql:host=$host;dbname=$db;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color:green'>✓ Connected successfully!</p>";

    // Test a simple query
    $stmt = $pdo->query("SELECT NOW() as current_time");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Current database time: " . $result['current_time'] . "</p>";

} catch (PDOException $e) {
    echo "<p style='color:red'>✗ Connection failed: " . $e->getMessage() . "</p>";
}

// Try connecting with 127.0.0.1
try {
    echo "<h2>Testing connection with host='127.0.0.1'...</h2>";
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=$db;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color:green'>✓ Connected successfully!</p>";

    // Test a simple query
    $stmt = $pdo->query("SELECT NOW() as current_time");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Current database time: " . $result['current_time'] . "</p>";

} catch (PDOException $e) {
    echo "<p style='color:red'>✗ Connection failed: " . $e->getMessage() . "</p>";
}

// Show PHP version and MySQL/PDO info
echo "<h2>PHP Environment</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>PDO MySQL Extension: " . (extension_loaded('pdo_mysql') ? 'Enabled' : 'Not enabled') . "</p>";
echo "<p>MySQL Extension: " . (extension_loaded('mysql') ? 'Enabled' : 'Not enabled') . "</p>";
echo "<p>MySQLi Extension: " . (extension_loaded('mysqli') ? 'Enabled' : 'Not enabled') . "</p>";

// Try to find socket path
echo "<h2>MySQL Socket Information</h2>";
$possibleSocketPaths = [
    '/var/lib/mysql/mysql.sock',
    '/var/run/mysqld/mysqld.sock',
    '/tmp/mysql.sock',
    '/var/mysql/mysql.sock'
];

foreach ($possibleSocketPaths as $socketPath) {
    echo "<p>Checking {$socketPath}: " . (file_exists($socketPath) ? 'Found' : 'Not found') . "</p>";
}

// Check if mysqli_connect can find socket automatically
echo "<h2>Testing MySQLi auto-connect</h2>";
if (function_exists('mysqli_connect')) {
    try {
        $mysqli = mysqli_connect($host, $user, $pass, $db);
        echo "<p style='color:green'>✓ MySQLi connected successfully!</p>";
        mysqli_close($mysqli);
    } catch (Exception $e) {
        echo "<p style='color:red'>✗ MySQLi connection failed: " . $e->getMessage() . "</p>";
    }
}
