import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        hmr: {
            host: 'localhost',
            port: 3000
        },
        watch: {
            usePolling: true
        },
        port: 3000
    },
    define: {
        global: 'window'
    },
});
