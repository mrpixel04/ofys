<?php
// Fix Livewire with Tailwind CSS
header('Content-Type: text/plain');

$rootDir = __DIR__;
echo "Working in: {$rootDir}\n\n";

// STEP 1: Find and update main layout files
echo "STEP 1: Finding main layout files...\n";
$layoutFiles = [];

// Check common locations for layout files
$commonPaths = [
    $rootDir . '/resources/views/layouts/app.blade.php',
    $rootDir . '/resources/views/layouts/guest.blade.php',
    $rootDir . '/resources/views/components/layouts/app.blade.php',
    $rootDir . '/resources/views/livewire/layouts/app.blade.php',
    $rootDir . '/resources/views/app.blade.php',
    $rootDir . '/resources/views/master.blade.php',
];

foreach ($commonPaths as $path) {
    if (file_exists($path)) {
        $layoutFiles[] = $path;
        echo "Found layout: " . basename($path) . "\n";
    }
}

// If no layouts found in common locations, search all blade files
if (empty($layoutFiles)) {
    echo "No layouts found in common locations. Searching all views...\n";

    function findLayoutFiles($dir, &$results) {
        if (!file_exists($dir)) return;

        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                findLayoutFiles($path, $results);
            } else if (strpos($file, '.blade.php') !== false) {
                $content = file_get_contents($path);
                // Look for indicators that this might be a layout file
                if (strpos($content, '<html') !== false ||
                    strpos($content, '<head') !== false ||
                    strpos($content, '@vite') !== false ||
                    strpos($content, 'DOCTYPE') !== false) {
                    $results[] = $path;
                }
            }
        }
    }

    findLayoutFiles($rootDir . '/resources/views', $layoutFiles);
    echo "Found " . count($layoutFiles) . " potential layout files.\n";
}

// STEP 2: Update all found layout files
echo "\nSTEP 2: Updating layout files with Tailwind CSS and Livewire scripts...\n";

$tailwindCdn = '<script src="https://cdn.tailwindcss.com"></script>';
$livewireStyles = '@livewireStyles';
$livewireScripts = '@livewireScripts';

$updatedCount = 0;

foreach ($layoutFiles as $file) {
    echo "Processing: " . basename($file) . "\n";
    $content = file_get_contents($file);
    $original = $content;

    // Create backup if it doesn't exist
    $backupFile = $file . '.bak';
    if (!file_exists($backupFile)) {
        file_put_contents($backupFile, $content);
        echo "  Created backup: " . basename($backupFile) . "\n";
    }

    // 1. Replace @vite directives with Tailwind CDN
    if (strpos($content, '@vite') !== false) {
        $content = preg_replace('/@vite\(\[(.*?)\]\)/', $tailwindCdn, $content);
        echo "  Replaced @vite directive with Tailwind CDN\n";
    }

    // 2. Make sure Tailwind is included in the head if not already
    if (strpos($content, 'tailwind') === false && strpos($content, '</head>') !== false) {
        $content = str_replace('</head>', $tailwindCdn . "\n</head>", $content);
        echo "  Added Tailwind CDN to head section\n";
    }

    // 3. Make sure Livewire styles and scripts are included if they aren't already
    if (strpos($content, '@livewireStyles') === false && strpos($content, '</head>') !== false) {
        $content = str_replace('</head>', "    " . $livewireStyles . "\n</head>", $content);
        echo "  Added @livewireStyles to head section\n";
    }

    if (strpos($content, '@livewireScripts') === false && strpos($content, '</body>') !== false) {
        $content = str_replace('</body>', "    " . $livewireScripts . "\n</body>", $content);
        echo "  Added @livewireScripts before end of body\n";
    }

    // Save changes if modified
    if ($content !== $original) {
        file_put_contents($file, $content);
        $updatedCount++;
        echo "  Updated " . basename($file) . " successfully\n";
    } else {
        echo "  No changes needed for " . basename($file) . "\n";
    }
}

echo "\nUpdated {$updatedCount} layout file(s).\n";

// STEP 3: Create a test blade component with Livewire and Tailwind
echo "\nSTEP 3: Creating a test component to verify the fix...\n";

// Create a simple Livewire component view
$testViewDir = $rootDir . '/resources/views/livewire';
if (!file_exists($testViewDir)) {
    mkdir($testViewDir, 0755, true);
    echo "Created directory: {$testViewDir}\n";
}

$testView = $testViewDir . '/test-component.blade.php';
$testViewContent = <<<'EOD'
<div class="bg-white p-6 rounded-lg shadow-lg max-w-md mx-auto mt-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Tailwind and Livewire Test</h2>

    <p class="text-gray-600 mb-4">
        If you're seeing this styled nicely with a white background, rounded corners, and shadow,
        then Tailwind CSS is working correctly!
    </p>

    <div class="mb-4">
        <span class="font-medium">Counter: </span>
        <span class="font-bold text-blue-600">{{ $count }}</span>
    </div>

    <button wire:click="increment"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Increment
    </button>
</div>
EOD;

file_put_contents($testView, $testViewContent);
echo "Created test view: " . basename($testView) . "\n";

// Create a simple Livewire component class
$livewireDir = $rootDir . '/app/Livewire';
if (!file_exists($livewireDir)) {
    mkdir($livewireDir, 0755, true);
    echo "Created directory: {$livewireDir}\n";
}

$testComponent = $livewireDir . '/TestComponent.php';
$testComponentContent = <<<'EOD'
<?php

namespace App\Livewire;

use Livewire\Component;

class TestComponent extends Component
{
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.test-component');
    }
}
EOD;

file_put_contents($testComponent, $testComponentContent);
echo "Created test component: " . basename($testComponent) . "\n";

// Create a route to test the component
$routesFile = $rootDir . '/routes/web.php';
if (file_exists($routesFile)) {
    $routesContent = file_get_contents($routesFile);

    // Check if test route already exists
    if (strpos($routesContent, 'TestComponent') === false) {
        $routesContent .= "\n\n// Test route for Tailwind & Livewire\nRoute::get('/test-tailwind', App\\Livewire\\TestComponent::class);\n";
        file_put_contents($routesFile, $routesContent);
        echo "Added test route: /test-tailwind\n";
    } else {
        echo "Test route already exists\n";
    }
} else {
    echo "Could not find routes file\n";
}

// STEP 4: Clear Laravel caches
echo "\nSTEP 4: Clearing Laravel cache...\n";

try {
    // Try to bootstrap Laravel
    require_once $rootDir . '/vendor/autoload.php';
    $app = require_once $rootDir . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    // Clear various caches
    $kernel->call('cache:clear');
    echo "✓ Application cache cleared\n";

    $kernel->call('config:clear');
    echo "✓ Configuration cache cleared\n";

    $kernel->call('route:clear');
    echo "✓ Route cache cleared\n";

    $kernel->call('view:clear');
    echo "✓ View cache cleared\n";

} catch (Exception $e) {
    echo "! Failed to clear Laravel cache: " . $e->getMessage() . "\n";
}

echo "\n============================================\n";
echo "Fix complete! Steps to verify:\n\n";
echo "1. Visit your main site: https://ofys.eastbizz.com\n";
echo "2. Check if styles are applied now\n";
echo "3. Try the test page: https://ofys.eastbizz.com/test-tailwind\n";
echo "   This page should display a styled Livewire component with a working counter\n";
echo "============================================\n";
