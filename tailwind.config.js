/** @type {import('tailwindcss').Config} */
export default {
  content: [
    // Rutas donde Tailwind va a utilizar sus clases
    // JIT (JOIN IN TIME) 
    // Si no especificamos una ruta acá no podriamos utilizar tailwind en ese/esos archivo/s
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php"
  ],
  theme: {
    extend: {
      blur: {
        xs: '2px',
      },
      screens: {
        xs: '425px'
      }
    },
  },
  plugins: [

  ],
  variants: {
    extend: {
      display: ["group-hover"],
    },
  },
}

