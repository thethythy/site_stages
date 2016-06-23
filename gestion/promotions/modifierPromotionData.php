<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."moteur/Utils.php");

include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");

include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");

include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Etudiant.php");

include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");

include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
	header("Content-type: text/html; charset=utf-8");

// Si une suppression d'un étudiant ou une modification de l'email a été effectuée
if (isset($_POST['email']) || isset($_GET['id'])) {
	$annee = $_POST['annee'];
	$parcours = $_POST['parcours'];
	$filiere = $_POST['filiere'];
} else {
	if (!isset($_POST['annee']))
		$annee = Promotion_BDD::getLastAnnee();
	else
		$annee = $_POST['annee'];

	if (!isset($_POST['parcours'])) {
		$tabParcours = Parcours::listerParcours();
		$parcours = $tabParcours[0]->getIdentifiantBDD();
	} else
		$parcours = $_POST['parcours'];

	if (!isset($_POST['filiere'])) {
		$tabFilieres = Filiere::listerFilieres();
		$filiere = $tabFilieres[0]->getIdentifiantBDD();
	} else
		$filiere = $_POST['filiere'];
}

$filtres = array();
array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));
array_push($filtres, new FiltreNumeric("idparcours", $parcours));
array_push($filtres, new FiltreNumeric("idfiliere", $filiere));

$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);
$tabPromos = Promotion_BDD::getListePromotions($filtre);

Promotion_IHM::afficherListeEtudiantsAEditer($tabPromos, $tabEtudiants);

?>