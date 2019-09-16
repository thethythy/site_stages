<?php

/**
 * Page planning_sallesData.php
 * Utilisation : page de traitement Ajax retournant un planning chronologique par salle
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

if (!headers_sent())
    header ("Content-type:text/html; charset=utf-8");

// Recuperation de l'annee de promotion (la rentrée)
if (date('n')>=10) $annee = date('Y');
else $annee = date('Y')-1;
//$annee = 2010; // Pour tester

// Prise en compte d'une date
if (!isset($_POST['date'])) {
	$dates = DateSoutenance::listerDateSoutenance(new FiltreNumeric("annee", $annee + 1));
	if (sizeof($dates) > 0) $date = $dates[0];
} else {
	$date = DateSoutenance::getDateSoutenance($_POST['date']);
}

// Prise en compte d'une salle
if (!isset($_POST['salle'])) {
	$salles = Salle::listerSalle();
	$salle = $salles[0];
} else {
	$salle = Salle::getSalle($_POST['salle']);
}

if (isset($date) && isset($salle)) {
	// Liste des soutenances associes a la date/salle
	$listeSoutenance = Soutenance::listerSoutenanceFromSalleAndDate($salle, $date);

	// Tri des soutenances selon l'heure de passage
	usort($listeSoutenance, array("Soutenance", "compareHeureSoutenance"));

	// Liste conventions ou contrats
	$listeConvOUCont = array();
	foreach ($listeSoutenance as $sout) {
		$oConvention = Soutenance::getConvention($sout);
		$oContrat = Soutenance::getContrat($sout);
		if ($oConvention)
			array_push($listeConvOUCont, $oConvention);
		else
			array_push($listeConvOUCont, $oContrat);
	}

	// Tri selon l'heure de passage
	usort($listeConvOUCont, array("Convention", "compareHeureSoutenance"));

	// Affichage du planning
	Salle_IHM::afficherPlanningSalles($annee, $listeConvOUCont);
} else
	echo "<br/><center>Veuillez sélectionner une salle et une date.</center>";

?>
