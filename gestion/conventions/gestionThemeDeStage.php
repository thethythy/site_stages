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

IHM_Generale::header("Modifier un ", "thème de stage", "../../", $tabLiens);

ThemeDeStage_IHM::afficherFormulaireGestion();

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

function modifier() {
    if (isset($_POST['theme']) && $_POST['theme'] != -1) {
        $element = $_POST['theme'];

        $theme = ThemeDeStage::getThemeDeStage($element);
        printf("<h2>Modification d'un thème de stage</h2>");
        printf("<center><form action='../../gestion/conventions/mod_themeDeStage.php' method=post name='the'>\n");
        printf("<td><input type=hidden name='id' size=100 value=%s></td>\n", $theme->getIdTheme());
        printf("<table><center><tr><td>Thème de stage : </td>\n");
        printf("<td><input name='label' size=100 value=%s></td>\n", $theme->getTheme());
       
        printf("<table><tr><td><input type=submit value='Enregistrer les données'/></center></td></tr>");
        printf("</table></form></center>");
    }
}

save();
modifier();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>