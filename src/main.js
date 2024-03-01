import gsap from "gsap";
import _ from "lodash";

import "./index.css";

import reloadIcon from "./reload-icon";
import expandIcon from "./expand-icon";
import reduceIcon from "./reduce-icon";
import screenIs from './tailwind.breakpoints'

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
const sideMenu = document.querySelector("[data-side-menu]");
const title = document.querySelector("[data-title]");
const content = document.querySelector("[data-content]");
const btnReloadLink = document.querySelector("[data-reload-link]");
const btnForceReload = document.querySelector("[data-btn-force-reload]");
const btnCancelReload = document.querySelector("[data-btn-cancel-reload]");
const btnToggleFullscreen = document.querySelector(
    "[data-btn-toggle-fullscreen]"
);

const tplParticipantRaw = document.querySelector("[data-tpl-id='participant']");
const warningModal = document.querySelector("[data-warning-modal]");

const loadFile = async (url) => {
    try {
        const res = await fetch(url);
        const resJson = await res.json();

        const resSorted = _.orderBy(resJson, ['nom'], ['asc']);

        return resSorted.map((item, idx) => ({ ...item, id: idx }));
    } catch (error) {
        // const fallbackFile = `${dataFileFolder}/liste.json`;
        // return await loadFile(fallbackFile);
    }
};

const displayParticipant = () => {
    const randomIndex = Math.floor(Math.random() * listParticipants.length);
    const randomParticipant = listParticipants[randomIndex];

    participantName.classList.remove("text-transparent");
    participantName.classList.add("text-gray-800");
    participantName.textContent = `${randomParticipant.prenom} ${randomParticipant.nom}`;

    const selectedParticipant = document.querySelector(
        `[data-participant-id="${randomParticipant.id}"]`
    );
    const order = nbTotalParticipants - listParticipants.length + 1;
    selectedParticipant.textContent = `${order}. ${selectedParticipant.textContent}`;
    selectedParticipant.classList.add("line-through");

    gsap.fromTo(
        participantName,
        { opacity: 0, ease: "power2.out", translateY: "20px" },
        { opacity: 1, ease: "power2.out", translateY: "0px", duration: 0.5 }
    );
    listParticipants.splice(randomIndex, 1);
    nbParticipants.textContent = `(${listParticipants.length}/${nbTotalParticipants})`;

    if (listParticipants.length === 0) {
        btnFetchParticipant.setAttribute("disabled", "disabled");
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
        e.currentTarget.innerHTML = reduceIcon;
        document.documentElement.requestFullscreen();
    } else if (document.exitFullscreen) {
        e.currentTarget.innerHTML = expandIcon;
        document.exitFullscreen();
    }
};

const toggleLayout = () => {
    isExpanded = !isExpanded;

    title.classList.toggle("horizontal-text");
    title.classList.toggle("text-4xl");
    btnToggleLayout.classList.toggle("rotate-180");
    updateReloadButtonLayout(isExpanded)
    if (isExpanded) {
        sideMenu.classList.remove("lg:w-[8%]");
        sideMenu.classList.add("lg:w-3/12", "max-h-[35%]");
        listParticipantsContainer.classList.remove("hidden");
        listParticipantsContainer.classList.add("block");
        content.classList.remove("lg:w-[92%]");
        content.classList.add("lg:w-9/12");
        btnReloadLink.innerHTML = "Recommencer";
    } else {
        sideMenu.classList.remove("lg:w-3/12");
        sideMenu.classList.add("lg:w-[8%]");
        listParticipantsContainer.classList.remove("block");
        listParticipantsContainer.classList.add("hidden");
        content.classList.remove("lg:w-9/12");
        content.classList.add("lg:w-[92%]");
    }
};

const updateReloadButtonLayout = (isExpanded) =>{
    if (!isExpanded && screenIs('lg')) {
        btnReloadLink.innerHTML = reloadIcon;
    } else {
        btnReloadLink.innerHTML = "Recommencer";
    }
}

const reload = () => {
    if (
        listParticipants.length < nbTotalParticipants &&
        listParticipants.length != 0
    ) {
        warningModal.showModal();
    } else {
        location.reload();
    }
};

btnFetchParticipant.addEventListener("click", displayParticipant);
btnToggleLayout.addEventListener("click", toggleLayout);
btnReloadLink.addEventListener("click", reload);
btnToggleFullscreen.addEventListener("click", toggleFullScreen);
btnForceReload.addEventListener("click", () => {
    location.reload();
});
btnCancelReload.addEventListener("click", () => {
    warningModal.close();
});

(async () => {
    btnFetchParticipant.setAttribute("disabled", "disabled");
    const mainFile = `${dataFileFolder}/liste.dist.json`;
    listParticipants = await loadFile(mainFile);
    nbTotalParticipants = listParticipants.length;
    nbParticipants.textContent = `(${listParticipants.length}/${nbTotalParticipants})`;
    generateListParticipants();
    btnFetchParticipant.removeAttribute("disabled");
})();
