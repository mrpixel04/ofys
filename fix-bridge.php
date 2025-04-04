<?php
// Fix Laravel bridge file
header('Content-Type: text/plain');

$rootDir = __DIR__;
$indexPath = $rootDir . '/index.php';
$bridgeContent = <<<'EOD'
<?php
/**
 * Laravel - A PHP Framework For Web Artisans
 * This file serves as a bridge to forward requests to Laravel's public/index.php
 */

// Define the path to Laravel's public directory
$publicPath = __DIR__ . '/public';

// Include public/index.php if it exists
if (file_exists($publicPath . '/index.php')) {
    // Set the correct working directory
    chdir($publicPath);

    // Define paths to help Laravel determine the project directory
    $realPublicDir = realpath($publicPath);
    if ($realPublicDir) {
        $_SERVER['DOCUMENT_ROOT'] = $realPublicDir;
    }

    // Forward the request to the Laravel application
    require_once $publicPath . '/index.php';
} else {
    // Display an error if public/index.php is missing
    http_response_code(500);
    echo 'Laravel public/index.php not found. Please check your installation.';
}
EOD;

// Create or update the bridge file
if (file_put_contents($indexPath, $bridgeContent)) {
    echo "Successfully updated the Laravel bridge file at " . $indexPath . "\n";
} else {
    echo "Failed to update the Laravel bridge file. Please check file permissions.\n";
}

// Check if .htaccess exists in the root directory
$rootHtaccessPath = $rootDir . '/.htaccess';
$publicHtaccessPath = $rootDir . '/public/.htaccess';

// Root .htaccess content
$rootHtaccessContent = <<<'EOD'
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Redirect all requests to index.php
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Deny access to sensitive files
<FilesMatch "^\.env|composer\.json|composer\.lock|artisan$">
    Order allow,deny
    Deny from all
</FilesMatch>

# PHP settings
<IfModule mod_php8.c>
    php_value upload_max_filesize 64M
    php_value post_max_size 64M
    php_value max_execution_time 300
    php_value max_input_time 300
</IfModule>
EOD;

// Public .htaccess content
$publicHtaccessContent = <<<'EOD'
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
EOD;

// Create or update the root .htaccess
if (file_put_contents($rootHtaccessPath, $rootHtaccessContent)) {
    echo "Successfully updated the root .htaccess file.\n";
} else {
    echo "Failed to update the root .htaccess file. Please check file permissions.\n";
}

// Create or update the public .htaccess
if (file_put_contents($publicHtaccessPath, $publicHtaccessContent)) {
    echo "Successfully updated the public .htaccess file.\n";
} else {
    echo "Failed to update the public .htaccess file. Please check file permissions.\n";
}

echo "\nFixes completed! Please try accessing your Laravel application at https://ofys.eastbizz.com/\n";
echo "If you still encounter issues, run the detailed-error.php script for more diagnostics.\n";
?>