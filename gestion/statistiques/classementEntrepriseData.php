<?php

/**
* Page classementEntrepriseData.php
* Utilisation : page de traitement Ajax retournant un tableau de classement
*		 des entreprises par nombre de stagiaire
*		 les fiches de stage sont accessibles
* Accès : restreint par authentification HTTP
*/

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
header('Content-type: text/html; charset=utf-8');

// -----------------------------------------------------------------------------
// Création des filtres



$filtres = array();


if (isset($_POST['annee_deb']))
array_push($filtres, new FiltreSuperieur('anneeuniversitaire', $_POST['annee_deb']));


if (isset($_POST['annee_fin']))
array_push($filtres, new FiltreInferieur('anneeuniversitaire', $_POST['annee_fin']));


if (isset($_POST['parcours']) && $_POST['parcours'] != '*')
array_push($filtres, new FiltreNumeric('idparcours', $_POST['parcours']));


if (isset($_POST['filiere']) && $_POST['filiere'] != '*')
array_push($filtres, new FiltreNumeric('idfiliere', $_POST['filiere']));


if (count($filtres) > 0) {
  $filtre = $filtres[0];
  for ($i = 1; $i < sizeof($filtres); $i++)
  $filtre = new Filtre($filtre, $filtres[$i], 'AND');
} else {
  $filtre = "";
}

if(isset($_POST['offre'])){
  if ($_POST['offre'] === 'Stage')
  $displayFlag = 0;
  else if($_POST['offre'] === 'Alternance')
  $displayFlag = 1;
  else
  $displayFlag = 2;
}
echo $displayFlag;

// -----------------------------------------------------------------------------
// Affichage des données

function trouveEmailEntreprise($oEntreprise) {
  $email = $oEntreprise->getEmail();

  if ($email == '' || $email == NULL) {
    $email = 'Pas d\'email connu';
  }

  return $email;
}

if (isset($_POST['annee_deb']) && $_POST['annee_deb'] != '' && isset($_POST['annee_fin']) && $_POST['annee_fin'] != ''){
  $tabOContrats = Contrat::getListeContrat($filtre);
  $tabOConventions = Convention::getListeConvention($filtre);
}
else{
  $tabOContrats = array();
  $tabOConventions = array();
}

$tabData = array();
if (sizeof($tabOConventions) > 0) {
  // Création du tableau des données
  foreach ($tabOConventions as $oConvention) {
    $idEntreprise = $oConvention->getEntreprise()->getIdentifiantBDD();
    $idPromotionCV = $oConvention->getPromotion()->getIdentifiantBDD();

    $tabData[$idEntreprise]['nbConventions']++;
    $tabData[$idEntreprise]['promotions'][$idPromotionCV]++;
    $tabData[$idEntreprise]['promotions']['conventions'][$idPromotionCV][$oConvention->getIdentifiantBDD()] = $oConvention;
  }
}

if(sizeof($tabOContrats) > 0){
  foreach ($tabOContrats as $oContrat) {
    $idEntreprise = $oContrat->getEntreprise()->getIdentifiantBDD();
    $idPromotionCN = $oContrat->getPromotion()->getIdentifiantBDD();

    $tabData[$idEntreprise]['nbContrats']++;
    $tabData[$idEntreprise]['promotions'][$idPromotionCN]++;
    $tabData[$idEntreprise]['promotions']['contrats'][$idPromotionCN][$oContrat->getIdentifiantBDD()] = $oContrat;
  }
}


// Fonction de comparaison pour le tri sur le nombre de conventions, contrats ou les deux
switch($displayFlag){
  case 0:
  function cmp1($a, $b) {
    if ($a['nbConventions'] == $b['nbConventions']) return 0;
    return ($a['nbConventions'] > $b['nbConventions']) ? -1 : 1;
  }
  break;
  case 1:
  function cmp1($a, $b) {
    if ($a['nbContrats'] == $b['nbContrats']) return 0;
    return ($a['nbContrats'] > $b['nbContrats']) ? -1 : 1;
  }
  break;
  case 2:
  function cmp1($a, $b) {
    if ( ($a['nbConventions']+$a['nbContrats']) == ($b['nbConventions']+$b['nbContrats']) ) return 0;
    return (($a['nbConventions']+$a['nbContrats']) > ($b['nbConventions']+$b['nbContrats'])) ? -1 : 1;
  }
  break;
}

// Fonction de comparaison pour le tri sur les promotions
function cmp2($a, $b) {
  $a1 = Promotion::getPromotion($a)->anneeUniversitaire;
  $a2 = Promotion::getPromotion($b)->anneeUniversitaire;

  if ($a1 == $a2) return 0;
  return ($a1 > $a2) ? -1 : 1;
}

// Tri du tableau des données
uasort($tabData, 'cmp1');
foreach ($tabData as $key => $value) {
  uksort($tabData[$key]['promotions']['conventions'], 'cmp2');
}


// Affichage du tableau trié
echo "Nombre d'entreprises sélectionnées : ".sizeof($tabData)."<p/>";
switch($displayFlag){
  case 0:
  echo '<table>
  <tr id="entete">
  <td width="40%">Entreprise</td>
  <td width="10%">Stagiaire(s)</td>
  <td width="60%">Stage(s)</td>
  </tr>';
  break;
  case 1:
  echo '<table>
  <tr id="entete">
  <td width="40%">Entreprise</td>
  <td width="10%">Alternants(s)</td>
  <td width="60%">Alternance(s)</td>
  </tr>';
  break;
  case 2:
  echo '<table>
  <tr id="entete">
  <td width="30%">Entreprise</td>
  <td width="5%">Stagiaire(s)</td>
  <td width="30%">Stage(s)</td>
  <td width="5%">Alternants(s)</td>
  <td width="30%">Alternance(s)</td>
  </tr>';
  break;
}


$i = 0; // Pour l'affichage de couleur alterné
foreach ($tabData as $key => $value) {
  if( ($displayFlag == 0 && $tabData[$key]['nbConventions'] != 0) || ($displayFlag == 1 && $tabData[$key]['nbContrats'] != 0) || ($displayFlag == 2)){
    echo '<tr class="ligne' . $i%2 . '">';

    // L'entreprise
    $oEntreprise = Entreprise::getEntreprise($key);
    echo '<td>';
    echo $oEntreprise->getNom() . '<br/>';
    echo $oEntreprise->getAdresse() . '<br/>';
    echo $oEntreprise->getCodePostal() . '&nbsp;';
    echo $oEntreprise->getVille() . '<br/>';
    echo trouveEmailEntreprise($oEntreprise);
    echo '</td>';

    if($displayFlag == 0 || $displayFlag == 2){
      if(($displayFlag == 2) && ($tabData[$key]['nbConventions'] == 0)){
        echo '<td>';
        echo '0';
        echo '</td>';
        echo '<td>';
        echo 'Pas de stagiaires';
        echo '</td>';
      } else {

        // Le nombre de stagiaires
        echo '<td>';
        echo $value['nbConventions'];
        echo '</td>';

        // Les fiches par promotion
        echo '<td>';

        $anneeUniversitaire = '';
        foreach ($value['promotions']['conventions'] as $key2 => $value2) {

          $oPromotion = Promotion::getPromotion($key2);

          if ($anneeUniversitaire == '') $anneeUniversitaire = $oPromotion->anneeUniversitaire;
          $annees = $oPromotion->anneeUniversitaire . '-' . ($oPromotion->anneeUniversitaire + 1) ;

          $j = 1; // Numéro de la fiche
          $fiches = '';
          foreach ($value2 as $key3 => $value3) {
            $fiches .= '<a href="./ficheDeStage.php?&idEtu=' . $value3->getIdEtudiant() . '&idPromo=' . $oPromotion->getIdentifiantBDD() .'" target="_blank">F'.$j.'</a>';
            if ($j++ < sizeof($value2)) $fiches .= ' ';
          }

          if ($anneeUniversitaire != $oPromotion->anneeUniversitaire) {
            echo '<hr/>';
            $anneeUniversitaire = $oPromotion->anneeUniversitaire;
          }

          echo sprintf('%d&nbsp;&nbsp;%s %s&nbsp;&nbsp;[%s]&nbsp;&nbsp;{%s}', sizeof($value2), $oPromotion->getFiliere()->getNom(), $oPromotion->getParcours()->getNom(), $annees, $fiches);

          echo '<br/>';
        }

        echo '</td>';
      }
    }

    if($displayFlag == 1 || $displayFlag == 2){

      // Le nombre d'alternants
      if(($displayFlag == 2) && ($tabData[$key]['nbContrats'] == 0)){
        echo '<td>';
        echo '0';
        echo '</td>';
        echo '<td>';
        echo 'Pas d\'alternants';
        echo '</td>';
      } else {
        echo '<td>';
        echo $value['nbContrats'];
        echo '</td>';

        // Les fiches par promotion
        echo '<td>';

        $anneeUniversitaire = '';
        foreach ($value['promotions']['contrats'] as $key4 => $value4) {

          $oPromotion = Promotion::getPromotion($key4);

          if ($anneeUniversitaire == '') $anneeUniversitaire = $oPromotion->anneeUniversitaire;
          $annees = $oPromotion->anneeUniversitaire . '-' . ($oPromotion->anneeUniversitaire + 1) ;

          $j = 1; // Numéro de la fiche
          $fiches = '';
          foreach ($value4 as $key3 => $value5) {
            $fiches .= '<a href="./ficheDeStage.php?&idEtu=' . $value5->getIdEtudiant() . '&idPromo=' . $oPromotion->getIdentifiantBDD() .'" target="_blank">F'.$j.'</a>';
            if ($j++ < sizeof($value4)) $fiches .= ' ';
          }

          if ($anneeUniversitaire != $oPromotion->anneeUniversitaire) {
            echo '<hr/>';
            $anneeUniversitaire = $oPromotion->anneeUniversitaire;
          }

          echo sprintf('%d&nbsp;&nbsp;%s %s&nbsp;&nbsp;[%s]&nbsp;&nbsp;{%s}', sizeof($value4), $oPromotion->getFiliere()->getNom(), $oPromotion->getParcours()->getNom(), $annees, $fiches);

          echo '<br/>';
        }

        echo '</td>';
      


    }

  }
  echo '</tr>';
}

$i++;
}

echo "</table>";


?>
