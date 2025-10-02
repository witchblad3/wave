import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
    server: {
        host: true,               // слушаем 0.0.0.0 внутри контейнера
        port: 5173,
        cors: { origin: true },
        hmr: { host: 'localhost', port: 5173, protocol: 'ws' },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
})
