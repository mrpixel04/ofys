<?php

/**
 * Fix 500 Error in Laravel Production
 *
 * This script addresses common issues causing 500 errors in Laravel on shared hosting
 */

$basePath = realpath(__DIR__);
echo "Fixing 500 errors in Laravel...\n";
echo "Base path: {$basePath}\n\n";

// 1. Check and fix .htaccess files
echo "Checking .htaccess files...\n";

// Root .htaccess
$rootHtaccess = <<<'EOL'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
EOL;

file_put_contents($basePath . '/.htaccess', $rootHtaccess);
echo "Root .htaccess created.\n";

// Public .htaccess
$publicHtaccess = <<<'EOL'
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

file_put_contents($basePath . '/public/.htaccess', $publicHtaccess);
echo "Public .htaccess created.\n";

// 2. Create simple index.php
echo "\nCreating simpler index.php file...\n";
$indexPhp = <<<'EOL'
<?php

define('LARAVEL_START', microtime(true));

// Register The Auto Loader
require __DIR__.'/../vendor/autoload.php';

// Run The Application
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
EOL;

file_put_contents($basePath . '/public/index.php', $indexPhp);
echo "Simple index.php created.\n";

// 3. Fix storage permissions
echo "\nFixing storage directory permissions...\n";
$directories = [
    $basePath . '/storage/app',
    $basePath . '/storage/framework/cache',
    $basePath . '/storage/framework/sessions',
    $basePath . '/storage/framework/views',
    $basePath . '/storage/logs',
    $basePath . '/bootstrap/cache'
];

foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
        echo "Created directory: {$dir}\n";
    }

    chmod($dir, 0755);
    echo "Set permissions for: {$dir}\n";
}

// 4. Create a test file to verify PHP execution
echo "\nCreating test.php file to verify PHP execution...\n";
$testPhp = <<<'EOL'
<?php
phpinfo();
EOL;

file_put_contents($basePath . '/public/test.php', $testPhp);
echo "Test file created at public/test.php\n";

// 5. Update bootstrap/app.php to handle subdirectory
echo "\nChecking bootstrap/app.php...\n";
$bootstrapApp = file_get_contents($basePath . '/bootstrap/app.php');

// Only add the code if it's not already there
if (strpos($bootstrapApp, 'detectEnvironment') === false) {
    // Find the line with $app = new Illuminate\Foundation\Application
    $pattern = '/\$app = new Illuminate\\\\Foundation\\\\Application\(/';

    $replacement = '$app = new Illuminate\\Foundation\\Application(
    realpath(__DIR__.\'/../\')
);

// Force production environment
$app->detectEnvironment(function() {
    return \'production\';
});

// Set storage path explicitly
$app->useStoragePath(realpath(__DIR__.\'/../storage\'));';

    $bootstrapApp = preg_replace($pattern, $replacement, $bootstrapApp);
    file_put_contents($basePath . '/bootstrap/app.php', $bootstrapApp);
    echo "Updated bootstrap/app.php with correct paths and environment detection.\n";
} else {
    echo "bootstrap/app.php already contains environment detection.\n";
}

echo "\nAll fixes applied. Please try accessing your site now.\n";
echo "If you still have issues, please check the following:\n";
echo "1. Try accessing the test file at: https://eastbizz.com/ofys/public/test.php\n";
echo "2. Check your server error logs for specific error messages\n";
echo "3. Ensure your hosting supports PHP 8.x and has all required extensions\n";
