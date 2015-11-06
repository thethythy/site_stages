<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/OffreDeStage_BDD.php");
include_once($chemin."ihm/OffreDeStage_IHM.php");
include_once($chemin."moteur/OffreDeStage.php");
include_once($chemin."moteur/Contact.php");
include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."moteur/Entreprise.php");
include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreSuperieur.php");
include_once($chemin."moteur/FiltreInferieur.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."bdd/Competence_BDD.php");
include_once($chemin."moteur/Competence.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion');
IHM_Generale::header("Liste des", "offres de stage", "../../", $tabLiens);

OffreDeStage_IHM::afficherFormulaireRecherche("listeDesOffreDeStageData.php");

// Affichage des données
echo "<div id='data'>\n";
include_once("listeDesOffreDeStageData.php");
echo "\n</div>";

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>