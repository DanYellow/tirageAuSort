import gsap from "gsap";

import './index.css'

let listParticipants = []
let nbTotalParticipants = 0;

const btnFetchParticipant = document.querySelector("[data-btn-random-participant]")
const listParticipantsContainer = document.querySelector("[data-list-participants]")
const participantName = document.querySelector("[data-participant-name]")
const nbParticipants = document.querySelector("[data-nb-participants]")

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

btnFetchParticipant.addEventListener("click", displayParticipant);

(async () => {
    const mainFile = `${dataFileFolder}/liste.diste.json`;
    listParticipants = await loadFile(mainFile);
    nbTotalParticipants = listParticipants.length;
    nbParticipants.textContent = `(${listParticipants.length}/${nbTotalParticipants})`;
    generateListParticipants();
})();