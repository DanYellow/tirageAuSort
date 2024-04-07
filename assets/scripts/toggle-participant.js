document
    .querySelectorAll("[data-take-part] input[type='radio']")
    .forEach((item) => {
        item.addEventListener("change", (e) => {
            e.currentTarget
                .closest(".accordion-item")
                .querySelector("button")
                .classList.toggle("opacity-70");
        });
    });

document
    .querySelectorAll("[data-take-part] input[type='radio']:checked")
    .forEach((item) => {
        if (String(item.value) === "0") {
            console.log(item.value);
            item.closest(".accordion-item")
                .querySelector("button")
                .classList.add("opacity-70");
        }
    });
