<?php

/**
 * Page visualiserOffre.php
 * Utilisation : page de visualisation détaillée d'une offre de stage
 * Accès : restreint par cookie ; lien accessible uniquement depuis listerOffreDeStage.php
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Stagiaire');

IHM_Generale::header("Visualiser une", "offre de stage", "../", $tabLiens);

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
	OffreDeStage_IHM::visualiserOffre($offreDeStage, "./listerOffreDeStage.php", $nom, $ville, $cp, $pays, $filiere, $parcours, $duree, $competence);
    } else {
	echo "Cette offre de stage a été retirée du site.<br/>";
    }
}

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>