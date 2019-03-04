<?php

/**
 * Page listeDesOffreDAlternance.php
 * Utilisation : page pour visualiser les offres d'alternance non-traitées et traitées
 * Dépendance(s) : listeDesOffreDAlternanceData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion');

IHM_Generale::header("Liste des", "offres d'alternance'", "../../", $tabLiens);

OffreDeStage_IHM::afficherFormulaireRecherche("listeDesOffreDAlternanceData.php");

// Affichage des données
echo "<div id='data'>\n";
include_once("listeDesOffreDAlternanceData.php");
echo "\n</div>";

?>

<?php
deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>
