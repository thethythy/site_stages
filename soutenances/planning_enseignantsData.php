<?php

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$chemin = "../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."moteur/Utils.php");

include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");

include_once($chemin."ihm/Parrain_IHM.php");
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

	// Listes conventions
	$listeConvention = Convention::getListeConvention($filtre);

	// Tri des conventions selon l'heure de passage
	usort($listeConvention, array("Convention", "compareHeureSoutenance"));

	// Pour chaque date soutenance
	$filtreDateSoutenance = new FiltreNumeric('annee', $annee+1);
	$listeDateSoutenance = DateSoutenance::listerDateSoutenance($filtreDateSoutenance);

	// Affichage du planning
	Parrain_IHM::afficherPlanningParrains($annee, $listeDateSoutenance, $listeConvention);

} else
	echo "<br/><center>Veuillez sélectionner un enseignant</center>";

?>