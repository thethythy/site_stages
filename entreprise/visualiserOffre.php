<?php

/**
 * Page visualiserOffre.php
 * Utilisation : page pour visualiser une offre de stage
 * Accès : public mais le lien est uniquement connu par envoi de mail aux entreprises
 */

$chemin = "../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."ihm/IHM_Generale.php");

include_once($chemin."ihm/OffreDeStage_IHM.php");
include_once($chemin."moteur/OffreDeStage.php");
include_once($chemin."bdd/OffreDeStage_BDD.php");

include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");

include_once($chemin."moteur/Entreprise.php");
include_once($chemin."bdd/Entreprise_BDD.php");

include_once($chemin."moteur/Contact.php");
include_once($chemin."bdd/Contact_BDD.php");

include_once($chemin."bdd/Competence_BDD.php");
include_once($chemin."moteur/Competence.php");

include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Entreprise');

IHM_Generale::header("Visualiser une", "offre de stage", "../", $tabLiens);

// On visualise une offre si l'identifiant est positionnné et qu'il correspond
// bien à une offre existante dans la base

if (isset($_GET['id'])) {
    $offreDeStage = OffreDeStage::getOffreDeStage($_GET['id']);
    if ($offreDeStage->getIdentifiantBDD() > 0) {
	$nom = isset($_GET['nom']) ? $_GET['nom'] : "";
	$ville = isset($_GET['ville']) ? $_GET['ville'] : "";
	$cp = isset($_GET['cp']) ? $_GET['cp'] : "";
	$pays = isset($_GET['pays']) ? $_GET['pays'] : "";
	$filiere = isset($_GET['filiere']) ? $_GET['filiere'] : "";
	$parcours = isset($_GET['parcours']) ? $_GET['parcours'] : "";
	$duree = isset($_GET['duree']) ? $_GET['duree'] : "";
	$competence = isset($_GET['competence']) ? $_GET['competence'] : "";
	OffreDeStage_IHM::visualiserOffre($offreDeStage, "../index.php", $nom, $ville, $cp, $pays, $filiere, $parcours, $duree, $competence);
    } else {
	echo "Cette offre de stage a été retirée du site.<br/>";
    }
}

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>