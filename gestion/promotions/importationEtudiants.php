<?php

/**
 * Page importationEtudiants.php
 * Utilisation : page pour importer une série d'étudiants depuis une autre promotion
 *		 page accessible depuis modifierPromotion.php
 * Dépendance(s) : importationEtudiantsData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

// Début de session
session_start();

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

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
	    Etudiant_BDD::sauvegarder($tabEtudiants[$i]);
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