document.addEventListener("DOMContentLoaded", () => {
    const filter = document.getElementById("genreFilter");
    const cards = document.querySelectorAll(".artist-card");

    if (!filter) return; // sécurité si le sélecteur n'est pas présent

    filter.addEventListener("change", () => {
        const selected = filter.value;
        console.log("Genre sélectionné :", selected);
        cards.forEach(card => {
            const genre = card.dataset.id;
            console.log("Carte genre :", genre);
            if (selected === "all" || genre === selected) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }

        });
    });
});
