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

// Si une année est sélectionnée
if (isset($_POST['annee']) && $_POST['annee'] != '*') {
    $annee = $_POST['annee'];
    array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));
} else {
    $annee = '';
}

if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
    array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));

if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
    array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
    $filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Etudiant::getEtudiants($filtre);

if (sizeof($tabEtudiants) > 0) {
    // Affichage des étudiants correspondants aux critères de recherches
    Etudiant_IHM::afficherListeEtudiants($annee, $tabEtudiants);
} else {
    echo "<br/><center>Aucun étudiant n'a été trouvé.</center><br/>";
}

?>