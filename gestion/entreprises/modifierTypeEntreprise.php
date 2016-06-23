<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."ihm/IHM_Generale.php");

include_once($chemin."ihm/TypeEntreprise_IHM.php");
include_once($chemin."bdd/TypeEntreprise_BDD.php");
include_once($chemin."moteur/TypeEntreprise.php");

include_once($chemin."bdd/Couleur_BDD.php");
include_once($chemin."moteur/Couleur.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier un ", "type d'entreprise", "../../", $tabLiens);

TypeEntreprise_IHM::afficherFormulaireSelection();

function modifier() {
    if (isset($_POST['type']) && $_POST['type'] != -1) {
	TypeEntreprise_IHM::afficherFormulaireModification($_POST['type']);
    }
}

modifier();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>