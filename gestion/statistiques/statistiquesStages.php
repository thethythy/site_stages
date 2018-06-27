<?php

/**
 * Page statistiquesStages.php
 * Utilisation : page de visualisation des statistiques des stages
 *		 (lieu, type d'entreprise, thème de stage)
 * Dépendance(s) : statistiques.js --> création des requêtes Ajax et affichage des réponses
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Statistiques des", "stages", "../../", $tabLiens, "statistiques");

// Affichage du formulaire de recherche
Promotion_IHM::afficherFormulaireSelectionInterval();

// Chargement des traitements (affichage et contrôle)
echo "<div id='data'></div>\n";
echo "<script type='text/javascript' src='statistiquesStages.js'></script>\n";

deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>
