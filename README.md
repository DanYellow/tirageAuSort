<p align="center">
  <a href="https://example.com/">
    <img src="https://via.placeholder.com/72" alt="Logo" width=72 height=72>
  </a>

  <h3 align="center">Logo</h3>

  <p align="center">
    Un simple tirage au sort avec tirage 100% aléatoire
  </p>
</p>


## Table des matières

- [Table des matières](#table-des-matières)
- [Installation](#installation)
  - [Notes](#notes)
- [Publier le projet](#publier-le-projet)

## Installation

- `git clone url-du-projet`
- `cd dossier-du-projet`
- `npm install`
- `npm start`
- `Accéder à "http://localhost:5173"`

### Notes
- Par défaut, le tirage au sort se fait sur une liste avec de fausses données. Pour utiliser les vôtres, il faudra ajouter un fichier "liste.dist.json" dans le dosser "public/data". Chaque objet devra avoir une clé "nom" et "prenom" (sans accents)

## Publier le projet
- `npm run build` (projet construit dans le dossier "/dist" à la racine)


Enjoy :metal: