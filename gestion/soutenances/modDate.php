<?php
include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/DateSoutenance_BDD.php");
include_once("../../classes/moteur/DateSoutenance.php");
include_once("../../classes/bdd/Promotion_BDD.php");
include_once("../../classes/moteur/Promotion.php");
include_once("../../classes/bdd/Filiere_BDD.php");
include_once("../../classes/moteur/Filiere.php");
include_once("../../classes/bdd/Parcours_BDD.php");
include_once("../../classes/moteur/Parcours.php");
include_once("../../classes/ihm/IHM_Generale.php");

header ("Content-type:text/html; charset=utf-8");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier une ", "date", "../../", $tabLiens);
function modifier(){
	if($_POST['id']!=-1){
		$date=DateSoutenance::getDateSoutenance($_POST['id']);
                $newDateData = explode("-", $_POST['newdate']);
		$date->setJour($newDateData[2]);
		$date->setMois($newDateData[1]);
		$date->setAnnee($newDateData[0]);
		$idd = DateSoutenance_BDD::sauvegarder($date);
		DateSoutenance_BDD::sauvegarderRelationPromo($idd, $_POST['promo']);
		printf("La date a été modifiée ! ");
	}else {
		IHM_Generale::erreur("Vous devez sélectionner une date !");
	}
}
modifier();
printf("<p><a href='../../gestion/soutenances/modifierDate.php'>Retour</a></p>");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>