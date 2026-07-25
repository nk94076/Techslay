/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./app/Views/**/*.php'],
  safelist: [
    // Status/badge colors assembled from PHP conditionals across admin views —
    // Tailwind's content scan can't see these since they're built at runtime.
    { pattern: /bg-(red|green|blue|amber|slate)-(50|100)/ },
    { pattern: /text-(red|green|blue|amber|slate)-(500|600|700)/ },
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          50: '#f5f3ff', 100: '#ede9fe', 200: '#ddd6fe', 300: '#c4b5fd',
          400: '#a78bfa', 500: '#7c3aed', 600: '#6d28d9', 700: '#5b21b6',
        },
        accent: { 500: '#2563eb', 600: '#1d4ed8' },
      },
    },
  },
  plugins: [],
};
