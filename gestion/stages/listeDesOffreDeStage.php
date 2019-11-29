<?php

/**
 * Page listeDesOffreDeStage.php
 * Utilisation : page pour visualiser les offres de stages non-traitées et traitées
 * Dépendance(s) : listeDesOffreDeStageData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion');

IHM_Generale::header("Liste des", "offres de stage", "../../", $tabLiens);

OffreDeStage_IHM::afficherFormulaireRecherche("listeDesOffreDeStageData.php");

// Affichage des données
echo "<div id='data'>\n";
include_once("listeDesOffreDeStageData.php");
echo "\n</div>";

?>

<?php
deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>