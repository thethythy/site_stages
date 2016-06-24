<?php

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/Couleur_IHM.php");
include_once($chemin . "bdd/Couleur_BDD.php");
include_once($chemin . "moteur/Couleur.php");

// ----------------------------------------------------------------------------
// Contrôleur

function supprimer() {
    if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'sup') {
	Couleur::deleteCouleur($_GET['id']);
    }
}

supprimer();

function modifier() {
    if (isset($_POST['id']) &&
	isset($_POST['nomcouleur']) && $_POST['nomcouleur'] != "" &&
	isset($_POST['codehexa']) && $_POST['codehexa'] != "") {
	$couleur = Couleur::getCouleur($_POST['id']);
	$couleur->setNom($_POST['nomcouleur']);
	$couleur->setCode(ltrim($_POST['codehexa'], "#"));
	Couleur_BDD::sauvegarder($couleur);
	$_GET['action'] = $_GET['id'] = '';
    }
}

modifier();

function save() {
    if (!isset($_POST['id']) &&
	isset($_POST['nomcouleur']) && $_POST['nomcouleur'] != "" &&
	isset($_POST['codehexa']) && $_POST['codehexa'] != "") {
	$tabDonnees = array();
	array_push($tabDonnees, $_POST['nomcouleur']);
	array_push($tabDonnees, ltrim($_POST['codehexa'], "#"));
	Couleur::saisirDonneesCouleur($tabDonnees);
    }
}

save();

// ----------------------------------------------------------------------------
// Affichage

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Gestion des", "couleurs", "../../", $tabLiens);

if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'mod') {
    Couleur_IHM::afficherFormulaireModification($_GET['id']);
} else {
    Couleur_IHM::afficherFormulaireSaisie();
}

Couleur_IHM::afficherListeCouleurAEditer();

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>
