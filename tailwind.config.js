/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./template-parts/**/*.{php,html,js}", "./template-parts/*.{php,html,js}","./includes/*.{php,html,js}","./*.{php,html,js}"],
  theme: {
    extend: {
      colors : {
        'header-color': '#1A1A1A80',
        'primary-green': '#018B8D',
        'primary-black': '#141414',
        'secondary-black': '#262626',
      }
    },
  },
  plugins: [
      require('tailwind-scrollbar')
  ],
}

