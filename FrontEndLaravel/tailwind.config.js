/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./index.html",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./app/**/*.php",
    ],
    theme: {
        extend: {
            colors: {
                // Custom colors sesuai brand WISE
            },
            spacing: {
                // Custom spacing jika diperlukan
            },
        },
    },
    plugins: [],
};
