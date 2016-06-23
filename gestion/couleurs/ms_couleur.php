<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/ihm/IHM_Generale.php");

include_once("../../classes/ihm/Couleur_IHM.php");
include_once("../../classes/bdd/Couleur_BDD.php");
include_once("../../classes/moteur/Couleur.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier/supprimer une ", "couleur", "../../", $tabLiens);

Couleur_IHM::afficherFormulaireSelection();

function modifier() {
    if (isset($_POST['couleur']) && $_POST['couleur'] != -1) {
	Couleur_IHM::afficherFormulaireModification($_POST['couleur']);
    }
}

modifier();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>