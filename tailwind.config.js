/** @type {import('tailwindcss').Config} */

import containerQueries from "@tailwindcss/container-queries";

export default {
    content: ["./index.html", "./src/**/*.{js,ts,jsx,tsx}"],
    theme: {
        extend: {
            transitionProperty: {
                width: "width",
            },
            screens: {
                fullscreen: { raw: "(display-mode: fullscreen)" },
            },
            fontSize: {
                "11xl": "10rem",
            },
            containers: {
                "2xs": "12rem",
            },
        },
    },
    plugins: [containerQueries],
};
