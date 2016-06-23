<?php

$chemin = "../classes/";

include_once($chemin."bdd/connec.inc");

include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");

include_once($chemin."ihm/Parrain_IHM.php");
include_once($chemin."bdd/Parrain_BDD.php");
include_once($chemin."moteur/Parrain.php");

include_once($chemin."bdd/Couleur_BDD.php");
include_once($chemin."moteur/Couleur.php");

include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");

include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");

include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Convention.php");

include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Etudiant.php");

include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."moteur/Contact.php");

include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."moteur/Entreprise.php");

include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");

if (!headers_sent())
    header ("Content-type:text/html; charset=utf-8");

$filtres = array();

// Si pas d'année sélectionnée
if (!isset($_POST['annee']))
	array_push($filtres, new FiltreNumeric("anneeuniversitaire", Promotion_BDD::getLastAnnee()));

// Si une recherche sur l'année est demandée
if (isset($_POST['annee']) && $_POST['annee'] != "")
	array_push($filtres, new FiltreNumeric("anneeuniversitaire", $_POST['annee']));

// Si une recherche sur le nom du parrain est demandée
if (isset($_POST['nom']) && $_POST['nom'] != '*')
	array_push($filtres, new FiltreNumeric("idparrain", $_POST['nom']));

// Si une recherche sur la filiere est demandée
if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
	array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

// Si une recherche sur le parcours est demandé
if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
	array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));

$nbFiltres = sizeof($filtres);

if ($nbFiltres >= 2) {
	$filtre = $filtres[0];
	for ($i = 1; $i < sizeof($filtres); $i++)
		$filtre = new Filtre($filtre, $filtres[$i], "AND");
} else if ($nbFiltres == 1) {
		$filtre = $filtres[0];
} else {
	$filtre = "";
}

$tabConventions = Convention::getListeConvention($filtre);

// Afficher le résultat de la recherche
Parrain_IHM::afficherListeParrainage($tabConventions);

?>