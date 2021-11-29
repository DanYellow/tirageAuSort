let liste = [];
let btn = document.getElementById('btn');
let nom = document.getElementById('nom');
let prenom = document.getElementById('prenom');
let nomPrenom = document.getElementById('nomPrenom');
let listeEtudiant = document.getElementById('listeEtudiant');


btn.addEventListener('click', genererNom);


fetch("assets/liste.json").then((data) => {
    data.json().then((data) => {
        liste = data;
        console.log(liste);

        liste.forEach((elem, index) => {
            let li = document.createElement('li');
            li.id = `etudiant${index + 1}`;
            li.textContent = elem.nom + " " + elem.prenom;
            listeEtudiant.append(li);
        })
    });
});

function genererNom(){
    gsap.fromTo(nomPrenom, {opacity : 0, ease: "power2.out", translateY : "20px"}, {opacity : 1, ease: "power2.out", translateY : "0px", duration: 0.5});
    let random = Math.floor(Math.random() * (liste.length - 0));
    let randomName = liste[random];
    
    liste.splice(random, 1);
    
    console.log(random);
    console.log(randomName);
    
    let nameValue = randomName["nom"];
    let prenomValue = randomName["prenom"];
    
    nom.innerText = nameValue;
    prenom.innerText = prenomValue;
    if(typeof(liste[0]) == 'undefined'){
        btn.removeEventListener("click", genererNom, false);
        btn.className="hidden";
    }
}