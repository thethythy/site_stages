<?php
$chemin = "../../classes/";
include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/ThemeDeStage_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/ThemeDeStage_IHM.php");
include_once($chemin."moteur/ThemeDeStage.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Ajouter un", "theme de stage", "../../",$tabLiens);
ThemeDeStage_IHM::afficherFormulaireSaisie();

function save(){
	if(isset($_POST['theme'])) {
		if($_POST['theme'] != ""){	
			
			$theme=$_POST['theme'];
			ThemeDeStage::saisirDonneesTheme($theme);
			printf("<p>Le nouveau thème de stage a été enregistré ! </p>");
		}else{
			IHM_Generale::erreur("Vous devez saisir des informations !");
		}
	}
	
}
save();
deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>