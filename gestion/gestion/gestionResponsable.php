<?php

/**
 * Page gestionResponsable.php
 * Utilisation : page de gestion de la liste des responsables
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// ----------------------------------------------------------------------------
// Contrôleur

function supprimer() {
    if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'sup') {
	Responsable::deleteResponsable($_GET['id']);
    }
}

supprimer();

function save() {
    if (!isset($_POST['id']) &&
	isset($_POST['responsabilite']) && $_POST['responsabilite'] != "" &&
	isset($_POST['nomresponsable']) && $_POST['nomresponsable'] != "" &&
	isset($_POST['prenomresponsable']) && $_POST['prenomresponsable'] != "" &&
	isset($_POST['emailresponsable']) && $_POST['emailresponsable'] != "" &&
	isset($_POST['titreresponsable'])) {
	$tabDonnees = array();
	array_push($tabDonnees, $_POST['responsabilite']);
	array_push($tabDonnees, $_POST['nomresponsable']);
	array_push($tabDonnees, $_POST['prenomresponsable']);
	array_push($tabDonnees, $_POST['emailresponsable']);
	array_push($tabDonnees, $_POST['titreresponsable']);
	Responsable::saisirDonneesResponsable($tabDonnees);
	$_GET['action'] = $_GET['id'] = '';
    }
}

save();

function modifier() {
    if (isset($_POST['id']) &&
	isset($_POST['responsabilite']) && $_POST['responsabilite'] != "" &&
	isset($_POST['nomresponsable']) && $_POST['nomresponsable'] != "" &&
	isset($_POST['prenomresponsable']) && $_POST['prenomresponsable'] != "" &&
	isset($_POST['emailresponsable']) && $_POST['emailresponsable'] != "" &&
	isset($_POST['titreresponsable'])) {
	$responsable = Responsable::getResponsable($_POST['id']);
	$responsable->setResponsabilite($_POST['responsabilite']);
	$responsable->setNomresponsable($_POST['nomresponsable']);
	$responsable->setPrenomresponsable($_POST['prenomresponsable']);
	$responsable->setEmailresponsable($_POST['emailresponsable']);
	$responsable->setTitreresponsable($_POST['titreresponsable']);
	Responsable_BDD::sauvegarder($responsable);
	$_GET['action'] = $_GET['id'] = '';
    }
}

modifier();

// ----------------------------------------------------------------------------
// Affichage

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion des responsables');

IHM_Generale::header("Gestion des", "responsables", "../../", $tabLiens);

if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'mod') {
    Responsable_IHM::afficherFormulaireModification($_GET['id']);
} else {
    Responsable_IHM::afficherFormulaireSaisie();
}

Responsable_IHM::afficherListeResponsableAEditer();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>