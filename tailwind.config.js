/** @type {import('tailwindcss').Config} */

import containerQueries from "@tailwindcss/container-queries";

module.exports = {
    content: ["./assets/**/*.js", "./templates/**/*.html.twig"],
    theme: {
        extend: {
            transitionProperty: {
                width: "width",
                "grid-template-columns": "grid-template-columns",
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
            minHeight: {
                100: "34rem",
                110: "40rem",
                120: "54rem",
            },
            colors: {
                "btn-primary": "#5368d5",
            },
        },
    },
    plugins: [containerQueries],
};
