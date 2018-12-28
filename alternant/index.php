<?php

/**
 * Page index.php
 * Utilisation : page principale d'accès aux fonctionnalités des étudiants
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$type_etudiant = $_SERVER['REQUEST_URI'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');

IHM_Generale::header("Alternant ", "", "../", $tabLiens);

IHM_Menu::menuAlternant();

?>
<p>Accueil alternance</p>
<?php

IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>
