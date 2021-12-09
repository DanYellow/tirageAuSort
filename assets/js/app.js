let liste = [];
const btn = document.getElementById('btnTirageAuSort');
const btnRe = document.getElementById('btn-re');
const nom = document.getElementById('nom');
const prenom = document.getElementById('prenom');
const nomPrenom = document.getElementById('nomPrenom');
const listeEtudiant = document.getElementById('liste');

btn.addEventListener('click', genererNom);

btnRe.addEventListener('click', recommencer);

fetch("assets/liste.json").then((data) => {
    return data.json()
}).then((data) => {
    liste = [...data];

    liste.forEach((elem, index) => {
        let li = document.createElement('li');
        li.setAttribute("data-etudiant", `${index}`);
        li.textContent = `${elem.nom} ${elem.prenom}`;
        listeEtudiant.append(li);
    })
});

function genererNom(){
    gsap.fromTo(nomPrenom, {opacity : 0, ease: "power2.out", translateY : "20px"}, {opacity : 1, ease: "power2.out", translateY : "0px", duration: 0.5});
    let random = Math.floor(Math.random() * (liste.length));
    let randomName = liste[random];

    const selectedLi = document.querySelector(`[data-etudiant = "${random}"]`);
    selectedLi.style.textDecoration = 'line-through';

    delete selectedLi.dataset.etudiant;
    
    liste.splice(random, 1);

    const allLi = document.querySelectorAll("[data-etudiant]");

    allLi.forEach((li, index) => {
        li.dataset.etudiant = index;
    })

    let nameValue = randomName["nom"];
    let prenomValue = randomName["prenom"];

    nom.innerText = nameValue;
    prenom.innerText = prenomValue;

    if(typeof(liste[0]) === 'undefined'){
        btn.removeEventListener("click", genererNom, false);
        btn.remove();
    }
}

function recommencer(){
    location.reload();
}