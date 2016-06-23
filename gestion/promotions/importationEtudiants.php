<?php

// Début de session
session_start();

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "moteur/Utils.php");

include_once($chemin . "moteur/Filtre.php");
include_once($chemin . "moteur/FiltreNumeric.php");
include_once($chemin . "moteur/FiltreString.php");

include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/Promotion_IHM.php");
include_once($chemin . "bdd/Promotion_BDD.php");
include_once($chemin . "moteur/Promotion.php");

include_once($chemin . "bdd/Etudiant_BDD.php");
include_once($chemin . "moteur/Etudiant.php");

include_once($chemin . "bdd/Filiere_BDD.php");
include_once($chemin . "moteur/Filiere.php");

include_once($chemin . "bdd/Parcours_BDD.php");
include_once($chemin . "moteur/Parcours.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Importer des", "étudiants", "../../", $tabLiens);

// Info venant de la page modifierPromotion
if (isset($_POST['promo'])) {
    $_SESSION['promo'] = $_POST['promo'];
    $promo_modifiee = Promotion::getPromotion($_POST['promo']);
    $filiere_modifiee = $promo_modifiee->getFiliere();
    $parcours_modifie = $promo_modifiee->getParcours();
}

// Info venant de la session
if (isset($_SESSION['promo'])) {
    $promo_modifiee = Promotion::getPromotion($_SESSION['promo']);
    $filiere_modifiee = $promo_modifiee->getFiliere();
    $parcours_modifie = $promo_modifiee->getParcours();
}

// Si un import a été effectué
if (isset($_POST['import'])) {

    // Création du filtre de recherche
    $filtres = array();

    array_push($filtres, new FiltreString("anneeuniversitaire", $_POST['annee']));
    array_push($filtres, new FiltreString("idparcours", $_POST['parcours']));
    array_push($filtres, new FiltreString("idfiliere", $_POST['filiere']));

    $nbFiltres = sizeof($filtres);
    $filtre = $filtres[0];

    for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

    // Récupérer les étudiants de la promotion sélectionnée
    $tabEtudiants = Promotion::listerEtudiants($filtre);

    for ($i = 0; $i < sizeof($tabEtudiants); $i++) {
	if (isset($_POST['etu' . $tabEtudiants[$i]->getIdentifiantBDD()])) {
	    // Mise à jour de l'étudiant
	    Etudiant_BDD::sauvegarder($tabEtudiants[$i], false);
	    // Insertion de l'étudiant dans la promotion
	    Etudiant_BDD::ajouterPromotion($tabEtudiants[$i]->getIdentifiantBDD(), $promo_modifiee->getIdentifiantBDD());
	}
    }

    Promotion_IHM::afficherEtudiantsImportes($promo_modifiee, $filiere_modifiee, $parcours_modifie, $tabEtudiants);

    // Fin de session
    session_unset();
    session_destroy();
} else {

    echo "Veuillez sélectionner la promotion des étudiants à importer dans la nouvelle promotion : ";
    echo $filiere_modifiee->getNom() . " " . $parcours_modifie->getNom() . " - " . $promo_modifiee->getAnneeUniversitaire() . "<br/>";

    Promotion_IHM::afficherFormulaireRecherche("importationEtudiantsData.php", false);

    // Affichage des données
    echo "<div id='data'>\n";
    include_once("importationEtudiantsData.php");
    echo "\n</div>";
}

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>