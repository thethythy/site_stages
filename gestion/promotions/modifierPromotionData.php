<?php

/**
 * Page modifierPromotionData.php
 * Utilisation : page retournant un tableau des étudiants d'une promotion
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
	header("Content-type: text/html; charset=utf-8");

// Si une suppression d'un étudiant ou une modification de l'email a été effectuée
if (isset($_POST['email']) || isset($_GET['id'])) {
	$annee = $_POST['annee'];
	$parcours = $_POST['parcours'];
	$filiere = $_POST['filiere'];
} else {
	if (!isset($_POST['annee']))
		$annee = Promotion_BDD::getLastAnnee();
	else
		$annee = $_POST['annee'];

	if (!isset($_POST['parcours'])) {
		$tabParcours = Parcours::listerParcours();
		$parcours = $tabParcours[0]->getIdentifiantBDD();
	} else
		$parcours = $_POST['parcours'];

	if (!isset($_POST['filiere'])) {
		$tabFilieres = Filiere::listerFilieres();
		$filiere = $tabFilieres[0]->getIdentifiantBDD();
	} else
		$filiere = $_POST['filiere'];
}

$filtres = array();
array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));
array_push($filtres, new FiltreNumeric("idparcours", $parcours));
array_push($filtres, new FiltreNumeric("idfiliere", $filiere));

$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);
$tabPromos = Promotion_BDD::getListePromotions($filtre);

Promotion_IHM::afficherListeEtudiantsAEditer($tabPromos, $tabEtudiants);

?>