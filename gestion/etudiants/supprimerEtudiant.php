<?php

/**
 * Page supprimerEtudiant.php
 * Utilisation : page pour supprimer des étudiants
 * Dépendance(s) : supprimerEtudiantData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");

include_once($chemin . "moteur/Filtre.php");
include_once($chemin . "moteur/FiltreNumeric.php");
include_once($chemin . "moteur/FiltreString.php");

include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/Promotion_IHM.php");
include_once($chemin . "bdd/Promotion_BDD.php");
include_once($chemin . "moteur/Promotion.php");

include_once($chemin . "bdd/Contact_BDD.php");
include_once($chemin . "moteur/Contact.php");

include_once($chemin . "bdd/Convention_BDD.php");
include_once($chemin . "moteur/Convention.php");

include_once($chemin . "bdd/Entreprise_BDD.php");
include_once($chemin . "moteur/Entreprise.php");

include_once($chemin . "bdd/Etudiant_BDD.php");
include_once($chemin . "moteur/Etudiant.php");

include_once($chemin . "bdd/Filiere_BDD.php");
include_once($chemin . "moteur/Filiere.php");

include_once($chemin . "bdd/Parcours_BDD.php");
include_once($chemin . "moteur/Parcours.php");

include_once($chemin . "bdd/Parrain_BDD.php");
include_once($chemin . "moteur/Parrain.php");

include_once($chemin . "bdd/Soutenance_BDD.php");
include_once($chemin . "moteur/Soutenance.php");

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