<?php

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "ihm/ThemeDeStage_IHM.php");
include_once($chemin . "bdd/ThemeDeStage_BDD.php");
include_once($chemin . "moteur/ThemeDeStage.php");

include_once($chemin . "bdd/Couleur_BDD.php");
include_once($chemin . "moteur/Couleur.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier un ", "thème de stage", "../../", $tabLiens);

ThemeDeStage_IHM::afficherFormulaireSelection();

function modifier() {
    if (isset($_POST['theme']) && $_POST['theme'] != -1) {
	$theme = ThemeDeStage::getThemeDeStage($_POST['theme']);
	ThemeDeStage_IHM::afficherFormulaireModification($theme);
    }
}

modifier();
deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>