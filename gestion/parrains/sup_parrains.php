<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/ihm/IHM_Generale.php");

include_once("../../classes/bdd/Parrain_BDD.php");
include_once("../../classes/moteur/Parrain.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Supprimer un ", "référent", "../../", $tabLiens);

function supprimer() {
    if ($_POST['parrain'] != -1) {
	Parrain::deleteParrain($_POST['parrain']);
	printf("<p>Le référent a été supprimé !</p>");
    } else {
	IHM_Generale::erreur("Vous devez sélectionner un référent !");
    }
}

supprimer();
printf("<div><a href='../../gestion/parrains/ms_parrains.php'>Retour</a></div>");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>