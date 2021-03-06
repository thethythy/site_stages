<?php

/**
 * Page planning_enseignants.php
 * Utilisation : page de traitement Ajax retournant un planning chronologique par enseignant
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

if (!headers_sent())
    header ("Content-type:text/html; charset=utf-8");

if (isset($_POST['enseignant']) && !empty($_POST['enseignant']) && $_POST['enseignant'] != -1) {
	$parrain = Parrain::getParrain($_POST['enseignant']);

	// Recuperation de l'annee promotion (la rentrée)
	if (date('n') >= 10)
	    $annee = date('Y');
	else
	    $annee = date('Y') - 1;

	// Filtres enseignant
	$filtres = array();
	array_push($filtres, new FiltreNumeric('idparrain', $parrain->getIdentifiantBDD()));
	array_push($filtres, new FiltreNumeric('idexaminateur', $parrain->getIdentifiantBDD()));
	$filtre = $filtres[0];
	for($i=1; $i<sizeof($filtres); $i++)
	    $filtre = new Filtre($filtre, $filtres[$i], "OR");

	// Liste conventions
	$listeConvention = Convention::getListeConvention($filtre);

	// Liste contrats
	$listeContrat = Contrat::getListeContrat($filtre);

	// Fusion des deux listes
	$listeConvCont = array_merge($listeConvention, $listeContrat);

	// Tri selon l'heure de passage
	usort($listeConvCont, array("Convention", "compareHeureSoutenance"));

	// Pour chaque date soutenance
	$filtreDateSoutenance = new FiltreNumeric('annee', $annee+1);
	$listeDateSoutenance = DateSoutenance::listerDateSoutenance($filtreDateSoutenance);

	// Affichage du planning
	Parrain_IHM::afficherPlanningParrains($annee, $listeDateSoutenance, $listeConvCont);

} else
	echo "<br/><center>Veuillez sélectionner un enseignant</center>";

?>