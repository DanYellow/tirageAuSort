import TomSelect from "tom-select";

import "./bootstrap.js";

import "./styles/admin.css";

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

if (window.location.hash) {
    const anchorTarget = document.querySelector(window.location.hash);
    if(anchorTarget) {
        // anchorTarget.scrollIntoView();
        window.scroll({
            top: anchorTarget.getBoundingClientRect().top - 85,
            left: 0,
            behavior: "auto",
        });
    }
}
