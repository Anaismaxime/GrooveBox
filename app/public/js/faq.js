// Sélectionne tous les titres cliquables des questions de la FAQ
const headers = document.querySelectorAll(".accordion-header");

// Pour chaque titre, on ajoute un comportement d'ouverture/fermeture
headers.forEach(header => {
    header.addEventListener("click", () => {
        const content = header.nextElementSibling;

        // Fermer les autres si on veut un vrai accordéon
        document.querySelectorAll(".accordion-content").forEach(other => {
            if (other !== content) {
                other.style.maxHeight = null;
            }
        });

        // Ouvre ou ferme le bloc cliqué selon son état actuel
        if (content.style.maxHeight) {
            content.style.maxHeight = null;
        } else {
            content.style.maxHeight = content.scrollHeight + "px";
        }
    });
});

