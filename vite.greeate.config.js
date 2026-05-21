import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/greeate.css',
                'resources/css/greeate.tailwind4.css',
                'resources/css/rtl.css',
                'resources/js/greeate.js',
                'resources/js/web-push.js',
            ],
            refresh: true,
        }),
    ],
});
