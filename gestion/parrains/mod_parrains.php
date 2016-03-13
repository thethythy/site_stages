<?php
header ('Content-type:text/html; charset=utf-8');
include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/Parrain_BDD.php");
include_once("../../classes/bdd/Couleur_BDD.php");
include_once("../../classes/moteur/Parrain.php");
include_once("../../classes/moteur/Couleur.php");
include_once("../../classes/ihm/IHM_Generale.php");
$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier un ", "référent", "../../", $tabLiens);
function modifier(){
if($_POST['id']!=-1){
	$parrain=Parrain::getParrain($_POST['id']);
	$parrain->setNom($_POST['nom']);
	$parrain->setPrenom($_POST['prenom']);
	$parrain->setEmail($_POST['email']);
	$parrain->setIdentifiant_couleur($_POST['couleur']);
	Parrain_BDD::sauvegarder($parrain);
	printf("Le référent a été modifié ! ");
}else {
	IHM_Generale::erreur("Vous devez sélectionner un référent !");
}
}
modifier();
printf("<p><a href='../../gestion/parrains/ms_parrains.php'>Retour</a></p>");
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>