<?php
header ('Content-type:text/html; charset=utf-8');
include_once("../../classes/bdd/connec.inc");
include_once("../../classes/bdd/Competence_BDD.php");
include_once("../../classes/ihm/IHM_Generale.php");
include_once("../../classes/ihm/Competence_IHM.php");
include_once("../../classes/moteur/Competence.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Modifier une", "compétence", "../../",$tabLiens);


function modifier() {


	if(isset($_POST['label'])){
		$competence = new Competence($_POST['id'], $_POST['label']);
		Competence_BDD::sauvegarder($competence);
		printf("La compétence a été modifié ! ");	}
	else{
		$competence = Competence::getCompetence($_GET['id']);

	    printf("<h2>Modification d'une compétence</h2>");
	    printf("<center><form action='modifierCompetence.php' method=post>\n");
	    printf("<td><input type=hidden name='id' size=100 value=%s></td>\n", $competence->getIdentifiantBDD());
	    printf("<table><center><tr><td>Compétence : </td>\n");
	    printf("<td><input name='label' size=100 value=%s></td>\n", $competence->getNom());
	    printf("<table><tr><td><input type=submit value='Modifier'/></center></td></tr>");
	    printf("</table></form></center>");
	}
}



modifier();
deconnexion();
printf("<p><a href='../../gestion/entreprises/gestionCompetence.php'>Retour</a></p>");
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>