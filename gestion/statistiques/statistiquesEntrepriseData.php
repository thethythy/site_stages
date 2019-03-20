<?php

/**
* Page statistiquesEntrepriseData.php
* Utilisation : page de traitement Ajax retournant un tableau des statistiques
*		 par entreprise
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

// Si une recherche sur le nom de l'entreprise est demandée
if (isset($_POST['nom']) && $_POST['nom'] != "")
array_push($filtres, new FiltreString("nom", "%" . $_POST['nom'] . "%"));

// Si une recherche sur le code postal est demandée
if (isset($_POST['cp']) && $_POST['cp'] != "")
array_push($filtres, new FiltreString("codepostal", $_POST['cp'] . "%"));

// Si une recherche sur la ville est demandée
if (isset($_POST['ville']) && $_POST['ville'] != "")
array_push($filtres, new FiltreString("ville", $_POST['ville'] . "%"));

// Si une recherche sur le pays est demandée
if (isset($_POST['pays']) && $_POST['pays'] != "")
array_push($filtres, new FiltreString("pays", $_POST['pays'] . "%"));

// En cas de requête directe avec l'identifiant
if (isset($_GET['id']) && $_GET['id'] != "")
array_push ($filtres, new FiltreNumeric("identreprise", $_GET['id']));

$nbFiltres = sizeof($filtres);

if ($nbFiltres >= 2) {
  $filtre = $filtres[0];
  for ($i = 1; $i < sizeof($filtres); $i++)
  $filtre = new Filtre($filtre, $filtres[$i], "AND");
} else if ($nbFiltres == 1) {
  $filtre = $filtres[0];
} else {
  $filtre = "";
}

// -----------------------------------------------------------------------------
// Affichage des données

function trouveEmailEntreprise($oEntreprise) {
  $email = $oEntreprise->getEmail();

  if ($email == '' || $email == NULL) {
    $email = 'Pas d\'email connu';
  }

  return $email;
}

// Les entreprises sélectionnées
$tabOEntreprise = Entreprise::getListeEntreprises($filtre);

if (sizeof($tabOEntreprise) > 0) {

  echo "Nombre d'entreprises sélectionnées : ".sizeof($tabOEntreprise)."<br/><br/>";

  $nbTotalConventions = 0; // Pour afficher ou pas un message d'alerte
  $entete = 1; // Pour afficher une seule fois l'entête du tableau
  $j = 0; // Pour l'affichage de couleur alterné

  // Pour toutes les entreprises sélectionnées
  for($i = 0; $i < sizeof($tabOEntreprise); $i++) {
    $idEnt = $tabOEntreprise[$i]->getIdentifiantBDD();
    $tabIdConventions = Entreprise_BDD::getListeConventionFromEntreprise($idEnt);
    $tabIdContrats = Entreprise_BDD::getListeConventionFromEntreprise($idEnt);

    if (sizeof($tabIdConventions) > 0 || sizeof($tabIdContrats) > 0) {
      // Création du tableau des données
      $tabData = array();
      foreach ($tabIdConventions as $idConvention) {
        $oConvention = Convention::getConvention($idConvention);
        $idPromotion = $oConvention->getPromotion()->getIdentifiantBDD();

        $tabData[$idEnt]['nbConventions']++;
        $tabData[$idEnt]['promotions'][$idPromotion]++;
        $tabData[$idEnt]['promotions']['conventions'][$idPromotion][$idConvention] = $oConvention;
      }
      $tabDataCon;
      foreach($tabIdContrats as $idContrat){
        $oContrat = Contrat::getContrat($idContrat);
        $idPromotion = $oContrat->getPromotion()->getIdentifiantBDD();

        $tabDataCon[$idEnt]['nbContrats']++;
        $tabDataCon[$idEnt]['promotions'][$idPromotion]++;
        $tabDataCon[$idEnt]['promotions']['contrats'][$idPromotion][$idContrat] = $oContrat;

      }

      if ($entete == 1) {
        echo "Liste des entreprises ayant pris des étudiants :<br/><br/>";
        echo '<form method=post action="../entreprises/listeDesContacts.php" target=_blank>
        <input type=hidden name=rech value=1>
        <table>
        <tr id="entete">
        <td width="30%">Entreprise</td>
        <td width="10%">Contact(s)</td>
        <td width="30%">Stagiaire(s)</td>
        <td width="30%">Alternant(s)</td>
        </tr>';
        $entete = 0;
      }

      foreach ($tabData as $key => $value) {

        echo '<tr class="ligne' . $j%2 . '">';

        // L'entreprise
        $oEntreprise = Entreprise::getEntreprise($key);
        echo "<td style='text-align: left; padding-left: 10px'>";
        echo "<b>Nom : </b>".$oEntreprise->getNom()."<br/>";
        echo "<b>Adresse : </b>".$oEntreprise->getAdresse()."<br/>";
        echo "<b>Ville : </b>".$oEntreprise->getCodePostal()."&nbsp;";
        echo $oEntreprise->getVille() . "<br/>";
        echo "<b>Email : </b><i>".trouveEmailEntreprise($oEntreprise)."</i><br/>";
        echo "<b>Type : </b>".$oEntreprise->getType()->getType();
        echo "</td>";

        // Les contacts
        echo '<td style="text-align: left; padding-left: 10px">';
        echo '<input type=hidden name=entreprise value="'.$idEnt.'">';
        echo '<input type=submit value="Liste des contacts"><br/>';
        echo "<br/>Nombre total : ". sizeof($oEntreprise->listeDeContacts());
        echo '</td>';

        // Les fiches de stage par promotion
        echo '<td style="text-align: left; padding-left: 10px">';

        $anneeUniversitaire = '';
        foreach ($value['promotions']['conventions'] as $key2 => $value2) {

          $oPromotion = Promotion::getPromotion($key2);

          if ($anneeUniversitaire == '') $anneeUniversitaire = $oPromotion->anneeUniversitaire;
          $annees = $oPromotion->anneeUniversitaire . '-' . ($oPromotion->anneeUniversitaire + 1) ;

          $k = 1; // Numéro de la fiche
          $fiches = '';
          foreach ($value2 as $key3 => $value3) {
            $fiches .= '<a href="./ficheDeStage.php?idEtu=' . $value3->getIdEtudiant() . '&idPromo=' . $oPromotion->getIdentifiantBDD() .'" target="_blank">F'.$k.'</a>';
            if ($k++ < sizeof($value2)) $fiches .= ' ';
          }

          echo sprintf('%d&nbsp;&nbsp;%s %s&nbsp;&nbsp;[%s]&nbsp;&nbsp;{%s}', sizeof($value2), $oPromotion->getFiliere()->getNom(), $oPromotion->getParcours()->getNom(), $annees, $fiches);

          echo '<br/>';
        }

        echo "<br/>Nombre total : ".$value['nbConventions'];

        echo '</td>';

        // ALTERNANCE
        echo '<td>';
        $anneeUniversitaire = '';
        foreach ($value['promotions']['contrats'] as $key2 => $value2) {

          $oPromotion = Promotion::getPromotion($key2);

          if ($anneeUniversitaire == '') $anneeUniversitaire = $oPromotion->anneeUniversitaire;
          $annees = $oPromotion->anneeUniversitaire . '-' . ($oPromotion->anneeUniversitaire + 1) ;

          $k = 1; // Numéro de la fiche
          $fiches = '';
          foreach ($value2 as $key3 => $value3) {
            $fiches .= '<a href="./ficheDeStage.php?idEtu=' . $value3->getIdEtudiant() . '&idPromo=' . $oPromotion->getIdentifiantBDD() .'" target="_blank">F'.$k.'</a>';
            if ($k++ < sizeof($value2)) $fiches .= ' ';
          }

          echo sprintf('%d&nbsp;&nbsp;%s %s&nbsp;&nbsp;[%s]&nbsp;&nbsp;{%s}', sizeof($value2), $oPromotion->getFiliere()->getNom(), $oPromotion->getParcours()->getNom(), $annees, $fiches);

          echo '<br/>';
        }

        echo "<br/>Nombre total : ".$value['nbConventions'];


        echo '</td>';


        echo '</tr>';

        $j++;
      }
      $nbTotalConventions += sizeof($tabIdConventions);
    }
  }

  if ($nbTotalConventions > 0)
  echo "</table>";
  else
  echo "Aucune entreprise sélectionnée n'a pris de stagiaire.";

} else {
  echo '<br/><center>Aucune entreprise ne correspond aux critères de recherche.</center><br/>';
}

?>
