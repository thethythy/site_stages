<?php

/**
 * Page ficheDeStage.php
 * Utilisation : page de visualisation d'une fiche de stage
 * Accès : restreint par authentification HTTP ; accessible depuis classementEntreprise.php
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
$tabLiens[2] = array('classementEntreprise.php', 'Top entreprises');

IHM_Generale::header("Fiche de", "stage", "../../", $tabLiens);

Stage_IHM::afficherFicheStage($_GET['idEtu'], $_GET['idPromo'], "../../documents/resumes/");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>