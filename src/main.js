import gsap from "gsap";

import './index.css';
import reloadIcon from "./reload-icon";

let listParticipants = []
let nbTotalParticipants = 0;

const btnFetchParticipant = document.querySelector("[data-btn-random-participant]")
const btnToggleLayout = document.querySelector("[data-btn-toggle-layout]")
const listParticipantsContainer = document.querySelector("[data-list-participants]")
const participantName = document.querySelector("[data-participant-name]")
const nbParticipants = document.querySelector("[data-nb-participants]")
const sideMenu = document.querySelector("[data-side-menu]")
const title = document.querySelector("[data-title]")
const content = document.querySelector("[data-content]")
const btnReloadLink = document.querySelector("[data-reload-link]")

const tplParticipantRaw = document.querySelector("[data-tpl-id='participant']");

const dataFileFolder = "/data";

const loadFile = async (url) => {
    try {
        const res = await fetch(url);
        const resJson = await res.json();

        return [...resJson].sort(({ nom: a }, { nom: b }) => b < a).map((item, idx) => ({...item, id: idx}));
    } catch (error) {
        const fallbackFile = `${dataFileFolder}/liste.json`;

        return await loadFile(fallbackFile);
    }
}

const displayParticipant = () => {
    const randomIndex = Math.floor(Math.random() * listParticipants.length);
    const randomParticipant = listParticipants[randomIndex];

    participantName.classList.remove("text-transparent")
    participantName.textContent = `${randomParticipant.prenom} ${randomParticipant.nom}`;
    
    const selectedParticipant = document.querySelector(`[data-participant-id="${randomParticipant.id}"]`);
    const order = (nbTotalParticipants - listParticipants.length) + 1
    selectedParticipant.textContent = `${order}. ${selectedParticipant.textContent}`
    selectedParticipant.classList.add("line-through")
    
    gsap.fromTo(
        participantName,
        { opacity: 0, ease: "power2.out", translateY: "20px" },
        { opacity: 1, ease: "power2.out", translateY: "0px", duration: 0.5 }
    );
    listParticipants.splice(randomIndex, 1);
    nbParticipants.textContent = `(${listParticipants.length}/${nbTotalParticipants})`;

    if(listParticipants.length === 0) {
        btnFetchParticipant.setAttribute("disabled", "disabled");
    }
}

const generateListParticipants = () => {
    listParticipants.forEach(element => {
        const tplParticipant = tplParticipantRaw.content.cloneNode(true);
        const liTag = tplParticipant.querySelector("li")
        liTag.textContent = `${element.prenom} ${element.nom}`;
        liTag.dataset.participantId = element.id;

        listParticipantsContainer.append(tplParticipant);
    });
}

let isExpanded = true;
const toggleLayout = () => {
    isExpanded = !isExpanded;

    title.classList.toggle("horizontal-text")
    if(isExpanded) {
        sideMenu.classList.remove("w-[8%]")
        sideMenu.classList.add("w-3/12")
        listParticipantsContainer.classList.remove("hidden")
        listParticipantsContainer.classList.add("block")
        content.classList.remove("w-[92%]")
        content.classList.add("w-9/12")
        btnReloadLink.innerHTML = "Recommencer";
    } else {
        sideMenu.classList.remove("w-3/12")
        sideMenu.classList.add("w-[8%]")
        listParticipantsContainer.classList.remove("block")
        listParticipantsContainer.classList.add("hidden")
        content.classList.remove("w-9/12")
        content.classList.add("w-[92%]")
        btnReloadLink.innerHTML = reloadIcon;
    }
}

document.querySelector("[data-warning-modal]").showModal()
const reload = () => {
    if(listParticipants.length != 0) {
        document.querySelector("[data-warning-modal]").showModal()
    } else {
        location.reload();
    }
}

btnFetchParticipant.addEventListener("click", displayParticipant);
btnToggleLayout.addEventListener("click", toggleLayout);
btnReloadLink.addEventListener("click", reload);

(async () => {
    const mainFile = `${dataFileFolder}/liste.diste.json`;
    listParticipants = await loadFile(mainFile);
    nbTotalParticipants = listParticipants.length;
    nbParticipants.textContent = `(${listParticipants.length}/${nbTotalParticipants})`;
    generateListParticipants();
})();