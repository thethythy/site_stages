<?php
$chemin = "../../classes/";
include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/ThemeDeStage_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."moteur/ThemeDeStage.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Supprimer un ", "thème de stage", "../../",$tabLiens);

function supprimer(){
	if(isset($_POST['theme']) && $_POST['theme'] != -1){
		$theme=$_POST['theme'];
		ThemeDeStage::deleteTheme($theme);
		printf("<p>Le thème de stage a été supprimé !</p>");
	}else {
		IHM_Generale::erreur("Vous devez sélectionner un thème de stage !");
	}
}

supprimer();
printf("<div><a href='../../gestion/conventions/gestionThemeDeStage.php'>Retour</a></div>");
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>