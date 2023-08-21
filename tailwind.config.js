/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'media',
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
    ],
    theme: {
        extend: {
            fontSize: {
                'base': '16px', // Bazowa czcionka dla domyślnych ekranów
            },
        },
    },
    plugins: [
    ],
}