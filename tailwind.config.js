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
                // Modern Primary Blue
                blue: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                },
                // Neutral Gray
                gray: {
                    50: '#f9fafb',
                    100: '#f3f4f6',
                    200: '#e5e7eb',
                    300: '#d1d5db',
                    400: '#9ca3af',
                    500: '#6b7280',
                    600: '#4b5563',
                    700: '#374151',
                    800: '#1f2937',
                    900: '#111827',
                },
                // Modern Accent Colors
                emerald: {
                    50: '#f0fdf4',
                    500: '#10b981',
                    600: '#059669',
                },
                violet: {
                    50: '#f5f3ff',
                    500: '#a855f7',
                    600: '#9333ea',
                },
                amber: {
                    50: '#fffbeb',
                    500: '#f59e0b',
                    600: '#d97706',
                },
                rose: {
                    50: '#fff5f7',
                    500: '#f43f5e',
                    600: '#e11d48',
                },
            },
            spacing: {
                xs: '0.5rem',
                sm: '0.75rem',
                md: '1rem',
                lg: '1.5rem',
                xl: '2rem',
                '2xl': '3rem',
            },
            fontSize: {
                xs: ['12px', { lineHeight: '1.5' }],
                sm: ['14px', { lineHeight: '1.5' }],
                base: ['16px', { lineHeight: '1.6' }],
                lg: ['18px', { lineHeight: '1.6' }],
                xl: ['20px', { lineHeight: '1.6' }],
                '2xl': ['24px', { lineHeight: '1.3' }],
                '3xl': ['30px', { lineHeight: '1.2' }],
                '4xl': ['36px', { lineHeight: '1.1' }],
            },
            fontWeight: {
                regular: '400',
                medium: '500',
                semibold: '600',
                bold: '700',
            },
            borderRadius: {
                sm: '4px',
                md: '6px',
                lg: '8px',
                xl: '12px',
                '2xl': '16px',
            },
            boxShadow: {
                sm: '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
                md: '0 4px 12px -2px rgba(0, 0, 0, 0.08)',
                lg: '0 10px 24px -4px rgba(0, 0, 0, 0.12)',
                xl: '0 20px 40px -8px rgba(0, 0, 0, 0.15)',
                '2xl': '0 25px 50px -12px rgba(0, 0, 0, 0.2)',
                glow: '0 0 20px rgba(59, 130, 246, 0.3)',
            },
            backgroundImage: {
                'gradient-modern': 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                'gradient-blue': 'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)',
                'gradient-emerald': 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
            },
            transitionDuration: {
                fast: '150ms',
                smooth: '200ms',
                slow: '300ms',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-up': 'slideUp 0.5s ease-out',
                'pulse-soft': 'pulseSoft 2s ease-in-out infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(10px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                pulseSoft: {
                    '0%, 100%': { opacity: '1' },
                    '50%': { opacity: '0.8' },
                },
            },
        },
    },

    plugins: [forms],
};
