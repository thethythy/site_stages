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

   /* if (isset($_POST['theme']) && $_POST['theme'] != -1) {
        $element = $_POST['theme'];

        $theme = ThemeDeStage::getTheme($element);
        $couleur = $parrain->getCouleur();
        $tabCouleur = Couleur::listerCouleur();

        printf("<h2>Modification d'un référent</h2>");
        printf("<center><form action='../../gestion/parrains/mod_parrains.php' method=post name=par>\n");
        printf("<td><input type=hidden name='id' size=100 value=%s></td>\n", $parrain->getIdentifiantBDD());
        printf("<table><center><tr><td>Nom : </td>\n");
        printf("<td><input name='nom' size=100 value=%s></td>\n", $parrain->getNom());
        printf("</tr><tr><td>Prénom : </td>\n");
        printf("<td><input name='prenom' size=100 value=%s></td></tr></center>\n", $parrain->getPrenom());
        printf("</tr><tr><td>Email : </td>\n");
        printf("<td><input name='email' size=100 value=%s></td>\n", $parrain->getEmail());
        printf("</tr><tr><td>Couleur : </td>\n");
        printf("<td><select id='couleur' name='couleur' onchange='showColor()'>");

        for ($i = 0; $i < sizeof($tabCouleur); $i++) {
            if ($couleur->getIdentifiantBDD() == $tabCouleur[$i]->getIdentifiantBDD())
                echo "<option style='color: #" . $tabCouleur[$i]->getCode() . ";' selected value='" . $tabCouleur[$i]->getIdentifiantBDD() . "'>" . $tabCouleur[$i]->getNom() . "</option>";
            else
                echo "<option style='color: #" . $tabCouleur[$i]->getCode() . ";' value='" . $tabCouleur[$i]->getIdentifiantBDD() . "'>" . $tabCouleur[$i]->getNom() . "</option>";
        }

        printf("</select>&nbsp;&nbsp;&nbsp;&nbsp;<input id='couleurActuel' readonly='disabled' style='background-color: %s; width: 100px; border-width: 0px;'/></td></tr></center></table>\n", '#' . $couleur->getCode());
        printf("<table><tr><td><input type=submit value='Enregistrer les données'/></center></td></tr>");
        printf("</table></form></center>");

        printf("
                <script>
                document.getElementById('formModifParrain').hidden = true;
                function showColor() {
                    var couleurActuelHTML = document.getElementById('couleurActuel');
                    var couleurHTML = document.getElementById('couleur');
                    couleurActuelHTML.style.backgroundColor = couleurHTML.options[couleurHTML.selectedIndex].style.color;
                }
            </script>");
    }*/
}

modifier();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>