<?php

$chemin = '../../classes/';

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."bdd/ThemeDeStage_BDD.php");
include_once($chemin."bdd/TypeEntreprise_BDD.php");


include_once($chemin."ihm/Entreprise_IHM.php");
include_once($chemin."ihm/Etudiant_IHM.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."ihm/Contact_IHM.php");
include_once($chemin."ihm/Convention_IHM.php");
include_once($chemin."ihm/ThemeDeStage_IHM.php");
include_once($chemin."ihm/IHM_Generale.php");


include_once($chemin."moteur/Entreprise.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."moteur/Contact.php");
include_once($chemin."moteur/ThemeDeStage.php");
include_once($chemin."moteur/TypeEntreprise.php");
include_once($chemin."moteur/Convention.php");

include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");


$tabCptTheme = array();
for ($i=0; $i<sizeof($tabListeTheme); $i++) {
	$tabCptTheme[$tabListeTheme[$i]->getIdTheme()] = 0;
}



function themeDeStage($convention) {
	$tabtheme = array();
	if (sizeof($convention)>0) {
		for ($i=0; $i<sizeof($convention); $i++) {
			$tabtheme[$i] = $convention[$i]->getTheme();
		}
	}
	return $tabtheme;
}




//recuperer une année universitaire
//construire un filtre selon la bonne année universitaire

function recupererDonneeM1($annee) {
	$parcoursISI = "9";
	$filiereMaster1 = "4";

	$filtreAnnee = new FiltreString('anneeuniversitaire', $annee);
	$filtreFiliere1 = new FiltreNumeric('idfiliere', $filiereMaster1);

	$filtreM1 = new Filtre($filtreAnnee, $filtreFiliere1, "AND");

	// recuperation de liste de convention
	$filtreConventionM1 = new Filtre($filtreAnnee, $filtreFiliere1, "AND");
	$conventionM1 = Convention::getListeConvention($filtreConventionM1);

	// get type possible
	$tabtype = TypeEntreprise::getListeTypeEntreprise("");
	if( ($taille=sizeof($tabtype))>0) {

	}

	return $conventionM1;

}

function recupererDonneeM2($annee) {
	$parcoursISI = "9";
	$filiereMaster2 = "1";

	$filtreAnnee = new FiltreString('anneeuniversitaire', $annee);
	$filtreFiliere2 = new FiltreNumeric('idfiliere', $filiereMaster2);

	$filtreM2 = new Filtre($filtreAnnee, $filtreFiliere2, "AND");


	$filtreConventionM2 = new Filtre($filtreAnnee, $filtreFiliere2, "AND");
	$conventionM2 = Convention::getListeConvention($filtreConventionM2);

	// get type possible
	$tabtype = TypeEntreprise::getListeTypeEntreprise("");
	if( ($taille=sizeof($tabtype))>0) {

	}
	return $conventionM2;
}