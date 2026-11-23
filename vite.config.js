import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        rolldownOptions: {
            output: {
                codeSplitting: {
                    groups: [
                        {
                            name: 'vendor-sinema',
                            test: /node_modules[\\/](gsap|lenis)/,
                        },
                        {
                            name: 'vendor-tabel',
                            test: /node_modules[\\/](jquery|datatables\.net|select2)/,
                        },
                        {
                            name: 'vendor-ui',
                            test: /node_modules[\\/](alpinejs|sweetalert2)/,
                        },
                    ],
                },
            },
        },
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
