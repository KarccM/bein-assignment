import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue"

export default defineConfig({
    plugins: [
        vue(),
        laravel([
            "resources/css/app.css",
            "resources/js/app.js",
        ]),
    ],
    resolve: {
        alias: {
            "@": "/resources/js/Bein-Assignment",
            "#": "/resources/js/Bein-Assignment",
        },
    },
});