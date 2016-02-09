<?php

$chemin = '../../classes/';

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."bdd/ThemeDeStage_BDD.php");
include_once($chemin."bdd/Convention_BDD.php");


include_once($chemin."ihm/Entreprise_IHM.php");
include_once($chemin."ihm/Etudiant_IHM.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."ihm/ThemeDeStage_IHM.php");
include_once($chemin."ihm/Convention_IHM.php");

include_once($chemin."ihm/IHM_Generale.php");


include_once($chemin."moteur/Entreprise.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."moteur/ThemeDeStage.php");
include_once($chemin."moteur/Convention.php");

include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Statistiques", "entreprises", "../../", $tabLiens);

Promotion_IHM::afficherFormulaireSelectionAnnee(true);



$tabEntreprises = Entreprise::getListeEntreprises("");
$tabThemeDeStage = ThemeDeStage::getListeTheme();
$tabConvention = Convention::getListeConvention("");

$mans = 0;
$sarthe = 0;
$region = 0;
$france = 0;
$monde = 0;
$dep = 0;

if(sizeof($tabEntreprises)>0){
	for($i=0; $i<sizeof($tabEntreprises); $i++){
		$nom = $tabEntreprises[$i]->getNom();	
		$adresse = $tabEntreprises[$i]->getAdresse();	
		$codepostal = $tabEntreprises[$i]->getCodePostal();
		$ville = strtolower($tabEntreprises[$i]->getVille());
		$pays = strtolower($tabEntreprises[$i]->getPays());	
		$email = $tabEntreprises[$i]->getEmail();
		
		$dep = $codepostal[0].$codepostal[1];
		
		$deps = array("53","85","49","44");

		if(strstr($ville, "mans") && ($codepostal == "72000" || $codepostal == "72100") && strstr($pays, "france") ) {
			$mans++;
		}
		else if($dep == "72"  && strstr($pays, "france")  && ($codepostal != "72000" || $codepostal != "72100") ) {
			$sarthe++;
		}
		else if(in_array($dep, $deps) && strstr($pays, "france")) {
			$region++;
		}
		else if(strstr($pays, "france")) {
			$france++;
		}
		else {
			$monde++;
		}

	}
}

/*if (sizeof($tabThemeDeStage)>0){

}*/




?>