<?php

/**
 * Page visualiserOffre.php
 * Utilisation : page pour visualiser une offre de stage
 * Accès : public mais le lien est uniquement connu par envoi de mail aux entreprises
 */

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Entreprise');

IHM_Generale::header("Visualiser une", "offre de stage", "../", $tabLiens);

// On visualise une offre si l'identifiant est positionnné et qu'il correspond
// bien à une offre existante dans la base

if (isset($_GET['id']) && isset($_GET['type'])) {
    if($_GET['type'] == 'alt'){
      $offre = OffreDAlternance::getOffreDAlternance($_GET['id']);

    } else {
      $offre = OffreDeStage::getOffreDeStage($_GET['id']);
    }
    if ($offre->getIdentifiantBDD() > 0) {
    	$nom = isset($_GET['nom']) ? $_GET['nom'] : "";
    	$ville = isset($_GET['ville']) ? $_GET['ville'] : "";
    	$cp = isset($_GET['cp']) ? $_GET['cp'] : "";
    	$pays = isset($_GET['pays']) ? $_GET['pays'] : "";
    	$filiere = isset($_GET['filiere']) ? $_GET['filiere'] : "";
    	$parcours = isset($_GET['parcours']) ? $_GET['parcours'] : "";
    	$duree = isset($_GET['duree']) ? $_GET['duree'] : "";
    	$competence = isset($_GET['competence']) ? $_GET['competence'] : "";
      $siret = isset($_GET['siret']) ? $_GET['siret'] : "";
	    OffreDeStage_IHM::visualiserOffre($offre, "../index.php", $nom, $ville, $cp, $pays, $filiere, $parcours, $duree, $competence, $siret);
    } else {
	     echo "Cette offre de stage a été retirée du site.<br/>";
    }
}

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>