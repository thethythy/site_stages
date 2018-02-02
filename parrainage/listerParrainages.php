<?php

/**
 * Page listerParrainages.php
 * Utilisation : page de visualisation des suivis de stages des référents
 * Dépendance(s) : listerParrainagesData.php --> traitement des requêtes Ajax
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

$chemin = "../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."ihm/IHM_Generale.php");

include_once($chemin."ihm/Parrain_IHM.php");
include_once($chemin."bdd/Parrain_BDD.php");
include_once($chemin."moteur/Parrain.php");

include_once($chemin."bdd/Couleur_BDD.php");
include_once($chemin."moteur/Couleur.php");

include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");

include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");

include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Convention.php");

include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Etudiant.php");

include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."moteur/Contact.php");

include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."moteur/Entreprise.php");

include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('index.php', 'Conventions et référents');

IHM_Generale::header("Charge des", "référents", "../", $tabLiens);

// Affichage du formulaire de recherche
Parrain_IHM::afficherFormulaireRecherche("listerParrainagesData.php");

// Affichage des données
echo "<div id='data'>\n";
include_once("listerParrainagesData.php");
echo "\n</div>";

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>