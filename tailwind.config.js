// Laravel Project: /tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                primary: '#3B82F6',
                secondary: '#64748B',
                accent: '#FBBF24',
                neutral: '#374151',
                'base-100': '#FFFFFF',
                info: '#3ABFF8',
                success: '#36D399',
                warning: '#FBBD23',
                error: '#F87272',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    variants: {
        extend: {
            backgroundColor: ['active'],
            textColor: ['active'],
            borderColor: ['active'],
        },
    },
    // plugins: [
    //     require('@tailwindcss/typography'),
    //     require('@tailwindcss/aspect-ratio'),
    //     require('@tailwindcss/line-clamp'),
    //     require('daisyui'),
    // ],
    // daisyui: {
    //     themes: [
    //         {
    //             mytheme: {
    //                 primary: '#3B82F6',
    //                 secondary: '#64748B',
    //                 accent: '#FBBF24',
    //                 neutral: '#374151',
    //                 'base-100': '#FFFFFF',
    //                 info: '#3ABFF8',
    //                 success: '#36D399',
    //                 warning: '#FBBD23',
    //                 error: '#F87272',
    //             },
    //         },
    //     ],
    // },
    // safelist: [
    //     'bg-primary',
    //     'bg-secondary',
    //     'bg-accent',
    //     'bg-neutral',
    //     'bg-base-100',
    //     'bg-info',
    //     'bg-success',
    //     'bg-warning',
    //     'bg-error',
    //     'text-primary',
    //     'text-secondary',
    //     'text-accent',
    //     'text-neutral',
    //     'text-base-100',
    //     'text-info',
    //     'text-success',
    //     'text-warning',
    //     'text-error',
    // ],

    plugins: [forms],
};
