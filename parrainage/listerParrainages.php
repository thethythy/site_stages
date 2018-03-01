<?php

/**
 * Page listerParrainages.php
 * Utilisation : page de visualisation des suivis de stages des référents
 * Dépendance(s) : listerParrainagesData.php --> traitement des requêtes Ajax
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('index.php', 'Conventions et référents');

IHM_Generale::header("Charge des", "référents", "../", $tabLiens);

// Affichage du formulaire de recherche
Parrain_IHM::afficherFormulaireRecherche("listerParrainagesData.php");

// Affichage des données
echo "<div id='data'>\n";
include_once("listerParrainagesData.php");
echo "\n</div>";

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>