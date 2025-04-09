import fs from "fs";
import { globby } from "globby";

const filesNeedToExclude = await globby([
    "dist/data/*.json",
    "!dist/data/*.dist.json",
    "!dist/data/*.local.json",
]);

filesNeedToExclude.forEach((file) => {
    fs.unlinkSync(file);
});
