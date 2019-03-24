<?php

/**
 * Page demanderValidationSDSData.php
 * Utilisation : page de traitement Ajax retournant un formulaire de demande
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

if (!headers_sent())
    header("Content-type:text/html; charset=utf-8");

$filtres = array();

// Si une recherche sur l'année est demandée
if (isset($_POST['annee']) && $_POST['annee'] != "")
    array_push($filtres, new FiltreNumeric("anneeuniversitaire", $_POST['annee']));

// Si une recherche sur le parcours est demandé
if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
    array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));

// Si une recherche sur la filiere est demandée
if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
    array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

if (sizeof($filtres) > 0) {
    $filtre = $filtres[0];

    for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

    $tabEtudiants = Promotion::listerEtudiants($filtre);
} else {
    $tabEtudiants = array();
}

if (sizeof($tabEtudiants) > 0) {
    SujetDeStage_IHM::afficherDemandeValidation($tabEtudiants);
} else {
    ?>
    <br/>
    <p>Aucun étudiant ne correspond aux critères de recherche.</p>
    <br/>
    <?php
}

?>