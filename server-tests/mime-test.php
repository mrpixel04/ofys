<?php
// Specifically test MIME types handling for CSS and JS files
echo "<h2>MIME Type Tester</h2>";

// Create test CSS file
$test_css_content = "body { color: red; }";
$test_css_file = __DIR__ . '/test-mime.css';
file_put_contents($test_css_file, $test_css_content);

// Create test JS file
$test_js_content = "console.log('test');";
$test_js_file = __DIR__ . '/test-mime.js';
file_put_contents($test_js_file, $test_js_content);

// Test function to check what MIME type would be sent
function testMimeType($filename) {
    $info = [];

    // Check using PHP's functions
    if (function_exists('mime_content_type')) {
        $info['mime_content_type'] = mime_content_type($filename);
    } else {
        $info['mime_content_type'] = 'Function not available';
    }

    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $info['finfo'] = finfo_file($finfo, $filename);
        finfo_close($finfo);
    } else {
        $info['finfo'] = 'Function not available';
    }

    // Extension based check
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $info['extension'] = $ext;

    // What the server would likely use based on extension
    $mime_map = [
        'css' => 'text/css',
        'js' => 'application/javascript'
    ];

    $info['expected_mime'] = isset($mime_map[$ext]) ? $mime_map[$ext] : 'unknown';

    return $info;
}

// Test our files
$css_info = testMimeType($test_css_file);
$js_info = testMimeType($test_js_file);

echo "<h3>CSS File Test</h3>";
echo "File: $test_css_file<br>";
echo "Extension: " . $css_info['extension'] . "<br>";
echo "mime_content_type: " . $css_info['mime_content_type'] . "<br>";
echo "finfo: " . $css_info['finfo'] . "<br>";
echo "Expected MIME: " . $css_info['expected_mime'] . "<br>";

echo "<h3>JS File Test</h3>";
echo "File: $test_js_file<br>";
echo "Extension: " . $js_info['extension'] . "<br>";
echo "mime_content_type: " . $js_info['mime_content_type'] . "<br>";
echo "finfo: " . $js_info['finfo'] . "<br>";
echo "Expected MIME: " . $js_info['expected_mime'] . "<br>";

// Get the base URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['REQUEST_URI'];
$path = pathinfo($uri, PATHINFO_DIRNAME);
$baseUrl = $protocol . '://' . $host . $path;

echo "<h3>HTTP Header Test</h3>";
echo "Direct access links (these should show proper MIME types when accessed directly):<br>";
echo "<a href='" . $baseUrl . "/test-mime.css' target='_blank'>CSS Test File</a><br>";
echo "<a href='" . $baseUrl . "/test-mime.js' target='_blank'>JS Test File</a><br>";

// Also create htaccess test file
$htaccess_content = <<<EOT
# Test .htaccess file for MIME types
<IfModule mod_mime.c>
    AddType text/css .css
    AddType application/javascript .js
</IfModule>

<FilesMatch "\.css$">
    ForceType text/css
    <IfModule mod_headers.c>
        Header set Content-Type "text/css"
    </IfModule>
</FilesMatch>

<FilesMatch "\.js$">
    ForceType application/javascript
    <IfModule mod_headers.c>
        Header set Content-Type "application/javascript"
    </IfModule>
</FilesMatch>
EOT;

$htaccess_file = __DIR__ . '/.htaccess';
file_put_contents($htaccess_file, $htaccess_content);
echo "<h3>Created Test .htaccess File</h3>";
echo "Contents:<br><pre>" . htmlspecialchars($htaccess_content) . "</pre>";

// Create cleanup script
$cleanup_content = <<<EOT
<?php
// Clean up test files
@unlink(__DIR__ . '/test-mime.css');
@unlink(__DIR__ . '/test-mime.js');
@unlink(__DIR__ . '/.htaccess');
echo "Cleanup complete";
EOT;

$cleanup_file = __DIR__ . '/mime-cleanup.php';
file_put_contents($cleanup_file, $cleanup_content);

echo "<h3>Cleanup</h3>";
echo "Test files will remain on server. To clean them up, visit: <a href='mime-cleanup.php'>Cleanup Script</a><br>";
echo "<div style='margin-top: 20px; padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd;'>";
echo "<p>You can run the following command on your server to check if the MIME types are being correctly served:</p>";
echo "<pre>curl -I " . $baseUrl . "/test-mime.css</pre>";
echo "<pre>curl -I " . $baseUrl . "/test-mime.js</pre>";
echo "</div>";

// Clean up test files after 1 hour
echo "<script>
setTimeout(function() {
    fetch('mime-cleanup.php');
}, 3600000); // 1 hour
</script>";

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