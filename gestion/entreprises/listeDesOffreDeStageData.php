<?php

/**
 * Page listeDesOffreDeStageData.php
 * Utilisation : obtenir un tableau des offres en attente et un tableau des offres traitées
 * Accès : restreint par authentification HTTP
 */

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");

include_once($chemin . "moteur/Filtre.php");
include_once($chemin . "moteur/FiltreSuperieur.php");
include_once($chemin . "moteur/FiltreInferieur.php");
include_once($chemin . "moteur/FiltreNumeric.php");
include_once($chemin . "moteur/FiltreString.php");

include_once($chemin . "ihm/OffreDeStage_IHM.php");
include_once($chemin . "bdd/OffreDeStage_BDD.php");
include_once($chemin . "moteur/OffreDeStage.php");

include_once($chemin . "moteur/Contact.php");
include_once($chemin . "bdd/Contact_BDD.php");

include_once($chemin . "moteur/Entreprise.php");
include_once($chemin . "bdd/Entreprise_BDD.php");

include_once($chemin . "bdd/Filiere_BDD.php");
include_once($chemin . "moteur/Filiere.php");

include_once($chemin . "bdd/Parcours_BDD.php");
include_once($chemin . "moteur/Parcours.php");

include_once($chemin . "bdd/Competence_BDD.php");
include_once($chemin . "moteur/Competence.php");

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

// Prise en compte des paramètres
$filtres = array();

// Si une recherche sur le nom de l'entreprise est demandée
if (isset($_POST['nom']) && $_POST['nom'] != "")
    array_push($filtres, new FiltreString("nom", "%" . $_POST['nom'] . "%"));

// Si une recherche sur le code postal est demandée
if (isset($_POST['cp']) && $_POST['cp'] != "")
    array_push($filtres, new FiltreString("codepostal", $_POST['cp'] . "%"));

// Si une recherche sur la ville est demandée
if (isset($_POST['ville']) && $_POST['ville'] != "")
    array_push($filtres, new FiltreString("ville", $_POST['ville'] . "%"));

// Si une recherche sur le pays est demandée
if (isset($_POST['pays']) && $_POST['pays'] != "")
    array_push($filtres, new FiltreString("pays", $_POST['pays'] . "%"));

// Si une recherche sur la filiere est demandée
if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
    array_push($filtres, new FiltreNumeric("idfiliere", $_POST['filiere']));

// Si une recherche sur le parcours est demandé
if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
    array_push($filtres, new FiltreNumeric("idparcours", $_POST['parcours']));

// Si une recherche sur la filiere est demandée
if (isset($_POST['competence']) && $_POST['competence'] != '*')
    array_push($filtres, new FiltreNumeric("idcompetence", $_POST['competence']));

// Si une recherche sur la duree est demandée
if (isset($_POST['duree']) && $_POST['duree'] != '*') {
    array_push($filtres, new FiltreInferieur("dureemin", $_POST['duree']));
    array_push($filtres, new FiltreSuperieur("dureemax", $_POST['duree']));
}

if (sizeof($filtres) > 0) {
    $filtre = $filtres[0];
    for ($i = 1; $i < sizeof($filtres); $i++)
	$filtre = new Filtre($filtre, $filtres[$i], "AND");
} else
    $filtre = "";

$tabOffreDeStages = OffreDeStage::getListeOffreDeStage($filtre);

// Si il y a au moins une offre de stage à traiter
if (sizeof($tabOffreDeStages) > 0) {
    // Affichage des entreprises correspondants aux critères de recherches
    OffreDeStage_IHM::afficherListeOffresAEditer($tabOffreDeStages);
    } else {
	echo "<br/><center>Aucune offre de stage ne correspond aux critères de recherche.<center/><br/>";
    }
    ?>