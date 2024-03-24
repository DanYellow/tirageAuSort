import TomSelect from "tom-select";

import "./bootstrap.js";

import "./styles/app.css";

document
    .querySelectorAll("select[id^='EloquenceContest_participants_']")
    .forEach((item) => {
        new TomSelect(item, {});
    });

document
    .querySelector("button.field-collection-add-button")
    .addEventListener("click", () => {
        setTimeout(() => {
            document
                .querySelectorAll(
                    "select[id^='EloquenceContest_participants_']"
                )
                .forEach((item) => {
                    if (!item.classList.contains("tomselected")) {
                        new TomSelect(item, {});
                    }
                });
        }, 50);
    });
