<?php

/**
 * Page ficheDeContrat.php
 * Utilisation : page de visualisation d'un ancien contrat
 * Accès : restreint par cookie ; lien accessible uniquement depuis listerAnciensContrats.php
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('index.php', 'Alternant');
$tabLiens[2] = array('listerAnciensContrats.php', 'Liste des anciens contrats');

IHM_Generale::header("Fiche de", "contrat", "../", $tabLiens);

Contrat_IHM::afficherFicheContrat($_GET['idEtu'], $_GET['idPromo'], "../documents/resumes/");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>
