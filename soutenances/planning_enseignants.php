<?php

/**
 * Page planning_enseignants.php
 * Utilisation : page de visualisation du planning par enseignant-référent
 * Dépendance(s) : planning_enseignantsData.php --> traitement des requêtes Ajax
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Soutenances');

IHM_Generale::header("Planning soutenance ", "par enseignants", "../",$tabLiens);

IHM_Menu::menuSoutenance();

Soutenance_IHM::afficherSelectionSoutenancesEnseignant('planning_enseignantsData.php');

// Affichage des données
echo "<div id='data'>\n";
include_once("planning_enseignantsData.php");
echo "\n</div>";

deconnexion();
IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>