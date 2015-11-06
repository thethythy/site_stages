<?php

include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/Couleur_BDD.php");
include_once("../../classes/moteur/Couleur.php");
include_once("../../classes/ihm/IHM_Generale.php");
include_once("../../classes/ihm/Couleur_IHM.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier/supprimer une ", "couleur", "../../", $tabLiens);

Couleur_IHM::afficherFormulaireModification();

function modifier() {
    global $tab20;
    if (isset($_POST['couleur']) && $_POST['couleur'] != -1) {
        $element = $_POST['couleur'];

        $couleur = Couleur::getCouleur($element);

        printf("<h2>Modification d'une couleur</h2>");
        printf("<center><form action='../../gestion/parrains/mod_couleur.php' method=post name=col>\n");
        printf("<td><input type=hidden name='id' value=%s></td>\n", $couleur->getIdentifiantBDD());
        printf("<table><center><tr><td width='75'>Nom : </td>");
        printf("<td><input name='nomCouleur' size=15 value=%s></td>\n", $couleur->getNom());
        printf("</tr><tr><td>Couleur : </td>");
        printf("<td><input id='colorPicker' type='color' name='codeHexa' value='%s' style='width: 100px;'></td></tr></center>\n", "#" . $couleur->getCode());
        printf("</td></tr></center></table>");
        printf("<table><tr><td><input type=submit value='Enregistrer les données'/></center></td></tr>");
        printf("</table></form></center>");

        printf("<script>
                    document.getElementById('formModifCouleur').hidden = true;
                </script>");
    }
}

modifier();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>