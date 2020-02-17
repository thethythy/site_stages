<?php

/**
 * Page SuiviCandidaturesData.php
 * Utilisation : page de traitement Ajax retournant un formulaire de dépôt
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

// ----------------------------------------------------------------------------
// Construction des filtres

$filtresEtu = array();
$filtresOffres = array();
$filtrePromo = array();

// Si pas d'année�sélectionnée
if (!isset($_POST['annee'])) {
    $annee = Promotion_BDD::getLastAnnee();
} else {
    $annee = $_POST['annee'];
}
array_push($filtresEtu, new FiltreNumeric("anneeuniversitaire", $annee));
array_push($filtrePromo, new FiltreNumeric("anneeuniversitaire", $annee));

// Si une recherche sur le parcours est demandé
if (!isset($_POST['parcours'])) {
    $tabParcours = Parcours::listerParcours();
    $parcours = $tabParcours[0]->getIdentifiantBDD();
} else {
    $parcours = $_POST['parcours'];
}
array_push($filtresEtu, new FiltreNumeric("idparcours", $parcours));

// Si une recherche sur la filiere est demandée
if (!isset($_POST['filiere'])) {
    $tabFilieres = Filiere::listerFilieres();
    $filiere = $tabFilieres[0]->getIdentifiantBDD();
} else {
    $filiere = $_POST['filiere'];
}
array_push($filtresEtu, new FiltreNumeric("idfiliere", $filiere));

// ----------------------------------------------------------------------------
// Sélection des offres pour la filière de l'année suivante

$oFiliere = Filiere::getFiliere($filiere);
$filiere = $oFiliere->getIdFiliereSuivante();

array_push($filtrePromo, new FiltreNumeric("idfiliere", $filiere));

$filtre = $filtrePromo[0];
for ($i = 1; $i < sizeof($filtrePromo); $i++)
    $filtre = new Filtre($filtre, $filtrePromo[$i], "AND");

$oPromotions = Promotion::listerPromotions($filtre);
if (sizeof($oPromotions) > 0) {
    $filtre = new FiltreNumeric("idpromotion", $oPromotions[0]->getIdentifiantBDD());
    for ($i = 1; $i < sizeof($oPromotions); $i++)
	$filtre = new Filtre($filtre, new FiltreNumeric("idpromotion", $oPromotions[$i]->getIdentifiantBDD()), "OR");
    array_push($filtresOffres, $filtre);
}

$filtreOffres = $filtresOffres[0];
for ($i = 1; $i < sizeof($filtresOffres); $i++)
    $filtreOffres = new Filtre($filtreOffres, $filtresOffres[$i], "AND");

// ----------------------------------------------------------------------------
// Sélection des étudiants qui ont candidaté

$filtreGlobalEtu = $filtresEtu[0];
for ($i = 1; $i < sizeof($filtresEtu); $i++)
    $filtreGlobalEtu = new Filtre($filtreGlobalEtu, $filtresEtu[$i], "AND");

// Liste des étudiants sélectionnés
$tabEtu = Promotion::listerEtudiants($filtreGlobalEtu);

// Il faut garder uniquement les étudiants qui ont candidatés
$tabEtuSelections = array();
foreach ($tabEtu as $oEtu) {
    if (Candidature::getListeCandidatures($oEtu->getIdentifiantBDD()))
	array_push($tabEtuSelections, $oEtu);
}

// ----------------------------------------------------------------------------
// Afficher le tableau de suivi de candidature

if (sizeof($tabEtu) == 0) {
    echo '<p>Sélectionnez le diplôme et la spécialité actuels des étudiants.</p>';
    echo '<p>Aucun étudiant ne correspond aux critères.</p>';
} else {
    if (isset($_POST['idEtudiant']) && $_POST['idEtudiant'] != '*') {
	$tabEtuSelections = [Etudiant::getEtudiant($_POST['idEtudiant'])];
    }
    $tabO = OffreDAlternance::getListeOffreDAlternance($filtreOffres);
    OffreDAlternance_IHM::afficherFormulaireSuiviGestion($tabEtu, $tabO, $tabEtuSelections);
}
?>
