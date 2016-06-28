<?php

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "ihm/IHM_Generale.php");

include_once("../../classes/moteur/Filtre.php");
include_once("../../classes/moteur/FiltreString.php");

include_once($chemin . "ihm/DateSoutenance_IHM.php");
include_once($chemin . "bdd/DateSoutenance_BDD.php");
include_once($chemin . "moteur/DateSoutenance.php");

include_once("../../classes/bdd/Promotion_BDD.php");
include_once("../../classes/moteur/Promotion.php");

include_once("../../classes/bdd/Filiere_BDD.php");
include_once("../../classes/moteur/Filiere.php");

include_once("../../classes/bdd/Parcours_BDD.php");
include_once("../../classes/moteur/Parcours.php");

// ----------------------------------------------------------------------------
// Contrôleur

function supprimer() {
    if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'sup') {
	DateSoutenance::deleteDateSoutenance($_GET['id']);
    }
}

supprimer();

function modifier() {
    if (isset($_POST['id']) &&
	isset($_POST['date']) && $_POST['date'] != "" &&
	isset($_POST['promo']) && $_POST['promo'] != "") {

	$date = explode("-", $_POST['date']);

	$oDate = DateSoutenance::getDateSoutenance($_POST['id']);
	$oDate->setJour($date[2]);
	$oDate->setMois($date[1]);
	$oDate->setAnnee($date[0]);

	DateSoutenance_BDD::sauvegarder($oDate);
	DateSoutenance_BDD::sauvegarderRelationPromo($_POST['id'], $_POST['promo']);

	$_GET['action'] = $_GET['id'] = '';
    }
}

modifier();

function save() {
    if (!isset($_POST['id']) &&
	isset($_POST['date']) && $_POST['date'] != "" &&
	isset($_POST['promo']) && $_POST['promo'] != "") {

	$date = explode("-", $_POST['date']);

	$tabDonnees = array();

	array_push($tabDonnees, $date[2]);
	array_push($tabDonnees, $date[1]);
	array_push($tabDonnees, $date[0]);
	array_push($tabDonnees, $_POST['promo']);

	DateSoutenance::saisirDonneesDateSoutenance($tabDonnees);
    }
}

save();

// ----------------------------------------------------------------------------
// Affichage

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Gestion des", "dates de soutenances", "../../", $tabLiens);

if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'mod') {
    DateSoutenance_IHM::afficherFormulaireModification($_GET['id']);
} else {
    DateSoutenance_IHM::afficherFormulaireSaisie();
}

DateSoutenance_IHM::afficherListeDateSoutenanceAEditer();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

deconnexion();

?>
