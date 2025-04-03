import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    base: '/ofys/', // This tells Vite to use the correct path
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            // Ensure public path is correctly set for subdirectory
            publicDirectory: 'public',
        }),
        tailwindcss(),
    ],
});
