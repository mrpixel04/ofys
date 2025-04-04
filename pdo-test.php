<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>PDO Extension Test</h1>";

echo "<h2>PHP Version</h2>";
echo "PHP Version: " . phpversion() . "<br>";

echo "<h2>PDO Status</h2>";
if (class_exists('PDO')) {
    echo "<p style='color:green'>✅ PDO extension is enabled</p>";

    // Check for MySQL driver
    echo "<h3>PDO Drivers</h3>";
    $drivers = PDO::getAvailableDrivers();
    echo "Available drivers: " . implode(', ', $drivers) . "<br>";

    if (in_array('mysql', $drivers)) {
        echo "<p style='color:green'>✅ PDO MySQL driver is available</p>";

        // Try connecting to the database
        try {
            $host = 'localhost';
            $db   = 'eastbizz_dbofys';
            $user = 'eastbizz_adofys';
            $pass = 'fbi22031978';

            echo "<h3>Testing database connection</h3>";
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<p style='color:green'>✅ Database connection successful!</p>";

            // Test a simple query
            $stmt = $pdo->query("SELECT NOW() as time");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p>Current database time: " . $row['time'] . "</p>";
        } catch (PDOException $e) {
            echo "<p style='color:red'>❌ Database connection failed: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color:red'>❌ PDO MySQL driver not available</p>";
    }
} else {
    echo "<p style='color:red'>❌ PDO extension is NOT enabled</p>";
    echo "<p>You need to enable PDO extension for PHP 8.2</p>";

    echo "<h3>How to enable PDO:</h3>";
    echo "<ol>";
    echo "<li>Log into cPanel</li>";
    echo "<li>Go to 'Select PHP Version' or 'PHP Extensions'</li>";
    echo "<li>Check the boxes for 'pdo' and 'pdo_mysql'</li>";
    echo "<li>Apply changes</li>";
    echo "</ol>";
}
