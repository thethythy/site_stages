<?php
$chemin = "../../classes/";
include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/TypeEntreprise_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."moteur/TypeEntreprise.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Supprimer un ", "Type d'entreprise", "../../",$tabLiens);

function supprimer(){
	if (isset($_POST['type']) && $_POST['type'] != -1) {
		$type = $_POST['type'];
		TypeEntreprise::supprimerTypeEntreprise($type);
		printf("<p>Le type d'entreprise a été supprimé !</p>");
	}else {
		IHM_Generale::erreur("Vous devez sélectionner un type d'entreprise !");
	}
}

supprimer();
printf("<div><a href='../../gestion/entreprises/modifierTypeEntreprise.php'>Retour</a></div>");
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>