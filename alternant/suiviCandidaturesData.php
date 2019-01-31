<?php

/**
 * Page SuiviCandidaturesData.php
 * Utilisation : page de traitement Ajax retournant un formulaire de dépôt
 * Accès : restreint par cookie
 */

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

if (!headers_sent())
    header("Content-type:text/html; charset=utf-8");

$filtres = array();

// Si pas d'ann�e s�lectionn�e
if (!isset($_POST['annee'])) {
    $annee = Promotion_BDD::getLastAnnee();
} else {
    $annee = $_POST['annee'];
}
array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));

// Si une recherche sur le parcours est demand�
if (!isset($_POST['parcours'])) {
    $tabParcours = Parcours::listerParcours();
    $parcours = $tabParcours[0]->getIdentifiantBDD();
} else {
    $parcours = $_POST['parcours'];
}
array_push($filtres, new FiltreNumeric("idparcours", $parcours));

// Si une recherche sur la filiere est demand�e
if (!isset($_POST['filiere'])) {
    $tabFilieres = Filiere::listerFilieres();
    $filiere = $tabFilieres[0]->getIdentifiantBDD();
} else {
    $filiere = $_POST['filiere'];
}
array_push($filtres, new FiltreNumeric("idfiliere", $filiere));

$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
    $filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);

if (sizeof($tabEtudiants) > 0)
    OffreDAlternance_IHM::afficherFormulaireSuivi($tabEtudiants, $annee, $parcours, $filiere);
else {
    ?>
    <br/>
    <p>Aucun étudiant ne correspond aux critères de recherche.</p>
    <br/>
    <?php
}
?>
