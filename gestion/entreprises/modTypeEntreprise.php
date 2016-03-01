<?php
$chemin = "../../classes/";
include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/TypeEntreprise_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."moteur/TypeEntreprise.php");
$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier un ", "type d'entreprise", "../../", $tabLiens);

function modifier(){
	if($_POST['id']!=-1){

		$type = TypeEntreprise::getTypeEntreprise($_POST['id']);
		$type->setType($_POST['label']);

		TypeEntreprise_BDD::sauvegarder($type);
		printf("Le type d'entreprise a été modifié ! ");
	}else {
		IHM_Generale::erreur("Vous devez sélectionner un type d'entreprise !");
	}
}
modifier();
printf("<p><a href='../../gestion/entreprises/modifierTypeEntreprise.php'>Retour</a></p>");
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>