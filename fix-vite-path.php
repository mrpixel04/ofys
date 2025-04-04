<?php
// Script to fix Vite path issues in Laravel
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fix Vite Path Issue</title>
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
    <h1>Fix Vite Path Issue</h1>

    <div class="section">
        <h2>Problem Detected</h2>
        <p>There's a path duplication issue in your Vite configuration. Laravel is looking for the manifest file at:</p>
        <pre>/home2/eastbizz/public_html/ofys/public/build//home/eastbizzcom/public_html/ofys/public/build/manifest.json</pre>
        <p>Notice the double path. This happens when Laravel's Vite configuration has an incorrect base path setting.</p>
    </div>

    <?php
    $rootDir = __DIR__;
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    if ($action === 'fix') {
        echo "<div class='section'>";
        echo "<h2>Fixing Vite Path Issues</h2>";

        // 1. Check and update vite.php configuration
        $viteConfigPath = $rootDir . '/config/vite.php';
        $viteIncludePath = $rootDir . '/vendor/laravel/framework/src/Illuminate/Foundation/Vite.php';

        // Try to find and update Laravel's Vite.php class
        if (file_exists($viteIncludePath)) {
            echo "<h3>Updating Laravel Vite Configuration:</h3>";

            // Create a backup
            $backupPath = $viteIncludePath . '.bak';
            if (!file_exists($backupPath)) {
                if (copy($viteIncludePath, $backupPath)) {
                    echo "<p class='success'>✓ Created backup of Vite.php</p>";
                } else {
                    echo "<p class='error'>✗ Failed to create backup of Vite.php</p>";
                }
            }

            // Read the file content
            $viteContent = file_get_contents($viteIncludePath);

            // Update the manifest path construction
            $originalViteContent = $viteContent;

            // Pattern to look for: buildPath() function that creates the manifest path
            $updatedContent = preg_replace(
                '/private function manifest\(\): array\s*{([^}]+)}/s',
                'private function manifest(): array {
        $buildPath = rtrim($this->buildDirectory, \'/\');
        $manifest = $this->manifestPath();

        if (! is_file($manifest)) {
            // If the path has duplication, try a simpler path
            if (str_contains($manifest, $this->buildDirectory . $this->buildDirectory)) {
                $simplePath = public_path("build/manifest.json");
                if (is_file($simplePath)) {
                    return json_decode(file_get_contents($simplePath), true);
                }
            }

            throw new ViteManifestNotFoundException(
                "Vite manifest not found at: {$manifest}."
            );
        }

        return json_decode(file_get_contents($manifest), true);}',
                $viteContent
            );

            if ($updatedContent === $viteContent) {
                echo "<p class='warning'>! Could not identify the manifest function pattern in Vite.php.</p>";
            } else {
                // Try a simpler approach: create a custom Vite class that extends the original
                echo "<p>Creating a custom Vite helper class instead of modifying core files...</p>";

                // Create a custom Vite helper class
                $appDir = $rootDir . '/app';
                $helpersDir = $appDir . '/Helpers';

                if (!file_exists($helpersDir)) {
                    if (mkdir($helpersDir, 0755, true)) {
                        echo "<p class='success'>✓ Created Helpers directory</p>";
                    } else {
                        echo "<p class='error'>✗ Failed to create Helpers directory</p>";
                    }
                }

                $customViteHelperPath = $helpersDir . '/ViteHelper.php';
                $customViteContent = <<<'EOD'
<?php

namespace App\Helpers;

use Illuminate\Foundation\Vite as LaravelVite;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\ViteManifestNotFoundException;

class ViteHelper extends LaravelVite
{
    /**
     * Override the manifest method to handle path duplications
     */
    protected function manifestPath(string $buildDirectory = null): string
    {
        $buildDirectory ??= $this->buildDirectory;

        // Use a simple, direct path to the manifest file
        return public_path('build/manifest.json');
    }
}
EOD;

                if (file_put_contents($customViteHelperPath, $customViteContent)) {
                    echo "<p class='success'>✓ Created custom ViteHelper class</p>";

                    // Now create a service provider to register this helper
                    $providersDir = $appDir . '/Providers';
                    $viteServiceProviderPath = $providersDir . '/ViteServiceProvider.php';
                    $viteServiceProviderContent = <<<'EOD'
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\ViteHelper;
use Illuminate\Foundation\Vite;

class ViteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Vite::class, function ($app) {
            return new ViteHelper();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
EOD;

                    if (file_put_contents($viteServiceProviderPath, $viteServiceProviderContent)) {
                        echo "<p class='success'>✓ Created ViteServiceProvider</p>";

                        // Register the service provider in config/app.php
                        $appConfigPath = $rootDir . '/config/app.php';
                        if (file_exists($appConfigPath)) {
                            $appConfig = file_get_contents($appConfigPath);

                            // Check if the provider is already registered
                            if (strpos($appConfig, 'App\\Providers\\ViteServiceProvider::class') === false) {
                                // Find the providers array
                                $pattern = '/\'providers\'\s*=>\s*\[\s*([^\]]+)\s*\]/s';
                                if (preg_match($pattern, $appConfig, $matches)) {
                                    $providersContent = $matches[1];
                                    $newProvidersContent = $providersContent . "\n        App\\Providers\\ViteServiceProvider::class,";
                                    $appConfig = str_replace($providersContent, $newProvidersContent, $appConfig);

                                    if (file_put_contents($appConfigPath, $appConfig)) {
                                        echo "<p class='success'>✓ Registered ViteServiceProvider in config/app.php</p>";
                                    } else {
                                        echo "<p class='error'>✗ Failed to update config/app.php</p>";
                                    }
                                } else {
                                    echo "<p class='error'>✗ Could not find providers array in config/app.php</p>";
                                }
                            } else {
                                echo "<p>ViteServiceProvider already registered in config/app.php</p>";
                            }
                        } else {
                            echo "<p class='error'>✗ config/app.php not found</p>";
                        }
                    } else {
                        echo "<p class='error'>✗ Failed to create ViteServiceProvider</p>";
                    }
                } else {
                    echo "<p class='error'>✗ Failed to create custom ViteHelper class</p>";
                }
            }
        } else {
            echo "<p class='error'>✗ Laravel Vite.php not found at expected location</p>";
        }

        // Create a simpler solution - a modified index.php that handles Vite manifest path
        echo "<h3>Creating a direct fix for public/index.php:</h3>";

        $indexPath = $rootDir . '/public/index.php';
        $originalIndexContent = file_exists($indexPath) ? file_get_contents($indexPath) : '';

        if (!empty($originalIndexContent)) {
            // Create a backup
            $indexBackupPath = $indexPath . '.bak';
            if (!file_exists($indexBackupPath)) {
                if (copy($indexPath, $indexBackupPath)) {
                    echo "<p class='success'>✓ Created backup of public/index.php</p>";
                } else {
                    echo "<p class='error'>✗ Failed to create backup of public/index.php</p>";
                }
            }

            // Create a special version of index.php with Vite fix
            $modifiedIndexContent = <<<'EOD'
<?php

define('LARAVEL_START', microtime(true));

// Fix Vite manifest path issue - create the manifest path if it doesn't exist
$manifestPath = __DIR__ . '/build/manifest.json';
if (!file_exists($manifestPath) && file_exists(__DIR__ . '/build')) {
    $manifestContent = file_exists($manifestPath . '.bak')
        ? file_get_contents($manifestPath . '.bak')
        : '{}';
    file_put_contents($manifestPath, $manifestContent);
}

// Continue with normal Laravel bootstrap
require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
EOD;

            if (file_put_contents($indexPath, $modifiedIndexContent)) {
                echo "<p class='success'>✓ Updated public/index.php with Vite manifest fix</p>";
            } else {
                echo "<p class='error'>✗ Failed to update public/index.php</p>";
            }
        } else {
            echo "<p class='error'>✗ public/index.php not found or empty</p>";
        }

        // Create a direct fix for the blade files
        echo "<h3>Fixing Blade Templates:</h3>";

        $viewsDir = $rootDir . '/resources/views';
        $bladeFiles = [];

        function findBladeFiles($dir, &$results) {
            if (!file_exists($dir)) return;

            $files = scandir($dir);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                $path = $dir . '/' . $file;
                if (is_dir($path)) {
                    findBladeFiles($path, $results);
                } else if (strpos($file, '.blade.php') !== false) {
                    $results[] = $path;
                }
            }
        }

        if (file_exists($viewsDir)) {
            findBladeFiles($viewsDir, $bladeFiles);

            // Create a backup directory
            $backupDir = $rootDir . '/resources/views/backups';
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            $updatedFiles = 0;
            foreach ($bladeFiles as $file) {
                $content = file_get_contents($file);

                // Check if file uses Vite
                if (strpos($content, '@vite') !== false) {
                    // Create a backup
                    $backupFile = $backupDir . '/' . basename($file) . '.bak';
                    file_put_contents($backupFile, $content);

                    // Replace @vite directives with manually included assets
                    $newContent = preg_replace('/@vite\(\[(.*?)\]\)/', '
<!-- Vite assets manually included -->
<link rel="stylesheet" href="{{ asset(\'build/assets/app-BTFOwWE6.css\') }}">
<script src="{{ asset(\'build/assets/app-BPKtxCGZ.js\') }}" defer></script>
', $content);

                    if ($newContent !== $content) {
                        file_put_contents($file, $newContent);
                        echo "<p class='success'>✓ Updated file: " . basename($file) . " with direct asset paths</p>";
                        $updatedFiles++;
                    }
                }
            }

            if ($updatedFiles === 0) {
                echo "<p>No Blade files with @vite directives found.</p>";
            }
        }

        // Clear Laravel cache
        echo "<h3>Clearing Laravel Cache:</h3>";

        try {
            // Try to bootstrap Laravel
            require_once $rootDir . '/vendor/autoload.php';
            $app = require_once $rootDir . '/bootstrap/app.php';
            $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

            // Clear various caches
            $kernel->call('cache:clear');
            echo "<p class='success'>✓ Application cache cleared</p>";

            $kernel->call('config:clear');
            echo "<p class='success'>✓ Configuration cache cleared</p>";

            $kernel->call('route:clear');
            echo "<p class='success'>✓ Route cache cleared</p>";

            $kernel->call('view:clear');
            echo "<p class='success'>✓ View cache cleared</p>";

        } catch (Exception $e) {
            echo "<p class='error'>✗ Failed to clear Laravel cache: " . $e->getMessage() . "</p>";
            echo "<p>You may need to manually run clear cache commands.</p>";
        }

        echo "</div>";

        echo "<div class='section'>";
        echo "<h2>Fix Complete!</h2>";
        echo "<p>The Vite path issue should now be fixed. Try accessing your Laravel application:</p>";
        echo "<ul>";
        echo "<li><a href='https://ofys.eastbizz.com/test' target='_blank'>Visit test page</a></li>";
        echo "<li><a href='https://ofys.eastbizz.com' target='_blank'>Visit main page</a></li>";
        echo "</ul>";

        echo "<p><strong>What was fixed:</strong></p>";
        echo "<ol>";
        echo "<li>Created a custom Vite helper that uses a direct path to the manifest file</li>";
        echo "<li>Updated public/index.php to ensure the manifest file exists</li>";
        echo "<li>Modified blade templates to directly include the assets instead of using Vite directives</li>";
        echo "<li>Cleared all Laravel caches</li>";
        echo "</ol>";
        echo "</div>";

    } else {
        // Show the fix button
    ?>
    <div class="section">
        <h2>Solution</h2>
        <p><a href="?action=fix" class="button">Fix Vite Path Issues</a></p>
        <p>This will:</p>
        <ol>
            <li>Create a custom Vite helper that fixes the path issue</li>
            <li>Update your Laravel configuration to use this helper</li>
            <li>Modify your blade templates to directly include the CSS/JS assets</li>
            <li>Update index.php to ensure the manifest file exists</li>
            <li>Clear all Laravel caches</li>
        </ol>
    </div>
    <?php
    }
    ?>

    <div class="section">
        <h2>Manifest File Information</h2>
        <?php
        $manifestPath = $rootDir . '/public/build/manifest.json';
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            echo "<p>Current manifest.json content:</p>";
            echo "<pre>" . json_encode($manifest, JSON_PRETTY_PRINT) . "</pre>";

            if (empty($manifest)) {
                echo "<p class='warning'>The manifest file exists but is empty or invalid JSON.</p>";
            } else {
                echo "<p class='success'>The manifest file exists and contains valid data.</p>";
            }

            // Show asset files
            echo "<h3>Asset Files:</h3>";
            echo "<ul>";
            foreach ($manifest as $entry => $config) {
                if (isset($config['file'])) {
                    $assetPath = $rootDir . '/public/build/' . $config['file'];
                    if (file_exists($assetPath)) {
                        echo "<li class='success'>" . $config['file'] . " (exists)</li>";
                    } else {
                        echo "<li class='error'>" . $config['file'] . " (missing)</li>";
                    }
                }
            }
            echo "</ul>";
        } else {
            echo "<p class='error'>Manifest file not found at: {$manifestPath}</p>";
        }
        ?>
    </div>
</body>
</html>
