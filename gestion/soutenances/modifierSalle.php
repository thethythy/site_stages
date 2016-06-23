<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/ihm/IHM_Generale.php");

include_once("../../classes/ihm/Salle_IHM.php");
include_once("../../classes/bdd/Salle_BDD.php");
include_once("../../classes/moteur/Salle.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier/supprimer une ", "salle", "../../", $tabLiens);

Salle_IHM::afficherFormulaireChoixSalle();

function modifier() {
    if (isset($_POST['salle']) && $_POST['salle'] != -1) {
	Salle_IHM::afficherFormulaireModification($_POST['salle']);
    }
}

modifier();

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>