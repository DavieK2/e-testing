import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import {svelte} from "@sveltejs/vite-plugin-svelte";
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        svelte({
            prebundleSvelteLibraries: true,
          }),
    ],
    optimizeDeps: {
        include: ['@inertiajs/inertia'],
    },

    resolve: {
        alias: {
            '$components': path.resolve('./resources/js/components'),
            '$lib': path.resolve('./resources/js/components')
        }
    }
});