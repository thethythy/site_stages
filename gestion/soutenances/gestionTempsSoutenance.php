<?php

/**
 * Page gestionTempsSoutenance.php
 * Utilisation : page pour gérer les durées de soutenance (création, édition)
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// ----------------------------------------------------------------------------
// Contrôleur

function raz() {
    if (isset($_GET['action']) && $_GET['action'] == 'sup' && isset($_GET['id'])) {
	$oFiliere = Filiere::getFiliere($_GET['id']);
	$oFiliere->setTempsSoutenance(0);
	Filiere_BDD::sauvegarder($oFiliere);
    }
}

raz();

function modifier() {
    if (isset($_POST['action']) && $_POST['action'] == 'mod' &&
	isset($_POST['id']) &&
	isset($_POST['duree']) && $_POST['duree'] != "") {
	$oFiliere = Filiere::getFiliere($_POST['id']);
	$oFiliere->setTempsSoutenance($_POST['duree']);
	Filiere_BDD::sauvegarder($oFiliere);

	$_GET['action'] = $_GET['id'] = '';
    }
}

modifier();

// ----------------------------------------------------------------------------
// Affichage

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Gérer les", "durées de soutenance", "../../", $tabLiens);

Filiere_IHM::afficherListeTempsSoutenanceAEditer();

if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'mod') {
    Filiere_IHM::afficherFormulaireModification($_GET['id']);
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

deconnexion();

?>