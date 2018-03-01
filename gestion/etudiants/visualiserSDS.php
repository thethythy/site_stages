<?php

/**
 * Page visualiserSDS.php
 * Utilisation : page pour consulter une demande de validation d'un sujet
 *		 page accessible depuis consulterSDS.php
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion');

IHM_Generale::header("Visualisation", "d'un sujet de stage", "../../", $tabLiens);

if (isset($_GET['id'])) {
    $sds = SujetDeStage::getSujetDeStage($_GET['id']);
    SujetDeStage_IHM::afficherSDS($sds, false);
    echo "<p><a href='./consulterSDS.php'>Retour</a></p>";
}

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");
?>