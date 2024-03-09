import gsap from "gsap";
import _ from "lodash";

import "./index.css";

let listParticipants = [];
let nbTotalParticipants = 0;
let isExpanded = true;
const dataFileFolder = "./data";

const btnFetchParticipant = document.querySelector(
    "[data-btn-random-participant]"
);
const btnToggleLayout = document.querySelector("[data-btn-toggle-layout]");
const listParticipantsContainer = document.querySelector(
    "[data-list-participants]"
);
const participantName = document.querySelector("[data-participant-name]");
const nbParticipants = document.querySelector("[data-nb-participants]");

const btnToggleFullscreen = document.querySelector(
    "[data-btn-toggle-fullscreen]"
);

const tplParticipantRaw = document.querySelector("[data-tpl-id='participant']");
const tplFullscreenBtnRaw = document.querySelector(
    "[data-tpl-id='fullscreen']"
);
const tplReduceScreenBtnRaw = document.querySelector(
    "[data-tpl-id='reduce-screen']"
);
const warningModal = document.querySelector("[data-warning-modal]");

const loadFile = async (url) => {
    try {
        const res = await fetch(url);
        const resJson = await res.json();

        const resSorted = _.orderBy(resJson, ["nom"], ["asc"]);

        return resSorted.map((item, idx) => ({ ...item, id: idx }));
    } catch (error) {
        const fallbackFile = `${dataFileFolder}/liste.json`;
        return await loadFile(fallbackFile);
    }
};



const generateListParticipants = () => {
    listParticipants.forEach((element) => {
        const tplParticipant = tplParticipantRaw.content.cloneNode(true);
        const liTag = tplParticipant.querySelector("li");
        liTag.textContent = `${element.prenom} ${element.nom}`;
        liTag.dataset.participantId = element.id;

        listParticipantsContainer.append(tplParticipant);
    });
};

const toggleFullScreen = (e) => {
    if (!document.fullscreenElement) {
        const tplReduceScreenBtn = tplReduceScreenBtnRaw.content.cloneNode(true);
        e.currentTarget.replaceChildren(tplReduceScreenBtn);
        document.documentElement.requestFullscreen();
    } else if (document.exitFullscreen) {
        const tplFullscreenBtn = tplFullscreenBtnRaw.content.cloneNode(true);
        e.currentTarget.replaceChildren(tplFullscreenBtn);
        document.exitFullscreen();
    }
};


(async () => {
    btnToggleFullscreen?.addEventListener("click", toggleFullScreen);
    // btnFetchParticipant?.setAttribute("disabled", "disabled");
    // const mainFile = `${dataFileFolder}/liste.dist.json`;
    // listParticipants = await loadFile(mainFile);

    // nbTotalParticipants = listParticipants.length;
    // nbParticipants.textContent = `(${listParticipants.length}/${nbTotalParticipants})`;
    // generateListParticipants();
    // btnFetchParticipant?.removeAttribute("disabled");
})();
