<?php

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/Tache_IHM.php");
include_once($chemin . "bdd/Tache_BDD.php");
include_once($chemin . "moteur/Tache.php");

// -----------------------------
// Fonctions de gestion du démon

include_once("./gestionDemon.php");

// ---------------------
// Contrôleur de la page

// Demande d'enregistrement d'une nouvelle tâche
if (isset($_POST['new']) && $_POST['newintitule'] != "") {
    $tabTache = array($_POST['newintitule'], $_POST['newstatut'], $_POST['newpriorite'], $_POST['newdatelimite']);
    Tache::saisirDonneesTache($tabTache);
}

// Demande de suppression d'une tâche
if (isset($_POST['delete'])) {
    foreach ($_POST['delete'] as $key => $value) {
	if ($value == 'Supprimer') {
	    Tache::deleteTache($key);
	    break;
	}
    }
}

// Demande de modification des tâches
if (isset($_POST['submit'])) {
    foreach ($_POST['intitule'] as $key => $value) {
	$oTache = Tache::getTache($key);
	$oTache->setIntitule($value);
	$oTache->setPriorite($_POST['priorite'][$key]);
	$oTache->setStatut($_POST['statut'][$key]);
	$oTache->setDateLimite($_POST['datelimite'][$key]);
	Tache::saveTache($oTache);
    }
}

// Demande de réinitialisation des tâches
if (isset($_POST['reset'])) {
    foreach (Tache::listerTaches() as $oTache) {
	// Remise à l'état normal
	$oTache->setStatut('Pas fait');

	// Ajout d'une année à la date limite
	$oTache->setDateLimite(date('Y-m-d', strtotime("+1 year", strtotime($oTache->getDateLimite()))));

	// Enregistrement des modifications
	$oTache->saveTache($oTache);
    }
}

// Demande d'arrêt du démon
if (isset($_POST['stop'])) {
    (new GestionDemon())->stop();
}

// Demande de lancement du démon
if (isset($_POST['go'])) {
    (new GestionDemon())->go();
}

// --------------------
// Affichage de la page

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion des stages');

IHM_Generale::header("Gestion des", "tâches", "../../", $tabLiens);

Tache_IHM::afficherFormulaireSaisie((new GestionDemon())->test());

/*
  echo '<br/>';
  echo 'ls -l /usr/bin/crontab : ';
  $sortie = array();
  $return = 0;
  exec('ls -l /usr/bin/crontab', $sortie, $return);
  var_dump($sortie);
  echo 'return : ' . $return;

  echo '<br/>';
  echo '/usr/bin/crontab -l : ';
  $sortie = array();
  $return = 0;
  exec('/usr/bin/crontab -l', $sortie, $return);
  var_dump($sortie);
  echo 'return : ' . $return;
 */

deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>