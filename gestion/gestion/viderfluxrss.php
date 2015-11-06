<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."moteur/FluxRSS.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion des stages');
IHM_Generale::header("R�-initialisation du ", "flux RSS", "../../", $tabLiens);

// V�rification de la p�riode pour ex�cuter cette fonction
$date = date('n');
if ($date == 9 || $date == 10) { // Il faut �tre entre le 1 septembre et le 31 octobre de l'ann�e en cours
	
	// R�-initialisation du flux RSS
	if (FluxRSS::existe()) {
		if (FluxRSS::deleteFlux()) {
			FluxRSS::initialise();
			echo "<p>Le flux RSS a �t� correctement r�-initialis�.</p>";
		}
		else
			IHM_Generale::erreur("Impossible de d�truire le flux RSS.");
	}
	else
		IHM_Generale::erreur("Le flux RSS n'existe pas.");
}
else
	IHM_Generale::erreur("Cette fonctionnalit� n'est accessible que durant le mois de septembre et le mois d'octobre.");


IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>