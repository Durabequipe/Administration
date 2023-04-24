// Récupérer l'élément sur lequel appliquer le zoom
const element = document.getElementById('builder-area');

// Ajouter un gestionnaire d'événement pour l'événement de la molette de la souris
element.addEventListener('wheel', (event) => {
    // Empêcher le comportement par défaut de la molette de la souris (faire défiler la page)
    event.preventDefault();

    // Déterminer la direction du mouvement de la molette de la souris (vers l'avant ou vers l'arrière)
    const direction = Math.sign(event.deltaY);

    // Ajuster la taille de l'élément en fonction de la direction du mouvement de la molette de la souris
    const scale = direction > 0 ? 0.9 : 1.1;

    //Obtenir la valeur actuelle de l'échelle
    const currentScale = element.style.scale === '' ? 1 : parseFloat(element.style.scale);

    console.log(currentScale);

    // Définir la nouvelle valeur de l'échelle
    const newScale = currentScale * scale;

    console.log(newScale);

    element.style.scale = newScale.toString();
});
