<?php

/**
 * Page gestionTypeEntreprise.php
 * Utilisation : page pour gérer les types d'entreprise (création, édition, suppression)
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// ----------------------------------------------------------------------------
// Contrôleur

function supprimer() {
    if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'sup') {
	TypeEntreprise::supprimerTypeEntreprise($_GET['id']);
    }
}

supprimer();

function modifier() {
    if (isset($_POST['id']) &&
	isset($_POST['type']) && $_POST['type'] != "" &&
	isset($_POST['idcouleur']) && $_POST['idcouleur'] != "") {
	$type = TypeEntreprise::getTypeEntreprise($_POST['id']);
	$type->setType($_POST['type']);
	$type->setIdentifiant_couleur($_POST['idcouleur']);
	TypeEntreprise_BDD::sauvegarder($type);
	$_GET['action'] = $_GET['id'] = '';
    }
}

modifier();

function save() {
    if (!isset($_POST['id']) &&
	isset($_POST['type']) && $_POST['type'] != "" &&
	isset($_POST['idcouleur']) && $_POST['idcouleur'] != "") {
	$tabDonnees = array();
	array_push($tabDonnees, $_POST['type']);
	array_push($tabDonnees, $_POST['idcouleur']);
	TypeEntreprise::saisirDonneesType($tabDonnees);
	$_GET['action'] = $_GET['id'] = '';
    }
}

save();

// ----------------------------------------------------------------------------
// Affichage

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Gestion des", "types d'entreprises", "../../", $tabLiens);

if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'mod') {
    TypeEntreprise_IHM::afficherFormulaireModification($_GET['id']);
} else {
    TypeEntreprise_IHM::afficherFormulaireSaisie();
}

TypeEntreprise_IHM::afficherListeTypeEntrepriseAEditer();

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>

