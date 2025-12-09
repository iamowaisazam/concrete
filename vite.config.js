import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';
import vuetify from 'vite-plugin-vuetify'

export default defineConfig({
    // base: "/build/",
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@': path.resolve(__dirname, 'resources/js'),
            '@stores': path.resolve(__dirname, 'resources/js/stores'),
            '@services': path.resolve(__dirname, 'resources/js/services'),
            '@plugins': path.resolve(__dirname, 'resources/js/plugins'),
            '@components': path.resolve(__dirname, 'resources/js/components'),
            '@assets': path.resolve(__dirname, 'resources/js/assets'),
            '@views': path.resolve(__dirname, 'resources/js/views'),
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue(),
        vuetify({ autoImport: true }),
    ],
});
