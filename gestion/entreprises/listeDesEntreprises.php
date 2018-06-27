<?php

/**
 * Page listeDesEntreprises.php
 * Utilisation : page pour visualiser les entreprises selon un filtre de sélection
 * Dépendance(s) : listeDesEntreprisesData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Liste des", "entreprises", "../../", $tabLiens);

Entreprise_IHM::afficherFormulaireRecherche("listeDesEntreprisesData.php");

// Affichage des données
echo "<div id='data'>\n";
include_once("listeDesEntreprisesData.php");
echo "\n</div>";

deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>