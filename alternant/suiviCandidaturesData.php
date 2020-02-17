<?php

/**
 * Page SuiviCandidaturesData.php
 * Utilisation : page de traitement Ajax retournant un formulaire de dépôt
 * Accès : restreint par cookie
 */

$access_control_target = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");

include_once('../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level1');

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

// Si une recherche sur le parcours est demandée
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
// Il faut sélectionner les offres pour la filière de l'année suivante

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
// La liste des étudiants sélectionnés

$filtreEtu = $filtresEtu[0];
for ($i = 1; $i < sizeof($filtresEtu); $i++)
    $filtreEtu = new Filtre($filtreEtu, $filtresEtu[$i], "AND");

$tabEtu = Promotion::listerEtudiants($filtreEtu);

// ----------------------------------------------------------------------------
// Afficher le tableau de suivi de candidature

if (sizeof($tabEtu) == 0) {
    echo '<p>Sélectionnez votre diplôme et votre spécialité actuels</p>';
    echo '<p>Aucun étudiant ne correspond aux critères de sélection.</p>';
} else {
    echo "<div id='data1'>\n";
    $tabO = OffreDAlternance::getListeOffreDAlternance($filtreOffres);
    OffreDAlternance_IHM::afficherFormulaireSuivi($tabO, $tabEtu);
    echo "\n</div>";
}
?>
