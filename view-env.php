<?php
// Simple script to view and edit .env file
header('Content-Type: text/plain');

$envPath = __DIR__ . '/.env';

if (file_exists($envPath)) {
    echo "Current .env file contents:\n\n";
    echo file_get_contents($envPath);
} else {
    echo ".env file not found!";
}
?>
