<?php

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."moteur/Promotion.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');
IHM_Generale::header("Liste des", "étudiants", "../../", $tabLiens);

// Affichage du formulaire de recherche
Promotion_IHM::afficherFormulaireRecherche("listeDesEtudiantsData.php", true);

// Affichage des données
echo "<br/>";
echo "<br/>";
echo "<div id='data'>\n";
include_once("listeDesEtudiantsData.php");
echo "\n</div>";

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>