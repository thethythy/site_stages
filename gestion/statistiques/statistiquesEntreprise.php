<?php

/**
 * Page statistiquesEntreprise.php
 * Utilisation : page de visualisation des statistiques par entreprise
 *		 (lieu, type d'entreprise, thème de stage)
 * Dépendance(s) : statistiquesEntrepriseData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Statistiques", "par entreprise", "../../", $tabLiens);

// Affichage du formulaire de recherche
Entreprise_IHM::afficherFormulaireRecherche("statistiquesEntrepriseData.php");

// Affichage des données
echo "<div id='data'>\n";
include_once("statistiquesEntrepriseData.php");
echo "\n</div>";

deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>
