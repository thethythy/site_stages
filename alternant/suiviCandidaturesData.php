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
  header("Content-type: text/html; charset=utf-8");


$filtresEtu = array();
$filtresOffres = array();

// Si pas d'ann�e s�lectionn�e
if (!isset($_POST['annee'])) {
  $annee = Promotion_BDD::getLastAnnee();
} else {
  $annee = $_POST['annee'];
}
array_push($filtresEtu, new FiltreNumeric("anneeuniversitaire", $annee));

// Si une recherche sur le parcours est demand�
if (!isset($_POST['parcours'])) {
  $tabParcours = Parcours::listerParcours();
  $parcours = $tabParcours[0]->getIdentifiantBDD();
} else {
  $parcours = $_POST['parcours'];
}
array_push($filtresEtu, new FiltreNumeric("idparcours", $parcours));
array_push($filtresOffres, new FiltreNumeric("idparcours", $parcours));

// Si une recherche sur la filiere est demand�e
if (!isset($_POST['filiere'])) {
  $tabFilieres = Filiere::listerFilieres();
  $filiere = $tabFilieres[0]->getIdentifiantBDD();
} else {
  $filiere = $_POST['filiere'];
}
array_push($filtresEtu, new FiltreNumeric("idfiliere", $filiere));
array_push($filtresOffres, new FiltreNumeric("idfiliere", $filiere));

$filtreEtu = $filtresEtu[0];

for ($i = 1; $i < sizeof($filtresEtu); $i++)
$filtreEtu = new Filtre($filtreEtu, $filtresEtu[$i], "AND");

$tabEtu = Promotion::listerEtudiants($filtreEtu);

$filtreOffres = $filtresOffres[0];
for ($i = 1; $i < sizeof($filtresOffres); $i++)
$filtreOffres = new Filtre($filtreOffres, $filtresOffres[$i], "AND");


if (sizeof($tabEtu) == 0){

  echo 'Aucun étudiant ne correspond à cette recherche.';


} else {
  echo "<div id='data1'>\n";
  $tabO = OffreDAlternance::getListeOffreDAlternance($filtreOffres);
  OffreDAlternance_IHM::afficherFormulaireSuivi($tabO, $tabEtu);
  echo "\n</div>";

}
?>
