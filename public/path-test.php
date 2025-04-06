<?php

// Basic PHP setup
define('LARAVEL_START', microtime(true));

// Load the autoloader
require __DIR__.'/../vendor/autoload.php';

// This is a simplified version of the Laravel bootstrap process
// Just enough to test asset and URL helpers

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

// Register important service providers
$app->register(Illuminate\Foundation\Providers\FoundationServiceProvider::class);
$app->register(Illuminate\View\ViewServiceProvider::class);

// Boot the application
$app->boot();

// Include our helper function - ONLY if it's not already loaded
// Commented out since Laravel's composer.json should already autoload helpers.php
// require_once dirname(__DIR__) . '/app/helpers.php';

// Basic HTML setup
echo "<!DOCTYPE html>";
echo "<html><head><title>Laravel Path Testing</title></head><body>";
echo "<h1>Laravel Path Helper Test</h1>";

// Test various asset path helpers
try {
    echo "<h2>Asset Helpers</h2>";
    echo "<ul>";
    echo "<li>asset('js/app.js'): " . asset('js/app.js') . "</li>";
    echo "<li>asset('css/app.css'): " . asset('css/app.css') . "</li>";
    echo "<li>asset('build/assets/app-BPKtxCGZ.js'): " . asset('build/assets/app-BPKtxCGZ.js') . "</li>";
    echo "<li>asset('build/assets/app-CFTAco04.css'): " . asset('build/assets/app-CFTAco04.css') . "</li>";

    // Test vite_asset helper if it exists
    if (function_exists('vite_asset')) {
        echo "<li>vite_asset('resources/js/app.js'): " . vite_asset('resources/js/app.js') . "</li>";
        echo "<li>vite_asset('resources/css/app.css'): " . vite_asset('resources/css/app.css') . "</li>";
    } else {
        echo "<li style='color:red'>vite_asset() function does not exist</li>";
    }
    echo "</ul>";

    // Environment information
    echo "<h2>Environment</h2>";
    echo "<ul>";
    echo "<li>APP_URL: " . env('APP_URL') . "</li>";
    echo "<li>ASSET_URL: " . env('ASSET_URL') . "</li>";
    echo "<li>VITE_ASSET_URL: " . env('VITE_ASSET_URL') . "</li>";
    echo "<li>app()->environment(): " . app()->environment() . "</li>";
    echo "</ul>";

    // Manifest information
    echo "<h2>Manifest Info</h2>";
    $manifestPath = public_path('build/manifest.json');
    if (file_exists($manifestPath)) {
        $manifest = json_decode(file_get_contents($manifestPath), true);
        echo "<pre>" . json_encode($manifest, JSON_PRETTY_PRINT) . "</pre>";
    } else {
        echo "<p style='color:red'>Manifest file not found at: $manifestPath</p>";
    }

} catch (Exception $e) {
    echo "<div style='color: red'>";
    echo "<h3>Error Occurred</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    echo "</div>";
}

echo "</body></html>";
