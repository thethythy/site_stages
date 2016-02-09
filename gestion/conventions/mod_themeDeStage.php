<?php
$chemin = "../../classes/";
include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/ThemeDeStage_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."moteur/ThemeDeStage.php");
$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier un ", "thème de stage", "../../", $tabLiens);

function modifier(){
	if($_POST['id']!=-1){

		$theme = ThemeDeStage::getThemeDeStage($_POST['id']);
		$theme->setTheme($_POST['label']);

		ThemeDeStage_BDD::saveModification($theme);
		printf("Le thème de stage a été modifié ! ");
	}else {
		IHM_Generale::erreur("Vous devez sélectionner un thème de stage !");
	}
}
modifier();
printf("<p><a href='../../gestion/conventions/modifierThemeDeStage.php'>Retour</a></p>");
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>