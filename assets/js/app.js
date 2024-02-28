let liste = [];
const btn = document.getElementById('btnTirageAuSort');
const btnRe = document.getElementById('btn-re');
const nom = document.getElementById('nom');
const prenom = document.getElementById('prenom');
const nomPrenom = document.getElementById('nomPrenom');
const listeEtudiant = document.getElementById('liste');

btn.addEventListener('click', genererNom);

btnRe.addEventListener('click', recommencer);



// fetch(mainFile).then((data) => {
//     return data.json()
// }).then((data) => {
//     liste = [...data];

//     liste.forEach((elem, index) => {
//         let li = document.createElement('li');
//         li.setAttribute("data-etudiant", `${index}`);
//         li.textContent = `${elem.nom} ${elem.prenom}`;
//         listeEtudiant.append(li);
//     })
// }).catch((e) => {
//     console.log("e", e)
// })

const chargementFichier = (url) => {
    fetch(url).then((data) => {
        return data.json()
    }).then((data) => {
        liste = data.sort(({nom: a}, {nom: b}) => b < a);
    
        liste.forEach((elem, index) => {
            let li = document.createElement('li');
            li.setAttribute("data-etudiant", `${index}`);
            li.textContent = `${elem.nom} ${elem.prenom}`;
            listeEtudiant.append(li);
        })
    }).catch((e) => {
        const fallbackFile = "assets/liste.json";
        chargementFichier(fallbackFile)
    })
}

const mainFile = "assets/liste.dist.json"
chargementFichier(mainFile)

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