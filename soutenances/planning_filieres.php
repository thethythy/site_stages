<?php

/**
 * Page planning_filieres.php
 * Utilisation : page de visualisation du planning par filière
 * Dépendance(s) : planning_filieresData.php --> traitement des requêtes Ajax
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Soutenances');

IHM_Generale::header("Planning soutenance ", "par diplôme", "../",$tabLiens);

IHM_Menu::menuSoutenance();

Soutenance_IHM::afficherSelectionSoutenancesPromotion("planning_filieresData.php");

// Affichage des données
echo "<br/>";
echo "<div id='data'>\n";
include_once("planning_filieresData.php");
echo "\n</div>";

deconnexion();
IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>