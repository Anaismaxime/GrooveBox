const container = document.querySelector('.carousel-container'); //Selectionne conteneur principal
const carousel = container.querySelector('.carousel'); // Selectionne le slide dans le conteneur
const slides = carousel.querySelectorAll('.slide'); //Recupère les elements à faire defiler

let index = 0; // 🧠 Initialise l'index de la slide affichée (on commence par la première)

//Fonction qui fait défiler le carrousel jusqu'à une slide précis
function scrollToSlide(i) {
    const slideWidth = slides[i].offsetWidth; //Calcule la largeur d'une slide


    container.scrollTo({   //Fait défiler horizontalement le container jusqu'à la bonne position
        left: slideWidth * i,  // Décalage horizontal calculé
        behavior: 'smooth'     // Effet de transition fluide
    });
}

// Défilement autom : toutes les 3 secondes, on passe à la slide suivante
setInterval(() => {
    index = (index + 1) % slides.length; // Incrémente l'index et revient à 0 après la dernière slide
    scrollToSlide(index);                // Fait défiler vers la nouvelle slide
}, 3000);
