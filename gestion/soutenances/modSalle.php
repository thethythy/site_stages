<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/ihm/IHM_Generale.php");

include_once("../../classes/bdd/Salle_BDD.php");
include_once("../../classes/moteur/Salle.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier une ", "salle", "../../", $tabLiens);

function modifier() {
    if ($_POST['id'] != -1) {
	$salle = Salle::getSalle($_POST['id']);
	$salle->setNom($_POST['nom']);
	Salle_BDD::sauvegarder($salle);
	printf("La salle a été modifiée ! ");
    } else {
	IHM_Generale::erreur("Vous devez sélectionner une salle !");
    }
}

modifier();
printf("<p><a href='../../gestion/soutenances/modifierSalle.php'>Retour</a></p>");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>