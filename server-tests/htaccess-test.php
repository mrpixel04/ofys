<?php
// Htaccess Test for OFYS Server Tests
?>
<!DOCTYPE html>
<html>
<head>
    <title>OFYS Server Tests - Htaccess Test</title>
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
    </style>
</head>
<body>
    <h1>OFYS Server Tests - Htaccess Test</h1>

    <div class="test-section">
        <h2>Web Server Information</h2>
        <?php
        // Get server software
        $serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown';
        $isApache = (stripos($serverSoftware, 'apache') !== false);
        $isNginx = (stripos($serverSoftware, 'nginx') !== false);
        $isIIS = (stripos($serverSoftware, 'iis') !== false);
        $serverType = $isApache ? "Apache" : ($isNginx ? "Nginx" : ($isIIS ? "IIS" : "Unknown"));

        // Get PHP interface
        $phpInterface = php_sapi_name();
        $isCGI = (stripos($phpInterface, 'cgi') !== false);
        $isFPM = (stripos($phpInterface, 'fpm') !== false);
        $isModPHP = (stripos($phpInterface, 'apache') !== false);
        ?>

        <table>
            <tr>
                <th>Property</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Server Software</td>
                <td><?php echo htmlspecialchars($serverSoftware); ?></td>
            </tr>
            <tr>
                <td>Server Type</td>
                <td><?php echo htmlspecialchars($serverType); ?></td>
            </tr>
            <tr>
                <td>PHP Interface</td>
                <td><?php echo htmlspecialchars($phpInterface); ?></td>
            </tr>
        </table>

        <?php if (!$isApache): ?>
            <p class="warning">
                Non-Apache web server detected. The .htaccess file is only used by Apache web servers.
                <?php if ($isNginx): ?>
                    For Nginx, you need to configure rewrite rules in your nginx.conf file.
                <?php elseif ($isIIS): ?>
                    For IIS, you need to configure rewrite rules in your web.config file.
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </div>

    <div class="test-section">
        <h2>Htaccess File Analysis</h2>
        <?php
        // Get document root
        $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';

        // Get base directory (one level up from the server-tests directory)
        $baseDir = dirname(dirname(__FILE__));

        // Determine if Laravel structure
        $isLaravel = file_exists($baseDir . '/artisan');

        // Check for Laravel public directory
        $publicDir = $baseDir . '/public';
        $isLaravelPublic = $isLaravel && is_dir($publicDir);

        // Determine paths to check for .htaccess
        $pathsToCheck = [
            'Document Root' => $documentRoot,
            'Current Directory' => dirname(__FILE__),
            'Base Directory' => $baseDir
        ];

        if ($isLaravelPublic) {
            $pathsToCheck['Laravel Public Dir'] = $publicDir;
        }

        $htaccessFiles = [];

        // Check for .htaccess files
        foreach ($pathsToCheck as $location => $path) {
            $htaccessPath = $path . '/.htaccess';
            if (file_exists($htaccessPath)) {
                $htaccessFiles[$location] = [
                    'path' => $htaccessPath,
                    'content' => file_get_contents($htaccessPath),
                    'size' => filesize($htaccessPath),
                    'perms' => substr(sprintf('%o', fileperms($htaccessPath)), -4)
                ];
            }
        }

        if (empty($htaccessFiles)):
        ?>
            <p class="warning">No .htaccess files found in any of the checked directories.</p>
            <p>If you're using Apache, an .htaccess file is often needed for URL rewriting, especially in Laravel applications.</p>
        <?php else: ?>
            <h3>Found .htaccess Files</h3>
            <table>
                <tr>
                    <th>Location</th>
                    <th>Path</th>
                    <th>Size</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($htaccessFiles as $location => $details): ?>
                <tr>
                    <td><?php echo htmlspecialchars($location); ?></td>
                    <td><?php echo htmlspecialchars($details['path']); ?></td>
                    <td><?php echo $details['size']; ?> bytes</td>
                    <td><?php echo $details['perms']; ?></td>
                    <td>
                        <button onclick="toggleContent('htaccess-<?php echo md5($details['path']); ?>')">View Content</button>
                    </td>
                </tr>
                <tr id="htaccess-<?php echo md5($details['path']); ?>" style="display: none;">
                    <td colspan="5">
                        <pre><?php echo htmlspecialchars($details['content']); ?></pre>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>

            <script>
                function toggleContent(id) {
                    var element = document.getElementById(id);
                    if (element.style.display === "none") {
                        element.style.display = "table-row";
                    } else {
                        element.style.display = "none";
                    }
                }
            </script>
        <?php endif; ?>
    </div>

    <div class="test-section">
        <h2>Apache Module Test</h2>
        <?php if ($isApache): ?>
            <?php
            // Check if we can use apache_get_modules()
            $canCheckModules = function_exists('apache_get_modules');

            if ($canCheckModules):
                $modules = apache_get_modules();
                $rewriteEnabled = in_array('mod_rewrite', $modules);
                $htaccessEnabled = false; // Will be checked below

                // Check for essential modules
                $essentialModules = [
                    'mod_rewrite' => [
                        'name' => 'URL Rewriting',
                        'status' => in_array('mod_rewrite', $modules),
                        'importance' => 'Critical for Laravel routing',
                    ],
                    'mod_headers' => [
                        'name' => 'Headers',
                        'status' => in_array('mod_headers', $modules),
                        'importance' => 'Important for security headers, caching, etc.',
                    ],
                    'mod_env' => [
                        'name' => 'Environment Variables',
                        'status' => in_array('mod_env', $modules),
                        'importance' => 'Used to set environment variables in .htaccess',
                    ],
                    'mod_mime' => [
                        'name' => 'MIME Types',
                        'status' => in_array('mod_mime', $modules),
                        'importance' => 'Important for content type handling',
                    ],
                    'mod_dir' => [
                        'name' => 'Directory Handling',
                        'status' => in_array('mod_dir', $modules),
                        'importance' => 'Used for directory index handling',
                    ]
                ];
            ?>
                <table>
                    <tr>
                        <th>Module</th>
                        <th>Feature</th>
                        <th>Status</th>
                        <th>Importance</th>
                    </tr>
                    <?php foreach ($essentialModules as $moduleName => $details): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($moduleName); ?></td>
                        <td><?php echo htmlspecialchars($details['name']); ?></td>
                        <td>
                            <?php if ($details['status']): ?>
                                <span class="success">Enabled</span>
                            <?php else: ?>
                                <span class="error">Not Enabled</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($details['importance']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>

                <?php if (!$rewriteEnabled): ?>
                <p class="error">
                    mod_rewrite is not enabled. This module is required for Laravel's URL routing to work properly.
                    Contact your hosting provider or enable it in your Apache configuration.
                </p>
                <?php endif; ?>

            <?php else: ?>
                <p class="warning">
                    Cannot check Apache modules directly. This is common in shared hosting environments.
                    Let's try an alternative test for mod_rewrite and .htaccess capabilities.
                </p>
            <?php endif; ?>

            <h3>Runtime Htaccess Test</h3>
            <?php
            // Create a test .htaccess file if we don't have information about modules
            $testHtaccessPath = __DIR__ . '/test-htaccess';
            if (!is_dir($testHtaccessPath)) {
                mkdir($testHtaccessPath, 0755, true);
            }

            // Create a test file
            file_put_contents($testHtaccessPath . '/test.php', '<?php echo "Default test file"; ?>');

            // Create a .htaccess file with a simple rewrite rule
            $htaccessContent = <<<EOT
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^rewrite-test$ test.php [L]

    # Set an environment variable to test if .htaccess is working
    SetEnv HTACCESS_WORKING true
</IfModule>

# Test for AllowOverride
<IfModule mod_env.c>
    SetEnv ALLOW_OVERRIDE_WORKING true
</IfModule>
EOT;

            file_put_contents($testHtaccessPath . '/.htaccess', $htaccessContent);

            // Get the URL to the test directory
            $testUrl = dirname($_SERVER['SCRIPT_NAME']) . '/test-htaccess';
            $rewriteTestUrl = $testUrl . '/rewrite-test';
            $normalTestUrl = $testUrl . '/test.php';

            // Check if HTACCESS_WORKING is set
            $htaccessWorking = isset($_SERVER['HTACCESS_WORKING']) && $_SERVER['HTACCESS_WORKING'] === 'true';
            $allowOverrideWorking = isset($_SERVER['ALLOW_OVERRIDE_WORKING']) && $_SERVER['ALLOW_OVERRIDE_WORKING'] === 'true';

            if ($htaccessWorking) {
                echo "<p class='success'>The .htaccess file is being processed correctly.</p>";
            } else {
                echo "<p class='warning'>Unable to confirm if .htaccess is being processed. This could be due to several factors:</p>";
                echo "<ul>";
                echo "<li>AllowOverride might be set to None in your Apache configuration</li>";
                echo "<li>mod_rewrite might not be enabled</li>";
                echo "<li>The server might not be sending environment variables to PHP</li>";
                echo "</ul>";
            }

            if ($allowOverrideWorking) {
                echo "<p class='success'>AllowOverride is working correctly.</p>";
            } else {
                echo "<p class='warning'>AllowOverride might not be set properly in your Apache configuration.</p>";
            }
            ?>

            <h3>Manual Tests</h3>
            <p>Please try accessing the following URLs to manually test rewrite functionality:</p>

            <table>
                <tr>
                    <th>Test</th>
                    <th>URL</th>
                    <th>Expected Result</th>
                </tr>
                <tr>
                    <td>Normal PHP file</td>
                    <td><a href="<?php echo $normalTestUrl; ?>" target="_blank"><?php echo $normalTestUrl; ?></a></td>
                    <td>Should display "Default test file"</td>
                </tr>
                <tr>
                    <td>Rewritten URL</td>
                    <td><a href="<?php echo $rewriteTestUrl; ?>" target="_blank"><?php echo $rewriteTestUrl; ?></a></td>
                    <td>Should display "Default test file" if mod_rewrite is working</td>
                </tr>
            </table>

            <div id="rewrite-test-result" class="warning">
                Click the "Test Rewrite" button to check if mod_rewrite is working.
            </div>
            <button onclick="testRewrite('<?php echo $rewriteTestUrl; ?>', '<?php echo $normalTestUrl; ?>')">Test Rewrite</button>

            <script>
                function testRewrite(rewriteUrl, normalUrl) {
                    const resultElement = document.getElementById('rewrite-test-result');
                    resultElement.innerHTML = "Testing rewrite functionality...";
                    resultElement.className = "";

                    // First fetch the normal URL to make sure it works
                    fetch(normalUrl)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`Normal URL failed with status ${response.status}`);
                            }
                            return response.text();
                        })
                        .then(normalText => {
                            // Now try the rewritten URL
                            return fetch(rewriteUrl)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(`Rewrite test failed with status ${response.status}`);
                                    }
                                    return response.text();
                                })
                                .then(rewriteText => {
                                    // Compare results
                                    if (rewriteText === normalText) {
                                        resultElement.innerHTML = "Success! mod_rewrite is working correctly.";
                                        resultElement.className = "success";
                                    } else {
                                        resultElement.innerHTML = "The rewrite test didn't match the normal file. This may indicate a partial rewrite configuration issue.";
                                        resultElement.className = "warning";
                                    }
                                });
                        })
                        .catch(error => {
                            resultElement.innerHTML = `Test failed: ${error.message}`;
                            resultElement.className = "error";
                        });
                }
            </script>
        <?php else: ?>
            <p>Apache tests are not applicable because you're using <?php echo $serverType; ?> server.</p>
        <?php endif; ?>
    </div>

    <div class="test-section">
        <h2>Recommendations</h2>
        <h3>For Apache Server</h3>
        <ul>
            <li>Ensure mod_rewrite is enabled</li>
            <li>Set AllowOverride to All in your Apache configuration</li>
            <li>Make sure your .htaccess file has the correct permissions (typically 644)</li>
            <li>If using Laravel, check that the correct .htaccess file exists in the public directory</li>
            <li>If using shared hosting, contact your provider to verify mod_rewrite support</li>
        </ul>

        <h3>For Nginx Server</h3>
        <ul>
            <li>.htaccess files are not used by Nginx</li>
            <li>Configure rewrite rules in your nginx.conf or site configuration file</li>
            <li>A typical Laravel Nginx configuration looks like this:</li>
        </ul>
        <pre>
server {
    listen 80;
    server_name example.com;
    root /path/to/your/laravel/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
</pre>

        <h3>Laravel Standard .htaccess</h3>
        <p>If you're missing the .htaccess file in your Laravel public directory, here's the standard content:</p>
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
