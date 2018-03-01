<?php

/**
 * Page importationEtudiantsData.php
 * Utilisation : page retournant un tableau des étudiants à importer
 *		 chaque étudiant est sélectionnable
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

// Si une recherche a été effectuée
if (isset($_POST['annee']) && isset($_POST['parcours']) && isset($_POST['filiere'])) {

    // Création du filtre de recherche
    $filtres = array();

    array_push($filtres, new FiltreString("anneeuniversitaire", $_POST['annee']));
    array_push($filtres, new FiltreString("idparcours", $_POST['parcours']));
    array_push($filtres, new FiltreString("idfiliere", $_POST['filiere']));

    $nbFiltres = sizeof($filtres);
    $filtre = $filtres[0];

    for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

    // Récupérer la promo, la filiere et le parcours
    $tabPromos = Promotion_BDD::getListePromotions($filtre);

    // Si au moins une promotion existe
    if (sizeof($tabPromos) > 0) {

	$promo = Promotion::getPromotion($tabPromos[0][0]);
	$filiere = $promo->getFiliere();
	$parcours = $promo->getParcours();

	echo "<br/>Veuillez sélectionner les étudiants à importer depuis la promotion : ";
	echo $filiere->getNom() . " " . $parcours->getNom() . " - " . $promo->getAnneeUniversitaire() . "<br/><br/>";

	// Récupérer les étudiants de la promotion sélectionnée
	$tabEtudiants = Promotion::listerEtudiants($filtre);

	// Si il y a au moins un étudiant
	if (sizeof($tabEtudiants) > 0) {
	    Promotion_IHM::afficherEtudiantsAImporter(
		    $_POST['annee'],
		    $filiere->getIdentifiantBDD(),
		    $parcours->getIdentifiantBDD(), $tabEtudiants);
	} else {
	    echo "Aucun étudiant n'a été trouvé.";
	}
    } else {
	echo "Aucune promotion ne correspond à ces critères de recherche.";
    }
}
?>