<?php
header ('Content-type:text/html; charset=utf-8');
include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/Competence_BDD.php");
include_once("../../classes/ihm/IHM_Generale.php");
include_once("../../classes/ihm/Competence_IHM.php");
include_once("../../classes/moteur/Competence.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Gestion des", "compétences", "../../",$tabLiens );

if (isset($_GET['id'])) {
	Competence::deleteCompetence($_GET['id']);
}

function save(){
	if (isset($_POST['nomCompetence']) && $_POST['nomCompetence'] != "") {
		$tabDonnees = array();
		$nom=$_POST['nomCompetence'];
		array_push($tabDonnees,$nom);
		Competence::saisirDonneesCompetences($tabDonnees);
	}
}

save();

Competence_IHM::afficherFormulaireSaisie();

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>