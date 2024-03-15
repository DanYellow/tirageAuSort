import gsap from "gsap";
import _ from "lodash";

import "/src/index.css";
import "./fullscreen";

let finalResults = null;
let configuration;
let index = 0;
let isRevealing = false;
const dataFileFolder = "./data";
const currentCategory = document.querySelector("[data-category-name]").dataset.categoryName
const listAwardsType = ["public", "jury"]

const btnCloseFormModal = document.querySelector(
    "[data-btn-close-form-modal]"
);
const lockIconContainer = document.querySelector("[data-lock]")
const passwordModal = document.querySelector("[data-password-modal]");
const passwordModalForm = document.querySelector("[data-password-modal-form]");

const encrypt = (str) => {
    return crypto.subtle.digest("SHA-512", new TextEncoder("utf-8").encode(str)).then(buf => {
        return Array.prototype.map.call(new Uint8Array(buf), x=>(('00'+x.toString(16)).slice(-2))).join('');
    });
}

const loadFileForCurrentCategory = async (url) => {
    try {
        const res = await fetch(url);
        const resJson = await res.json();

        configuration = resJson.configuration;

        return resJson[currentCategory];
    } catch (error) {
        const fallbackFile = `${dataFileFolder}/ranking.json`;
        return await loadFile(fallbackFile);
    }
};

const listAuthorizedKeys = ["enter", "NumpadEnter"].map((item) =>
    item.toLowerCase()
);

const revealWinnerForAward = async (e) => {
    if (
        !e.ctrlKey ||
        !listAuthorizedKeys.includes(e.code.toLowerCase()) ||
        index >= listAwardsType.length ||
        isRevealing
    ) {
        return;
    }

    isRevealing = true;
    const type = listAwardsType[index];

    const winnerForCategory = document.querySelector(`[data-${type}-award]`);
    const winnerData = finalResults[type];
    winnerForCategory.innerHTML = `${winnerData.prenom} <span class="font-bold">${winnerData.nom}</span>`;

    await gsap.to(winnerForCategory, { 
            filter: "blur(0px)", 
            duration: Number(configuration?.["transition-time"] || 3.5), 
            ease: "power2.out" 
        });
    index++;
    isRevealing = false;
};

const enableAllFeatures = async () => {
    lockIconContainer.remove()
    const mainFile = `${dataFileFolder}/${atob("cmFua2luZy5kaXN0Lmpzb24=")}`;
    finalResults = await loadFileForCurrentCategory(mainFile);

    document.addEventListener("keydown", revealWinnerForAward);
}

const hash = "64510d7fd46ced29e92b91b20c3c935913182d79c995301bcf468a3a44514d3d815555404d061fc9f38f99c962b2f2907869a32370d338812c3956a4dca0c724"

;(async () => {
    passwordModal.showModal()
    passwordModalForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        passwordModal.close();
        const decryptedPassword = await encrypt(formData.get("password"))
        if(decryptedPassword === hash) {
            enableAllFeatures()
        }
    })
    
    btnCloseFormModal.addEventListener("click", () => {
        passwordModal.close();
    });
})();
