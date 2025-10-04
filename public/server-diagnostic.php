<?php
/**
 * Server Diagnostic Tool for OFYS
 * Upload this file to your server's public directory to diagnose provider route issues
 */

// Basic information
$serverInfo = [
    'php_version' => phpversion(),
    'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
    'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown',
    'script_filename' => $_SERVER['SCRIPT_FILENAME'] ?? 'Unknown',
    'request_uri' => $_SERVER['REQUEST_URI'] ?? 'Unknown',
    'server_name' => $_SERVER['SERVER_NAME'] ?? 'Unknown'
];

// Check for .htaccess file
$htaccessExists = file_exists(dirname(__FILE__) . '/.htaccess');
$htaccessContent = $htaccessExists ? file_get_contents(dirname(__FILE__) . '/.htaccess') : 'Not found';

// Check for mod_rewrite
$modRewriteEnabled = function_exists('apache_get_modules') ?
    in_array('mod_rewrite', apache_get_modules()) :
    'Cannot determine (not running as Apache module)';

// Check Laravel storage directory permissions
$storagePath = dirname(__FILE__) . '/../storage';
$storagePermissions = [
    'storage_exists' => is_dir($storagePath),
    'storage_writable' => is_writable($storagePath),
    'storage_logs_writable' => is_writable($storagePath . '/logs'),
    'storage_framework_writable' => is_writable($storagePath . '/framework'),
    'bootstrap_cache_writable' => is_writable(dirname(__FILE__) . '/../bootstrap/cache')
];

// Check base file permissions
$publicPermissions = [
    'public_writable' => is_writable(dirname(__FILE__)),
    'index_php_readable' => is_readable(dirname(__FILE__) . '/index.php'),
    'index_php_permissions' => fileperms(dirname(__FILE__) . '/index.php')
];

// Test specific routes using file_get_contents
function testUrl($url) {
    $context = stream_context_create([
        'http' => ['timeout' => 3, 'ignore_errors' => true]
    ]);

    $response = @file_get_contents($url, false, $context);
    $status = $http_response_header[0] ?? 'Unknown';

    return [
        'url' => $url,
        'status' => $status,
        'success' => strpos($status, '200') !== false
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OFYS Server Diagnostic</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1200px; margin: 0 auto; padding: 20px; line-height: 1.6; }
        h1, h2, h3 { color: #333; }
        .diagnostic-section { margin-bottom: 30px; border: 1px solid #ddd; padding: 20px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .success { color: green; }
        .failure { color: red; }
        .warning { color: orange; }
        pre { background: #f5f5f5; padding: 10px; overflow: auto; border-radius: 3px; max-height: 300px; }
        .fix-suggestion { background-color: #e6f7ff; border-left: 4px solid #1890ff; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>OFYS Server Diagnostic Tool</h1>
    <p>This tool helps diagnose issues with the OFYS application on your shared hosting environment.</p>

    <div class="diagnostic-section">
        <h2>Server Information</h2>
        <table>
            <?php foreach($serverInfo as $key => $value): ?>
            <tr>
                <th><?= ucwords(str_replace('_', ' ', $key)) ?></th>
                <td><?= htmlspecialchars($value) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="diagnostic-section">
        <h2>.htaccess Configuration</h2>
        <p>Status: <strong class="<?= $htaccessExists ? 'success' : 'failure' ?>"><?= $htaccessExists ? 'Found' : 'Not Found' ?></strong></p>

        <?php if($htaccessExists): ?>
        <h3>Content:</h3>
        <pre><?= htmlspecialchars($htaccessContent) ?></pre>
        <?php else: ?>
        <div class="fix-suggestion">
            <p><strong>Recommendation:</strong> Create an .htaccess file in your public directory with the following content:</p>
            <pre>&lt;IfModule mod_rewrite.c&gt;
    RewriteEngine On
    RewriteBase /
    RewriteRule ^index\.php$ - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.php [L]
&lt;/IfModule&gt;</pre>
        </div>
        <?php endif; ?>

        <p>mod_rewrite enabled: <strong class="<?= $modRewriteEnabled === true ? 'success' : ($modRewriteEnabled === false ? 'failure' : 'warning') ?>"><?= is_bool($modRewriteEnabled) ? ($modRewriteEnabled ? 'Yes' : 'No') : $modRewriteEnabled ?></strong></p>
    </div>

    <div class="diagnostic-section">
        <h2>Directory Permissions</h2>
        <table>
            <?php foreach($storagePermissions as $key => $value): ?>
            <tr>
                <th><?= ucwords(str_replace('_', ' ', $key)) ?></th>
                <td class="<?= $value ? 'success' : 'failure' ?>"><?= $value ? 'Yes' : 'No' ?></td>
            </tr>
            <?php endforeach; ?>

            <?php foreach($publicPermissions as $key => $value): ?>
            <tr>
                <th><?= ucwords(str_replace('_', ' ', $key)) ?></th>
                <td class="<?= $key === 'index_php_permissions' ? '' : ($value ? 'success' : 'failure') ?>">
                    <?php if($key === 'index_php_permissions'): ?>
                        <?= decoct($value & 0777) ?> (<?= substr(sprintf('%o', $value), -4) ?>)
                    <?php else: ?>
                        <?= $value ? 'Yes' : 'No' ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="diagnostic-section">
        <h2>Laravel Route Testing</h2>
        <p>Testing admin and provider routes to identify differences:</p>

        <table>
            <tr>
                <th>Route Type</th>
                <th>URL</th>
                <th>Status</th>
            </tr>

            <?php
            // Get the base URL
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $baseUrl = $protocol . "://" . $_SERVER['HTTP_HOST'];

            // Test routes
            $routes = [
                'Admin Dashboard' => '/admin/dashboard',
                'Provider Dashboard' => '/provider/dashboard',
                'Provider Activities' => '/provider/activities',
                'Provider Simple Activities' => '/provider/simple-activities',
            ];

            foreach($routes as $name => $path):
                $url = $baseUrl . $path;
                $test = testUrl($url);
            ?>
            <tr>
                <td><?= $name ?></td>
                <td><?= htmlspecialchars($url) ?></td>
                <td class="<?= $test['success'] ? 'success' : 'failure' ?>"><?= htmlspecialchars($test['status']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="diagnostic-section">
        <h2>Recommendations for Provider Section</h2>
        <div class="fix-suggestion">
            <p><strong>1. Check .htaccess file:</strong> Make sure it contains proper rewrite rules.</p>
            <p><strong>2. Check file permissions:</strong> Storage and bootstrap/cache directories should be writable.</p>
            <p><strong>3. Route caching:</strong> Try running these commands on your server:</p>
            <pre>php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear</pre>
            <p><strong>4. Check controller namespaces:</strong> Make sure you're not having controller conflicts.</p>
            <p><strong>5. Check for URL format issues:</strong> On shared hosting, you might need a different URL format for the provider routes.</p>
        </div>
    </div>
</body>
</html>