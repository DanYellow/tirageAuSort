import TomSelect from "tom-select";
import TomSelect_remove_button from "tom-select/dist/js/plugins/remove_button.js";
TomSelect.define("remove_button", TomSelect_remove_button);

import "./bootstrap.js";

import "./styles/admin.css";

const tomSelectOptions = {
    allowEmptyOption: true,
    plugins: ["clear_button"],
};

document
    .querySelectorAll("select[id^='EloquenceContest_participants_']")
    .forEach((item) => {
        new TomSelect(item, tomSelectOptions);
    });

if (document.querySelector("button.field-collection-add-button")) {
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
                            new TomSelect(item, tomSelectOptions);
                        }
                    });
            }, 50);
        });
}
if (window.location.hash) {
    const anchorTarget = document.querySelector(window.location.hash);
    if (anchorTarget) {
        window.scroll({
            top: anchorTarget.getBoundingClientRect().top - 85,
            left: 0,
            behavior: "auto",
        });
        anchorTarget.parentNode
            .querySelector(".accordion-collapse")
            .classList.add("show");
    }
}

const awardComputedText = document.querySelector(
    "[data-computed-award-display]"
);
if (awardComputedText) {
    document
        .querySelector("[data-award-title]")
        .addEventListener("input", (e) => {
            awardComputedText.textContent = e.currentTarget.value;
        });
}
