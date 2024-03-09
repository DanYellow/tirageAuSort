/** @type {import('tailwindcss').Config} */

import containerQueries from "@tailwindcss/container-queries";
import forms from "@tailwindcss/forms";

export default {
    content: ["./*.html", "./src/**/*.{js,ts,jsx,tsx}"],
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
            minHeight: {
                100: "34rem",
                110: "40rem",
                120: "54rem",
            },
        },
    },
    plugins: [containerQueries, forms],
};
