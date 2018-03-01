<?php

/**
 * Page supprimerEtudiant.php
 * Utilisation : page pour supprimer des étudiants
 * Dépendance(s) : supprimerEtudiantData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Supprimer un", "étudiant", "../../", $tabLiens);

if ((isset($_GET['id'])) && (isset($_GET['promo']))) {
    // Necessaire pour que dans le formulaire de recherche, on resélectionne les valeurs précédement sélectionnées
    $promo = Promotion::getPromotion($_GET['promo']);
    $filiere = $promo->getFiliere();
    $parcours = $promo->getParcours();
    $_POST['annee'] = $promo->getAnneeUniversitaire();
    $_POST['parcours'] = $parcours->getIdentifiantBDD();
    $_POST['filiere'] = $filiere->getIdentifiantBDD();

    // Suppression définitive de l'étudiant
    Etudiant::supprimerDefinitivementEtudiant($_GET['id']);
}

// Affichage du formulaire de recherche
Promotion_IHM::afficherFormulaireRecherche("supprimerEtudiantData.php", false);

// Affichage des données
echo "<div id='data'>\n";
include_once("supprimerEtudiantData.php");
echo "\n</div>";

?>

<?php

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>