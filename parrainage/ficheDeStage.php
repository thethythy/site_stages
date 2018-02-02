<?php

/**
 * Page ficheDeStage.php
 * Utilisation : page de visualisation d'une fiche de stage
 * Accès : restreint par cookie ; accès depuis la page listerParrainages.php
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$chemin = "../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Stage_IHM.php");

include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."moteur/Contact.php");

include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Convention.php");

include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."moteur/Entreprise.php");

include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Etudiant.php");

include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");

include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");

include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");

include_once($chemin."bdd/Parrain_BDD.php");
include_once($chemin."moteur/Parrain.php");

include_once($chemin."bdd/Couleur_BDD.php");
include_once($chemin."moteur/Couleur.php");

include_once($chemin."bdd/Soutenance_BDD.php");
include_once($chemin."moteur/Soutenance.php");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('index.php', 'Conventions et référents');
$tabLiens[2] = array('listerParrainages.php', 'Charge des référents');

IHM_Generale::header("Fiche de", "stage", "../", $tabLiens);

Stage_IHM::afficherFicheStage($_GET['idEtu'], $_GET['idPromo'], "../documents/resumes/");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>