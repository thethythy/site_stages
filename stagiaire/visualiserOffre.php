<?php

include_once("../classes/bdd/connec.inc");
include_once("../classes/ihm/IHM_Generale.php");
include_once("../classes/ihm/OffreDeStage_IHM.php");
include_once("../classes/moteur/OffreDeStage.php");
include_once("../classes/bdd/OffreDeStage_BDD.php");
include_once("../classes/bdd/Filiere_BDD.php");
include_once("../classes/moteur/Filiere.php");
include_once("../classes/moteur/Filtre.php");
include_once("../classes/moteur/FiltreString.php");
include_once("../classes/moteur/Entreprise.php");
include_once("../classes/bdd/Entreprise_BDD.php");
include_once("../classes/moteur/Contact.php");
include_once("../classes/bdd/Contact_BDD.php");
include_once("../classes/bdd/Competence_BDD.php");
include_once("../classes/moteur/Competence.php");
include_once("../classes/bdd/Parcours_BDD.php");
include_once("../classes/moteur/Parcours.php");

header ("Content-type:text/html; charset=utf-8");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Stagiaire');
IHM_Generale::header("Visualiser une", "offre de stage", "../", $tabLiens);

if(isset($_GET['id'])){
	$offreDeStage = OffreDeStage::getOffreDeStage($_GET['id']);
	if ($offreDeStage->getIdentifiantBDD() > 0) {
		OffreDeStage_IHM::visualiserOffre($offreDeStage, "./listerOffreDeStage.php", $_GET['nom'], $_GET['ville'], $_GET['cp'], $_GET['pays'], $_GET['filiere'], $_GET['parcours'], $_GET['duree'], $_GET['competence']);
	}
	else {
		echo "Cette offre de stage a été retirée du site.<br/>";
	}
}

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");
?>