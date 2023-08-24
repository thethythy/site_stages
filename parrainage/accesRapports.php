<?php

/**
 * Page accesRApports.php
 * Utilisation : page d'accès aux rapports de stage de l'année en cours
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('index.php', 'Conventions et référents');

IHM_Generale::header("Accès", "aux rapports de stage", "../", $tabLiens);

// Fonction de comparaison utilisée dans le tri
function cmpFileName($n1, $n2) {
    $ex_n1 = explode("_", $n1);
    $ex_n2 = explode("_", $n2);
    
    return strcmp($ex_n1[2], $ex_n2[2]);
}

// Aller dans le répertoire des rapports
$directory = '../documents/rapports';
chdir($directory);

// Récupérer les noms des fichiers de M2, les trier puis les afficher avec un lien
$liste_Rapports_M2 = glob("*Master2*");
if (sizeof($liste_Rapports_M2) > 0) {
    usort($liste_Rapports_M2, "cmpFileName");
    ?><p><h3>Liste des rapports de M2 accessibles actuellement :</h3></p><?php
    ?><ul><?php
    foreach ($liste_Rapports_M2 as $value) {
	$nom = explode("_", $value)[2];
	$prenom = explode("_", $value)[3];
	echo "<li id='entete2'>$nom $prenom <a href='http://".$_SERVER['HTTP_HOST']."/documents/rapports/".$value."'>accessible ici</a></li>";
    }
    ?></ul><?php
} else {
    ?><p><h3>Aucun rapport de M2 trouvé pour cette année !</h3></p><?php
}

// Récupérer les noms des fichiers de M1, les trier puis les afficher avec un lien
$liste_Rapports_M1 = glob("*Master1*");
if (sizeof($liste_Rapports_M1) > 0) {
    usort($liste_Rapports_M1, "cmpFileName");
    ?><p><h3>Liste des rapports de M1 accessibles actuellement :</h3></p><?php
    ?><ul><?php
    foreach ($liste_Rapports_M1 as $value) {
	$nom = explode("_", $value)[2];
	$prenom = explode("_", $value)[3];
	echo "<li id='entete2'>$nom $prenom <a href='http://".$_SERVER['HTTP_HOST']."/documents/rapports/".$value."'>accessible ici</a></li>";
    }
    ?></ul><?php
} else {
    ?><p><h3>Aucun rapport de M1 trouvé pour cette année !</h3></p><?php
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>

