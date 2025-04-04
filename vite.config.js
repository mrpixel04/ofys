import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    base: '/', // Updated to root path since we're using a subdomain instead of subdirectory
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            // Updated for subdomain
            publicDirectory: 'public',
        }),
        tailwindcss(),
    ],
});
