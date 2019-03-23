<?php

/**
 * Page listeDesOffreDeStageData.php
 * Utilisation : obtenir un tableau des offres en attente et un tableau des offres traitées
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

// Prise en compte des paramètres
$filtres = array();

// Si une recherche sur le nom de l'entreprise est demandée
if (isset($_POST['nom']) && $_POST['nom'] != "")
    array_push($filtres, new FiltreString("nom", "%" . $_POST['nom'] . "%"));

// Si une recherche sur le code postal est demandée
if (isset($_POST['cp']) && $_POST['cp'] != "")
    array_push($filtres, new FiltreString("codepostal", $_POST['cp'] . "%"));

// Si une recherche sur la ville est demandée
if (isset($_POST['ville']) && $_POST['ville'] != "")
    array_push($filtres, new FiltreString("ville", $_POST['ville'] . "%"));

// Si une recherche sur le pays est demandée
if (isset($_POST['pays']) && $_POST['pays'] != "")
    array_push($filtres, new FiltreString("pays", $_POST['pays'] . "%"));

// Si une recherche sur la filiere est demandée
if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
    array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

// Si une recherche sur le parcours est demandé
if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
    array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));

// Si une recherche sur la filiere est demandée
if (isset($_POST['competence']) && $_POST['competence'] != '*')
    array_push($filtres, new FiltreNumeric("idcompetence", $_POST['competence']));

// Si une recherche sur la duree est demandée
if (isset($_POST['duree']) && $_POST['duree'] != '*') {
    array_push($filtres, new FiltreInferieur("dureemin", $_POST['duree']));
    array_push($filtres, new FiltreSuperieur("dureemax", $_POST['duree']));
}

if (sizeof($filtres) > 0) {
    $filtre = $filtres[0];
    for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");
} else {
    $filtre = "";
}

Utils::printLog("A");
$tabOffreDAlternance = OffreDAlternance::getListeOffreDAlternance($filtre);
Utils::printLog("B");
// Si il y a au moins une offre de stage à traiter
if (sizeof($tabOffreDAlternance) > 0) {
    // Affichage des entreprises correspondants aux critères de recherches
    OffreDAlternance_IHM::afficherListeOffresAEditer($tabOffreDAlternance);
    } else {
	echo "<br/><center>Aucune offre d'alternance ne correspond aux critères de recherche.<center/><br/>";
    }
?>
