<?php

/**
 * Page SuiviCandidatures.php
 * Utilisation : page d'accès aux offres de stages de l'année en cours
 * Dépendance(s) : SuiviCandidaturesData.php --> traitement des requêtes Ajax
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Alternant');

IHM_Generale::header("Suvi des", "candidatures", "../", $tabLiens);



Promotion_IHM::afficherFormulaireRecherche("suiviCandidaturesData.php", false);

echo "<div id='data'>\n";
include_once("suiviCandidaturesData.php");
echo "\n</div>";



deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");
?>
