<?php
include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/Salle_BDD.php");
include_once("../../classes/moteur/Salle.php");
include_once("../../classes/ihm/IHM_Generale.php");

header ("Content-type:text/html; charset=utf-8");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Supprimer une ", "salle", "../../",$tabLiens);

function supprimer(){
if($_POST['salle']!=-1){
	$element=$_POST['salle'];
	Salle::deleteSalle($element);
	printf("<p>La salle a été supprimée!</p>");
}else {
	IHM_Generale::erreur("Vous devez sélectionner une salle !");
}
}

supprimer();
printf("<div><a href='../../gestion/soutenances/modifierSalle.php'>Retour</a></div>");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>