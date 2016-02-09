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

ThemeDeStage_IHM::afficherFormulaireModification();

function modifier() {
    global $tab23;

    if (isset($_POST['theme']) && $_POST['theme'] != -1) {
        $element = $_POST['theme'];

        $theme = ThemeDeStage::getThemeDeStage($element);
        printf("<h2>Modification d'un thème de stage</h2>");
        printf("<center><form action='../../gestion/conventions/mod_themeDeStage.php' method=post name='theme'>\n");
        printf("<td><input type=hidden name='id' size=100 value=%s></td>\n", $theme->getIdTheme());
        printf("<table><center><tr><td>Thème de stage : </td>\n");
        printf("<td><input name='label' size=100 value=%s></td>\n", $theme->getTheme());
       
        printf("<table><tr><td><input type=submit value='Enregistrer les données'/></center></td></tr>");
        printf("</table></form></center>");
    }
}

modifier();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>