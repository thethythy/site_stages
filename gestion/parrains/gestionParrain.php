<?php

/**
 * Page gestionParrain.php
 * Utilisation : page pour gérer les parrains (création, édition, suppression)
 * Accès : restreint par authentification HTTP
 */

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/Parrain_IHM.php");
include_once($chemin . "bdd/Parrain_BDD.php");
include_once($chemin . "moteur/Parrain.php");

include_once($chemin . "bdd/Couleur_BDD.php");
include_once($chemin . "moteur/Couleur.php");

// ----------------------------------------------------------------------------
// Contrôleur

function supprimer() {
    if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'sup') {
	Parrain::deleteParrain($_GET['id']);
    }
}

supprimer();

function modifier() {
    if (isset($_POST['id']) &&
	isset($_POST['nomparrain']) && $_POST['nomparrain'] != "" &&
	isset($_POST['prenomparrain']) && $_POST['prenomparrain'] != "" &&
	isset($_POST['emailparrain']) && $_POST['emailparrain'] != "" &&
	isset($_POST['idcouleur']) && $_POST['idcouleur'] != "") {
	$parrain = Parrain::getParrain($_POST['id']);
	$parrain->setNom($_POST['nomparrain']);
	$parrain->setPrenom($_POST['prenomparrain']);
	$parrain->setEmail($_POST['emailparrain']);
	$parrain->setIdentifiant_couleur($_POST['idcouleur']);
	Parrain_BDD::sauvegarder($parrain);
	$_GET['action'] = $_GET['id'] = '';
    }
}

modifier();

function save() {
    if (!isset($_POST['id']) &&
	isset($_POST['nomparrain']) && $_POST['nomparrain'] != "" &&
	isset($_POST['prenomparrain']) && $_POST['prenomparrain'] != "" &&
	isset($_POST['emailparrain']) && $_POST['emailparrain'] != "" &&
	isset($_POST['idcouleur']) && $_POST['idcouleur'] != "") {
	$tabDonnees = array();
	array_push($tabDonnees, $_POST['nomparrain']);
	array_push($tabDonnees, $_POST['prenomparrain']);
	array_push($tabDonnees, $_POST['emailparrain']);
	array_push($tabDonnees, $_POST['idcouleur']);
	Parrain::saisirDonneesParrain($tabDonnees);
	$_GET['action'] = $_GET['id'] = '';
    }
}

save();

// ----------------------------------------------------------------------------
// Affichage

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Gestion des", "référents", "../../", $tabLiens);

if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'mod') {
    Parrain_IHM::afficherFormulaireModificationParrain($_GET['id']);
} else {
    Parrain_IHM::afficherFormulaireSaisie();
}

Parrain_IHM::afficherListeParrainAEditer();

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>

