<?php

/**
 * Page validerSDS.php
 * Utilisation : page pour visualiser les demandes de validation non traitées
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion');

IHM_Generale::header("Validation", "d'un sujet de stage", "../../", $tabLiens);

$tabSDS = SujetDeStage::getSujetDeStageAValider();
if (sizeof($tabSDS) > 0)
    SujetDeStage_IHM::afficherTableauSDSAValider($tabSDS);
else
    echo "Il n'y a aucun sujet à valider en attente.<br/>";

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>