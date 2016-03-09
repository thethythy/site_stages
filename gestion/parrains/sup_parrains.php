<?php
header ('Content-type:text/html; charset=utf-8');
include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/Parrain_BDD.php");
include_once("../../classes/moteur/Parrain.php");
include_once("../../classes/ihm/IHM_Generale.php");
$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Supprimer un ", "r�f�rent", "../../",$tabLiens);

function supprimer(){
	if($_POST['parrain']!=-1){
		$element=$_POST['parrain'];
		Parrain::deleteParrain($element);
		printf("<p>Le r�f�rent a �t� supprim� !</p>");
	}else {
		IHM_Generale::erreur("Vous devez s�lectionner un r�f�rent !");
	}
}

supprimer();
printf("<div><a href='../../gestion/parrains/ms_parrains.php'>Retour</a></div>");
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>