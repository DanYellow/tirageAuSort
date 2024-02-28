import gsap from "gsap";

import './index.css'

let listParticipants = []

const btnFetchParticipant = document.querySelector("[data-btn-random-participant]")
const listParticipantsContainer = document.querySelector("[data-list-participants]")
const participantName = document.querySelector("[data-participant-name]")

const templateParticipantRaw = document.querySelector("[data-tpl-id='participant']");

const loadFile = async (url) => {
    try {
        const res = await fetch(url);
        const resJson = await res.json();

        return [...resJson].sort(({ nom: a }, { nom: b }) => b < a);
    } catch (error) {
        const fallbackFile = "/liste.json";
        return await loadFile(fallbackFile);
    }
}

const displayParticipant = () => {
    const randomIndex = Math.floor(Math.random() * listParticipants.length);
    const randomParticipant = listParticipants[randomIndex];

    participantName.classList.remove("text-transparent")
    participantName.textContent = `${randomParticipant.prenom} ${randomParticipant.nom}`;

    gsap.fromTo(
        participantName,
        { opacity: 0, ease: "power2.out", translateY: "20px" },
        { opacity: 1, ease: "power2.out", translateY: "0px", duration: 0.5 }
    );
}

btnFetchParticipant.addEventListener("click", displayParticipant);

(async () => {
    const mainFile = "/liste.distz.json";
    listParticipants = await loadFile(mainFile);
    console.log(listParticipants);
})();