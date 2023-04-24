import {defineConfig} from 'vite'
import laravel, {refreshPaths} from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/jsPlumb.js',
                'resources/js/draggable.js',
                'resources/js/zoomable.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
                'app/Forms/Components/**',
            ],
        }),
    ],
})
