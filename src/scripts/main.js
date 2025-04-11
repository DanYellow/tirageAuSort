import gsap from "gsap";
import _ from "lodash";

import "/src/index.css";
import "./fullscreen";

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
const participantContainer = document.querySelector("[data-participant]");
const participantName = document.querySelector("[data-participant-name]");
const participantSubject = document.querySelector("[data-participant-subject]");

const nbParticipants = document.querySelector("[data-nb-participants]");
const title = document.querySelector("[data-title]");
const btnReloadLink = document.querySelector("[data-reload-link]");
const btnForceReload = document.querySelector("[data-btn-force-reload]");
const btnCancelReload = document.querySelector("[data-btn-cancel-reload]");
const gridMainLayout = document.querySelector("[data-grid-main-layout]");
const tplParticipantRaw = document.querySelector("[data-tpl-id='participant']");

const warningModal = document.querySelector("[data-warning-modal]");

const loadFile = async (url) => {
    try {
        const res = await fetch(url);
        const resJson = await res.json();

        const resSorted = _.orderBy(resJson, ["nom"], ["asc"]);

        return resSorted.map((item, idx) => ({ ...item, id: idx }));
    } catch (error) {
        const fallbackFile = `${dataFileFolder}/liste.dist.json`;
        return await loadFile(fallbackFile);
    }
};

const displayParticipant = () => {
    const randomIndex = Math.floor(Math.random() * listParticipants.length);
    const randomParticipant = listParticipants[randomIndex];

    participantContainer.classList.remove("text-transparent");
    participantContainer.classList.add("text-gray-800");

    const lastnameSpan = document.createElement("span");
    lastnameSpan.classList.add("font-semibold");
    lastnameSpan.textContent = randomParticipant.nom

    participantName.textContent = `${randomParticipant.prenom} `;
    participantName.appendChild(lastnameSpan)

    // participantSubject.textContent = randomParticipant.sujet

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
    nbParticipants.textContent = `(${listParticipants.length}/${nbTotalParticipants})`;

    if (listParticipants.length === 0) {
        btnFetchParticipant.classList.add("hidden");
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

const toggleLayout = () => {
    title.classList.toggle("horizontal-text", isExpanded);
    title.classList.toggle("text-4xl", isExpanded);
    title.classList.toggle("text-3xl", !isExpanded);
    btnToggleLayout.classList.toggle("rotate-180", isExpanded);

    if (isExpanded) {
        gridMainLayout.classList.add("xl:grid-cols-[6%_auto]")
        gridMainLayout.classList.add("grid-rows-[minmax(13%,_220px)_auto_60px]")
        gridMainLayout.classList.add("grid-rows-[35%_auto_60px]");
        gridMainLayout.classList.remove("grid-rows-[350px_auto_80px]")
        gridMainLayout.classList.remove("xl:grid-cols-[25%_auto]");
        
        listParticipantsContainer.classList.remove("block");
        listParticipantsContainer.classList.add("hidden");
    } else {
        gridMainLayout.classList.add("grid-rows-[350px_auto_80px]");
        gridMainLayout.classList.add("xl:grid-cols-[25%_auto]");
        gridMainLayout.classList.remove("grid-rows-[minmax(13%,_220px)_auto_60px]");
        gridMainLayout.classList.remove("xl:grid-cols-[6%_auto]");
        gridMainLayout.classList.remove("grid-rows-[35%_auto_60px]");

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
btnForceReload.addEventListener("click", () => {
    location.reload();
});
btnCancelReload?.addEventListener("click", () => {
    warningModal.close();
});

(async () => {
    btnFetchParticipant?.setAttribute("disabled", "disabled");
    const mainFile = `${dataFileFolder}/liste.local.json`;
    listParticipants = await loadFile(mainFile);

    nbTotalParticipants = listParticipants.length;
    nbParticipants.textContent = `(${listParticipants.length}/${nbTotalParticipants})`;
    generateListParticipants();
    btnFetchParticipant.removeAttribute("disabled");
})();
