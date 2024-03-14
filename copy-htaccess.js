import { copyFile } from "node:fs/promises";

const listDistFolders = ["dist/assets", "dist/images"];

listDistFolders.forEach(async (item) => {
    await copyFile("public/data/.htaccess", `${item}/.htaccess`);
});
