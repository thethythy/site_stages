// Flag indicateur du premier chargement
var firstLoad = true;

// Astuce pour charger le bon gestionnaire d'événement
function loadEtudiant() {
    // Mise à jour de la table une seule fois
    if (firstLoad) {
	table = table.concat("idEtudiant"); // On réutilise le tableau déjà existant
	firstLoad = false;
    }

    // Ré-installer un gestionnaire
    new LoadData(table, "suiviCandidaturesData.php", "onchange");

    // Lancer le bon gestionnaire
    document.getElementById("idEtudiant").onchange();
}
