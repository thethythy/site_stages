<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."ihm/Filiere_IHM.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."moteur/Utils.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Modifier une", "durée de soutenance", "../../", $tabLiens);

Filiere_IHM::afficherFormulaireModificationTempsSoutenance();

function modifier(){
	global $tab10;
	if(isset($_POST['filiere']) && $_POST['filiere']!=-1){
		$element=$_POST['filiere'];
	
		$filiere=Filiere::getFiliere($element);
		printf("<h2>Modification de la durée de la soutenance</h2>");
		printf("<center><form action='../../gestion/promotions/modTempsSoutenance.php' method=post name=temps>\n");
		printf("<td><input type=hidden name='id' size=100 value=%s></td>\n",$filiere->getIdentifiantBDD());
		printf("<table><center><tr><td style='width: 200px;'>Nom :</td><td>%s</td></tr>\n",$filiere->getNom());
		printf("<tr><td>Durée de la soutenance : </td>\n");
		printf("<td><input name='duree' size=3 value=%s> minutes</td>\n",$filiere->getTempsSoutenance());
		printf("<table><tr><td><input type=submit value='Enregistrer les données'/></center></td></tr>");
		printf("</table></form></center>");
	}
}

modifier();

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>