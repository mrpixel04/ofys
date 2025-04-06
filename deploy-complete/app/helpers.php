<?php

/**
 * Get the correct URL for stored files, accounting for production server structure
 */
if (!function_exists('storage_url')) {
    function storage_url($path)
    {
        // On your cPanel server, images are directly in public/storage/
        // We'll use a direct URL reference for consistent access
        return url('/storage/' . $path);
    }
}

if (!function_exists('vite_asset')) {
    /**
     * Get the path to a versioned Vite asset.
     *
     * @param  string  $path
     * @return string
     */
    function vite_asset($path)
    {
        // Load manifest file
        static $manifest = null;
        if ($manifest === null) {
            $manifestPath = public_path('build/manifest.json');
            if (file_exists($manifestPath)) {
                $manifest = json_decode(file_get_contents($manifestPath), true);
            } else {
                $manifest = [];
            }
        }

        // Find the asset in the manifest
        if (isset($manifest[$path])) {
            return asset('build/' . $manifest[$path]['file']);
        }

        // Fallback to direct asset path
        return asset($path);
    }
}
