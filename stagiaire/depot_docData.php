<?php

$chemin = "../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."moteur/Utils.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Etudiant_IHM.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."moteur/SujetDeStage.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."moteur/Parrain.php");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."bdd/Parrain_BDD.php");

header ("Content-type:text/html; charset=utf-8");

$filtres = array();

// Si pas d'année sélectionnée
if (!isset($_POST['annee'])) {
	$annee = Promotion_BDD::getLastAnnee();
} else {
	$annee = $_POST['annee'];
}
array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));

// Si une recherche sur le parcours est demandé
if (!isset($_POST['parcours'])) {
	$tabParcours = Parcours::listerParcours();
	$parcours = $tabParcours[0]->getIdentifiantBDD();
} else {
	$parcours = $_POST['parcours'];
}
array_push($filtres, new FiltreNumeric("idparcours", $parcours));

// Si une recherche sur la filiere est demandée
if (!isset($_POST['filiere'])) {
	$tabFilieres = Filiere::listerFilieres();
	$filiere = $tabFilieres[0]->getIdentifiantBDD();
} else {
	$filiere = $_POST['filiere'];
}
array_push($filtres, new FiltreNumeric("idfiliere", $filiere));

$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);

if (sizeof($tabEtudiants) > 0) 
	Etudiant_IHM::afficherFormulaireDepot($tabEtudiants, $annee, $parcours, $filiere);
else {
	?>
		<br/>
			<p>Aucun étudiant ne correspond aux critères de recherche.</p>
		<br/>
	<?php
}

?>