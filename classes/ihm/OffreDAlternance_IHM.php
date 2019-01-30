<?php

class OffreDAlternance_IHM {

  /**
  * Afficher un formulaire de sélection des offres de stage
  * @param string $fichier La page de traitement du formulaire
  */
  public static function afficherFormulaireRecherche($fichier) {
    $tabF = Filiere::listerFilieres();
    $tabP = Parcours::listerParcours();
    $tabC = Competence::listerCompetences();
    ?>
    <form action="javascript:">
      <table width="100%">
        <tr>
          <td width="70%" align="center">
            <table>
              <tr>
                <td>Nom de l'entreprise</td>
                <td>
                  <input id="nom" type="text" name="nom" value="<?php if (isset($_POST['nom'])) { echo $_POST['nom'];} ?>"/>
                </td>
              </tr>
              <tr>
                <td>Numéro département (ou code postal)</td>
                <td>
                  <input id="cp" type="text" name="cp" value="<?php if (isset($_POST['cp'])) { echo $_POST['cp']; } ?>"/>
                </td>
              </tr>
              <tr>
                <td>Diplôme</td>
                <td>
                  <select id="filiere" name="filiere">
                    <?php
                    echo "<option value='*'>Tous</option>";
                    for ($i = 0; $i < sizeof($tabF); $i++) {
                      if (isset($_POST['filiere']) && $_POST['filiere'] == $tabF[$i]->getIdentifiantBDD())
                      echo "<option selected value='" . $tabF[$i]->getIdentifiantBDD() . "'>" . $tabF[$i]->getNom() . "</option>";
                      else
                      echo "<option value='" . $tabF[$i]->getIdentifiantBDD() . "'>" . $tabF[$i]->getNom() . "</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Durée</td>
                <td>
                  <select id="duree" name="duree"><option value='*'>Indifférent </option>
                    <?php
                    for ($i = 1; $i <= 2; $i++) {
                      if (isset($_POST['duree']) && $_POST['duree'] == $i) {
                        echo "<option selected value='$i'>$i</option>";
                      } else {
                        echo"<option value='$i'>$i</option>";
                      }
                    }
                    ?>
                  </select>
                  ans
                </td>
              </tr>
            </table>
          </td>
          <td width="30%">
            <table>
              <tr>
                <td>Ville</td>
                <td>
                  <input id="ville" type="text" name="ville" value="<?php if (isset($_POST['ville'])) { echo $_POST['ville']; } ?>"/>
                </td>
              </tr>
              <tr>
                <td>Pays</td>
                <td>
                  <input id="pays" type="text" name="pays" value="<?php if (isset($_POST['pays'])) { echo $_POST['pays']; } ?>" />
                </td>
              </tr>
              <tr>
                <td>Spécialité</td>
                <td>
                  <select id="parcours" name="parcours">
                    <?php
                    echo "<option value='*'>Toutes</option>";
                    for ($i = 0; $i < sizeof($tabP); $i++) {
                      if (isset($_POST['parcours']) && $_POST['parcours'] == $tabP[$i]->getIdentifiantBDD())
                      echo "<option selected value='" . $tabP[$i]->getIdentifiantBDD() . "'>" . $tabP[$i]->getNom() . "</option>";
                      else
                      echo "<option value='" . $tabP[$i]->getIdentifiantBDD() . "'>" . $tabP[$i]->getNom() . "</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Compétence</td>
                <td>
                  <select id="competence" name="competence">
                    <?php
                    echo "<option value='*'>Toutes</option>";
                    for ($i = 0; $i < sizeof($tabC); $i++) {
                      if (isset($_POST['competence']) && $_POST['competence'] == $tabC[$i]->getIdentifiantBDD())
                      echo "<option selected value='" . $tabC[$i]->getIdentifiantBDD() . "'>" . $tabC[$i]->getNom() . "</option>";
                      else
                      echo "<option value='" . $tabC[$i]->getIdentifiantBDD() . "'>" . $tabC[$i]->getNom() . "</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </form>
    <script type="text/javascript">
    var table_onchange = new Array("filiere", "parcours", "duree", "competence");
    new LoadData(table_onchange, "<?php echo $fichier; ?>", "onchange");
    var table_onkeyup = new Array("nom", "ville", "cp", "pays");
    new LoadData(table_onkeyup, "<?php echo $fichier; ?>", "onkeyup");
    </script>
    <?php
  }
}
?>
