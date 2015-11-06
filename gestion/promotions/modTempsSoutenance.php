<?php
include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/Filiere_BDD.php");
include_once("../../classes/moteur/Filiere.php");
include_once("../../classes/ihm/IHM_Generale.php");
$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier une ", "dur�e par dipl�me", "../../", $tabLiens);
function modifier(){
if($_POST['id']!=-1){
	$filiere=Filiere::getFiliere($_POST['id']);
	$filiere->setTempsSoutenance($_POST['duree']);
	Filiere_BDD::sauvegarder($filiere);
	printf("La dur�e a �t� modifi�e ! ");
}else {
	IHM_Generale::erreur("Vous devez s�lectionner un dipl�me !");
}
}
modifier();
printf("<p><a href='../../gestion/promotions/modifierTempsSoutenance.php'>Retour</a></p>");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>