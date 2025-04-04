<?php

/**
 * Get the correct URL for stored files, accounting for production server structure
 */
if (!function_exists('storage_url')) {
    function storage_url($path)
    {
        // On your cPanel server, images are directly in public/storage/
        // We'll use a direct URL reference for consistent access
        return url('/public/storage/' . $path);
    }
}
