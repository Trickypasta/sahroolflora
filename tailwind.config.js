// tailwind.config.js

import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", "sans-serif"],
                lora: ["Lora", "serif"],
            },
            typography: ({ theme }) => ({
                DEFAULT: {
                    css: {
                        p: {
                            fontFamily: theme('fontFamily.sans'),
                        },
                    },
                },
            }),
        },
    },

    plugins: [
        forms,
        typography,
    ],
};