<?php

$tabCptTheme = array();
for ($i=0; $i<sizeof($tabListeTheme); $i++) {
	$tabCptTheme[$tabListeTheme[$i]->getIdTheme()] = 0;
}

$tabCptTypeEntreprise = array();
for ($i=0; $i<sizeof($tabListeType); $i++) {
	$tabCptTypeEntreprise[$tabListeType[$i]->getIdentifiantBDD()] = 0;
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

function typeEntreprise($convention) {
	$tabentreprise = array();
	if (sizeof($convention)>0) {
		for ($i=0; $i<sizeof($convention); $i++) {
			$tabentreprise[$i] = $convention[$i]->getEntreprise()->getType();
		}
	}
	return $tabentreprise;
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