<?php
// Instructions for OFYS Server Tests
?>
<!DOCTYPE html>
<html>
<head>
    <title>OFYS Server Tests - Instructions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2, h3 {
            color: #333;
        }
        pre {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
        code {
            background-color: #f5f5f5;
            padding: 2px 4px;
            border-radius: 3px;
        }
        .test-group {
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>OFYS Server Tests - Instructions</h1>

    <div class="test-group">
        <h2>Overview</h2>
        <p>This suite of test files is designed to help diagnose and fix common issues with Laravel applications on shared hosting environments, particularly related to asset loading, path configuration, and htaccess rules.</p>

        <h3>Test Files</h3>
        <table>
            <tr>
                <th>Test</th>
                <th>Purpose</th>
            </tr>
            <tr>
                <td><a href="asset-test.php">asset-test.php</a></td>
                <td>Tests whether CSS/JS assets are loading properly and displays asset URLs</td>
            </tr>
            <tr>
                <td><a href="path-test.php">path-test.php</a></td>
                <td>Shows server paths and configurations to help diagnose path-related issues</td>
            </tr>
            <tr>
                <td><a href="mime-test.php">mime-test.php</a></td>
                <td>Tests MIME type handling for various file types</td>
            </tr>
            <tr>
                <td><a href="htaccess-test.php">htaccess-test.php</a></td>
                <td>Tests if .htaccess rules are being processed correctly</td>
            </tr>
            <tr>
                <td><a href="asset-proxy-test.php">asset-proxy-test.php</a></td>
                <td>Tests a custom PHP asset proxy solution for serving assets</td>
            </tr>
        </table>
    </div>

    <div class="test-group">
        <h2>How to Use These Tests</h2>

        <h3>Step 1: Upload Tests to Server</h3>
        <p>Upload all the test files to your server, preferably in a directory like <code>/server-tests/</code> at the same level as your Laravel public directory.</p>

        <h3>Step 2: Run Each Test</h3>
        <p>Visit each test in your browser and follow the on-screen instructions to diagnose issues.</p>

        <h3>Step 3: Analyze Results</h3>
        <p>Based on the test results, you'll be able to identify common issues:</p>
        <ul>
            <li>Path configuration problems</li>
            <li>Asset loading issues</li>
            <li>MIME type misconfiguration</li>
            <li>.htaccess rule processing issues</li>
        </ul>

        <h3>Step 4: Apply Solutions</h3>
        <p>Each test provides recommended solutions based on the results.</p>
    </div>

    <div class="test-group">
        <h2>Asset Test Details</h2>
        <p>The asset test helps identify if your application's CSS and JavaScript files are loading properly.</p>

        <h3>What It Tests</h3>
        <ul>
            <li>Whether CSS/JS files can be loaded from standard locations</li>
            <li>Asset URL formation (absolute vs. relative paths)</li>
            <li>Proper MIME type handling for assets</li>
        </ul>

        <h3>Potential Solutions for Asset Issues</h3>
        <ul>
            <li>Update your asset paths in blade templates:
<pre>
&lt;!-- Instead of: --&gt;
&lt;link href="{{ asset('css/app.css') }}" rel="stylesheet"&gt;

&lt;!-- Try: --&gt;
&lt;link href="{{ url('css/app.css') }}" rel="stylesheet"&gt;
<!-- or -->
&lt;link href="/css/app.css" rel="stylesheet"&gt;
</pre>
            </li>
            <li>Create an asset proxy script (see asset-proxy-test.php)</li>
            <li>Ensure proper .htaccess configuration</li>
        </ul>
    </div>

    <div class="test-group">
        <h2>Path Test Details</h2>
        <p>The path test shows server configuration and file paths to help diagnose path-related issues.</p>

        <h3>What It Shows</h3>
        <ul>
            <li>Document root</li>
            <li>Script paths</li>
            <li>Directory structure</li>
            <li>Server environment variables</li>
        </ul>

        <h3>Using Path Information</h3>
        <p>Compare the path information with your Laravel configuration to ensure paths are correctly set in:</p>
        <ul>
            <li>.env file</li>
            <li>config/app.php (for URL configuration)</li>
            <li>public/.htaccess</li>
        </ul>
    </div>

    <div class="test-group">
        <h2>MIME Test Details</h2>
        <p>This test checks if your server is correctly handling MIME types for different file extensions.</p>

        <h3>What It Tests</h3>
        <ul>
            <li>CSS and JS MIME type detection</li>
            <li>Image MIME type handling</li>
            <li>Font MIME type configuration</li>
        </ul>

        <h3>Fixing MIME Type Issues</h3>
        <p>If MIME types are incorrectly configured, add these rules to your .htaccess:</p>
<pre>
&lt;IfModule mod_mime.c&gt;
    AddType text/css .css
    AddType application/javascript .js
    AddType image/jpeg .jpg .jpeg
    AddType image/png .png
    AddType image/svg+xml .svg
    AddType application/font-woff .woff
    AddType application/font-woff2 .woff2
&lt;/IfModule&gt;
</pre>
    </div>

    <div class="test-group">
        <h2>Htaccess Test Details</h2>
        <p>This test verifies if .htaccess rules are being processed correctly on your server.</p>

        <h3>What It Tests</h3>
        <ul>
            <li>Mod_rewrite functionality</li>
            <li>Header modification</li>
            <li>Basic rewrites and redirects</li>
        </ul>

        <h3>Common .htaccess Issues</h3>
        <ul>
            <li>AllowOverride not set to All in Apache configuration</li>
            <li>mod_rewrite not enabled</li>
            <li>Syntax errors in .htaccess rules</li>
        </ul>

        <h3>Laravel-Specific .htaccess</h3>
        <p>For Laravel, ensure your public/.htaccess contains:</p>
<pre>
&lt;IfModule mod_rewrite.c&gt;
    &lt;IfModule mod_negotiation.c&gt;
        Options -MultiViews -Indexes
    &lt;/IfModule&gt;

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
&lt;/IfModule&gt;
</pre>
    </div>

    <div class="test-group">
        <h2>Asset Proxy Solution</h2>
        <p>The asset proxy test demonstrates a PHP-based solution for serving assets when direct asset loading fails.</p>

        <h3>How It Works</h3>
        <p>The asset proxy:</p>
        <ul>
            <li>Intercepts requests for static assets (CSS, JS, images)</li>
            <li>Serves them with correct MIME types</li>
            <li>Provides detailed debugging information</li>
        </ul>

        <h3>Implementation Steps</h3>
        <ol>
            <li>Copy the asset-proxy.php file to your Laravel root directory</li>
            <li>Add .htaccess rules to redirect asset requests to the proxy</li>
            <li>Test with your application's assets</li>
        </ol>

        <h3>Sample .htaccess for Asset Proxy</h3>
<pre>
# Asset proxy .htaccess rules
&lt;IfModule mod_rewrite.c&gt;
    RewriteEngine On

    # Don't proxy requests to PHP files
    RewriteCond %{REQUEST_URI} !\.php$

    # Redirect CSS files to asset proxy
    RewriteRule ^css/(.*)$ asset-proxy.php?css=$1 [L]

    # Redirect JS files to asset proxy
    RewriteRule ^js/(.*)$ asset-proxy.php?js=$1 [L]

    # Redirect build assets to asset proxy
    RewriteRule ^build/assets/(.*)$ asset-proxy.php?build=$1 [L]

    # Redirect storage files to asset proxy
    RewriteRule ^storage/(.*)$ asset-proxy.php?storage=$1 [L]
&lt;/IfModule&gt;
</pre>
    </div>

    <div class="test-group">
        <h2>Laravel Deployment Best Practices for Shared Hosting</h2>

        <h3>Directory Structure</h3>
        <p>Recommended directory structure for shared hosting:</p>
<pre>
public_html/       # Web root directory
    index.php      # Laravel's public/index.php
    .htaccess      # Laravel's public/.htaccess
    css/           # CSS files
    js/            # JavaScript files
    storage/       # Symbolic link to ../laravel/storage/app/public
laravel/           # Laravel application (outside web root)
    app/
    bootstrap/
    config/
    database/
    routes/
    storage/
    vendor/
    .env
    artisan
</pre>

        <h3>Key Modifications</h3>
        <ol>
            <li>Update paths in index.php to point to the correct location:
<pre>
require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';
</pre>
            </li>
            <li>Set the correct APP_URL in .env:
<pre>
APP_URL=https://yourdomain.com
</pre>
            </li>
            <li>Create the storage symlink manually or via SSH if available:
<pre>
ln -s /path/to/laravel/storage/app/public /path/to/public_html/storage
</pre>
            </li>
        </ol>
    </div>

    <div class="test-group">
        <h2>Final Checklist</h2>
        <ul>
            <li>✅ Correct directory structure</li>
            <li>✅ Proper .htaccess configuration</li>
            <li>✅ Working asset loading (direct or via proxy)</li>
            <li>✅ Storage link created</li>
            <li>✅ Correct APP_URL in .env</li>
            <li>✅ File permissions set correctly</li>
            <li>✅ Cache cleared after deployment</li>
        </ul>
    </div>

    <!-- Navigation -->
    <hr>
    <h3>Navigation</h3>
    <ul>
        <li><a href="asset-test.php">Asset Test</a></li>
        <li><a href="path-test.php">Path Test</a></li>
        <li><a href="mime-test.php">MIME Test</a></li>
        <li><a href="htaccess-test.php">Htaccess Test</a></li>
        <li><a href="asset-proxy-test.php">Asset Proxy Test</a></li>
        <li><a href="instructions.php">Instructions</a></li>
    </ul>
</body>
</html>
