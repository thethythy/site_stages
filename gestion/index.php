<?php

/**
 * Page index.php
 * Utilisation : page principale des outils pour les référents
 * Accès : restreint par authentification HTTP
 */

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');

IHM_Generale::header("Gestion des ", "stages et alternances", "../", $tabLiens);

Gestion_IHM::afficherMenuGestion();

deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");
?>
