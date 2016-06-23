<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/ihm/IHM_Generale.php");

include_once("../../classes/ihm/Parrain_IHM.php");
include_once("../../classes/bdd/Parrain_BDD.php");
include_once("../../classes/moteur/Parrain.php");

include_once("../../classes/bdd/Couleur_BDD.php");
include_once("../../classes/moteur/Couleur.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier/supprimer un ", "référent", "../../", $tabLiens);

function modifier() {
    if (isset($_POST['parrain']) && $_POST['parrain'] != -1) {
	Parrain_IHM::afficherFormulaireModificationParrain($_POST['parrain']);
    } else {
	Parrain_IHM::afficherFormulaireModification();
    }
}

modifier();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>