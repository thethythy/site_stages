<?php

/**
 * Page saisirCotrat.php
 * Utilisation : page pour saisir une nouvelle convention de stage
 * Dépendance(s) : saisirContratData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Saisir un", "contrat d'alternance", "../../", $tabLiens);

Promotion_IHM::afficherFormulaireRecherche("saisirContratData.php", false, true);

// Affichage des données
echo "<div id='data'>\n";
include_once("saisirContratData.php");
echo "\n</div>";

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>
