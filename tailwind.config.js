/** Builds a Tailwind color object whose shades read from CSS variables
 *  (e.g. --brand-500: "124 58 237") so colors can change at runtime. */
function withOpacity(varPrefix, shades) {
  const colors = {};
  for (const shade of shades) {
    colors[shade] = ({ opacityValue }) =>
      opacityValue === undefined
        ? `rgb(var(${varPrefix}-${shade}))`
        : `rgb(var(${varPrefix}-${shade}) / ${opacityValue})`;
  }
  return colors;
}

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
        // Values come from CSS custom properties injected at runtime
        // (App\Core\Theme, from Settings → Theme) rather than being baked
        // into this build, so admin color changes apply without a rebuild.
        brand: withOpacity('--brand', [50, 100, 200, 300, 400, 500, 600, 700, 800, 900]),
        accent: withOpacity('--accent', [50, 100, 200, 300, 400, 500, 600, 700, 800, 900]),
      },
    },
  },
  plugins: [],
};
