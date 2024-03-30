const logoInput = document.querySelector("[data-logo-input]");
const logoContainer = document.querySelector("[data-logo-img]");

if (logoInput) {
    logoInput.addEventListener("change", (e) => {
        console.log(e)
        const [file] = e.target.files;

        logoContainer.src = URL.createObjectURL(file);
    });
}
