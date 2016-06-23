<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/ihm/IHM_Generale.php");

include_once("../../classes/ihm/Competence_IHM.php");
include_once("../../classes/bdd/Competence_BDD.php");
include_once("../../classes/moteur/Competence.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Gestion des", "compétences", "../../", $tabLiens);

if (isset($_GET['id'])) {
    Competence::deleteCompetence($_GET['id']);
}

function save() {
    if (isset($_POST['nomCompetence']) && $_POST['nomCompetence'] != "") {
	$tabDonnees = array();
	array_push($tabDonnees, $_POST['nomCompetence']);
	Competence::saisirDonneesCompetences($tabDonnees);
    }
}

save();
Competence_IHM::afficherFormulaireSaisie();

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>