<?php

class SuiviCandidatures_IHM {

  /**
  * Afficher un formulaire de sélection des offres d'alternance
  * @param string $fichier La page de traitement du formulaire
  */

  public static function afficherListeOffresSuivi($tabEtu, $page, $tous, $vide=FALSE, $filtreOffres) {
    $tabAU = Promotion_BDD::getAnneesUniversitaires();
    $tabF = Filiere::listerFilieres();
    $tabP = Parcours::listerParcours();
    $tabE = OffreDAlternance::getListeOffreDAlternance($filtreOffres);
    ?>
Début form

<form action='' method='post' class="formToTableCheatStyle" action='javascript:'>
  <!-- FORM PROMOTION_IHM -->
  <table width="100%">
    <tr>
      <td align="center" >
        Sélectionnez l'année :
        <select id="annee" name="annee">
        <?php
        if ($vide) echo "<option value=''>----------</option>";
        if ($tous) echo "<option value='*'>Toutes</option>";
        for ($i=0; $i<sizeof($tabAU); $i++) {
        if ((isset($_POST['annee'])) && ($_POST['annee'] == $tabAU[$i]))
        echo "<option selected value='$tabAU[$i]'>".$tabAU[$i]."-".($tabAU[$i]+1)."</option>";
        else
        echo "<option value='$tabAU[$i]'>".$tabAU[$i]."-".($tabAU[$i]+1)."</option>";
        }
        ?>
        </select>
      </td>
      <td>
        <table width="100%">
          <tr>
            <td align="center">
              Sélectionnez le diplôme :
              <select id="filiere" name="filiere">
                <?php
                if ($vide) echo "<option value=''>----------</option>";
                if ($tous) echo "<option value='*'>Tous</option>";
                for ($i=0; $i<sizeof($tabF); $i++) {
                if ((isset($_POST['filiere'])) && ($_POST['filiere'] == $tabF[$i]->getIdentifiantBDD()))
                echo "<option selected value='".$tabF[$i]->getIdentifiantBDD()."'>".$tabF[$i]->getNom()."</option>";
                else
                echo "<option value='".$tabF[$i]->getIdentifiantBDD()."'>".$tabF[$i]->getNom()."</option>";
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td align="center">
              Sélectionnez la spécialité :
              <select id="parcours" name="parcours">
                <?php
                if ($vide) echo "<option value=''>----------</option>";
                if ($tous) echo "<option value='*'>Tous</option>";
                for ($i=0; $i<sizeof($tabP); $i++) {
                if ((isset($_POST['parcours'])) && ($_POST['parcours'] == $tabP[$i]->getIdentifiantBDD()))
                echo "<option selected value='".$tabP[$i]->getIdentifiantBDD()."'>".$tabP[$i]->getNom()."</option>";
                else
                echo "<option value='".$tabP[$i]->getIdentifiantBDD()."'>".$tabP[$i]->getNom()."</option>";
                }
                ?>
              </select>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <!-- NOM ETU -->
  <table>
    <tr>
      <td align="center">Nom de l'étudiant :
        <select id ="etudiant" name="etudiant">
          <option value="-1">-----------</option>
          <?php
          for ($i = 0; $i < sizeof($tabEtu); $i++) {
          if ((isset($_POST['idEtudiant'])) && ($_POST['idEtudiant'] == $tabEtu[$i]->getIdentifiantBDD()))
          echo "<option selected value='" . $tabEtu[$i]->getIdentifiantBDD() . "'>" . $tabEtu[$i]->getNom() . " " . $tabEtu[$i]->getPrenom() . "</option>";
          else
          echo "<option value='" . $tabEtu[$i]->getIdentifiantBDD() . "'>" . $tabEtu[$i]->getNom() . " " . $tabEtu[$i]->getPrenom() . "</option>";
          }
          ?>
        </select>
      </td>
    </tr>
  </table>
  <!-- TABLE OFFRES -->
  <table class="tableToFormCheatStyle">
    <tr id="entete" class="cellBordersCheatStyle">
      <td width="30%" class="cellBordersCheatStyle">Titre</td>
      <td width="35%" class="cellBordersCheatStyle">Entreprise</td>
      <td width="15%" class="cellBordersCheatStyle">Etat</td>
    </tr>
    <?php
    $cpt = 0;
    for ($i = 0; $i < sizeof($tabE); $i++) {
    ?>
    <tr id="ligne<?php echo $cpt % 2; $cpt++; ?>">
      <td class="cellBordersCheatStyle"><?php echo $tabE[$i]->getTitre(); ?></td>
      <td class="cellBordersCheatStyle">
        <?php
        $entreprise = $tabE[$i]->getEntreprise();
        echo $entreprise->getNom();
        ?>
      </td>
      <td align="center" class="cellBordersCheatStyle">
        <select <?php echo 'name="statut'.$i.'"'; ?> >
          <option value="--">--</option>
          <option value="Pas intéressé">Pas intéressé</option>
          <option value="Postulé">Postulé</option>
          <option value="Entretien">Entretien</option>
          <option value="Entrenu">Entretenu</option>
          <option value="Pris">Pris</option>
          <option value="Refusé">Refusé</option>
        </select>
      </td>
    </tr>
  <?php
  }
  ?>
  </table>

<div class='align-center' style='background-color: white;'><input type='submit' value='Enregistrer'></div>
</form>
Fin Form
<script type="text/javascript">
  var table = new Array("annee", "filiere", "parcours", "etudiant");
  new LoadData(table, "<?php echo $page; ?>", "onchange");
</script>
<br/><br/>
<?php
}
}
?>
