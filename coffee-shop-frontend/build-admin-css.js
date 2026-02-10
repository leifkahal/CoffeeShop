#!/usr/bin/env node

/**
 * Build script to compile admin.css with Tailwind CSS
 * Runs PostCSS on admin.css to process @tailwind and @apply directives
 * Supports watch mode with --watch flag
 */

const postcss = require('postcss');
const tailwindcss = require('tailwindcss');
const autoprefixer = require('autoprefixer');
const fs = require('fs');
const path = require('path');
const chokidar = require('chokidar');

// Input and output paths
const inputFile = path.resolve(__dirname, '../themes/CoffeeShop/admin.css');
const outputFile = path.resolve(__dirname, '../themes/CoffeeShop/admin.min.css');
const phpDir = path.resolve(__dirname, '../themes/CoffeeShop');

// Tailwind config
const tailwindConfig = {
  content: [
    path.resolve(__dirname, '../themes/CoffeeShop/**/*.php'),
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#000000',
          light: '#a0522d',
          dark: '#6b3410',
        },
        secondary: {
          DEFAULT: '#e9d665',
          light: '#f0e089',
          dark: '#d4c150',
        },
        accent: {
          DEFAULT: '#861316',
          light: '#67584D',
          dark: '#000000',
        },
        background: {
          DEFAULT: '#9a8d7e',
          dark: '#67584D',
        },
        cream: {
          DEFAULT: '#F5F5DC',
          light: '#FFFDD0',
          dark: '#FFEFD5',
        },
      },
    },
  },
};

// Build function
async function build() {
  try {
    const input = fs.readFileSync(inputFile, 'utf8');

    const result = await postcss([
      tailwindcss(tailwindConfig),
      autoprefixer(),
    ]).process(input, { from: inputFile, to: outputFile });

    fs.writeFileSync(outputFile, result.css);
    const timestamp = new Date().toLocaleTimeString();
    console.log(`[${timestamp}] ✓ Admin CSS compiled successfully`);
  } catch (err) {
    console.error('Error compiling admin CSS:', err);
    if (!isWatchMode) {
      process.exit(1);
    }
  }
}

// Check if watch mode is enabled
const isWatchMode = process.argv.includes('--watch');

if (isWatchMode) {
  console.log('👀 Watching for changes to admin.css and PHP files...');

  // Watch admin.css and PHP files
  const watcher = chokidar.watch([inputFile, phpDir], {
    ignored: /node_modules/,
    persistent: true,
    awaitWriteFinish: {
      stabilityThreshold: 100,
      pollInterval: 100,
    },
  });

  watcher.on('change', (file) => {
    console.log(`\n📝 File changed: ${path.relative(process.cwd(), file)}`);
    build();
  });

  // Initial build
  build();
} else {
  // Single build
  build();
}
