<?php

/**
 * Page ficheDeStage.php
 * Utilisation : page de visualisation d'un ancien stage
 * Accès : restreint par cookie ; lien accessible uniquement depuis listerAnciensStages.php
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('index.php', 'Stagiaire');
$tabLiens[2] = array('listerAnciensStages.php', 'Liste des anciens stages');

IHM_Generale::header("Fiche de", "stage", "../", $tabLiens);

Stage_IHM::afficherFicheStage($_GET['idEtu'], $_GET['idPromo'], "../documents/resumes/");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>