<?php
// Display server information
echo "<h2>Server Information</h2>";
echo "Current directory: " . __DIR__ . "<br>";
echo "Document root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Script filename: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "<hr>";

// Test for CSS files
echo "<h2>CSS Files Check</h2>";
$css_paths = [
    'css/app.css',
    'public/css/app.css',
    'build/assets/app-Wobp9lDR.css',
    'public/build/assets/app-Wobp9lDR.css',
    '../css/app.css',
    '../public/css/app.css',
    '../build/assets/app-Wobp9lDR.css'
];

foreach ($css_paths as $path) {
    $full_path = __DIR__ . '/' . $path;
    echo "$path: " . (file_exists($full_path) ? 'EXISTS' : 'NOT FOUND') . " ($full_path)<br>";
}
echo "<hr>";

// Test for JS files
echo "<h2>JavaScript Files Check</h2>";
$js_paths = [
    'js/app.js',
    'public/js/app.js',
    'build/assets/provider-8IhWpMfa.js',
    'public/build/assets/provider-8IhWpMfa.js',
    'build/assets/index-h5_rRomJ.js',
    'public/build/assets/index-h5_rRomJ.js',
    '../js/app.js',
    '../public/js/app.js',
    '../build/assets/provider-8IhWpMfa.js',
    '../build/assets/index-h5_rRomJ.js'
];

foreach ($js_paths as $path) {
    $full_path = __DIR__ . '/' . $path;
    echo "$path: " . (file_exists($full_path) ? 'EXISTS' : 'NOT FOUND') . " ($full_path)<br>";
}
echo "<hr>";

// Directory listing for build directory
echo "<h2>Directory Listing: build/</h2>";
$build_dir = __DIR__ . '/build';
if (is_dir($build_dir)) {
    echo "Directory exists.<br>";
    $files = scandir($build_dir);
    echo "Contents: <pre>" . print_r($files, true) . "</pre>";
} else {
    echo "Directory NOT FOUND: $build_dir<br>";
}

// Check parent build directory
$parent_build_dir = dirname(__DIR__) . '/build';
if (is_dir($parent_build_dir)) {
    echo "Parent build directory exists: $parent_build_dir<br>";
    $files = scandir($parent_build_dir);
    echo "Contents: <pre>" . print_r($files, true) . "</pre>";
}
echo "<hr>";

// Directory listing for build/assets directory
echo "<h2>Directory Listing: build/assets/</h2>";
$assets_dir = __DIR__ . '/build/assets';
if (is_dir($assets_dir)) {
    echo "Directory exists.<br>";
    $files = scandir($assets_dir);
    echo "Contents: <pre>" . print_r($files, true) . "</pre>";
} else {
    echo "Directory NOT FOUND: $assets_dir<br>";
}

// Check parent build/assets directory
$parent_assets_dir = dirname(__DIR__) . '/build/assets';
if (is_dir($parent_assets_dir)) {
    echo "Parent build/assets directory exists: $parent_assets_dir<br>";
    $files = scandir($parent_assets_dir);
    echo "Contents: <pre>" . print_r($files, true) . "</pre>";
}
echo "<hr>";

// Check MIME type functionality
echo "<h2>MIME Type Test</h2>";
function getFileMimeType($filename) {
    if (function_exists('mime_content_type')) {
        return mime_content_type($filename);
    } elseif (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $filename);
        finfo_close($finfo);
        return $mime;
    } else {
        return 'Unknown (no MIME detection function available)';
    }
}

// Test some files for MIME types
$test_files = [];
foreach ($css_paths as $path) {
    $full_path = __DIR__ . '/' . $path;
    if (file_exists($full_path)) {
        $test_files[] = $full_path;
    }
}
foreach ($js_paths as $path) {
    $full_path = __DIR__ . '/' . $path;
    if (file_exists($full_path)) {
        $test_files[] = $full_path;
    }
}

foreach ($test_files as $file) {
    $mime = getFileMimeType($file);
    echo "File: $file<br>MIME Type: $mime<br><br>";
}

// Asset Test for OFYS Server Tests
?>
<!DOCTYPE html>
<html>
<head>
    <title>OFYS Server Tests - Asset Test</title>
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
        .test-section {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
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
        .success {
            color: green;
        }
        .warning {
            color: orange;
        }
        .error {
            color: red;
        }
        .test-image {
            max-width: 100px;
            border: 1px solid #ddd;
            margin: 5px;
        }
        .asset-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }
        .asset-item {
            margin: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>OFYS Server Tests - Asset Test</h1>

    <div class="test-section">
        <h2>Absolute Asset Path Test</h2>
        <?php
        // Get the base URL
        function getBaseUrl() {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            return $protocol . $host;
        }

        // Get Laravel public path
        $baseDir = dirname(dirname(__FILE__));
        $publicPath = $baseDir . '/public';
        $isLaravelPublic = is_dir($publicPath);

        $baseUrl = getBaseUrl();
        ?>

        <p>Testing absolute path asset loading:</p>

        <?php if ($isLaravelPublic): ?>
            <?php
            // Try to find some common assets in the public directory
            $assetTypes = [
                'css' => ['css', 'min.css'],
                'js' => ['js', 'min.js'],
                'images' => ['png', 'jpg', 'jpeg', 'gif', 'svg'],
                'fonts' => ['woff', 'woff2', 'ttf', 'eot']
            ];

            $foundAssets = [];

            // Function to recursively find assets in the public directory
            function findAssets($dir, $extensions, &$results, $maxDepth = 3, $currentDepth = 0) {
                if ($currentDepth > $maxDepth) {
                    return;
                }

                if (!is_dir($dir)) {
                    return;
                }

                $files = scandir($dir);
                foreach ($files as $file) {
                    if ($file === '.' || $file === '..') {
                        continue;
                    }

                    $path = $dir . '/' . $file;

                    if (is_file($path)) {
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        if (in_array($ext, $extensions)) {
                            // Get the relative path from the public directory
                            $relativePath = str_replace($GLOBALS['publicPath'] . '/', '', $path);
                            $results[] = $relativePath;

                            // Limit to 5 assets per type
                            if (count($results) >= 5) {
                                return;
                            }
                        }
                    } elseif (is_dir($path)) {
                        findAssets($path, $extensions, $results, $maxDepth, $currentDepth + 1);
                    }
                }
            }

            foreach ($assetTypes as $type => $extensions) {
                $assets = [];
                findAssets($publicPath, $extensions, $assets);
                if (!empty($assets)) {
                    $foundAssets[$type] = $assets;
                }
            }

            if (!empty($foundAssets)):
            ?>
                <div class="asset-container">
                    <?php
                    // Display found assets
                    foreach ($foundAssets as $type => $assets):
                        foreach ($assets as $asset):
                            $assetUrl = $baseUrl . '/' . $asset;
                    ?>
                        <div class="asset-item">
                            <?php if ($type === 'images'): ?>
                                <img src="<?php echo $assetUrl; ?>" alt="<?php echo $asset; ?>" class="test-image">
                                <div>
                                    <small><?php echo basename($asset); ?></small>
                                </div>
                            <?php else: ?>
                                <div>
                                    <a href="<?php echo $assetUrl; ?>" target="_blank"><?php echo basename($asset); ?></a>
                                    <small>(<?php echo $type; ?>)</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php
                        endforeach;
                    endforeach;
                    ?>
                </div>
            <?php else: ?>
                <p class="warning">No assets found in the public directory. Please make sure your Laravel public directory contains assets.</p>
            <?php endif; ?>
        <?php else: ?>
            <p class="warning">Laravel public directory not found. Creating test assets for general testing.</p>

            <!-- Test images with different paths -->
            <h3>Test Images</h3>
            <div class="asset-container">
                <!-- Absolute URLs from the website root -->
                <div class="asset-item">
                    <img src="/test-image.png" alt="Test Image (Root)" class="test-image">
                    <div><small>/test-image.png</small></div>
                </div>

                <!-- Relative URLs -->
                <div class="asset-item">
                    <img src="test-image.png" alt="Test Image (Relative)" class="test-image">
                    <div><small>test-image.png</small></div>
                </div>

                <!-- Base URL + path -->
                <div class="asset-item">
                    <img src="<?php echo $baseUrl; ?>/test-image.png" alt="Test Image (Full URL)" class="test-image">
                    <div><small><?php echo $baseUrl; ?>/test-image.png</small></div>
                </div>
            </div>

            <h3>Test CSS/JS</h3>
            <div class="asset-container">
                <div class="asset-item">
                    <a href="/test.css" target="_blank">test.css</a> (Root)
                </div>
                <div class="asset-item">
                    <a href="test.css" target="_blank">test.css</a> (Relative)
                </div>
                <div class="asset-item">
                    <a href="<?php echo $baseUrl; ?>/test.css" target="_blank">test.css</a> (Full URL)
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="test-section">
        <h2>Generate Test Assets</h2>
        <p>This section creates test assets in the current directory for testing purposes.</p>

        <?php
        // Generate a test image if it doesn't exist
        $testImagePath = __DIR__ . '/test-image.png';
        $testImageUrl = dirname($_SERVER['SCRIPT_NAME']) . '/test-image.png';

        if (!file_exists($testImagePath)) {
            // Create a simple PNG image
            $im = imagecreatetruecolor(100, 50);
            $textColor = imagecolorallocate($im, 255, 255, 255);
            $bgColor = imagecolorallocate($im, 0, 102, 204);
            imagefilledrectangle($im, 0, 0, 99, 49, $bgColor);
            imagestring($im, 5, 10, 15, 'Test Image', $textColor);
            imagepng($im, $testImagePath);
            imagedestroy($im);
            echo "<p class='success'>Created test image at: $testImagePath</p>";
        }

        // Generate a test CSS file if it doesn't exist
        $testCssPath = __DIR__ . '/test.css';
        $testCssUrl = dirname($_SERVER['SCRIPT_NAME']) . '/test.css';

        if (!file_exists($testCssPath)) {
            $cssContent = "body { background-color: #f0f0f0; color: #333; }\n";
            $cssContent .= ".test-box { border: 1px solid #ddd; padding: 20px; margin: 20px; }\n";
            file_put_contents($testCssPath, $cssContent);
            echo "<p class='success'>Created test CSS at: $testCssPath</p>";
        }

        // Generate a test JS file if it doesn't exist
        $testJsPath = __DIR__ . '/test.js';
        $testJsUrl = dirname($_SERVER['SCRIPT_NAME']) . '/test.js';

        if (!file_exists($testJsPath)) {
            $jsContent = "console.log('Test script loaded successfully');\n";
            $jsContent .= "function testFunction() { alert('Test function called!'); }\n";
            file_put_contents($testJsPath, $jsContent);
            echo "<p class='success'>Created test JS at: $testJsPath</p>";
        }
        ?>

        <h3>Generated Test Assets</h3>
        <div class="asset-container">
            <div class="asset-item">
                <img src="<?php echo $testImageUrl; ?>" alt="Generated Test Image" class="test-image">
                <div><small>Generated test-image.png</small></div>
            </div>

            <div class="asset-item">
                <a href="<?php echo $testCssUrl; ?>" target="_blank">test.css</a>
            </div>

            <div class="asset-item">
                <a href="<?php echo $testJsUrl; ?>" target="_blank">test.js</a>
            </div>
        </div>

        <h3>Test Generated Assets</h3>
        <p>Including the generated CSS file and JS file:</p>

        <link rel="stylesheet" href="<?php echo $testCssUrl; ?>">
        <script src="<?php echo $testJsUrl; ?>"></script>

        <div class="test-box">
            This box should be styled with the test CSS file if it loaded successfully.
            <button onclick="testFunction()">Test JS Function</button>
        </div>
    </div>

    <div class="test-section">
        <h2>Laravel Asset Loading Test</h2>
        <?php
        // Check if Laravel's public path exists
        if ($isLaravelPublic):
            $publicUrl = $baseUrl;
            $cssFile = 'css/app.css';
            $jsFile = 'js/app.js';

            // Check if common Laravel asset files exist
            $cssExists = file_exists($publicPath . '/' . $cssFile);
            $jsExists = file_exists($publicPath . '/' . $jsFile);

            // Try to find other alternatives if the standard ones don't exist
            if (!$cssExists) {
                // Look for any CSS files in css directory
                if (is_dir($publicPath . '/css')) {
                    $files = scandir($publicPath . '/css');
                    foreach ($files as $file) {
                        if (pathinfo($file, PATHINFO_EXTENSION) === 'css') {
                            $cssFile = 'css/' . $file;
                            $cssExists = true;
                            break;
                        }
                    }
                }

                // If still not found, look for any CSS files in the public directory
                if (!$cssExists) {
                    $files = scandir($publicPath);
                    foreach ($files as $file) {
                        if (pathinfo($file, PATHINFO_EXTENSION) === 'css') {
                            $cssFile = $file;
                            $cssExists = true;
                            break;
                        }
                    }
                }
            }

            if (!$jsExists) {
                // Look for any JS files in js directory
                if (is_dir($publicPath . '/js')) {
                    $files = scandir($publicPath . '/js');
                    foreach ($files as $file) {
                        if (pathinfo($file, PATHINFO_EXTENSION) === 'js') {
                            $jsFile = 'js/' . $file;
                            $jsExists = true;
                            break;
                        }
                    }
                }

                // If still not found, look for any JS files in the public directory
                if (!$jsExists) {
                    $files = scandir($publicPath);
                    foreach ($files as $file) {
                        if (pathinfo($file, PATHINFO_EXTENSION) === 'js') {
                            $jsFile = $file;
                            $jsExists = true;
                            break;
                        }
                    }
                }
            }
        ?>
            <h3>Laravel Asset Test</h3>
            <p>Testing Laravel asset loading with different URL formats:</p>

            <?php if ($cssExists): ?>
            <div class="asset-item">
                <h4>CSS File: <?php echo $cssFile; ?></h4>
                <table>
                    <tr>
                        <th>Method</th>
                        <th>URL</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td>Absolute Path</td>
                        <td><a href="/<?php echo $cssFile; ?>" target="_blank">/<?php echo $cssFile; ?></a></td>
                        <td id="css-absolute-status">Checking...</td>
                    </tr>
                    <tr>
                        <td>Relative Path</td>
                        <td><a href="<?php echo $cssFile; ?>" target="_blank"><?php echo $cssFile; ?></a></td>
                        <td id="css-relative-status">Checking...</td>
                    </tr>
                    <tr>
                        <td>Full URL</td>
                        <td><a href="<?php echo $publicUrl . '/' . $cssFile; ?>" target="_blank"><?php echo $publicUrl . '/' . $cssFile; ?></a></td>
                        <td id="css-full-status">Checking...</td>
                    </tr>
                </table>
            </div>
            <?php endif; ?>

            <?php if ($jsExists): ?>
            <div class="asset-item">
                <h4>JS File: <?php echo $jsFile; ?></h4>
                <table>
                    <tr>
                        <th>Method</th>
                        <th>URL</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td>Absolute Path</td>
                        <td><a href="/<?php echo $jsFile; ?>" target="_blank">/<?php echo $jsFile; ?></a></td>
                        <td id="js-absolute-status">Checking...</td>
                    </tr>
                    <tr>
                        <td>Relative Path</td>
                        <td><a href="<?php echo $jsFile; ?>" target="_blank"><?php echo $jsFile; ?></a></td>
                        <td id="js-relative-status">Checking...</td>
                    </tr>
                    <tr>
                        <td>Full URL</td>
                        <td><a href="<?php echo $publicUrl . '/' . $jsFile; ?>" target="_blank"><?php echo $publicUrl . '/' . $jsFile; ?></a></td>
                        <td id="js-full-status">Checking...</td>
                    </tr>
                </table>
            </div>
            <?php endif; ?>

            <script>
                // Function to check if a URL is accessible
                function checkUrl(url, elementId) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('HEAD', url, true);
                    xhr.onreadystatechange = function() {
                        const element = document.getElementById(elementId);
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                element.innerHTML = '<span class="success">Success (200)</span>';
                            } else {
                                element.innerHTML = '<span class="error">Failed (' + xhr.status + ')</span>';
                            }
                        }
                    };
                    xhr.onerror = function() {
                        document.getElementById(elementId).innerHTML = '<span class="error">Request Error</span>';
                    };
                    xhr.send();
                }

                // Check CSS URLs
                <?php if ($cssExists): ?>
                checkUrl('/<?php echo $cssFile; ?>', 'css-absolute-status');
                checkUrl('<?php echo $cssFile; ?>', 'css-relative-status');
                checkUrl('<?php echo $publicUrl . '/' . $cssFile; ?>', 'css-full-status');
                <?php endif; ?>

                // Check JS URLs
                <?php if ($jsExists): ?>
                checkUrl('/<?php echo $jsFile; ?>', 'js-absolute-status');
                checkUrl('<?php echo $jsFile; ?>', 'js-relative-status');
                checkUrl('<?php echo $publicUrl . '/' . $jsFile; ?>', 'js-full-status');
                <?php endif; ?>
            </script>

        <?php else: ?>
            <p class="warning">Laravel public directory not found. Skipping Laravel-specific asset tests.</p>
        <?php endif; ?>
    </div>

    <div class="test-section">
        <h2>Analysis & Recommendations</h2>
        <?php
        // Check if we're in Laravel public directory
        $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
        $scriptDir = dirname(__FILE__);

        $isInPublic = false;
        $publicPathRelation = "";

        if ($isLaravelPublic) {
            if (strpos($publicPath, $documentRoot) === 0) {
                // Document root contains public directory
                $relativePath = substr($publicPath, strlen($documentRoot));
                if ($relativePath) {
                    $publicPathRelation = "Laravel's public directory is located at: $relativePath relative to document root";
                    if ($relativePath === '') {
                        $isInPublic = true;
                        $publicPathRelation = "Document root is correctly set to Laravel's public directory.";
                    }
                }
            } else {
                $publicPathRelation = "Laravel's public directory is not within document root.";
            }
        }
        ?>

        <h3>Environment Analysis</h3>
        <ul>
            <li>Document Root: <?php echo $documentRoot; ?></li>
            <li>Script Directory: <?php echo $scriptDir; ?></li>
            <?php if ($isLaravelPublic): ?>
                <li>Laravel Public Directory: <?php echo $publicPath; ?></li>
                <li><?php echo $publicPathRelation; ?></li>
            <?php endif; ?>
        </ul>

        <h3>Recommendations</h3>
        <ul>
            <?php if ($isLaravelPublic && !$isInPublic): ?>
                <li class="warning">Your document root should point to Laravel's public directory. Current document root is: <?php echo $documentRoot; ?></li>
                <li>For shared hosting: Consider moving Laravel files outside the public_html directory and keeping only the public files in public_html, updating index.php to point to the correct paths.</li>
            <?php endif; ?>

            <li>Make sure your web server is configured to allow access to CSS, JS, and image files.</li>
            <li>Check .htaccess file for any rules that might be blocking asset files.</li>
            <li>If using Laravel, make sure APP_URL in .env matches your actual domain.</li>
            <li>Consider using the asset() helper in your views to generate correct URLs.</li>
            <li>If asset URLs fail, consider implementing the asset proxy solution (see asset-proxy-test.php).</li>
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
