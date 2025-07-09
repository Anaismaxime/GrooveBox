//Selection menu déroulant
const filter = document.getElementById("genreFilter");
//Récupère les cartes des artistes affichés
const cards = document.querySelectorAll(".artist-card");

    filter.addEventListener("change", () => { //Ecoute l'évènement "change" (nv genre choisi)
        const selected = filter.value; //On Récupère le genre selectionner
        cards.forEach(card => { //On parcours toutes les cartes
            const genre = card.dataset.id; //On récupère la valeur de l'attribut data-id sur la carte
            if (selected === "all" || genre === selected) { //Si l'option est "tout" ou que le genre est identique :
                card.style.display = ""; //On l'affiche
            } else {
                card.style.display = "none"; //On le cache
            }

        });
    });

