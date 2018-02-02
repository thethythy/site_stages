<?php

/**
 * Page planning_salles.php
 * Utilisation : page de visualisation du planning par salle
 * Dépendance(s) : planning_sallesData.php --> traitement des requêtes Ajax
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$chemin = "../classes/";

include_once($chemin."bdd/connec.inc");

include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/Utils.php");

include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Menu.php");

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

IHM_Generale::header("Planning soutenance ", "par salles", "../",$tabLiens);

Menu::menuSoutenance();

// Recuperation de l'annee promotion (la rentrée)
if (date('n')>=10)
    $annee = date('Y');
else
    $annee = date('Y')-1;

Soutenance_IHM::afficherSelectionSoutenancesSalle($annee, "planning_sallesData.php");

// Affichage des données
echo "<br/>";
echo "<div id='data'>\n";
include_once("planning_sallesData.php");
echo "\n</div>";

deconnexion();
IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>