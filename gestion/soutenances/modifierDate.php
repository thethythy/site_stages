<?php

include_once("../../classes/bdd/connec.inc");

include_once("../../classes/moteur/Filtre.php");
include_once("../../classes/moteur/FiltreString.php");

include_once("../../classes/ihm/IHM_Generale.php");

include_once("../../classes/ihm/DateSoutenance_IHM.php");
include_once("../../classes/bdd/DateSoutenance_BDD.php");
include_once("../../classes/moteur/DateSoutenance.php");

include_once("../../classes/bdd/Promotion_BDD.php");
include_once("../../classes/moteur/Promotion.php");

include_once("../../classes/bdd/Filiere_BDD.php");
include_once("../../classes/moteur/Filiere.php");

include_once("../../classes/bdd/Parcours_BDD.php");
include_once("../../classes/moteur/Parcours.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier/supprimer une ", "date", "../../", $tabLiens);

DateSoutenance_IHM::afficherFormulaireChoixDate();

function modifier() {
    if (isset($_POST['date']) && $_POST['date'] != -1) {
	DateSoutenance_IHM::afficherFormulaireModification($_POST['date']);
    }
}

modifier();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>