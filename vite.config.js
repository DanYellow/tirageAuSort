import { defineConfig } from "vite";
import { resolve, dirname } from "path";
import { fileURLToPath } from "url";
import vituum from "vituum";
import nunjucks from "@vituum/vite-plugin-nunjucks";
import tailwindcss from "@vituum/vite-plugin-tailwindcss";


const __dirname = dirname(fileURLToPath(import.meta.url));

export default defineConfig({
    base: "./",
    plugins: [
        vituum(),
        nunjucks({
            root: "./src",
        }),
        tailwindcss(),
    ],
    define: {
        "import.meta.env.CURRENT_YEAR": JSON.stringify(
            new Date().getFullYear()
        ),
    },
    build: {
        rollupOptions: {
            input: ["./src/pages/**/*.html", "./src/pages/**/*.njk"],
        },
    },
});
