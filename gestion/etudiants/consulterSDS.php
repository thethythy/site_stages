<?php

/**
 * Page consulterSDS.php
 * Utilisation : page pour visualiser les demandes de validation déjà traitées
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion');

IHM_Generale::header("Consulter", "les sujets de stage", "../../", $tabLiens);

$tabSDS = SujetDeStage::getSujetDeStageValide();
if (sizeof($tabSDS) > 0)
    SujetDeStage_IHM::afficherTableauSDSValide($tabSDS);
else
    echo "<p>Il n'y aucun sujet de stage validé.</p>";

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>