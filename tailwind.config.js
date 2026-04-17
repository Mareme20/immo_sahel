import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', 'Figtree', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', 'ui-serif', 'Georgia', ...defaultTheme.fontFamily.serif],
                display: ['var(--font-clash)', 'Playfair Display', 'ui-serif', 'Georgia'],
            },
            colors: {
                primary: {
                    50: '#eef7ff',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    900: '#1e3a8a',
                },
                gold: {
                    50: '#fef7e8',
                    100: '#fde8af',
                    400: '#f4c430',
                    500: '#eab308',
                    600: '#ca8a04',
                    700: '#a16207',
                },
                copper: {
                    50: '#fdf4f1',
                    400: '#fb923c',
                    500: '#f59e0b',
                    600: '#d97706',
                },
                neutral: {
                    50: '#fafafa',
                    900: '#111827',
                },
            },
            animation: {
                'fade-in': 'fadeIn 0.6s ease-out',
                'slide-up': 'slideUp 0.5s ease-out',
                'float': 'float 3s ease-in-out infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
            },
        },
    },

    // Custom font-face for Clash Display
    fontFamily: {
        'clash': ['Clash Display', 'ui-serif'],
    },

    plugins: [forms],
};
