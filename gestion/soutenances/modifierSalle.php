<?php 
include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/Salle_BDD.php");
include_once("../../classes/moteur/Salle.php");
include_once("../../classes/ihm/IHM_Generale.php");
include_once("../../classes/ihm/Salle_IHM.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Modifier/supprimer une ", "salle", "../../", $tabLiens);

Salle_IHM::afficherFormulaireModification();

function modifier(){
	global $tab16;
	if(isset($_POST['salle']) && $_POST['salle']!=-1){
		$element=$_POST['salle'];
	
		$salle=Salle::getSalle($element);
		printf("<h2>Modification d'une salle</h2>");
		printf("<center><form action='../../gestion/soutenances/modSalle.php' method=post name=par>\n");
		printf("<td><input type=hidden name='id' size=100 value=%s></td>\n",$salle->getIdentifiantBDD());
		printf("<table><center><tr><td>Nom : </td>\n");
		printf("<td><input name='nom' size=100 value=%s></td>\n",$salle->getNom());
		printf("<table><tr><td><input type=submit value='Enregistrer les données'/></center></td></tr>");
		printf("</table></form></center>");
	}
}

modifier();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>