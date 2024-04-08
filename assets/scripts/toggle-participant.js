document
    .querySelectorAll("[data-take-part] input[type='radio']:checked")
    .forEach((item) => {
        if (String(item.value) === "0") {
            item.closest(".accordion-item")
                .querySelector("button")
                .classList.add("opacity-70");
        }
    });

document.body.addEventListener(
    "change",
    function (event) {
        if (
            event.target.matches("[data-take-part] input[type='radio']:checked")
        ) {
            event.target
                .closest(".accordion-item")
                .querySelector("button")
                .classList.toggle("opacity-70");
        }
    },
    true
);
