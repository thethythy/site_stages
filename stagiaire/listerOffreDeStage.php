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
$tabLiens[1] = array('./', 'Stagiaire');

IHM_Generale::header("Liste des", "offres de stage", "../", $tabLiens);

// Affichage du formulaire de recherche
OffreDeStage_IHM::afficherFormulaireRecherche("listerOffreDeStageData.php");

// Affichage des données
echo "<div id='data'>\n";
include_once("listerOffreDeStageData.php");
echo "\n</div>";

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>