<?php

/**
 * Page listerOffreDeStage.php
 * Utilisation : page d'accès aux offres de stages de l'année en cours
 * Dépendance(s) : listerOffreDeStageData.php --> traitement des requêtes Ajax
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Alternant');

IHM_Generale::header("Liste des", "offres d'alternance", "../", $tabLiens);

// Affichage du formulaire de recherche
OffreDAlternance_IHM::afficherFormulaireRecherche("listerOffreDAltData.php");

// Affichage des données
echo "<div id='data'>\n";
include_once("listerOffreDAltData.php");
echo "\n</div>";

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>
