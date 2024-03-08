import { defineConfig } from "vite";

export default defineConfig({
    base: "./",
    define: {
        'import.meta.env.CURRENT_YEAR': JSON.stringify(new Date().getFullYear()),
    },
});
