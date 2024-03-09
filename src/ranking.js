import gsap from "gsap";
import _ from "lodash";

import "./index.css";

let finalRank = null;
const dataFileFolder = "./data";
let index;
let isRevealing = false;

const btnToggleFullscreen = document.querySelector(
    "[data-btn-toggle-fullscreen]"
);

const tplFullscreenBtnRaw = document.querySelector(
    "[data-tpl-id='fullscreen']"
);
const tplReduceScreenBtnRaw = document.querySelector(
    "[data-tpl-id='reduce-screen']"
);
const lockIconContainer = document.querySelector("[data-lock]")
const passwordModal = document.querySelector("[data-password-modal]");
const passwordModalForm = document.querySelector("[data-password-modal-form]");

const loadFile = async (url) => {
    try {
        const res = await fetch(url);
        const resJson = await res.json();

        const resSorted = _.orderBy(resJson, ["rank"], ["desc"]);

        return resSorted.map((item, idx) => ({ ...item, id: idx }));
    } catch (error) {
        const fallbackFile = `${dataFileFolder}/liste.json`;
        return await loadFile(fallbackFile);
    }
};

const toggleFullScreen = (e) => {
    if (!document.fullscreenElement) {
        const tplReduceScreenBtn =
            tplReduceScreenBtnRaw.content.cloneNode(true);
        e.currentTarget.replaceChildren(tplReduceScreenBtn);
        document.documentElement.requestFullscreen();
    } else if (document.exitFullscreen) {
        const tplFullscreenBtn = tplFullscreenBtnRaw.content.cloneNode(true);
        e.currentTarget.replaceChildren(tplFullscreenBtn);
        document.exitFullscreen();
    }
};

const listAuthorizedKeys = ["enter", "NumpadEnter"].map((item) =>
    item.toLowerCase()
);

const revealRankedParticipant = async (e) => {
    if (
        !listAuthorizedKeys.includes(e.code.toLowerCase()) ||
        index <= 0 ||
        isRevealing
    ) {
        return;
    }
    isRevealing = true;
    const participantName = document.querySelector(
        `[data-ranked-participant="${index}"]`
    );

    await gsap.fromTo(
        participantName,
        { ease: "power2.out", translateY: "0" },
        { ease: "power2.out", translateY: "100px", duration: 1.5 }
    );

    participantName.textContent = `${finalRank[index - 1].prenom} ${
        finalRank[index - 1].nom
    }`;

    await gsap.fromTo(
        participantName,
        { opacity: 0, ease: "power2.out", translateY: "100px" },
        { opacity: 1, ease: "power2.out", translateY: "0px", duration: 1.5 }
    );
    index--;
    isRevealing = false;
};

const enableAllFeatures = async () => {
    lockIconContainer.remove()
    const mainFile = `${dataFileFolder}/ranking.dist.json`;
    finalRank = await loadFile(mainFile);

    document.addEventListener("keydown", revealRankedParticipant);
    index = finalRank.length;
}

(async () => {
    passwordModal.showModal()
    passwordModalForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        passwordModal.close();
        if(formData.get("password") === "src") {
            enableAllFeatures()
        }
    })

    btnToggleFullscreen.addEventListener("click", toggleFullScreen);
})();
