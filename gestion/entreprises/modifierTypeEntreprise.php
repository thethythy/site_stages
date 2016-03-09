<?php

header ('Content-type:text/html; charset=utf-8');

$chemin = "../../classes/";
include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/TypeEntreprise_BDD.php");
include_once($chemin."bdd/Couleur_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/TypeEntreprise_IHM.php");
include_once($chemin."moteur/TypeEntreprise.php");
include_once($chemin."moteur/Couleur.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier un ", "type d'entreprise", "../../", $tabLiens);

TypeEntreprise_IHM::afficherFormulaireModification();

function modifier() {
    if (isset($_POST['type']) && $_POST['type'] != -1) {
        $element = $_POST['type'];

        $type = TypeEntreprise::getTypeEntreprise($element);
        $couleur = $type->getCouleur();
        $tabCouleur = Couleur::listerCouleur();

        printf("<h2>Modification d'un type d'entreprise</h2>");
        printf("<center><form action='../../gestion/entreprises/modTypeEntreprise.php' method=post name='typ'>\n");
        printf("<td><input type=hidden name='id' size=100 value=%s></td>\n", $type->getIdentifiantBDD());
        printf("<table><center><tr><td>Type d'entreprise : </td>\n");
        printf("<td><input name='label' size=100 value=%s></td>\n", $type->getType());
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