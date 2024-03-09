import { defineConfig } from "vite";
import { resolve, dirname } from "path";
import { fileURLToPath } from "url";

const __dirname = dirname(fileURLToPath(import.meta.url));


export default defineConfig({
    base: "./",
    define: {
        "import.meta.env.CURRENT_YEAR": JSON.stringify(
            new Date().getFullYear()
        ),
    },
    build: {
        rollupOptions: {
            input: {
                main: resolve(__dirname, "index.html"),
                ranking: resolve(__dirname, "classement.html"),
            },
        },
    },
});
