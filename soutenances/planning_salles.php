<?php

/**
 * Page planning_salles.php
 * Utilisation : page de visualisation du planning par salle
 * Dépendance(s) : planning_sallesData.php --> traitement des requêtes Ajax
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Soutenances');

IHM_Generale::header("Planning soutenance ", "par salles", "../",$tabLiens);

IHM_Menu::menuSoutenance();

// Recuperation de l'annee promotion (la rentrée)
if (date('n')>=10)
    $annee = date('Y');
else
    $annee = date('Y')-1;

Soutenance_IHM::afficherSelectionSoutenancesSalle($annee, "planning_sallesData.php");

// Affichage des données
echo "<br/>";
echo "<div id='data'>\n";
include_once("planning_sallesData.php");
echo "\n</div>";

deconnexion();
IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>