import { defineConfig } from "vite";
import { globby } from "globby";

import vituum from "vituum";

import nunjucks from "@vituum/vite-plugin-nunjucks";
import tailwindcss from "@vituum/vite-plugin-tailwindcss";

const paths = await globby(['src/pages/*.json']);
const finalJsonPaths = paths.map((item) => {
    let categoryName = item.replace("src/pages/", "")
    categoryName = categoryName.replace(".json", "")
    return categoryName
})

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
                list_categories: finalJsonPaths,
            },
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
