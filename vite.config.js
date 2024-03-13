import { defineConfig } from "vite";
import { resolve, dirname } from "path";
import { fileURLToPath } from "url";
import vituum from "vituum";
import nunjucks from "@vituum/vite-plugin-nunjucks";

const __dirname = dirname(fileURLToPath(import.meta.url));

export default defineConfig({
    base: "./",
    plugins: [
        vituum(),
        nunjucks({
            root: "./src",
        }),
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
        // rollupOptions: {
        //     input: {
        //         main: resolve(__dirname, "index.html"),
        //         ranking: resolve(__dirname, "classement.html"),
        //     },
        // },
    },
});
