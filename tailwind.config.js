// /** @type {import('tailwindcss').Config} */
// module.exports = {
//   content: [
//     "./resources/**/*.blade.php",
//     "./resources/**/*.js",
//     "./resources/**/*.vue",
//     "./app/View/Components/**/*.php",
//   ],
//   theme: {
//     extend: {
//       colors: {
//         primary: '#3B82F6',
//         secondary: '#64748B',
//       }
//     },
//   },
//   plugins: [
//     require('@tailwindcss/forms'),
//     require('@tailwindcss/aspect-ratio'),
//   ],
// }
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}