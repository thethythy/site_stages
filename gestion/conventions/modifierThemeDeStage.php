<?php
header ('Content-type:text/html; charset=utf-8');

$chemin = "../../classes/";
include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/ThemeDeStage_BDD.php");
include_once($chemin."bdd/Couleur_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/ThemeDeStage_IHM.php");
include_once($chemin."moteur/ThemeDeStage.php");
include_once($chemin."moteur/Couleur.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier un ", "thème de stage", "../../", $tabLiens);

ThemeDeStage_IHM::afficherFormulaireModification();

function modifier() {
    if (isset($_POST['theme']) && $_POST['theme'] != -1) {
        $element = $_POST['theme'];

        $theme = ThemeDeStage::getThemeDeStage($element);
        $couleur = $theme->getCouleur();
        $tabCouleur = Couleur::listerCouleur();

        printf("<h2>Modification d'un thème de stage</h2>");
        printf("<center><form action='../../gestion/conventions/mod_themeDeStage.php' method=post name='the'>\n");
        printf("<td><input type=hidden name='id' size=100 value=%s></td>\n", $theme->getIdTheme());
        printf("<table><center><tr><td>Thème de stage : </td>\n");
        printf("<td><input name='label' size=100 value=%s></td>\n", $theme->getTheme());
        printf("</tr><tr><td>Couleur : </td>\n");
        printf("<td><select id='couleur' name='couleur' onchange='showColor()'>");

        for ($i = 0; $i < sizeof($tabCouleur); $i++) {
            if ($couleur->getIdentifiantBDD() == $tabCouleur[$i]->getIdentifiantBDD())
                echo "<option style='color: #" . $tabCouleur[$i]->getCode() . ";' selected value='" . $tabCouleur[$i]->getIdentifiantBDD() . "'>" . $tabCouleur[$i]->getNom() . "</option>";
            else
                echo "<option style='color: #" . $tabCouleur[$i]->getCode() . ";' value='" . $tabCouleur[$i]->getIdentifiantBDD() . "'>" . $tabCouleur[$i]->getNom() . "</option>";
        }

        printf("</select>&nbsp;&nbsp;&nbsp;&nbsp;<input id='couleurActuel' readonly='disabled' style='background-color: %s; width: 100px; border-width: 0px;'/></td></tr></center></table>\n", '#' . $couleur->getCode());
        printf("<table><tr><td><input type=submit value='Modifier'/></center></td></tr>");
        printf("</table></form></center>");

        printf("
                <script>
                document.getElementById('formModifTheme').hidden = true;
                function showColor() {
                    var couleurActuelHTML = document.getElementById('couleurActuel');
                    var couleurHTML = document.getElementById('couleur');
                    couleurActuelHTML.style.backgroundColor = couleurHTML.options[couleurHTML.selectedIndex].style.color;
                }
            </script>");
    }
}

modifier();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>