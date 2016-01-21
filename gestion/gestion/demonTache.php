#!/usr/bin/php

<?php

$chemin = "/Users/lemeunie/git-repository/site_stages/classes/";
include_once($chemin . "bdd/Tache_BDD.php");
include_once($chemin . "moteur/Tache.php");

// Connexion et s�lection de la base
$db = new mysqli('localhost','root','', 'stages');
if ($db->connect_errno) {
    echo "Echec lors de connexion (" . $db->connect_errno . ") " . $db->connect_error;
}

// Table des t�ches en base
$tab21 = 'taches';

// Cr�ation du tableau des infos des t�ches
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

// Notification par email des t�ches � effectuer
function notifier($iTache) {
    $headers = "From: thierry.lemeunier@univ-lemans.fr\n";
    $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
    $headers .= "Content-Transfer-Encoding: 8bit";
    $msg = "Date limite atteinte pour la t�che : " . $iTache;
    mail("thierry.lemeunier@univ-lemans.fr", 'Site des stages : t�che � effectuer', $msg, $headers);
}

// Chargement du tableau des t�ches
$tabSTache = array();
createTableSTache($tabSTache);

// Notifier l'utilisateur si n�cessaire
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