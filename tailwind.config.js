import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import daisyui from 'daisyui';

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
                sans: ['League Spartan', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                mint: '#37CDBE',
                charcoal: '#1D232A',
                cream: '#FAFCFB',
                'cream-alt': '#F0F5F3',
                purple: '#570DF8',
            },
            animation: {
                'bounce-slow': 'bounce-slow 4s ease-in-out infinite',
            },
            keyframes: {
                'bounce-slow': {
                    '0%, 100%': { transform: 'translateY(-5%)' },
                    '50%': { transform: 'translateY(5%)' },
                },
            },
            transitionTimingFunction: {
                'premium': 'cubic-bezier(0.16, 1, 0.3, 1)',
            },
        },
    },

    plugins: [forms, daisyui],

    daisyui: {
        themes: [
            {
                bersihinaja: {
                    "primary": "#570df8",
                    "secondary": "#f000b8",
                    "accent": "#37cdbe",
                    "neutral": "#2a323c",
                    "base-100": "#1d232a",
                    "info": "#3abff8",
                    "success": "#36d399",
                    "warning": "#fbbd23",
                    "error": "#f87272",
                },
            },
            "light",
            "dark",
        ],
    },
};
