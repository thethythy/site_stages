<?php

/**
 * Page listeDesEtudiantsData.php
 * Utilisation : page pour obtenir la liste des étudiants d'une ou toutes les promotions
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

$filtres = array();

// Si pas d'année sélectionnée
if (!isset($_POST['annee'])) {
    $annee = Promotion_BDD::getLastAnnee();
    array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));
} else {
    $annee = $_POST['annee'];
    array_push($filtres, new FiltreNumeric("anneeuniversitaire", $_POST['annee']));
}

if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
    array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));

if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
    array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
    $filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);
$tabPromos = Promotion_BDD::getListePromotions($filtre);

if (sizeof($tabPromos) > 0) {
    // Si il y a au moins un étudiant
    if (sizeof($tabEtudiants) > 0) {
	// Affichage des étudiants correspondants aux critères de recherches
	Etudiant_IHM::afficherListeEtudiants($annee, $tabEtudiants);
    } else {
	echo "<br/><center>Aucun étudiant n'a été trouvé.</center><br/>";
    }
} else {
    echo "<br/><center>Aucune promotion ne correspond aux critères de recherche.</center><br/>";
}
?>