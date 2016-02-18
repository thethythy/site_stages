<?php
include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/Parrain_BDD.php");
include_once("../../classes/bdd/Couleur_BDD.php");
include_once("../../classes/moteur/Parrain.php");
include_once("../../classes/moteur/Couleur.php");
include_once("../../classes/ihm/IHM_Generale.php");
$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier un ", "r�f�rent", "../../", $tabLiens);
function modifier(){
if($_POST['id']!=-1){
	$parrain=Parrain::getParrain($_POST['id']);
	$parrain->setNom($_POST['nom']);
	$parrain->setPrenom($_POST['prenom']);
	$parrain->setEmail($_POST['email']);
	$parrain->setIdentifiant_couleur($_POST['couleur']);
	Parrain_BDD::sauvegarder($parrain);
	printf("Le r�f�rent a �t� modifi� ! ");
}else {
	IHM_Generale::erreur("Vous devez s�lectionner un r�f�rent !");
}
}
modifier();
printf("<p><a href='../../gestion/parrains/ms_parrains.php'>Retour</a></p>");
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>