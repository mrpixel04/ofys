<?php
// Test database connection
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Database Connection Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        h1 { color: #333; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Database Connection Test</h1>

    <?php
    // Load .env file
    $envPath = __DIR__ . '/.env';

    if (!file_exists($envPath)) {
        echo "<p class='error'>.env file not found!</p>";
        exit;
    }

    // Parse the .env file manually
    $env = [];
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $env[$key] = $value;
        }
    }

    // Check if all necessary database credentials are present
    $required = ['DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'];
    $missing = [];

    foreach ($required as $field) {
        if (empty($env[$field])) {
            $missing[] = $field;
        }
    }

    if (!empty($missing)) {
        echo "<p class='error'>Missing database configuration: " . implode(', ', $missing) . "</p>";
        echo "<p>Please run the fix-db.php script to complete your database configuration.</p>";
    } else {
        echo "<p>Database configuration found:</p>";
        echo "<ul>";
        echo "<li>Connection: {$env['DB_CONNECTION']}</li>";
        echo "<li>Host: {$env['DB_HOST']}</li>";
        echo "<li>Port: {$env['DB_PORT']}</li>";
        echo "<li>Database: {$env['DB_DATABASE']}</li>";
        echo "<li>Username: {$env['DB_USERNAME']}</li>";
        echo "<li>Password: " . (empty($env['DB_PASSWORD']) ? "Not set" : "Set (hidden)") . "</li>";
        echo "</ul>";

        // Attempt connection
        try {
            $pdo = new PDO(
                "{$env['DB_CONNECTION']}:host={$env['DB_HOST']};port={$env['DB_PORT']};dbname={$env['DB_DATABASE']}",
                $env['DB_USERNAME'],
                $env['DB_PASSWORD']
            );

            // Set PDO to throw exceptions on error
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo "<p class='success'>✓ Successfully connected to the database!</p>";

            // Display Laravel tables
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

            if (!empty($tables)) {
                echo "<p>Found " . count($tables) . " tables in your database:</p>";
                echo "<ul>";
                foreach ($tables as $table) {
                    echo "<li>{$table}</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No tables found in your database. Your Laravel migrations may not have been run yet.</p>";
            }

        } catch (PDOException $e) {
            echo "<p class='error'>✗ Database connection failed: " . $e->getMessage() . "</p>";
            echo "<p>Make sure your database credentials are correct and the database server is accessible.</p>";
        }
    }

    echo "<h2>Next Steps</h2>";
    echo "<ol>";
    echo "<li>If the connection test failed, update your database credentials using the fix-db.php script.</li>";
    echo "<li>If you need to run Laravel migrations, create a migrate.php script to run them.</li>";
    echo "<li>Once your database is connected, try accessing your Laravel application at <a href='https://ofys.eastbizz.com'>https://ofys.eastbizz.com</a></li>";
    echo "</ol>";
    ?>
</body>
</html>
