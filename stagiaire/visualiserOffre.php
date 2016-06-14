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
	echo "Cette offre de stage a �t� retir�e du site.<br/>";
    }
}

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");
?>