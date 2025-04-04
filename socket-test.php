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

echo "<h1>MySQL Socket Test</h1>";

// Try different socket paths
$socketPaths = [
    '/var/lib/mysql/mysql.sock',
    '/var/run/mysqld/mysqld.sock',
    '/tmp/mysql.sock',
    '/opt/lampp/var/mysql/mysql.sock',
    '/var/mysql/mysql.sock'
];

foreach ($socketPaths as $socket) {
    echo "<h2>Testing socket: $socket</h2>";
    try {
        $dsn = "mysql:unix_socket=$socket;dbname=$db";
        $pdo = new PDO($dsn, $user, $pass);
        echo "<p style='color:green'>✓ Connection successful using this socket!</p>";

        // If we get here, we've found a working socket
        echo "<h3>This socket works! Use it in your .env file as:</h3>";
        echo "<code>DB_HOST=localhost;unix_socket=$socket</code>";

        // Exit after finding the first working socket
        break;
    } catch (PDOException $e) {
        echo "<p style='color:red'>✗ Connection failed: " . $e->getMessage() . "</p>";
    }
}

// Get system and PHP info
echo "<h2>System Info</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Operating System: " . PHP_OS . "</p>";

if (function_exists('shell_exec')) {
    echo "<h3>Looking for MySQL socket using system commands:</h3>";
    echo "<pre>";
    echo shell_exec('find / -name "*.sock" -type s 2>/dev/null | grep -i mysql');
    echo "</pre>";
}
