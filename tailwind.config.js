import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'ghana-gold': '#FFC107', // Vivid Gold/Yellow
                'moringa-leaf': '#2E7D32', // Deep Organic Green
                'soil-brown': '#4E342E', // Rich Earthy Brown
            },
        },
    },

    plugins: [forms],
};
