<?php
include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/Couleur_BDD.php");
include_once("../../classes/moteur/Couleur.php");
include_once("../../classes/ihm/IHM_Generale.php");
$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier une ", "couleur", "../../", $tabLiens);
function modifier(){
if($_POST['id']!=-1){
	$couleur=Couleur::getCouleur($_POST['id']);
	$couleur->setNom($_POST['nomCouleur']);
	$couleur->setCode(ltrim($_POST['codeHexa'], "#"));
	Couleur_BDD::sauvegarder($couleur);
	printf("La couleur a �t� modifi�e ! ");
}else {
	IHM_Generale::erreur("Vous devez s�lectionner une couleur !");
}
}
modifier();
printf("<p><a href='../../gestion/parrains/ms_couleur.php'>Retour</a></p>");
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>