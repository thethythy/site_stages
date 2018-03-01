<?php

/**
 * Page classementEntreprise.php
 * Utilisation : page de visualisation du classement des entreprises par nombre de stagiaires
 * Dépendance(s) : classementEntrepriseData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Top", "entreprises", "../../", $tabLiens);

// Affichage du formulaire de recherche
Promotion_IHM::afficherFormulaireRecherche("classementEntrepriseData.php", TRUE, TRUE);

// Affichage des données
echo "<div id='data'>\n";
include_once("classementEntrepriseData.php");
echo "\n</div>";

deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../");

?>
