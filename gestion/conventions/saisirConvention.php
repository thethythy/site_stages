<?php

/**
 * Page saisirConvention.php
 * Utilisation : page pour saisir une nouvelle convention de stage
 * Dépendance(s) : saisirConventionData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");
include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "bdd/Contact_BDD.php");
include_once($chemin . "moteur/Contact.php");

include_once($chemin . "bdd/Convention_BDD.php");
include_once($chemin . "moteur/Convention.php");

include_once($chemin . "bdd/Entreprise_BDD.php");
include_once($chemin . "moteur/Entreprise.php");

include_once($chemin . "bdd/Couleur_BDD.php");
include_once($chemin . "moteur/Couleur.php");

include_once($chemin . "bdd/Etudiant_BDD.php");
include_once($chemin . "moteur/Etudiant.php");

include_once($chemin . "bdd/Filiere_BDD.php");
include_once($chemin . "moteur/Filiere.php");

include_once($chemin . "bdd/Parcours_BDD.php");
include_once($chemin . "moteur/Parcours.php");

include_once($chemin . "ihm/Promotion_IHM.php");
include_once($chemin . "bdd/Promotion_BDD.php");
include_once($chemin . "moteur/Promotion.php");

include_once($chemin . "bdd/Parrain_BDD.php");
include_once($chemin . "moteur/Parrain.php");

include_once($chemin . "bdd/Soutenance_BDD.php");
include_once($chemin . "moteur/Soutenance.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Saisir une", "convention", "../../", $tabLiens);

Promotion_IHM::afficherFormulaireRecherche("saisirConventionData.php", false, true);

// Affichage des données
echo "<div id='data'>\n";
include_once("saisirConventionData.php");
echo "\n</div>";

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>