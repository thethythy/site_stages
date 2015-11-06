<?php>

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."moteur/SujetDeStage.php");
include_once($chemin."bdd/SujetDeStage_BDD.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion des stages');
IHM_Generale::header("Gestion de la", "base", "../../", $tabLiens);

// V�rification de la p�riode pour ex�cuter cette fonction
$date = date('n');
if ($date == 9 || $date == 10) { // Il faut �tre entre le 1 septembre et le 31 octobre de l'ann�e en cours
	
	// Suppression des anciennes validations de stage
	$tabSujet = SujetDeStage::getListeSujetDeStage("");
	foreach ($tabSujet as $sujet) {
		SujetDeStage::supprimeSujetDeStage($sujet->getIdentifiantBDD());
	}
	echo "<p>Suppression des anciens sujet de stage effectu�e.</p>";
}
else
	IHM_Generale::erreur("Cette fonctionnalit� n'est accessible que durant le mois de Septembre et le mois d'octobre");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>