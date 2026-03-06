import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/agent.js',
                'resources/js/display.js',
                'resources/js/queue/agent.js',
                'resources/js/queue/screen.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,/*
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: '10.0.2.2',
        },*/
    },
});