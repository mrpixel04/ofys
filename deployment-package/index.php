<?php
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * Bootstrap the Laravel application from the public directory.
 */

// Path to the front controller (this file)
define('LARAVEL_START', microtime(true));

// Load the autoloader
require __DIR__.'/vendor/autoload.php';

// Load the application
$app = require_once __DIR__.'/bootstrap/app.php';

// Run the application
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
