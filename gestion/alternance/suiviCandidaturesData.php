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

$filtresEtu = array();
$filtresOffres = array();

// Si pas d'année�sélectionnée
if (!isset($_POST['annee'])) {
  $annee = Promotion_BDD::getLastAnnee();
} else {
  $annee = $_POST['annee'];
}
array_push($filtresEtu, new FiltreNumeric("anneeuniversitaire", $annee));

// Si une recherche sur le parcours est demandé
if (!isset($_POST['parcours'])) {
  $tabParcours = Parcours::listerParcours();
  $parcours = $tabParcours[0]->getIdentifiantBDD();
} else {
  $parcours = $_POST['parcours'];
}
array_push($filtresEtu, new FiltreNumeric("idparcours", $parcours));
array_push($filtresOffres, new FiltreNumeric("idparcours", $parcours));

// Si une recherche sur la filiere est demandée
if (!isset($_POST['filiere'])) {
  $tabFilieres = Filiere::listerFilieres();
  $filiere = $tabFilieres[0]->getIdentifiantBDD();
} else {
  $filiere = $_POST['filiere'];
}
array_push($filtresEtu, new FiltreNumeric("idfiliere", $filiere));
array_push($filtresOffres, new FiltreNumeric("idfiliere", $filiere));

// Filtre global pour les étudiants
$filtreGlobalEtu = $filtresEtu[0];
for ($i = 1; $i < sizeof($filtresEtu); $i++)
  $filtreGlobalEtu = new Filtre($filtreGlobalEtu, $filtresEtu[$i], "AND");

// Liste des étudiants sélectionnés
$tabEtu = Promotion::listerEtudiants($filtreGlobalEtu);

// Il faut garder uniquement les étudiants qui ont candidatés
$tabEtuSelections = array();
foreach($tabEtu as $oEtu) {
    if (Candidature::getListeCandidatures($oEtu->getIdentifiantBDD()))
	array_push($tabEtuSelections, $oEtu);
}

// Liste des offres sélectionnées
$tabOffres = array();

if (sizeof($tabEtu) > 0) {
    $tabPromos = Promotion::listerPromotions($filtreGlobalEtu);
    $filtre = array();
    foreach($tabPromos as $oPromo) {
	array_push($filtre, new FiltreNumeric("idpromotion", $oPromo->getIdentifiantBDD()));
    }

    $filtrePromos = $filtre[0];
    for ($i = 1; $i < sizeof($filtre); $i++)
	$filtrePromos = new Filtre($filtrePromos, $filtre[$i], "OR");

    $filtreGlobalOffres = $filtresOffres[0];
    for ($i = 1; $i < sizeof($filtresOffres); $i++)
	$filtreGlobalOffres = new Filtre($filtreGlobalOffres, $filtresOffres[$i],"AND");

    $filtreGlobalOffre = new Filtre($filtreGlobalOffres, $filtrePromos, "AND");

    $tabOffres = OffreDAlternance::getListeOffreDAlternance($filtreGlobalOffre);
}

// Afficher le tableau de suivi de candidature

if (sizeof($tabEtu) == 0) {
  echo '<p>Sélectionnez le diplôme et la spécialité actuels des étudiants.</p>';
  echo '<p>Aucun étudiant ne correspond aux critères.</p>';
} else {
  if (isset($_POST['idEtudiant']) && $_POST['idEtudiant'] != '*') {
    $tabEtuSelections = [Etudiant::getEtudiant($_POST['idEtudiant'])];
  }
  OffreDAlternance_IHM::afficherFormulaireSuiviGestion($tabEtu, $tabOffres, $tabEtuSelections);
}
?>
