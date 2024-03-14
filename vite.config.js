import { defineConfig } from "vite";
import { globby } from "globby";

import vituum from "vituum";

import nunjucks from "@vituum/vite-plugin-nunjucks";
import tailwindcss from "@vituum/vite-plugin-tailwindcss";

import fs from "fs";
import { copyFile } from 'node:fs/promises';


const paths = await globby(["src/pages/*.json"]);
const finalJsonPaths = paths.map((item) => {
    let categoryName = item.replace("src/pages/", "");
    categoryName = categoryName.replace(".json", "");
    return categoryName;
});


const addHtaccessFile = () => {
    return {
        name: "add-htaccess-file",
        resolveId(source) {
            return source === "virtual-module" ? source : null;
        },
        async buildEnd() {
            // const listDistFolders = ["dist/assets", "dist/images"]

            // listDistFolders.forEach(async (item) => {
            //     await copyFile('public/data/.htaccess', `${item}/.htaccess`);
            // })
        },
    };
}

function removeLocalJsonFiles() {
    return {
        name: "remove-local-json-files",
        resolveId(source) {
            return source === "virtual-module" ? source : null;
        },
        async buildEnd() {
            const filesNeedToExclude = await globby(["dist/data/*.json", "!dist/data/*.dist.json"]);
            filesNeedToExclude.forEach((file) => {
                fs.unlinkSync(file);
            })
            
        },
    };
}

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
        removeLocalJsonFiles(),
        addHtaccessFile(),
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
    build: {
        manifest: true,
    },
});
