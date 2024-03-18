
import gsap from 'gsap';

const btnFetchParticipant = document.querySelector(
    "[data-btn-random-participant]"
);
const listParticipantsContainer = document.querySelector(
    "[data-list-participants]"
);
const participantContainer = document.querySelector("[data-participant]");
const participantName = document.querySelector("[data-participant-name]");
const participantFormation = document.querySelector("[data-participant-formation]");

const nbRemainingParticipants = document.querySelector("[data-remaining-participants]");

let listParticipants = JSON.parse(listParticipantsContainer.dataset?.listParticipants) || [];
let nbTotalParticipants = 0;

console.log(listParticipants);

const displayParticipant = () => {
    const randomIndex = Math.floor(Math.random() * listParticipants.length);
    const randomParticipant = listParticipants[randomIndex];
    console.log(randomParticipant);
    participantContainer.classList.remove("text-transparent");
    participantContainer.classList.add("text-gray-800");

    const lastnameSpan = document.createElement("span");
    lastnameSpan.classList.add("font-bold")
    lastnameSpan.textContent = randomParticipant.lastname

    participantName.textContent = `${randomParticipant.firstname} `;
    participantName.appendChild(lastnameSpan)

    participantFormation.textContent = randomParticipant.formation

    const selectedParticipant = document.querySelector(
        `[data-participant-id="${randomParticipant.id}"]`
    );

    selectedParticipant.classList.add("line-through");
    selectedParticipant.scrollIntoView({
        behavior: "auto",
    });

    gsap.fromTo(
        participantContainer,
        { opacity: 0, ease: "power2.out", translateY: "20px" },
        { opacity: 1, ease: "power2.out", translateY: "0px", duration: 0.5 }
    );
    listParticipants.splice(randomIndex, 1);
    nbRemainingParticipants.textContent = listParticipants.length;

    if (listParticipants.length === 0) {
        btnFetchParticipant.setAttribute("disabled", "disabled");
    }
};

(async () => {
    btnFetchParticipant.addEventListener("click", displayParticipant);
})();