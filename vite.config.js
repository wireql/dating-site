import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/tailwind.output.css', 'resources/css/jquery.simple-modal.min.css', 'resources/js/jquery.simple-modal.min.js'],
            refresh: true,
        }),
    ],
});
