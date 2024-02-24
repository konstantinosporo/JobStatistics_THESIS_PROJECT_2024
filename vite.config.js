import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/css/icons/icons.css', 'resources/css/myCss/independentIndex/indIndex.css', 'resources/js/app.js', 'resources/js/myJs/colorTheme.js', 'resources/js/myJs/msg.js'],
            refresh: true,
        }),
    ],
});
