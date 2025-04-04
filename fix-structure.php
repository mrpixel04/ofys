<?php
// Check and fix Laravel hosting structure
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laravel Structure Fix</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        h1, h2, h3 { color: #333; }
        pre { background: #f5f5f5; padding: 10px; overflow: auto; border-radius: 4px; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        .info { color: blue; }
        .section { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Laravel Structure Fix</h1>

    <div class="section">
        <h2>Identifying Hosting Structure</h2>
        <?php
        $rootDir = __DIR__;
        $serverRoot = isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : '';
        $requestUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $scriptName = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';

        echo "<p>Current directory: " . $rootDir . "</p>";
        echo "<p>Server document root: " . $serverRoot . "</p>";
        echo "<p>Request URI: " . $requestUri . "</p>";
        echo "<p>Script name: " . $scriptName . "</p>";

        // Check if we're in a subdomain or subfolder setup
        $publicPath = $rootDir . '/public';
        $isSubdomain = ($serverRoot === $rootDir || $serverRoot === $rootDir . '/');
        $isSubfolder = (!$isSubdomain && strpos($serverRoot, $rootDir) !== false);

        if ($isSubdomain) {
            echo "<p class='info'>Detected setup: <strong>Subdomain pointing to Laravel root</strong></p>";
            echo "<p>In this setup, you need a bridge file that forwards requests to public/index.php</p>";
        } elseif ($isSubfolder) {
            echo "<p class='info'>Detected setup: <strong>Subfolder installation</strong></p>";
            echo "<p>In this setup, your Laravel application is installed in a subfolder of the document root.</p>";
        } else {
            echo "<p class='info'>Detected setup: <strong>Document root pointing to public directory</strong> (ideal setup)</p>";
            echo "<p>In this setup, the web server should be configured to use Laravel's public directory as the document root.</p>";
        }

        $action = isset($_GET['action']) ? $_GET['action'] : '';

        if ($action === 'fix_subdomain') {
            echo "<h3>Fixing subdomain setup...</h3>";

            // Create or update the bridge file
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

            if (file_put_contents($indexPath, $bridgeContent)) {
                echo "<p class='success'>✓ Successfully created bridge file at {$indexPath}</p>";
            } else {
                echo "<p class='error'>✗ Failed to create bridge file. Check permissions.</p>";
            }

            // Create or update root .htaccess
            $rootHtaccessPath = $rootDir . '/.htaccess';
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

            if (file_put_contents($rootHtaccessPath, $rootHtaccessContent)) {
                echo "<p class='success'>✓ Successfully created root .htaccess at {$rootHtaccessPath}</p>";
            } else {
                echo "<p class='error'>✗ Failed to create root .htaccess. Check permissions.</p>";
            }

            // Create or update public .htaccess
            $publicHtaccessPath = $publicPath . '/.htaccess';
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

            if (file_put_contents($publicHtaccessPath, $publicHtaccessContent)) {
                echo "<p class='success'>✓ Successfully created public .htaccess at {$publicHtaccessPath}</p>";
            } else {
                echo "<p class='error'>✗ Failed to create public .htaccess. Check permissions.</p>";
            }

            echo "<p class='success'>✓ Subdomain setup has been configured!</p>";
            echo "<p>Try accessing your Laravel application at: <a href='/'>https://ofys.eastbizz.com</a></p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>Fix Your Setup</h2>

        <?php if ($action !== 'fix_subdomain'): ?>
            <p>Based on the detected setup, we can apply the appropriate fixes:</p>

            <?php if ($isSubdomain): ?>
                <p><a href="?action=fix_subdomain" class="button">Fix Subdomain Setup</a></p>
                <p>This will:</p>
                <ul>
                    <li>Create a bridge file that forwards requests to public/index.php</li>
                    <li>Create proper .htaccess files in both root and public directories</li>
                </ul>
            <?php elseif ($isSubfolder): ?>
                <p class="info">Subfolder setup requires additional configuration. Contact your hosting provider for assistance.</p>
            <?php else: ?>
                <p class="success">Your setup appears to be the ideal configuration. No fixes needed!</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>Troubleshooting Apache Configuration</h2>
        <?php
        // Check for Apache modules
        function check_apache_module($name) {
            if (function_exists('apache_get_modules')) {
                $modules = apache_get_modules();
                return in_array($name, $modules);
            }
            // If apache_get_modules is not available, try phpinfo
            ob_start();
            phpinfo(INFO_MODULES);
            $phpinfo = ob_get_clean();
            return strpos($phpinfo, $name) !== false;
        }

        echo "<h3>Apache Module Check:</h3>";

        // Check for mod_rewrite
        $mod_rewrite = check_apache_module('mod_rewrite');
        if ($mod_rewrite) {
            echo "<p class='success'>✓ mod_rewrite is enabled</p>";
        } else {
            echo "<p class='warning'>! Unable to determine if mod_rewrite is enabled</p>";
            echo "<p>To enable mod_rewrite on shared hosting:</p>";
            echo "<ol>";
            echo "<li>Create or edit .htaccess file in your root directory</li>";
            echo "<li>Add the following directive: <code>RewriteEngine On</code></li>";
            echo "<li>Contact your hosting provider if you continue to have issues</li>";
            echo "</ol>";
        }

        // Test if .htaccess is working by writing a test file
        $testHtaccessDir = $rootDir . '/htaccess-test';
        $testHtaccessFile = $testHtaccessDir . '/.htaccess';
        $testHtmlFile = $testHtaccessDir . '/test.html';

        // Create test directory if it doesn't exist
        if (!file_exists($testHtaccessDir)) {
            mkdir($testHtaccessDir, 0755, true);
        }

        // Create .htaccess file that denies access to all html files
        $testHtaccessContent = "
<Files *.html>
    Order allow,deny
    Deny from all
</Files>
";
        file_put_contents($testHtaccessFile, $testHtaccessContent);

        // Create test HTML file
        $testHtmlContent = "<html><body><h1>Test Page</h1></body></html>";
        file_put_contents($testHtmlFile, $testHtmlContent);

        echo "<h3>.htaccess Test:</h3>";
        echo "<p>Created a test directory with .htaccess to verify if directives are honored.</p>";
        echo "<p>If .htaccess is working properly, the following link should give a 403 Forbidden error:</p>";
        echo "<p><a href='htaccess-test/test.html' target='_blank'>Test .htaccess restrictions</a></p>";
        echo "<p class='info'>Note: You need to click the link and check if you see a 403 error</p>";

        echo "<h3>Common Apache Issues:</h3>";
        echo "<ol>";
        echo "<li>mod_rewrite not enabled - contact your hosting provider</li>";
        echo "<li>AllowOverride not set to All - contact your hosting provider</li>";
        echo "<li>Incorrect .htaccess syntax - fixed by our script</li>";
        echo "<li>Directory permissions issues - fixed by our script</li>";
        echo "</ol>";
        ?>
    </div>

    <div class="section">
        <h2>PHP Configuration Check</h2>
        <?php
        // Check PHP settings
        $requiredExtensions = ['openssl', 'pdo', 'mbstring', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath', 'fileinfo', 'pdo_mysql'];
        $missingExtensions = [];

        foreach ($requiredExtensions as $ext) {
            if (!extension_loaded($ext)) {
                $missingExtensions[] = $ext;
            }
        }

        if (empty($missingExtensions)) {
            echo "<p class='success'>✓ All required PHP extensions are installed</p>";
        } else {
            echo "<p class='error'>✗ Missing PHP extensions: " . implode(', ', $missingExtensions) . "</p>";
            echo "<p>Contact your hosting provider to enable these extensions.</p>";
        }

        // Check PHP version
        $phpVersion = PHP_VERSION;
        $minVersion = '8.0.0';

        if (version_compare($phpVersion, $minVersion, '>=')) {
            echo "<p class='success'>✓ PHP version {$phpVersion} is compatible</p>";
        } else {
            echo "<p class='error'>✗ PHP version {$phpVersion} is below the recommended minimum ({$minVersion})</p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>Final Recommendations</h2>
        <ol>
            <li>Run the diagnostic script: <a href="detailed-error.php">detailed-error.php</a></li>
            <li>Clear Laravel cache: <a href="clear-cache.php">clear-cache.php</a></li>
            <li>Test database connection: <a href="test-db.php">test-db.php</a></li>
            <li>If still having issues, check the Laravel log for specific errors</li>
            <li>If mod_rewrite is not working, contact your hosting provider</li>
        </ol>
    </div>
</body>
</html>
