//Je selectionne mon formulaire par son ID
const form = document.querySelector('#contact-form');

//fonction de validation d'adresse email
function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email); // Renvoie true si le format est correct
}

function sanitizeInput(string) {
    return string.replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

form.addEventListener('submit', function (e) {
    e.preventDefault(); // On empêche l'envoi classique (avec rechargement de page)

    // On récupère les champs du formulaire
    const emailInput = form.querySelector('#contacts_form_email');
    const subjectInput = form.querySelector('#contacts_form_subject');
    const agreeInput = form.querySelector('#contacts_form_agreeterms');

    // On nettoie et récupère les valeurs
    const email = sanitizeInput(emailInput.value.trim()); // Email nettoyé
    const subject = sanitizeInput(subjectInput.value.trim()); // Sujet nettoyé
    const agreeterms = agreeInput.checked; // Boolean : true si coché

    // Validation manuelle
    if (!email || !subject || !agreeterms) {
        alert('Tous les champs sont obligatoires et vous devez accepter la collecte de données.');
        return; // Stoppe l'envoi si un champ est vide
    }

    if (!isValidEmail(email)) {
        alert('Veuillez entrer une adresse email valide.');
        return; // Stoppe si l'email est mal formé
    }

    // Préparer les données du formulaire (clé => valeur)
    const formData = new FormData();
    formData.append('contacts_form[email]', email); // champ email
    formData.append('contacts_form[subject]', subject); // champ sujet
    formData.append('contacts_form[agreeterms]', '1'); // valeur cochée (booléen → "1")

    // Envoi en AJAX avec Fetch
    fetch(form.getAttribute('action'), {
        method: 'POST', // On envoie les données avec la méthode POST
        body: formData  // Les données formatées sous forme de formulaire
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur serveur'); // Si le serveur ne répond pas correctement
            }
            return response.text(); // On récupère la réponse (ici, HTML)
        })
        .then(() => {
            // ok : on remplace le formulaire par un message
            document.querySelector('.home-form-container').innerHTML = `
                <p class="success-message">Merci ! Votre message a bien été envoyé.</p>
            `;
        })
        .catch(error => {
            // ko
            console.error(error); // Affiche dans la console
            alert("Erreur : le message n'a pas pu être envoyé.");
        });
});
