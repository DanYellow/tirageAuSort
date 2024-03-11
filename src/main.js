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
const sideMenu = document.querySelector("[data-side-menu]");
const title = document.querySelector("[data-title]");
const content = document.querySelector("[data-content]");
const btnReloadLink = document.querySelector("[data-reload-link]");
const btnForceReload = document.querySelector("[data-btn-force-reload]");
const btnCancelReload = document.querySelector("[data-btn-cancel-reload]");
const gridMainLayout = document.querySelector("[data-grid-main-layout]");
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

const displayParticipant = () => {
    const randomIndex = Math.floor(Math.random() * listParticipants.length);
    const randomParticipant = listParticipants[randomIndex];

    participantName.classList.remove("text-transparent");
    participantName.classList.add("text-gray-800");
    //  font-bold
    const lastnameSpan = document.createElement("span");
    lastnameSpan.classList.add("font-bold")
    lastnameSpan.textContent = randomParticipant.nom

    participantName.textContent = `${randomParticipant.prenom} `;
    participantName.appendChild(lastnameSpan)

    const selectedParticipant = document.querySelector(
        `[data-participant-id="${randomParticipant.id}"]`
    );

    selectedParticipant.classList.add("line-through");
    selectedParticipant.scrollIntoView({
        behavior: "auto",
    });

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
    listParticipants.forEach((item) => {
        const tplParticipant = tplParticipantRaw.content.cloneNode(true);
        const liTag = tplParticipant.querySelector("li");
        const firstnameTag = tplParticipant.querySelector("[data-firstname]")
        const lastnameTag = tplParticipant.querySelector("[data-lastname]")

        firstnameTag.textContent = item.prenom;
        lastnameTag.textContent = item.nom;
        liTag.dataset.participantId = item.id;

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

const toggleLayout = () => {
    title.classList.toggle("horizontal-text");
    title.classList.toggle("text-4xl");
    btnToggleLayout.classList.toggle("rotate-180");
    if (isExpanded) {
        gridMainLayout.classList.add("lg:grid-cols-[6%_auto]")
        gridMainLayout.classList.remove("grid-rows-[350px_auto_60px]")
        gridMainLayout.classList.add("grid-rows-[minmax(13%,_220px)_auto_60px]")

        sideMenu.classList.remove("lg:grid-cols-[25%_auto]");
        
        listParticipantsContainer.classList.remove("block");
        listParticipantsContainer.classList.add("hidden");
    } else {
        gridMainLayout.classList.remove("grid-rows-[minmax(13%,_220px)_auto_60px]")
        gridMainLayout.classList.add("grid-rows-[350px_auto_60px]")
        gridMainLayout.classList.add("lg:grid-cols-[25%_auto]")
        gridMainLayout.classList.remove("lg:grid-cols-[6%_auto]")
        gridMainLayout.classList.remove("grid-rows-[35%_auto_60px]")

        listParticipantsContainer.classList.remove("hidden");
        listParticipantsContainer.classList.add("block");
    }
    isExpanded = !isExpanded;
};

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
btnCancelReload?.addEventListener("click", () => {
    warningModal.close();
});

(async () => {
    btnFetchParticipant?.setAttribute("disabled", "disabled");
    const mainFile = `${dataFileFolder}/liste.dist.json`;
    listParticipants = await loadFile(mainFile);

    nbTotalParticipants = listParticipants.length;
    nbParticipants.textContent = `(${listParticipants.length}/${nbTotalParticipants})`;
    generateListParticipants();
    btnFetchParticipant.removeAttribute("disabled");
})();
