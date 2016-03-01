<?php
$chemin = "../../classes/";
include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/TypeEntreprise_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/TypeEntreprise_IHM.php");
include_once($chemin."moteur/TypeEntreprise.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier un ", "type d'entreprise", "../../", $tabLiens);

TypeEntreprise_IHM::afficherFormulaireModification();

function modifier() {
    if (isset($_POST['type']) && $_POST['type'] != -1) {
        $element = $_POST['type'];

        $type = TypeEntreprise::getTypeEntreprise($element);
        printf("<h2>Modification d'un type d'entreprise</h2>");
        printf("<center><form action='../../gestion/entreprises/modTypeEntreprise.php' method=post name='the'>\n");
        printf("<td><input type=hidden name='id' size=100 value=%s></td>\n", $type->getIdentifiantBDD());
        printf("<table><center><tr><td>Type d'entreprise : </td>\n");
        printf("<td><input name='label' size=100 value=%s></td>\n", $type->getType());
       
        printf("<table><tr><td><input type=submit value='Enregistrer les données'/></center></td></tr>");
        printf("</table></form></center>");
    }
}

modifier();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>