<?php

/**
* Page SuiviCandidatures.php
* Utilisation : page d'accès aux offres de stages de l'année en cours
* Dépendance(s) : SuiviCandidaturesData.php --> traitement des requêtes Ajax
* Accès : restreint par cookie
*/

include_once("../../classes/bdd/connec.inc");
include_once('../../classes/moteur/Utils.php');

spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion');

IHM_Generale::header("Suivi des", "candidatures", "../../", $tabLiens);

echo "<script type='text/javascript' src='suiviCandidatures.js'></script>\n";

echo "<div id='erreurAjax'></div>";
Promotion_IHM::afficherFormulaireRecherche("suiviCandidaturesData.php", false, false);

echo "<div id='data'>";
include_once("suiviCandidaturesData.php");
echo "</div><div id=\"Fin Data\"></div>";



deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");
?>
