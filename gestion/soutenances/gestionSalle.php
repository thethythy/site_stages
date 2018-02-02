<?php

/**
 * Page gestionSalle.php
 * Utilisation : page pour gérer les salles (création, édition, suppression)
 * Accès : restreint par authentification HTTP
 */

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/Salle_IHM.php");
include_once($chemin . "bdd/Salle_BDD.php");
include_once($chemin . "moteur/Salle.php");

// ----------------------------------------------------------------------------
// Contrôleur

function supprimer() {
    if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'sup') {
	Salle::deleteSalle($_GET['id']);
    }
}

supprimer();

function modifier() {
    if (isset($_POST['id']) &&
	isset($_POST['nom']) && $_POST['nom'] != "") {
	$salle = Salle::getSalle($_POST['id']);
	$salle->setNom($_POST['nom']);
	Salle_BDD::sauvegarder($salle);
	$_GET['action'] = $_GET['id'] = '';
    }
}

modifier();

function save() {
    if (!isset($_POST['id']) &&
	isset($_POST['nom']) && $_POST['nom'] != "") {
	$tabDonnees = array();
	array_push($tabDonnees, $_POST['nom']);
	Salle::saisirDonneesSalle($tabDonnees);
	$_GET['action'] = $_GET['id'] = '';
    }
}

save();

// ----------------------------------------------------------------------------
// Affichage

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Gestion des", "salles", "../../", $tabLiens);

if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'mod') {
    Salle_IHM::afficherFormulaireModification($_GET['id']);
} else {
    Salle_IHM::afficherFormulaireSaisie();
}

Salle_IHM::afficherListeSalleAEditer();

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>
