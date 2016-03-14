<?php 
include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/DateSoutenance_BDD.php");
include_once("../../classes/moteur/DateSoutenance.php");
include_once("../../classes/bdd/Promotion_BDD.php");
include_once("../../classes/moteur/Promotion.php");
include_once("../../classes/bdd/Filiere_BDD.php");
include_once("../../classes/moteur/Filiere.php");
include_once("../../classes/bdd/Parcours_BDD.php");
include_once("../../classes/moteur/Parcours.php");
include_once("../../classes/ihm/IHM_Generale.php");
include_once("../../classes/ihm/DateSoutenance_IHM.php");
include_once("../../classes/moteur/Filtre.php");
include_once("../../classes/moteur/FiltreString.php");

header ("Content-type:text/html; charset=utf-8");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier/supprimer une ", "date", "../../", $tabLiens);

DateSoutenance_IHM::afficherFormulaireModification();

function modifier() {
    global $tab5;
    if (isset($_POST['date']) && $_POST['date'] != -1) {
	$date = DateSoutenance::getDateSoutenance($_POST['date']);
	printf("<h2>Modification d'une date</h2>");
	printf("<center><form action='../../gestion/soutenances/modDate.php' method=post name=par>\n");
	printf("<td><input type=hidden name='id' size=100 value=%s></td>\n",$date->getIdentifiantBDD());
	printf("<table><center><tr><td>Date : </td>\n");
	printf("<td><input id='newdate' type='date' name='newdate' value='%s'/></td>\n", date('Y-m-d', mktime(0, 0, 0, $date->getMois(), $date->getJour(), $date->getAnnee())));
	printf("<tr><td>&nbsp;</td><td></td></tr>");
	printf("<tr><td size=200>Sélectionner les<br />promotions associées :</td><td>");
        $tabPromoDate = DateSoutenance::listerRelationPromoDate($date->getIdentifiantBDD());
        $tabPromo = Promotion::listerPromotions(new FiltreString('anneeuniversitaire', $date->getAnnee() - 1));
        foreach ($tabPromo as $promo) {
            $check = "";
            foreach ($tabPromoDate as $promo2)
                if ($promo2==$promo->getIdentifiantBDD()) $check="checked";
            echo '<input type="checkbox" name="promo[]" value="'.$promo->getIdentifiantBDD().'" '.$check.'>'.$promo->getFiliere()->getNom().' '.$promo->getParcours()->getNom().'<br />';
        }  
        printf("</td></tr>");
        printf("<tr><td>&nbsp;</td><td></td></tr>");
        printf("<table><tr><td><input type=submit value='Enregistrer les données'/></center></td></tr>");
        printf("</table></form></center>");
        
        printf("<script>
                    document.getElementById('formModifDate').hidden = true;
                </script>");
    }
}

modifier();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>