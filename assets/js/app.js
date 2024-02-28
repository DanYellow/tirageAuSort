let liste = [];
const btn = document.getElementById("btnTirageAuSort");
const btnReset = document.getElementById("btn-re");
const nom = document.getElementById("nom");
const prenom = document.getElementById("prenom");
const nomPrenom = document.getElementById("nomPrenom");
const listeEtudiant = document.getElementById("liste");

const templateParticipantRaw = document.querySelector("[data-tpl-id='participant']");

const templateContainer = document.querySelector("[data-tpl-container]")

// templateContainer.appendChild(templateParticipant)

const chargementFichier = (url) => {
    fetch(url)
        .then((data) => data.json())
        .then((data) => {
            liste = data.sort(({ nom: a }, { nom: b }) => b < a);

            liste.forEach((elem, index) => {
                let li = document.createElement("li");
                li.setAttribute("data-etudiant", `${index}`);
                li.textContent = `${elem.nom} ${elem.prenom}`;
                listeEtudiant.append(li);
            });
        })
        .catch(() => {
            const fallbackFile = "assets/liste.json";
            chargementFichier(fallbackFile);
        });
};

const mainFile = "assets/liste.dist.json";
chargementFichier(mainFile);

const genererNom = () => {
    gsap.fromTo(
        nomPrenom,
        { opacity: 0, ease: "power2.out", translateY: "20px" },
        { opacity: 1, ease: "power2.out", translateY: "0px", duration: 0.5 }
    );
    let random = Math.floor(Math.random() * liste.length);
    let randomName = liste[random];

    const selectedLi = document.querySelector(`[data-etudiant = "${random}"]`);
    selectedLi.style.textDecoration = "line-through";

    delete selectedLi.dataset.etudiant;

    liste.splice(random, 1);

    const allLi = document.querySelectorAll("[data-etudiant]");

    allLi.forEach((li, index) => {
        li.dataset.etudiant = index;
    });

    let lastname = randomName["nom"];
    let firstname = randomName["prenom"];
    
    const templateParticipant = templateParticipantRaw.content.cloneNode(true);
    templateParticipant.querySelector("[data-firstname]").textContent = firstname;
    templateParticipant.querySelector("[data-lastname]").textContent = lastname;

    templateContainer.replaceChildren(templateParticipant)

    

    if (typeof liste[0] === "undefined") {
        btn.removeEventListener("click", genererNom, false);
        btn.remove();
    }
}

const recommencer = () => {
    location.reload();
};

btn.addEventListener("click", genererNom);
btnReset.addEventListener("click", recommencer);
