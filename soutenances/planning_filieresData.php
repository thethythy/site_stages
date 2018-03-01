<?php

/**
 * Page planning_filieresData.php
 * Utilisation : page de traitement Ajax retournant un planning chronologique par filière
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

if (!headers_sent())
    header ("Content-type:text/html; charset=utf-8");

if (!isset($_POST['promotion'])) {
	if (date('n')>=10) $annee = date('Y');
	else $annee = date('Y')-1;
	//$annee = 2010; // Pour tester

	// Liste promotion de l'année
	$filtrePromotion = new FiltreNumeric('anneeuniversitaire', $annee);
	$tabPromotion = Promotion::listerPromotions($filtrePromotion);
	$promotion = $tabPromotion[0];

} else {
	$promotion = Promotion::getPromotion($_POST['promotion']);
}

if (isset($promotion)) {
	$annee = $promotion->getAnneeUniversitaire();

	// Listes conventions
	$filtreConvention = new FiltreNumeric($tab19.'.idpromotion', $promotion->getIdentifiantBDD());
	// Listes conventions
	$listeConvention = Convention::getListeConvention($filtreConvention);

	// Tri des conventions selon l'heure de passage
	usort($listeConvention, array("Convention", "compareHeureSoutenance"));

	// Pour chaque date soutenance
	$filtreDateSoutenance = new FiltreNumeric('annee', $annee+1);
	$listeDateSoutenance = DateSoutenance::listerDateSoutenance($filtreDateSoutenance);

	// Affichage du planning
	Promotion_IHM::afficherPlanningPromotions($promotion, $listeDateSoutenance, $listeConvention);
} else
	echo "<br/><center>Veuillez sélectionner une promotion.</center>";

?>