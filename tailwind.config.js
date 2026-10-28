import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['var(--sans)', ...defaultTheme.fontFamily.sans],
                serif: ['var(--serif)', ...defaultTheme.fontFamily.serif],
            },
            
    
            colors: {
                theme: {
                    DEFAULT: 'var(--theme-color)', 
                    dark: 'var(--theme-dark)',    
                },
                secondary: 'var(--secondary)', 
                accent: 'var(--accent)',         
                dark: 'var(--dark)',         
                body: 'var(--body-text)',       
                bg: {
                    white: 'var(--bg-white)',
                    light: 'var(--bg-light)',
                },
                line: 'var(--border-color)',    
            },

   
            boxShadow: {
                'soft': 'var(--shadow-soft)',
                'hover': 'var(--shadow-hover)',
            },


            transitionTimingFunction: {
                'custom': 'cubic-bezier(0.25, 0.8, 0.25, 1)',
            },
            transitionDuration: {
                '400': '400ms',
            },
        },
    },
    plugins: [],
};