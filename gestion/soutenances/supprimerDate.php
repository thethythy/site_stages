<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/ihm/IHM_Generale.php");

include_once("../../classes/bdd/DateSoutenance_BDD.php");
include_once("../../classes/moteur/DateSoutenance.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Supprimer une ", "date", "../../", $tabLiens);

function supprimer() {
    if ($_POST['date'] != -1) {
	DateSoutenance::deleteDateSoutenance($_POST['date']);
	printf("<p>La date a été supprimée!</p>");
    } else {
	IHM_Generale::erreur("Vous devez sélectionner une date !");
    }
}

supprimer();
printf("<div><a href='../../gestion/soutenances/modifierDate.php'>Retour</a></div>");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>