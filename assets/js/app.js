let liste = [];
const btn = document.getElementById('btn');
const nom = document.getElementById('nom');
const prenom = document.getElementById('prenom');
const nomPrenom = document.getElementById('nomPrenom');
const listeEtudiant = document.getElementById('listeEtudiant');


btn.addEventListener('click', genererNom);


fetch("assets/liste.json").then((data) => {
    data.json().then((data) => {
        // Bien vu le fait de garder une version propre de la liste des utilisateurs.
        // Toutefois, en javascript, les objets sont copiés par référence et non par valeur
        // Si vous avez bien crée une autre variable les deux pointent vers la même adresse mémoire
        // Ce qui veut dire qu'en modifiant "liste", vous modifiez également "data"
        // Ici, il est préférable d'utiliser liste = [...data]
        // Plus d'infos ici : https://www.samanthaming.com/tidbits/35-es6-way-to-clone-an-array/
        liste = data; 
        console.log(liste);

        liste.forEach((elem, index) => {
            let li = document.createElement('li');
            // Il est préférable d'utiliser un data-attribut ici.
            li.id = `etudiant${index + 1}`;
            // Pourquoi ne pas avoir utilisé également le template string ici ? Vous l'avez fait sur la ligne précédente
            li.textContent = elem.nom + " " + elem.prenom;
            listeEtudiant.append(li);
        })
    });
});

function genererNom(){
    gsap.fromTo(nomPrenom, {opacity : 0, ease: "power2.out", translateY : "20px"}, {opacity : 1, ease: "power2.out", translateY : "0px", duration: 0.5});
    // Pourquoi "- 0" ?
    let random = Math.floor(Math.random() * (liste.length - 0));
    let randomName = liste[random];
    
    liste.splice(random, 1);
    
    console.log(random);
    console.log(randomName);
    
    let nameValue = randomName["nom"];
    let prenomValue = randomName["prenom"];
    
    nom.innerText = nameValue;
    prenom.innerText = prenomValue;
    // Toujours prendre le réflexe du triple égal en javascript.
    // Le double ne fait que comparer les valeurs. Le triple compare les valeurs ET les types
    // 1 == "1" : true
    // 1 === "1" : false
    if(typeof(liste[0]) == 'undefined'){
        btn.removeEventListener("click", genererNom, false);
        // Il existe l'attribut "disabled", il est plus approprié
        btn.className="hidden";
    }
}