<?php
// Laravel Quick Fix Script for Shared Hosting
header('Content-Type: text/plain');

echo "==============================================\n";
echo "Laravel Quick Fix for Shared Hosting\n";
echo "==============================================\n\n";

$basePath = __DIR__;
echo "Working in: " . $basePath . "\n\n";

// 1. Create essential directories with correct permissions
echo "1. Creating essential directories...\n";
$directories = [
    'storage/app/public',
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'bootstrap/cache',
    'public/storage',
];

foreach ($directories as $dir) {
    $fullPath = $basePath . '/' . $dir;
    echo "  Checking $dir... ";

    if (!file_exists($fullPath)) {
        if (mkdir($fullPath, 0755, true)) {
            echo "created successfully.\n";
        } else {
            echo "FAILED to create.\n";
        }
    } else {
        echo "already exists.\n";
    }

    // Set permissions
    @chmod($fullPath, 0755);
}

// 2. Create or fix .htaccess files
echo "\n2. Creating/fixing .htaccess files...\n";

// Root .htaccess
$rootHtaccess = <<<'EOT'
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Handle direct file access
    RewriteCond %{REQUEST_FILENAME} -f
    RewriteRule ^ - [L]

    # Handle direct directory access
    RewriteCond %{REQUEST_FILENAME} -d
    RewriteRule ^ - [L]

    # For Laravel in the public directory
    RewriteRule ^$ public/index.php [L]
    RewriteRule ^((?!public/).*)$ public/$1 [L,NC]
</IfModule>

# Set directory index
DirectoryIndex index.php index.html

# Disable directory browsing
Options -Indexes
EOT;

// Public .htaccess
$publicHtaccess = <<<'EOT'
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
EOT;

// Write root .htaccess
echo "  Writing root .htaccess... ";
if (file_put_contents($basePath . '/.htaccess', $rootHtaccess)) {
    echo "done.\n";
} else {
    echo "FAILED.\n";
}

// Write public .htaccess
echo "  Writing public/.htaccess... ";
if (file_put_contents($basePath . '/public/.htaccess', $publicHtaccess)) {
    echo "done.\n";
} else {
    echo "FAILED.\n";
}

// 3. Check if .env file exists, create from example if not
echo "\n3. Checking .env file...\n";
if (!file_exists($basePath . '/.env')) {
    echo "  .env file not found. ";

    if (file_exists($basePath . '/.env.example')) {
        echo "Creating from .env.example... ";
        if (copy($basePath . '/.env.example', $basePath . '/.env')) {
            echo "done.\n";
            echo "  IMPORTANT: You should edit the .env file with your real database credentials.\n";
        } else {
            echo "FAILED.\n";
        }
    } else {
        echo "Creating default .env file... ";

        $defaultEnv = <<<'EOT'
APP_NAME=Laravel
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://ofys.eastbizz.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
EOT;

        if (file_put_contents($basePath . '/.env', $defaultEnv)) {
            echo "done.\n";
            echo "  IMPORTANT: You must edit the .env file with your actual database credentials.\n";
        } else {
            echo "FAILED.\n";
        }
    }
} else {
    echo "  .env file exists.\n";

    // Check if APP_KEY is set
    $env = file_get_contents($basePath . '/.env');
    if (!preg_match('/APP_KEY=base64:/', $env)) {
        echo "  APP_KEY not found or not in correct format. Generating new key... ";

        // Generate a random key
        try {
            $key = 'base64:' . base64_encode(random_bytes(32));
            $env = preg_replace('/APP_KEY=.*/', "APP_KEY=$key", $env);

            if (file_put_contents($basePath . '/.env', $env)) {
                echo "done.\n";
            } else {
                echo "FAILED to save.\n";
            }
        } catch (Exception $e) {
            echo "FAILED: " . $e->getMessage() . "\n";
        }
    }
}

// 4. Create storage symlink (directory copy for shared hosting)
echo "\n4. Setting up storage symlink...\n";
$publicStorage = $basePath . '/public/storage';
$appStorage = $basePath . '/storage/app/public';

if (!file_exists($publicStorage)) {
    echo "  public/storage doesn't exist. Creating... ";
    if (mkdir($publicStorage, 0755, true)) {
        echo "done.\n";
    } else {
        echo "FAILED.\n";
    }
}

// Copy files from storage/app/public to public/storage if any exist
if (file_exists($appStorage)) {
    echo "  Copying files from storage/app/public to public/storage...\n";

    // Simple file copy for basic cases
    $files = glob($appStorage . '/*');
    if (count($files) > 0) {
        foreach ($files as $file) {
            $filename = basename($file);
            echo "    Copying $filename... ";
            if (is_dir($file)) {
                echo "is directory, skipping.\n";
            } else {
                if (copy($file, $publicStorage . '/' . $filename)) {
                    echo "done.\n";
                } else {
                    echo "FAILED.\n";
                }
            }
        }
    } else {
        echo "  No files found in storage/app/public.\n";
    }
}

// 5. Create a bootstrap test file
echo "\n5. Creating a bootstrap test file...\n";
$bootstrapTest = <<<'EOT'
<?php
// This file verifies that the Laravel bootstrap process works
try {
    require __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "Bootstrap successful!";
} catch (Exception $e) {
    http_response_code(500);
    echo "Bootstrap failed: " . $e->getMessage();
}
EOT;

echo "  Writing bootstrap-test.php... ";
if (file_put_contents($basePath . '/bootstrap-test.php', $bootstrapTest)) {
    echo "done.\n";
    echo "  You can test Laravel bootstrapping at: https://ofys.eastbizz.com/bootstrap-test.php\n";
} else {
    echo "FAILED.\n";
}

// 6. Create an index.php file in root as fallback
echo "\n6. Creating root index.php bridge file...\n";
$rootIndex = <<<'EOT'
<?php
/**
 * Laravel - Bridge for Shared Hosting
 */

// Set paths
$laravelPath = __DIR__;
$publicPath = $laravelPath . '/public';

// Forward to Laravel's public/index.php
if (file_exists($publicPath . '/index.php')) {
    require $publicPath . '/index.php';
} else {
    echo '<h1>Laravel Setup Error</h1>';
    echo '<p>Could not find Laravel\'s public/index.php file.</p>';
    echo '<p>Please ensure Laravel is properly installed in this directory.</p>';
}
EOT;

echo "  Writing root index.php... ";
// Only create if it doesn't exist or isn't a Laravel bridge already
if (!file_exists($basePath . '/index.php') || strpos(file_get_contents($basePath . '/index.php'), 'Laravel - Bridge') === false) {
    if (file_put_contents($basePath . '/index.php', $rootIndex)) {
        echo "done.\n";
    } else {
        echo "FAILED.\n";
    }
} else {
    echo "already exists and looks like a Laravel bridge.\n";
}

echo "\n==============================================\n";
echo "Quick Fix Completed!\n";
echo "==============================================\n\n";

echo "Next Steps:\n";
echo "1. Visit https://ofys.eastbizz.com/check-error.php to diagnose any remaining issues\n";
echo "2. Make sure your database credentials are correct in the .env file\n";
echo "3. If you still see errors, check storage/logs/laravel.log for details\n";
echo "4. Try accessing your Laravel application at https://ofys.eastbizz.com\n";
?>