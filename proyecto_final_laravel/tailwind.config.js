/** @type {import('tailwindcss').Config} */
export default {
  darkMode:'class',
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.jsx', // ¡ESTO ES IMPORTANTE!
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
