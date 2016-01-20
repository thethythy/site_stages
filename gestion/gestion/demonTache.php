#!/usr/bin/php

<?php
$chemin = "/Applications/MAMP/htdocs/classes/";
include_once($chemin . "bdd/Tache_BDD.php");
include_once($chemin . "moteur/Tache.php");
// Connexion à la base
$db = mysql_connect('127.0.0.1:8889','','') or die("Impossible de se connecter : " . mysql_error());
// Sélection de la base
//mysql_select_db('stages', $db) or die("Impossible de trouver la base : " . mysql_error());
// Table des tâches en base
$tab21 = 'taches';
// Création du tableau des infos des tâches
function createTableSTache(&$tabSTache) {
    foreach (Tache::listerTaches() as $oTache) {
	if ($oTache->getStatut() == "Pas fait") {
	    $tabTache = array();
	    array_push($tabTache, $oTache->getDateLimite());
	    array_push($tabTache, $oTache->getIntitule());
	    array_push($tabSTache, $tabTache);
	}
    }
}
// Notification par email des tâches à effectuer
function notifier($iTache) {
    $headers = "From: thierry.lemeunier@univ-lemans.fr\n";
    $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
    $headers .= "Content-Transfer-Encoding: 8bit";
    $msg = "Date limite atteinte pour la tâche : " . $iTache;
    mail("thierry.lemeunier@univ-lemans.fr", 'Site des stages : tâche à effectuer', $msg, $headers);
}
// Chargement du tableau des tâches
$tabSTache = array();
createTableSTache($tabSTache);
// Notifier l'utilisateur si nécessaire
date_default_timezone_set("Europe/Paris");
$date = time();
foreach ($tabSTache as $sTache) {
    if ($date >= strtotime($sTache[0])) {
	notifier($sTache[1]);
    }
}
// Signaler le fonctionneemnt normal par modification de la date de modification du fichier "RUN"
if (file_exists("/tmp/RUN_CRON_SITE_STAGE")) {
    touch("/tmp/RUN_CRON_SITE_STAGE");
}
?>