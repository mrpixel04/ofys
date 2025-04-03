<?php

/**
 * Database Connection Test
 *
 * This script tests the database connection using the settings in your .env file.
 * It helps identify if database connectivity is causing 500 errors in Laravel.
 */

echo "<h1>Database Connection Test</h1>";

// Get the root directory
$basePath = realpath(__DIR__ . '/..');
echo "<p>Base path: {$basePath}</p>";

// Load the .env file
if (file_exists($basePath . '/.env')) {
    echo "<p>✅ .env file found.</p>";

    // Parse the .env file
    $env = parse_ini_file($basePath . '/.env');

    if ($env) {
        echo "<h2>Database Settings from .env</h2>";
        echo "<ul>";
        echo "<li>DB_CONNECTION: " . ($env['DB_CONNECTION'] ?? 'Not set') . "</li>";
        echo "<li>DB_HOST: " . ($env['DB_HOST'] ?? 'Not set') . "</li>";
        echo "<li>DB_PORT: " . ($env['DB_PORT'] ?? 'Not set') . "</li>";
        echo "<li>DB_DATABASE: " . ($env['DB_DATABASE'] ?? 'Not set') . "</li>";
        echo "<li>DB_USERNAME: " . ($env['DB_USERNAME'] ?? 'Not set') . "</li>";
        echo "<li>DB_PASSWORD: " . (isset($env['DB_PASSWORD']) ? '******' : 'Not set') . "</li>";
        echo "</ul>";

        // Try to connect to the database
        echo "<h2>Testing Database Connection</h2>";
        try {
            $dbConnection = $env['DB_CONNECTION'] ?? 'mysql';
            $dbHost = $env['DB_HOST'] ?? '127.0.0.1';
            $dbPort = $env['DB_PORT'] ?? '3306';
            $dbName = $env['DB_DATABASE'] ?? '';
            $dbUsername = $env['DB_USERNAME'] ?? '';
            $dbPassword = $env['DB_PASSWORD'] ?? '';

            // Create a PDO connection
            if ($dbName && $dbUsername) {
                $dsn = "{$dbConnection}:host={$dbHost};port={$dbPort};dbname={$dbName}";
                $pdo = new PDO($dsn, $dbUsername, $dbPassword);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                echo "<p>✅ Successfully connected to the database!</p>";

                // Check if important tables exist
                $tables = ['users', 'migrations', 'password_reset_tokens', 'failed_jobs'];
                echo "<h3>Checking Core Tables</h3>";
                echo "<ul>";

                foreach ($tables as $table) {
                    $stmt = $pdo->prepare("SHOW TABLES LIKE ?");
                    $stmt->execute([$table]);

                    if ($stmt->rowCount() > 0) {
                        echo "<li>✅ Table '{$table}' exists</li>";
                    } else {
                        echo "<li>❌ Table '{$table}' does not exist</li>";
                    }
                }

                echo "</ul>";

                // Get total number of tables
                $stmt = $pdo->query("SHOW TABLES");
                $totalTables = $stmt->rowCount();
                echo "<p>Total tables in database: {$totalTables}</p>";

                if ($totalTables == 0) {
                    echo "<p>⚠️ <strong>Warning:</strong> No tables found in the database. You may need to run migrations.</p>";
                }
            } else {
                echo "<p>❌ Missing required database configuration in .env file. Please check your database settings.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>❌ Failed to connect to the database: " . $e->getMessage() . "</p>";
            echo "<h3>Common Database Error Solutions</h3>";
            echo "<ol>";
            echo "<li>Check if the database exists and the user has access to it</li>";
            echo "<li>Verify the database credentials in your .env file</li>";
            echo "<li>Ensure the database server is running and accessible</li>";
            echo "<li>Check if the database user has correct permissions</li>";
            echo "</ol>";
        }
    } else {
        echo "<p>❌ Failed to parse .env file.</p>";
    }
} else {
    echo "<p>❌ .env file not found at {$basePath}/.env</p>";
}

echo "<h2>Next Steps</h2>";
echo "<ol>";
echo "<li>If database connection failed, fix the issues noted above</li>";
echo "<li>If database connection succeeded but you still have 500 errors, the issue may be elsewhere</li>";
echo "<li>Try running migrations with: <code>php artisan migrate</code></li>";
echo "<li>Check Laravel log file at: <code>{$basePath}/storage/logs/laravel.log</code></li>";
echo "</ol>";
