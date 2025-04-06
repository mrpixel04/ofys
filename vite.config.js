import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    base: process.env.NODE_ENV === 'production' ? '/build/' : '/',
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/provider.js'
            ],
            refresh: true,
            publicDirectory: 'public',
        }),
        tailwindcss(),
    ],
});
