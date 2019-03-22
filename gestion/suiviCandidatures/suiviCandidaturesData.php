<?php

/**
* Page SuiviCandidaturesData.php
* Utilisation : page de traitement Ajax retournant un formulaire de dépôt
* Accès : restreint par cookie
*/


include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

if (!headers_sent())
  header("Content-type: text/html; charset=utf-8");

$filtresEtu = array();

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

// Si une recherche sur la filiere est demand�e
if (!isset($_POST['filiere'])) {
  $tabFilieres = Filiere::listerFilieres();
  $filiere = $tabFilieres[0]->getIdentifiantBDD();
} else {
  $filiere = $_POST['filiere'];
}
array_push($filtresEtu, new FiltreNumeric("idfiliere", $filiere));

$filtreEtu = $filtresEtu[0];

for ($i = 1; $i < sizeof($filtresEtu); $i++)
$filtreEtu = new Filtre($filtreEtu, $filtresEtu[$i], "AND");

$tabEtu = Promotion::listerEtudiants($filtreEtu);


if (sizeof($tabEtu) == 0){

  echo 'Aucun étudiant ne correspond à cette recherche.';


} else {
  echo "<div id='data1'>\n";
  if(isset($_POST['idEtudiant']) && $_POST['idEtudiant'] != '*'){
    $tabC = Candidature::getListeCandidatures($_POST['idEtudiant']);
  } else {
    $tabC = Candidature::getCandidaturesEtudiant($tabEtu);
  }
  if(!is_array($tabC)){
    echo "Il ny'a pas de candidature qui réponde aux critères.";
  } else {
  OffreDAlternance_IHM::afficherFormulaireSuiviGestion($tabC, $tabEtu);
}

  echo "\n</div>";

}
?>

<script> setColor() </script>
