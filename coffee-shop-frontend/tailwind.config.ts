import type { Config } from 'tailwindcss'
import plugin from 'tailwindcss/plugin';


const config: Config = {
  content: [
    './src/pages/**/*.{js,ts,jsx,tsx,mdx}',
    './src/components/**/*.{js,ts,jsx,tsx,mdx}',
    './src/app/**/*.{js,ts,jsx,tsx,mdx}',
  ],
  theme: {
    extend: {
      colors: {
        // Caffe Umbria inspired color palette
        primary: {
          DEFAULT: '#000000', // Dark texta
          light: '#a0522d',
          dark: '#6b3410',
        },
        secondary: {
          DEFAULT: '#e9d665', // Gold
          light: '#f0e089',
          dark: '#d4c150',
        },
        accent: {
          DEFAULT: '#861316', // Coffee brown
          light: '#67584D',
          dark: '#000000',
        },
        background: {
          DEFAULT: '#9a8d7e', // Cream
          dark: '#67584D',
        },
        cream: '#dbcac1', 
        gold: '#67584D',
        texta: '#000000', // Text color for contrast
      },
      fontFamily: {
        sans: ['system-ui', '-apple-system', 'sans-serif'],
        serif: ['Georgia', 'serif'],
      },
      backgroundImage: {
        'hero-img': "url('/coffee-shop.jpg')",
        'hero-texture': "url('/daisy.png')",
      },
      textShadow: {
        'stroke-1': ' -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000',
        'stroke-2': ' -2px -2px 0 #000, 2px -2px 0 #000, -2px 2px 0 #000, 2px 2px 0 #000',
        'stroke-3': ' -3px -3px 0 #000, 3px -3px 0 #000, -3px 3px 0 #000, 3px 3px 0 #000',
        'stroke-4': ' -4px -4px 0 #000, 4px -4px 0 #000, -4px 4px 0 #000, 4px 4px 0 #000',
        'stroke-5': ' -5px -5px 0 #000, 5px -5px 0 #000, -5px 5px 0 #000, 5px 5px 0 #000',
      },
    },
  },
  plugins: [
    require('@designbycode/tailwindcss-text-stroke'),
    plugin(function ({ matchUtilities, theme }) {
      matchUtilities(
        {
          'text-shadow': (value) => ({ textShadow: value }),
        },
        { values: theme('textShadow') }
      );
    }),
  ],
}

export default config
