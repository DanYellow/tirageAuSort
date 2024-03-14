import { defineConfig } from "vite";
import vituum from "vituum";

import nunjucks from "@vituum/vite-plugin-nunjucks";
import tailwindcss from "@vituum/vite-plugin-tailwindcss";

export default defineConfig({
    base: "./",
    plugins: [
        vituum({
            pages: {
                normalizeBasePath: true,
            },
        }),
        nunjucks({
            root: "./src",
            globals: {
                "foo": "hello"
            }
        }),
        tailwindcss(),
    ],
    define: {
        "import.meta.env.CURRENT_YEAR": JSON.stringify(
            new Date().getFullYear()
        ),
    },
    server: {
        host: true,
        open: true,
    },
});
