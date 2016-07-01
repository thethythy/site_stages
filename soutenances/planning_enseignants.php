<?php

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$chemin = "../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."ihm/Menu.php");
include_once($chemin."ihm/IHM_Generale.php");

include_once($chemin."ihm/Soutenance_IHM.php");
include_once($chemin."bdd/Soutenance_BDD.php");
include_once($chemin."moteur/Soutenance.php");

include_once($chemin."bdd/Parrain_BDD.php");
include_once($chemin."moteur/Parrain.php");

include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Convention.php");

include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");

include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");

include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");

include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Etudiant.php");

include_once($chemin."bdd/Salle_BDD.php");
include_once($chemin."moteur/Salle.php");

include_once($chemin."bdd/DateSoutenance_BDD.php");
include_once($chemin."moteur/DateSoutenance.php");

include_once($chemin."bdd/SujetDeStage_BDD.php");
include_once($chemin."moteur/SujetDeStage.php");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Soutenances');

IHM_Generale::header("Planning soutenance ", "par enseignants", "../",$tabLiens);

Menu::menuSoutenance();

Soutenance_IHM::afficherSelectionSoutenancesEnseignant('planning_enseignantsData.php');

// Affichage des données
echo "<div id='data'>\n";
include_once("planning_enseignantsData.php");
echo "\n</div>";

deconnexion();
IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>