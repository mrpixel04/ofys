<?php

/**
 * Final URL Fix for Laravel on Subdirectory
 *
 * This script fixes the most common issues with Laravel in a subdirectory setup
 * based on the diagnostic results from your server.
 */

$basePath = realpath(__DIR__);
echo "Final URL Fix for Laravel...\n";
echo "Base path: {$basePath}\n\n";

// 1. Fix the .env file with correct paths and settings
echo "Updating .env file with correct values...\n";
if (file_exists($basePath . '/.env')) {
    $env = file_get_contents($basePath . '/.env');

    // Fix APP_URL - ensure it points to the subdirectory
    $env = preg_replace('/APP_URL=.*/', 'APP_URL=https://eastbizz.com/ofys', $env);

    // Set application to production mode
    $env = preg_replace('/APP_ENV=.*/', 'APP_ENV=production', $env);

    // Disable debug mode
    $env = preg_replace('/APP_DEBUG=.*/', 'APP_DEBUG=false', $env);

    // Set asset URL to match the subdirectory
    if (strpos($env, 'ASSET_URL') === false) {
        $env .= "\nASSET_URL=https://eastbizz.com/ofys\n";
    } else {
        $env = preg_replace('/ASSET_URL=.*/', 'ASSET_URL=https://eastbizz.com/ofys', $env);
    }

    file_put_contents($basePath . '/.env', $env);
    echo "Updated .env file with correct URL settings.\n";
} else {
    echo "ERROR: .env file not found. This is required for Laravel to function.\n";
}

// 2. Update AppServiceProvider to handle subdirectory URLs
echo "\nUpdating AppServiceProvider.php for subdirectory...\n";
$appServicePath = $basePath . '/app/Providers/AppServiceProvider.php';

if (file_exists($appServicePath)) {
    $appService = file_get_contents($appServicePath);

    // Check if we need to update the class
    if (strpos($appService, 'URL::forceRootUrl') === false) {
        // Find the boot method
        $pattern = '/public function boot\(\)(?::\s*void)?\s*\{/';

        if (preg_match($pattern, $appService)) {
            // Add URL forcing inside the boot method
            $replacement = "public function boot()\n    {\n        // Force URLs for subdirectory installation\n        \\Illuminate\\Support\\Facades\\URL::forceRootUrl(config('app.url'));\n        if (str_contains(config('app.url'), 'https://')) {\n            \\Illuminate\\Support\\Facades\\URL::forceScheme('https');\n        }\n";

            $appService = preg_replace($pattern, $replacement, $appService);
            file_put_contents($appServicePath, $appService);
            echo "Updated AppServiceProvider.php to handle subdirectory URLs.\n";
        } else {
            echo "Could not find boot method in AppServiceProvider.php.\n";
        }
    } else {
        echo "AppServiceProvider.php already has URL configuration.\n";
    }
} else {
    echo "ERROR: AppServiceProvider.php not found.\n";
}

// 3. Create a public/.htaccess file specifically for subdirectory
echo "\nCreating custom .htaccess for subdirectory...\n";
$htaccess = <<<'EOL'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOL;
file_put_contents($basePath . '/public/.htaccess', $htaccess);
echo "Created public/.htaccess file.\n";

// 4. Create root .htaccess file
echo "Creating root .htaccess file for subdirectory access...\n";
$rootHtaccess = <<<'EOL'
<IfModule mod_rewrite.c>
    RewriteEngine On
    # Handle direct access to /ofys instead of /ofys/public
    RewriteRule ^$ public/ [L]
    RewriteRule (.*) public/$1 [L]
</IfModule>
EOL;
file_put_contents($basePath . '/.htaccess', $rootHtaccess);
echo "Created root .htaccess file.\n";

// 5. Clear all Laravel caches
echo "\nClearing Laravel caches...\n";
$cacheFiles = glob($basePath . '/bootstrap/cache/*.php');
if (!empty($cacheFiles)) {
    array_map('unlink', $cacheFiles);
    echo "Cleared " . count($cacheFiles) . " cache files.\n";
} else {
    echo "No cache files to clear.\n";
}

// 6. Create a simple index.php in public directory
echo "\nCreating a simple index.php file...\n";
$indexPhp = <<<'EOL'
<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 * Customized for subdirectory installation
 */

// Define the absolute path to the application
$basePath = realpath(__DIR__ . '/..');

// Register The Auto Loader
require $basePath . '/vendor/autoload.php';

// Run The Application
$app = require_once $basePath . '/bootstrap/app.php';

// Handle the request
$kernel = $app->make(Illuminate\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
EOL;
file_put_contents($basePath . '/public/index.php', $indexPhp);
echo "Created simple index.php file.\n";

// 7. Create a simple test route to verify routing is working
echo "\nCreating a test route to verify routing...\n";
$routePath = $basePath . '/routes/web.php';
if (file_exists($routePath)) {
    $routes = file_get_contents($routePath);

    // Add test route if it doesn't exist
    if (strpos($routes, 'Route::get(\'/test-route\'') === false) {
        $testRoute = "\n// Test route to verify routing is working\nRoute::get('/test-route', function () {\n    return 'Laravel routing is working correctly in subdirectory setup!';\n});\n";
        file_put_contents($routePath, $routes . $testRoute);
        echo "Added test route to routes/web.php.\n";
    } else {
        echo "Test route already exists.\n";
    }
} else {
    echo "ERROR: routes/web.php not found.\n";
}

echo "\nFix complete! Please try the following URLs to test your application:\n";
echo "1. Main application: https://eastbizz.com/ofys/\n";
echo "2. Direct public access: https://eastbizz.com/ofys/public\n";
echo "3. Test route: https://eastbizz.com/ofys/test-route\n";
echo "4. Diagnostic page: https://eastbizz.com/ofys/public/diagnose.php\n\n";
echo "If you still have 500 errors, please check your server error logs for specific error messages.\n";
