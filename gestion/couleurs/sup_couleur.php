<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/ihm/IHM_Generale.php");

include_once("../../classes/bdd/Couleur_BDD.php");
include_once("../../classes/moteur/Couleur.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Supprimer une ", "couleur", "../../", $tabLiens);

function supprimer() {
    if ($_POST['couleur'] != -1) {
	Couleur::deleteCouleur($_POST['couleur']);
	printf("<p>La couleur a été supprimée!</p>");
    } else {
	IHM_Generale::erreur("Vous devez sélectionner une couleur !");
    }
}

supprimer();
printf("<div><a href='../../gestion/couleurs/ms_couleur.php'>Retour</a></div>");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>