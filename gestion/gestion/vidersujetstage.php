<?php

/**
 * Page vidersujetstage.php
 * Utilisation : page de suppression des anciennes demandes de validation
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion des stages');

IHM_Generale::header("Gestion de la", "base", "../../", $tabLiens);

// Vérification de la période pour exécuter cette fonction
$date = date('n');
if ($date == 9 || $date == 10) { // Il faut être entre le 1 septembre et le 31 octobre de l'année en cours
    // Suppression des anciennes validations de stage
    $tabSujet = SujetDeStage::getListeSujetDeStage("");
    foreach ($tabSujet as $sujet) {
	SujetDeStage::supprimeSujetDeStage($sujet->getIdentifiantBDD());
    }
    echo "<p>Suppression des anciens sujet de stage effectuée.</p>";
} else
    IHM_Generale::erreur("Cette fonctionnalité n'est accessible que durant le mois de Septembre et le mois d'octobre");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>