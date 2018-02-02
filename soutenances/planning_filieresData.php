<?php

/**
 * Page planning_filieresData.php
 * Utilisation : page de traitement Ajax retournant un planning chronologique par filière
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$chemin = "../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/Utils.php");

include_once($chemin."bdd/Parrain_BDD.php");
include_once($chemin."moteur/Parrain.php");

include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Convention.php");

include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");

include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");

include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");

include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Etudiant.php");

include_once($chemin."bdd/Salle_BDD.php");
include_once($chemin."moteur/Salle.php");

include_once($chemin."bdd/DateSoutenance_BDD.php");
include_once($chemin."moteur/DateSoutenance.php");

include_once($chemin."bdd/Soutenance_BDD.php");
include_once($chemin."moteur/Soutenance.php");

include_once($chemin."bdd/SujetDeStage_BDD.php");
include_once($chemin."moteur/SujetDeStage.php");

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