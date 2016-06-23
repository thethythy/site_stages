<?php

$chemin = "../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");

include_once($chemin."ihm/Salle_IHM.php");
include_once($chemin."bdd/Salle_BDD.php");
include_once($chemin."moteur/Salle.php");

include_once($chemin."bdd/Parrain_BDD.php");
include_once($chemin."moteur/Parrain.php");

include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Convention.php");

include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");

include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");

include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");

include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Etudiant.php");

include_once($chemin."bdd/DateSoutenance_BDD.php");
include_once($chemin."moteur/DateSoutenance.php");

include_once($chemin."bdd/Soutenance_BDD.php");
include_once($chemin."moteur/Soutenance.php");

include_once($chemin."bdd/SujetDeStage_BDD.php");
include_once($chemin."moteur/SujetDeStage.php");


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

	// Liste conventions
	$listeConvention = array();
	foreach ($listeSoutenance as $sout)
		array_push($listeConvention, Soutenance::getConvention($sout));

	// Tri des conventions selon l'heure de passage
	usort($listeConvention, array("Convention", "compareHeureSoutenance"));

	// Affichage du plannging
	Salle_IHM::afficherPlanningSalles($annee, $listeConvention);
} else
	echo "<br/><center>Veuillez sélectionner une salle et une date.</center>";

?>
