<?php

/**
 * Page gestionThemeDeStage.php
 * Utilisation : page pour gérer les thèmes de stage (création, édition, suppression)
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// ----------------------------------------------------------------------------
// Contrôleur

function supprimer() {
    if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'sup') {
	ThemeDeStage::deleteTheme($_GET['id']);
    }
}

supprimer();

function modifier() {
    if (isset($_POST['id']) &&
	isset($_POST['theme']) && $_POST['theme'] != "" &&
	isset($_POST['idcouleur']) && $_POST['idcouleur'] != "") {
	$type = ThemeDeStage::getThemeDeStage($_POST['id']);
	$type->setTheme($_POST['theme']);
	$type->setIdentifiant_couleur($_POST['idcouleur']);
	ThemeDeStage_BDD::sauvegarder($type);
	$_GET['action'] = $_GET['id'] = '';
    }
}

modifier();

function save() {
    if (!isset($_POST['id']) &&
	isset($_POST['theme']) && $_POST['theme'] != "" &&
	isset($_POST['idcouleur']) && $_POST['idcouleur'] != "") {
	$tabDonnees = array();
	array_push($tabDonnees, $_POST['theme']);
	array_push($tabDonnees, $_POST['idcouleur']);
	ThemeDeStage::saisirDonneesTheme($tabDonnees);
	$_GET['action'] = $_GET['id'] = '';
    }
}

save();

// ----------------------------------------------------------------------------
// Affichage

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Gestion des", "thèmes de stage", "../../", $tabLiens);

if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'mod') {
    ThemeDeStage_IHM::afficherFormulaireModification($_GET['id']);
} else {
    ThemeDeStage_IHM::afficherFormulaireSaisie();
}

ThemeDeStage_IHM::afficherListeThemeDeStageAEditer();

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>

