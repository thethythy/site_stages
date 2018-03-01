<?php

/**
 * Page listerAnciensStagesData.php
 * Utilisation : page de traitement Ajax retournant un tableau des anciens stages
 *		 selon les critères de sélection
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

if (!headers_sent())
    header("Content-type:text/html; charset=utf-8");

$filtres = array();

// ----------------------------------------------------------------------------
// Première partie du filtrage : obtenir une liste d'étudiants d'une promotion

// Si une recherche sur l'année est demandée
if (isset($_POST['annee'])) {
    $annee = $_POST['annee'];
    array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));
}

// Si une recherche sur le parcours est demandée
if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
    array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));

// Si une recherche sur la filiere est demandée
if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
    array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

$tabOEtuWithConv = array();

if (sizeof($filtres) > 0) {
    $filtre = $filtres[0];
    for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

    $tabPromos = Promotion_BDD::getListePromotions($filtre);

    if (sizeof($tabPromos) > 0) {
	$tabOEtudiants = Promotion::listerEtudiants($filtre);

	// Récupération des étudiants ayant une convention
	//$tabOEtuWithConv = array();
	for ($i = 0; $i < sizeof($tabOEtudiants); $i++) {
	    if ($tabOEtudiants[$i]->getConvention($annee) != null)
		array_push($tabOEtuWithConv, $tabOEtudiants[$i]);
	}
    }
}

// ----------------------------------------------------------------------------
// Deuxième partie du filtrage : prendre en compte les 3 autres critères

if (isset($_POST['annee'])) {

    // Si une recherche sur le thème du stage est demandée
    if (isset($_POST['technologie']) && $_POST['technologie'] != '*') {
	$tabOEtudiants = array();
	foreach ($tabOEtuWithConv as $oEtudiant) {
	    $oConvention = $oEtudiant->getConvention($annee);
	    if ($oConvention != null) {
		if ($oConvention->getIdTheme() == $_POST['technologie'])
		    array_push($tabOEtudiants, $oEtudiant);
	    }
	}
	$tabOEtuWithConv = $tabOEtudiants;
    }

    // Si une recherche sur le type d'entreprise est demandée
    if (isset($_POST['typeEntreprise']) && $_POST['typeEntreprise'] != '*') {
	$tabOEtudiants = array();
	foreach ($tabOEtuWithConv as $oEtudiant) {
	    $oConvention = $oEtudiant->getConvention($annee);
	    if ($oConvention != null) {
		$oEntreprise = $oConvention->getEntreprise();
		if ($oEntreprise->getType()->getIdentifiantBDD() == $_POST['typeEntreprise'])
		    array_push($tabOEtudiants, $oEtudiant);
	    }
	}
	$tabOEtuWithConv = $tabOEtudiants;
    }

    // Si une recherche sur le lieu du stage est demandée
    if (isset($_POST['lieustage']) && $_POST['lieustage'] != '*') {
	$tabOEtudiants = array();
	foreach ($tabOEtuWithConv as $oEtudiant) {
	    $oConvention = $oEtudiant->getConvention($annee);
	    if ($oConvention != null) {
		$oEntreprise = $oConvention->getEntreprise();
		$codepostal = $oEntreprise->getCodePostal();
		$ville = strtolower($oEntreprise->getVille());
		$pays = strtolower($oEntreprise->getPays());
		$lieu = Utils::getLieuDuStage($codepostal, $ville, $pays);
		if ($_POST['lieustage'] == array_search($lieu, Utils::getLieuxStage()))
		    array_push($tabOEtudiants, $oEtudiant);
	    }
	}
	$tabOEtuWithConv = $tabOEtudiants;
    }

}

if (isset($_POST['annee']) && sizeof($tabPromos) > 0) {
    // Si il y a au moins un étudiant avec une convention
    if (sizeof($tabOEtuWithConv) > 0) {
	// Affichage des stages des étudiants
	Stage_IHM::afficherListeAncienStages($tabOEtuWithConv, $annee);
    } else {
	echo "Aucun stage n'a été trouvé pour ces critères de recherche.";
    }
} else {
    echo "Aucune promotion ne correspond à ces critères de recherche.";
}

?>