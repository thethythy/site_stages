<?php

/**
 * Page getDatesJSON.php
 * Utilisation : page pour obtenir une flux JSON des périodes de soutenances
 *		 page appelée par planifier_compresse.js
 * Accès : restreint par authentification HTTP
 */

include_once("../../../classes/bdd/connec.inc");

include_once('../../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level3');

// En-tête du flux JSON
header("Content-type: application/json; charset=utf-8");

// Récupération des dates de soutenance de l'année sélectionnée
if (isset($_GET["annee"])) $annee = $_GET["annee"] + 1 ; else $annee = Promotion_BDD::getLastAnnee() + 1;
$filtre_annee = new FiltreNumeric("annee", $annee);
$tabDates = DateSoutenance::listerDateSoutenance($filtre_annee);

if (sizeof($tabDates) > 0) {

	$dates = array();
	$nom_periode = 'Période';
	$num_periode = 0;
	$old_date = 0;
	$date = array();
	$duree = 0;

	for ($i = 0 ; $i < sizeof($tabDates); $i++) {

		$mois = $tabDates[$i]->getMois();
		$jour = $tabDates[$i]->getJour();

		$new_date = strtotime($annee."-".$mois."-".$jour);

		// Calcul de l'intervalle de jour entre deux dates
		if ($old_date == 0) {
			$intervalle = 0;
		} else {
			$intervalle = round(abs($new_date - $old_date)/60/60/24);
		}

		// On continue la période ou on commence une nouvelle période ?
		if ( $intervalle <= 1 )  {
			// Même période
			$duree++;
			$date["duree"] = $duree;
			if ($intervalle == 0) {
				$date["annee"] = $annee;
				$date["mois"] = $mois - 1;
				$date["jour"] = $jour;
			}
		} else {
			// Ajout période précédente
			$num_periode++;
			$date["nom"] = $nom_periode.$num_periode;
			array_push($dates, $date);

			// Nouvelle période
			$duree = 1;
			$date = array();
			$date["annee"] = $annee;
			$date["mois"] = $mois - 1;
			$date["jour"] = $jour;
			$date["duree"] = $duree;
		}

		$old_date = $new_date;
	}

	if ($duree >= 1) {
	    $num_periode++;
	    $date["nom"] = $nom_periode.$num_periode;
	    array_push($dates, $date);
	}

	// Encodage en JSON puis envoie du flux
	print(json_encode($dates));
}

?>
