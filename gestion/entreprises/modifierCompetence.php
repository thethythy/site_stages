<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/ihm/IHM_Generale.php");

include_once("../../classes/ihm/Competence_IHM.php");
include_once("../../classes/bdd/Competence_BDD.php");
include_once("../../classes/moteur/Competence.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier une", "compétence", "../../", $tabLiens);

function modifier() {
    if (isset($_POST['id']) && isset($_POST['label'])) {
	$competence = new Competence($_POST['id'], $_POST['label']);
	Competence_BDD::sauvegarder($competence);
	echo "La compétence a été modifiée !";
    }
}

modifier();

if (isset($_GET['id'])) {
    Competence_IHM::afficherFormulaireModification($_GET['id']);
}

echo "<p><a href='../../gestion/entreprises/gestionCompetence.php'>Retour</a></p>";

deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>