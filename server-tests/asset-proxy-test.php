<?php
// Test custom asset proxy file for handling assets
echo "<h2>Asset Proxy Test</h2>";

// Create the asset proxy file
$asset_proxy_php = <<<EOT
<?php
// asset-proxy.php - Handle asset serving for shared hosting
header('Access-Control-Allow-Origin: *');

// For debugging
\$debug_log = [];
\$debug_log[] = "Request URI: " . \$_SERVER['REQUEST_URI'];
\$debug_log[] = "Query string: " . \$_SERVER['QUERY_STRING'];

\$requestUri = \$_SERVER['REQUEST_URI'];

// Handle storage files
if (isset(\$_GET['storage'])) {
    \$path = 'storage/' . \$_GET['storage'];
    \$fullPath = __DIR__ . '/' . \$path;
    \$debug_log[] = "Storage path: \$fullPath";

    if (file_exists(\$fullPath)) {
        // Set appropriate content type based on file extension
        \$ext = pathinfo(\$fullPath, PATHINFO_EXTENSION);
        \$debug_log[] = "File extension: \$ext";

        switch (\$ext) {
            case 'jpg':
            case 'jpeg':
                header('Content-Type: image/jpeg');
                break;
            case 'png':
                header('Content-Type: image/png');
                break;
            case 'gif':
                header('Content-Type: image/gif');
                break;
            case 'css':
                header('Content-Type: text/css');
                break;
            case 'js':
                header('Content-Type: application/javascript');
                break;
            default:
                header('Content-Type: application/octet-stream');
        }

        // Output the file
        readfile(\$fullPath);
        exit;
    } else {
        \$debug_log[] = "Storage file not found: \$fullPath";
    }
}

// Handle build asset files
if (isset(\$_GET['build'])) {
    \$path = 'build/assets/' . \$_GET['build'];
    \$fullPath = __DIR__ . '/' . \$path;
    \$debug_log[] = "Build path: \$fullPath";

    if (file_exists(\$fullPath)) {
        \$ext = pathinfo(\$fullPath, PATHINFO_EXTENSION);
        \$debug_log[] = "File extension: \$ext";

        switch (\$ext) {
            case 'css':
                header('Content-Type: text/css');
                break;
            case 'js':
                header('Content-Type: application/javascript');
                break;
            default:
                header('Content-Type: application/octet-stream');
        }

        readfile(\$fullPath);
        exit;
    } else {
        \$debug_log[] = "Build file not found: \$fullPath";
    }
}

// Handle CSS files
if (isset(\$_GET['css'])) {
    \$path = 'css/' . \$_GET['css'];
    \$fullPath = __DIR__ . '/' . \$path;
    \$debug_log[] = "CSS path: \$fullPath";

    if (file_exists(\$fullPath)) {
        header('Content-Type: text/css');
        readfile(\$fullPath);
        exit;
    } else {
        \$debug_log[] = "CSS file not found: \$fullPath";
    }
}

// Handle JS files
if (isset(\$_GET['js'])) {
    \$path = 'js/' . \$_GET['js'];
    \$fullPath = __DIR__ . '/' . \$path;
    \$debug_log[] = "JS path: \$fullPath";

    if (file_exists(\$fullPath)) {
        header('Content-Type: application/javascript');
        readfile(\$fullPath);
        exit;
    } else {
        \$debug_log[] = "JS file not found: \$fullPath";
    }
}

// Handle app.js
if (strpos(\$requestUri, 'app.js') !== false) {
    \$paths = [
        __DIR__ . '/js/app.js',
        __DIR__ . '/public/js/app.js',
        dirname(__DIR__) . '/js/app.js',
        dirname(__DIR__) . '/public/js/app.js'
    ];

    \$debug_log[] = "Looking for app.js in multiple locations";

    foreach (\$paths as \$path) {
        \$debug_log[] = "Checking: \$path";
        if (file_exists(\$path)) {
            \$debug_log[] = "Found app.js at: \$path";
            header('Content-Type: application/javascript');
            readfile(\$path);
            exit;
        }
    }

    \$debug_log[] = "app.js not found in any location";
}

// Handle app.css
if (strpos(\$requestUri, 'app.css') !== false) {
    \$paths = [
        __DIR__ . '/css/app.css',
        __DIR__ . '/public/css/app.css',
        dirname(__DIR__) . '/css/app.css',
        dirname(__DIR__) . '/public/css/app.css'
    ];

    \$debug_log[] = "Looking for app.css in multiple locations";

    foreach (\$paths as \$path) {
        \$debug_log[] = "Checking: \$path";
        if (file_exists(\$path)) {
            \$debug_log[] = "Found app.css at: \$path";
            header('Content-Type: text/css');
            readfile(\$path);
            exit;
        }
    }

    \$debug_log[] = "app.css not found in any location";
}

// If we get here, file wasn't found
header("HTTP/1.0 404 Not Found");
echo "<h1>Asset not found</h1>";
echo "<p>Request URI: " . htmlspecialchars(\$requestUri) . "</p>";
echo "<h2>Debug Log</h2>";
echo "<pre>" . implode("\\n", \$debug_log) . "</pre>";
EOT;

file_put_contents(__DIR__ . '/asset-proxy.php', $asset_proxy_php);

// Create test directories and files
$directories = [
    __DIR__ . '/css',
    __DIR__ . '/js',
    __DIR__ . '/build/assets',
    __DIR__ . '/storage/images'
];

// Create directories if they don't exist
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "Created directory: $dir<br>";
    }
}

// Create test files
$test_files = [
    __DIR__ . '/css/proxy-test.css' => 'body { color: purple; }',
    __DIR__ . '/js/proxy-test.js' => 'console.log("proxy test");',
    __DIR__ . '/build/assets/proxy-test.css' => 'body { font-size: 20px; }',
    __DIR__ . '/build/assets/proxy-test.js' => 'console.log("proxy build test");',
    // Create a test image
    __DIR__ . '/storage/images/test.jpg' => file_get_contents(__DIR__ . '/test-image.jpg') ?: 'FAKE IMAGE DATA'
];

// Create the files
foreach ($test_files as $file => $content) {
    file_put_contents($file, $content);
    echo "Created file: $file<br>";
}

// Create a test image if it doesn't exist
if (!file_exists(__DIR__ . '/test-image.jpg')) {
    // Create a simple image with PHP
    $image = imagecreate(100, 100);
    $background = imagecolorallocate($image, 0, 0, 255);
    $text_color = imagecolorallocate($image, 255, 255, 255);
    imagestring($image, 5, 10, 40, 'Test Image', $text_color);

    // Save the image
    imagejpeg($image, __DIR__ . '/test-image.jpg');
    imagedestroy($image);

    echo "Created test image<br>";
}

// Create an htaccess file that redirects to the asset proxy
$htaccess_content = <<<EOT
# Asset Proxy htaccess
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Redirect CSS files to asset proxy
    RewriteRule ^css/(.*)$ asset-proxy.php?css=$1 [L]

    # Redirect JS files to asset proxy
    RewriteRule ^js/(.*)$ asset-proxy.php?js=$1 [L]

    # Redirect build assets to asset proxy
    RewriteRule ^build/assets/(.*)$ asset-proxy.php?build=$1 [L]

    # Redirect storage files to asset proxy
    RewriteRule ^storage/(.*)$ asset-proxy.php?storage=$1 [L]
</IfModule>
EOT;

file_put_contents(__DIR__ . '/.htaccess', $htaccess_content);
echo "Created .htaccess file with rewrite rules<br>";

// Create a cleanup script
$cleanup_content = <<<EOT
<?php
// Clean up test files
function deleteDir(\$dirPath) {
    if (!is_dir(\$dirPath)) {
        return;
    }
    if (substr(\$dirPath, strlen(\$dirPath) - 1, 1) != '/') {
        \$dirPath .= '/';
    }
    \$files = glob(\$dirPath . '*', GLOB_MARK);
    foreach (\$files as \$file) {
        if (is_dir(\$file)) {
            deleteDir(\$file);
        } else {
            unlink(\$file);
        }
    }
    rmdir(\$dirPath);
}

// Delete created directories and files
@unlink(__DIR__ . '/.htaccess');
@unlink(__DIR__ . '/asset-proxy.php');
@unlink(__DIR__ . '/test-image.jpg');

if (is_dir(__DIR__ . '/css')) {
    deleteDir(__DIR__ . '/css');
    echo "Deleted css directory<br>";
}

if (is_dir(__DIR__ . '/js')) {
    deleteDir(__DIR__ . '/js');
    echo "Deleted js directory<br>";
}

if (is_dir(__DIR__ . '/build')) {
    deleteDir(__DIR__ . '/build');
    echo "Deleted build directory<br>";
}

if (is_dir(__DIR__ . '/storage')) {
    deleteDir(__DIR__ . '/storage');
    echo "Deleted storage directory<br>";
}

echo "Cleanup complete";
EOT;

$cleanup_file = __DIR__ . '/asset-proxy-cleanup.php';
file_put_contents($cleanup_file, $cleanup_content);

// Get the base URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['REQUEST_URI'];
$path = pathinfo($uri, PATHINFO_DIRNAME);
$baseUrl = $protocol . '://' . $host . $path;

// Output test links
echo "<h3>Test Links</h3>";
echo "<p>These links should be served through the asset proxy with the correct MIME type:</p>";
echo "<ul>";
echo "<li><a href='css/proxy-test.css' target='_blank'>CSS Test File</a></li>";
echo "<li><a href='js/proxy-test.js' target='_blank'>JS Test File</a></li>";
echo "<li><a href='build/assets/proxy-test.css' target='_blank'>Build CSS Test File</a></li>";
echo "<li><a href='build/assets/proxy-test.js' target='_blank'>Build JS Test File</a></li>";
echo "<li><a href='storage/images/test.jpg' target='_blank'>Test Image</a></li>";
echo "</ul>";

echo "<h3>Direct Asset Proxy Test</h3>";
echo "<p>You can also call the asset proxy directly with query parameters:</p>";
echo "<ul>";
echo "<li><a href='asset-proxy.php?css=proxy-test.css' target='_blank'>Direct CSS Test</a></li>";
echo "<li><a href='asset-proxy.php?js=proxy-test.js' target='_blank'>Direct JS Test</a></li>";
echo "<li><a href='asset-proxy.php?build=proxy-test.css' target='_blank'>Direct Build CSS Test</a></li>";
echo "<li><a href='asset-proxy.php?storage=images/test.jpg' target='_blank'>Direct Storage Image Test</a></li>";
echo "</ul>";

echo "<h3>Cleanup</h3>";
echo "Test files will remain on server. To clean them up, visit: <a href='asset-proxy-cleanup.php'>Cleanup Script</a><br>";

// Add navigation links
echo "<hr>";
echo "<h3>Navigation</h3>";
echo "<ul>";
echo "<li><a href='asset-test.php'>Asset Test</a></li>";
echo "<li><a href='path-test.php'>Path Test</a></li>";
echo "<li><a href='mime-test.php'>MIME Test</a></li>";
echo "<li><a href='htaccess-test.php'>Htaccess Test</a></li>";
echo "<li><a href='asset-proxy-test.php'>Asset Proxy Test</a></li>";
echo "</ul>";

// Add a link to an instructions file
echo "<hr>";
echo "<h3><a href='instructions.php'>View Test Instructions</a></h3>";
