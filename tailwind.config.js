import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
<<<<<<< HEAD
        "./resources/**/*.js",
=======
>>>>>>> 6e27fc8f819ab12cb9a87b13b18e6246c488fc80
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

<<<<<<< HEAD
    plugins: [
        forms,
        typography,
    ],
=======
    plugins: [forms, typography],
>>>>>>> 6e27fc8f819ab12cb9a87b13b18e6246c488fc80
};
