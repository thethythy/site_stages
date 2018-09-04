<?php

/**
 * Page listeDesEtudiants.php
 * Utilisation : page pour visualiser les étudiants d'une ou plusieurs promotions
 * Dépendance(s) : listeDesEtudiantsData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Liste des", "étudiants", "../../", $tabLiens);

// Traitement d'une demande de suppression définitive d'un étudiant
if (isset($_GET['id']) && isset($_GET['supprime'])) {
    // Suppression définitive de l'étudiant
    Etudiant::supprimerDefinitivementEtudiant($_GET['id']);
}

// Affichage du formulaire de recherche
Promotion_IHM::afficherFormulaireRecherche("gestionEtudiantsData.php", true);

// Affichage des données
echo "<div id='data'>\n";
include_once("gestionEtudiantsData.php");
echo "\n</div>";

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>