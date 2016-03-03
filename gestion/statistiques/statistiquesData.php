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

function lieuDuStage($convention) {
	$mans = 0;
	$sarthe = 0;
	$region = 0;
	$france = 0;
	$monde = 0;
	$dep = 0;

	if(sizeof($convention)>0) {
		for ($i=0; $i<sizeof($convention); $i++){
			$entreprise = $convention[$i]->getEntreprise();

			$nom = $entreprise->getNom();	
			$adresse = $entreprise->getAdresse();	
			$codepostal = $entreprise->getCodePostal();
			$ville = strtolower($entreprise->getVille());
			$pays = strtolower($entreprise->getPays());	
			$email = $entreprise->getEmail();
			$typeentrepriseM1 = $entreprise->getType();

			if (strlen($codepostal) == 5) 
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

	$tabLieu = array(
		'Le Mans' => $mans,
		'Sarthe (Hors Le Mans)' => $sarthe,
		'Pays de la Loire (Hors Sarthe)' => $region,
		'France (Hors Pays de la Loire)' => $france,
		'Etranger (Hors France)' => $monde
		);

	return $tabLieu;
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