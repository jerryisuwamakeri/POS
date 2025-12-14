import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    husk: '#bda160',
                    'old-lace': '#fefdf7',
                    'indian-khaki': '#c1ad86',
                    'albescent-white': '#f2e4c9',
                    teak: '#bba16f',
                    'off-yellow': '#fef9e7',
                    akaroa: '#dacaaa',
                },
            },
        },
    },

    plugins: [forms],
};

