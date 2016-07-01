<?php

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/Competence_IHM.php");
include_once($chemin . "bdd/Competence_BDD.php");
include_once($chemin . "moteur/Competence.php");

// ----------------------------------------------------------------------------
// Contrôleur

function supprimer() {
    if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'sup') {
	Competence::deleteCompetence($_GET['id']);
    }
}

supprimer();

function modifier() {
    if (isset($_POST['id']) && isset($_POST['nomcompetence']) && $_POST['nomcompetence'] != "") {
	$competence = new Competence($_POST['id'], $_POST['nomcompetence']);
	Competence_BDD::sauvegarder($competence);
	$_GET['action'] = $_GET['id'] = '';
    }
}

modifier();

function save() {
    if (!isset($_POST['id']) && isset($_POST['nomcompetence']) && $_POST['nomcompetence'] != "") {
	$tabDonnees = array();
	array_push($tabDonnees, $_POST['nomcompetence']);
	Competence::saisirDonneesCompetences($tabDonnees);
	$_GET['action'] = $_GET['id'] = '';
    }
}

save();

// ----------------------------------------------------------------------------
// Affichage

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Gestion des", "compétences", "../../", $tabLiens);

if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'mod') {
    Competence_IHM::afficherFormulaireModification($_GET['id']);
} else {
    Competence_IHM::afficherFormulaireSaisie();
}

Competence_IHM::afficherListeCompetenceAEditer();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

deconnexion();

?>