<?php

class Promotion_IHM {

  /**
  * Afficher un formulaire de sélection d'une année universitaire
  * @param boolean $vide Indicateur à true si on affiche une année vide
  */
  public static function afficherFormulaireSelectionAnnee($vide) {
    $tabAU = Promotion_BDD::getAnneesUniversitaires();
    ?>
    <form method=post action="javascript:">
      <table width="100%">
        <tr>
          <td align="center" >
            Sélectionnez l'année :
            <select id="annee" name="annee">
              <?php
              if ($vide) echo "<option value=''></option>";
              for ($i=0; $i<sizeof($tabAU); $i++) {
                if ((isset($_POST['annee'])) && ($_POST['annee'] == $tabAU[$i]))
                echo "<option selected value='$tabAU[$i]'>".$tabAU[$i]."-".($tabAU[$i]+1)."</option>";
                else
                echo "<option value='$tabAU[$i]'>".$tabAU[$i]."-".($tabAU[$i]+1)."</option>";
              }
              ?>
            </select>
          </td>
        </tr>
      </table>
    </form>

    <script type="text/javascript">
    var table = new Array("annee");
    new LoadData(table, "", "onchange");
    </script>
    <?php
  }

  /**
  * Afficher un formulaire de sélection d'un intervalle d'années ainsi qu'une
  * filière et un parcours éventuels
  */
  public static function afficherFormulaireSelectionInterval() {
    $tabAU = Promotion_BDD::getAnneesUniversitaires();
    $tabF = Filiere::listerFilieres();
    $tabP = Parcours::listerParcours();
    ?>
    <form method=post action="javascript:">
      <table width="100%">
        <tr>
          <td>
            <table width="100%">
              <tr>
                <td align="center">
                  Année de départ :
                  <select id="annee_deb" name="annee_deb">
                    <?php
                    echo "<option value=''>----------</option>";
                    for ($i=0; $i<sizeof($tabAU); $i++) {
                      if ((isset($_POST['annee_deb'])) && ($_POST['annee_deb'] == $tabAU[$i]))
                      echo "<option selected value='$tabAU[$i]'>".$tabAU[$i]."-".($tabAU[$i]+1)."</option>";
                      else
                      echo "<option value='$tabAU[$i]'>".$tabAU[$i]."-".($tabAU[$i]+1)."</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="center">
                  Année de fin :
                  <select id="annee_fin" name="annee_fin">
                    <?php
                    echo "<option value=''>----------</option>";
                    for ($i=0; $i<sizeof($tabAU); $i++) {
                      if ((isset($_POST['annee_fin'])) && ($_POST['annee_fin'] == $tabAU[$i]))
                      echo "<option selected value='$tabAU[$i]'>".$tabAU[$i]."-".($tabAU[$i]+1)."</option>";
                      else
                      echo "<option value='$tabAU[$i]'>".$tabAU[$i]."-".($tabAU[$i]+1)."</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>
            </table>
          </td>
          <td>
            <table width="100%">
              <tr>
                <td align="center">
                  Sélectionnez le diplôme :
                  <select id="filiere" name="filiere">
                    <?php
                    echo "<option value='*'>Tous</option>";
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
                    echo "<option value='*'>Tous</option>";
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
    </form>

    <script type="text/javascript">
    var table = new Array("annee_deb", "annee_fin", "filiere", "parcours");
    new LoadData(table,"", "onchange");
    </script>
    <?php
  }


  public static function afficherFormulaireSelectionInterval2($page) {
    $tabAU = Promotion_BDD::getAnneesUniversitaires();
    $tabF = Filiere::listerFilieres();
    $tabP = Parcours::listerParcours();
    ?>
    <form method=post action="javascript:">
      <table width="100%">
        <tr>
          <td>
            <table width="100%">
              <tr>
                <td align="center">
                  Année de départ :
                  <select id="annee_deb" name="annee_deb">
                    <?php
                    echo "<option value=''>----------</option>";
                    for ($i=0; $i<sizeof($tabAU); $i++) {
                      if ((isset($_POST['annee_deb'])) && ($_POST['annee_deb'] == $tabAU[$i]))
                      echo "<option selected value='$tabAU[$i]'>".$tabAU[$i]."-".($tabAU[$i]+1)."</option>";
                      else
                      echo "<option value='$tabAU[$i]'>".$tabAU[$i]."-".($tabAU[$i]+1)."</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="center">
                  Année de fin :
                  <select id="annee_fin" name="annee_fin">
                    <?php
                    echo "<option value=''>----------</option>";
                    for ($i=0; $i<sizeof($tabAU); $i++) {
                      if ((isset($_POST['annee_fin'])) && ($_POST['annee_fin'] == $tabAU[$i]))
                      echo "<option selected value='$tabAU[$i]'>".$tabAU[$i]."-".($tabAU[$i]+1)."</option>";
                      else
                      echo "<option value='$tabAU[$i]'>".$tabAU[$i]."-".($tabAU[$i]+1)."</option>";
                    }
                    ?>
                  </select>
                </td>
              </tr>
            </table>
          </td>
          <td>
            <table width="100%">
              <tr>
                <td align="center">
                  Sélectionnez le diplôme :
                  <select id="filiere" name="filiere">
                    <?php
                    echo "<option value='*'>Tous</option>";
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
                    echo "<option value='*'>Tous</option>";
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
    </form>

    <script type="text/javascript">
    var table = new Array("annee_deb", "annee_fin", "filiere", "parcours");
    new LoadData(table, "<?php echo $page; ?>", "onchange");
    </script>
    <?php
  }
  /**
  * Afficher un formulaire de sélection d'une promotion (année, filière, parcours)
  * @param string $page Page de traitement de la requête Ajax
  * @param boolean $tous Indicateur à true pour afficher a proposition "Tous" dans les combobox
  * @param boolean $vide Indicateur à true pour obliger à sélectionner une année
  */
  public static function afficherFormulaireRecherche($page, $tous, $vide=FALSE) {
    $tabAU = Promotion_BDD::getAnneesUniversitaires();
    $tabF = Filiere::listerFilieres();
    $tabP = Parcours::listerParcours();
    ?>
    <form id="formPromotion" method=post action="javascript:">
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
    </form>

    <script type="text/javascript">
    var table = new Array("annee", "filiere", "parcours");
    new LoadData(table, "<?php echo $page; ?>", "onchange");
    </script>
    <?php
  }

  /**
  * Afficher un formulaire pour créer une nouvelle promotion
  */
  public static function afficherFormulaireAjout() {
    $tabF = Filiere::listerFilieres();
    $tabP = Parcours::listerParcours();
    ?>
    <form method=post action="">
      <table width="100%">
        <tr>
          <td colspan="3" align="center">
            Année :&nbsp;
            <?php
            if((isset($_POST['annee'])) && ($_POST['annee'] != ""))
            echo "<input type='text' value='".$_POST['annee']."' name='annee'>";
            else
            echo "<input type='text' value='".date("Y")."' name='annee'>";
            ?>
          </td>
        </tr>
        <tr>
          <td width="45%" align="center">
            <br/>
            Sélectionnez le diplôme :&nbsp;
            <select name="filiere1">
              <?php
              for($i=0; $i<sizeof($tabF); $i++){
                if(isset($_POST['filiere']) && $_POST['filiere'] == $tabF[$i]->getIdentifiantBDD())
                echo "<option selected value='".$tabF[$i]->getIdentifiantBDD()."'>".$tabF[$i]->getNom()."</option>";
                else
                echo "<option value='".$tabF[$i]->getIdentifiantBDD()."'>".$tabF[$i]->getNom()."</option>";
              }
              ?>
            </select>
          </td>
          <td width="10%" align="center">OU</td>
          <td width="45%" align="center">Créez un nouveau diplôme :&nbsp;<input type="text" value="<?php if(isset($_POST['filiere2'])) $_POST['filiere2'] ?>" name="filiere2"></td>
        </tr>
        <tr>
          <td width="45%" align="center">
            <br/>
            Sélectionnez la spécialité :&nbsp;
            <select name="parcours1">
              <?php
              for ($i=0; $i<sizeof($tabP); $i++) {
                if(isset($_POST['parcours']) && $_POST['parcours'] == $tabP[$i]->getIdentifiantBDD())
                echo "<option selected value='".$tabP[$i]->getIdentifiantBDD()."'>".$tabP[$i]->getNom()."</option>";
                else
                echo "<option value='".$tabP[$i]->getIdentifiantBDD()."'>".$tabP[$i]->getNom()."</option>";
              }
              ?>
            </select>
          </td>
          <td width="10%" align="center">OU</td>
          <td width="45%" align="center">Crééz une nouveau parcours :&nbsp;<input type="text" value="<?php if(isset($_POST['parcours2'])) $_POST['parcours2'] ?>" name="parcours2"></td>
        </tr>
        <tr>
          <td colspan="3" align="center">
            <br/>
            Email :&nbsp;
            <?php
            if ((isset($_POST['email'])) && ($_POST['email'] != ""))
            echo "<input type='text' value='".$_POST['email']."' name='email'>";
            else
            echo "<input type='text' value='' name='email'>";
            ?>
          </td>
        </tr>
        <tr>
          <td colspan="3" align="center">
            <br/>
            <input type="hidden" value="1" name="add"/>
            <input type="submit" value="Ajouter"/>
          </td>
        </tr>
      </table>
    </form>
    <?php
  }

  /**
  * Afficher un formulaire pour importer des étudiants après création d'une promotion
  * @param integer $idPromo Identifiant de la promotion
  */
  public static function afficherFormulaireAjoutOK($idPromo) {
    ?>
    <table align="center">
      <tr>
        <td colspan="2" align="center">
          Création de la promotion réalisée avec succès.
        </td>
      </tr>
      <tr>
        <td width="20%" align="center">
          <form method=post action="../">
            <input type="submit" value="Retourner au menu"/>
          </form>
        </td>
        <td width="20%" align="center">
          <form method=post action="./importationEtudiants.php">
            <input type="hidden" value="<?php echo $idPromo; ?>" name="promo"/>
            <input type="submit" value="Importer des étudiants"/>
          </form>
        </td>
      </tr>
    </table>
    <?php
  }

  /**
  * Afficher un formulaire d'importation d'étudiants sélectionables depuis
  * une liste  Après sélection l'utilisateur peut lancer l'importation.
  * @param integer $annee Année concernée
  * @param integer $filiere Identifiant de la filière concernée
  * @param integer $parcours Identifiant du parcours concerné
  * @param tableau d'objets $tabEtudiants Liste des objets Etudiants concernés
  */
  public static function afficherEtudiantsAImporter($annee, $filiere, $parcours, $tabEtudiants) {
    ?>
    <form method=post action="importationEtudiants.php">
      <table width='100%'>
        <tr id="entete">
          <td width="80%" align="left">Etudiants</td>
          <td width="20%" align="center">Importer</td>
        </tr>
        <?php
        for ($i = 0; $i < sizeof($tabEtudiants); $i++) {
          ?>
          <tr id="ligne<?php echo $i % 2; ?>">
            <td width="80%" align="left">
              <?php echo $tabEtudiants[$i]->getNom() . " " . $tabEtudiants[$i]->getPrenom(); ?>
            </td>
            <td width="20%" align="center">
              <?php echo "<input type='checkbox' id='etu" . $tabEtudiants[$i]->getIdentifiantBDD() . "' name='etu" . $tabEtudiants[$i]->getIdentifiantBDD() . "'/>";?>
            </td>
          </tr>
          <?php
        }
        ?>
        <tr>
          <td colspan="2" id="submit">
            <br/>
            <input type="hidden" value="1" name="import">
            <input type="hidden" value="<?php echo $annee; ?>" name="annee">
            <input type="hidden" value="<?php echo $parcours; ?>" name="parcours">
            <input type="hidden" value="<?php echo $filiere; ?>" name="filiere">
            <input type="submit" name="btnImporter" value="Importer">
            <input type="submit" name="btnAnnuler" value="Annuler">
          </td>
        </tr>
      </table>
    </form>
    <?php
  }

  /**
  * Afficher la liste des étudiants importés dans une promotion.
  * Un bouton permet d'afficher la promotion complète.
  * @param Promotion $promo La promotion concernée
  * @param Filiere $filiere La filière concernée
  * @param Parcours $parcours Le parcours concerné
  * @param tableau d'objets $tabEtudiants Les objets Etudiants concernés
  */
  public static function afficherEtudiantsImportes($promo, $filiere, $parcours, $tabEtudiants) {
    echo "Les étudiants ci-dessous ont été ajoutés à la promotion : ";
    echo $filiere->getNom() . " " . $parcours->getNom() . " - " . $promo->getAnneeUniversitaire() . "<br/>";
    ?>
    <table>
      <?php
      for ($i = 0; $i < sizeof($tabEtudiants); $i++) {
        if (isset($_POST['etu' . $tabEtudiants[$i]->getIdentifiantBDD()])) {
          ?>
          <tr id="ligne<?php echo $i % 2; ?>">
            <td width="100%" align="left">
              <?php echo $tabEtudiants[$i]->getNom() . " " . $tabEtudiants[$i]->getPrenom() . " " . $tabEtudiants[$i]->getEmailInstitutionel(); ?>
            </td>
          </tr>
          <?php
        }
      }
      ?>
      <tr>
        <td>
          <table>
            <tr>
              <td width="50%" align="center">
                <form method=post action="modifierPromotion.php">
                  <input type="hidden" value="1" name="rech"/>
                  <input type="hidden" value="<?php echo $promo->getAnneeUniversitaire(); ?>" name="annee"/>
                  <input type="hidden" value="<?php echo $filiere->getIdentifiantBDD(); ?>" name="filiere"/>
                  <input type="hidden" value="<?php echo $parcours->getIdentifiantBDD(); ?>" name="parcours"/>
                  <input type="submit" value="Afficher la promotion"/>
                </form>
              </td>
              <td width="50%" align="center">
                <form method=post action="../">
                  <input type="submit" value="Retourner au menu"/>
                </form>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <?php
  }

  /**
  * Afficher un formulaire de modification du statut des étudiants d'une promotion
  * (stage trouvé ou pas, alternant, etc.) pour le suivi pédagogique
  * @param type $annee L'année concerné
  * @param type $filiere La filière concernée
  * @param type $parcours Le parcours concerné
  * @param tableau d'objets $tabPromos Les objets Promotion concernés
  * @param tableau d'objets $tabEtudiants Les objets Etudiant concernés
  */
  public static function afficherListeStatutSuiviEtudiant($annee, $filiere, $parcours, $tabPromos, $tabEtudiants) {
    if (sizeof($tabPromos) > 0) {
      if (sizeof($tabEtudiants) > 0) {
        ?>
        <form method="POST">
          <table>
            <tr id="entete">
              <td width="20%">Etudiant</td>
              <td width="70%" align="center">Statut</td>
            </tr>
            <?php
            $nbEtudiants = sizeof($tabEtudiants);
            $nbAlters = 0;
            $nbAltersPRO = 0;
            $nbAltersAPP = 0;
            $nbRechs = 0;
            $nbConvSignees = 0;
            $nbConvEnCours = 0;
            $nbDesPistes = 0;
            $nbRiens = 0;
            $nbIndefinis = 0;

            for ($i = 0; $i < $nbEtudiants; $i++) {
              $idEtu = $tabEtudiants[$i]->getIdentifiantBDD();
              $statut = $tabEtudiants[$i]->getCodeEtudiant();

              switch ($statut) {
                case "":
                case "0":
                $nbIndefinis++;
                break;
                case "1":
                $nbRiens++;
                break;
                case "2":
                $nbDesPistes++;
                break;
                case "3":
                $nbConvEnCours++;
                break;
                case "4":
                $nbConvSignees++;
                break;
                case "5":
                $nbAlters++;
                break;
                case "51":
                $nbAlters++;
                $nbAltersPRO++;
                break;
                case "52":
                $nbAlters++;
                $nbAltersAPP++;
                break;
                case "6":
                $nbRechs++;
                break;
                default:
                break;
              }
              ?>
              <tr id="ligne<?php echo $i % 2; ?>">
                <td>
                  <?php echo $tabEtudiants[$i]->getNom() . " " . $tabEtudiants[$i]->getPrenom(); ?>
                </td>
                <td align="center">
                  <select name="<?php echo "statut[$idEtu]"; ?>">
                    <option value="0" <?php if ($statut == "0" || $statut == "") echo "selected"; ?> >Indéfini</option>
                    <option value="1" <?php if ($statut == "1") echo "selected"; ?> >Rien</option>
                    <option value="2" <?php if ($statut == "2") echo "selected"; ?> >Des pistes</option>
                    <option value="3" <?php if ($statut == "3") echo "selected"; ?> >En signature</option>
                    <option value="4" <?php if ($statut == "4") echo "selected"; ?> >Signée</option>
                    <option value="5" <?php if ($statut == "5") echo "selected"; ?> >Alternant</option>
                    <option value="51" <?php if ($statut == "51") echo "selected"; ?> >Alt Pro</option>
                    <option value="52" <?php if ($statut == "52") echo "selected"; ?> >Alt App</option>
                    <option value="6" <?php if ($statut == "6") echo "selected"; ?> >Recherche</option>
                  </select>
                </td>
              </tr>
              <?php
            }
            ?>
            <tr id='entete2'>
              <td align="center">
                Total : <?php echo $nbEtudiants; ?>
              </td>
              <td align="center">
                Indéfini : <?php echo $nbIndefinis; ?>&nbsp;|&nbsp;
                Rien : <?php echo $nbRiens; ?>&nbsp;|&nbsp;
                Des pistes : <?php echo $nbDesPistes; ?>&nbsp;|&nbsp
                En cours : <?php echo $nbConvEnCours; ?>&nbsp;|&nbsp
                Signées : <?php echo $nbConvSignees; ?>&nbsp;|&nbsp
                Alternants : <?php echo $nbAlters . " [".$nbAltersPRO." Pro | ".$nbAltersAPP." App]"; ?>&nbsp;|&nbsp;
                Rech. : <?php echo $nbRechs; ?>
              </td>
            </tr>
          </table>
          <table align="center">
            <tr>
              <td align=center>
                <input type=submit name=valider value="Valider les modifications"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type=submit name=reset value="Tout réinitialiser"/>
              </td>
            </tr>
          </table>
          <input type="hidden" name="annee" value="<?php echo $annee; ?>"/>
          <input type='hidden' name='filiere' value="<?php echo $filiere; ?>"/>
          <input type='hidden' name='parcours' value="<?php echo $parcours; ?>"/>
        </form>
        <br/><br/>
        <?php
      } else {
        ?>
        <br/><center>Aucun étudiant n'est dans cette promotion.<center/><br/>
          <?php
        }
      } else {
        ?>
        <br/><center>Aucune promotion ne correspond à ces critères de recherche.<center/><br/>
          <?php
        }
      }

      /**
      * Afficher un formulaire sous forme de liste d'étudiants appartenant
      * à une promotion à éditer ou à supprimer
      * @param tableau d'objets $tabPromos Un tableau d'objets Promotion (normalement une seule promotion)
      * @param tableau d'objets $tabEtudiants Un tableau d'objets Etudiants de la promotion
      */
      public static function afficherListeEtudiantsAEditer($tabPromos, $tabEtudiants) {
        if (sizeof($tabPromos) > 0) {
          $idPromo = $tabPromos[0][0];
          $promotion = Promotion::getPromotion($idPromo);
          $email = $promotion->getEmailPromotion();
          $nbEtudiants = sizeof($tabEtudiants);
          ?>
          <table align="center">
            <tr>
              <td width="25%" align="center">
                <form method=post action="ajouterEtudiant.php">
                  <input type="hidden" value="<?php echo $idPromo; ?>" name="promo"/>
                  <input type="submit" value="Ajouter un nouvel étudiant"/>
                </form>
              </td>
              <td width="25%" align="center">
                <form method=post action="importationEtudiants.php">
                  <input type="hidden" value="<?php echo $idPromo; ?>" name="promo"/>
                  <input type="submit" value="Importer des étudiants"/>
                </form>
              </td>
              <td width="25%" align="center">
                <form method=post action="modifierPromotion.php">
                  <input type="hidden" value="<?php echo $idPromo; ?>" name="delpromo"/>
                  <input type="submit" value="Supprimer la promotion"/>
                </form>
              </td>
            </tr>
          </table>

          <form method=post action="modifierPromotion.php">
            <input type="hidden" value="<?php echo $idPromo; ?>" name="promo"/>
            <input type="submit" value="Modifier l'email de la promotion :"/>
            <input type='text' value="<?php if ($email == "") echo "?"; else echo $email; ?>" name='email'>
          </form>

          <?php

          // Si il y a au moins un étudiant
          if ($nbEtudiants > 0) {
            // Affichage des étudiants correspondants aux critères de recherches
            echo "Nombre d'étudiants de la promotion : ".$nbEtudiants."<p/>";
            echo "<table width='75%'>
            <tr id='entete'>
            <td width='55%'>Nom et Prénom</td>
            <td width='10%' align='center'>Modifier</td>
            <td width='10%' align='center'>Supprimer</td>
            </tr>";
            for ($i = 0; $i < $nbEtudiants; $i++) {
              ?>
              <tr id="ligne<?php echo $i%2; ?>">
                <td>
                  <?php echo $tabEtudiants[$i]->getNom()." ".$tabEtudiants[$i]->getPrenom(); ?>
                </td>
                <td align="center">
                  <a href="modifierEtudiant.php?promo=<?php echo $idPromo; ?>&id=<?php echo $tabEtudiants[$i]->getIdentifiantBDD(); ?>">
                    <img src="../../images/reply.png"/>
                  </a>
                </td>
                <td align="center">
                  <a href="modifierPromotion.php?promo=<?php echo $idPromo; ?>&id=<?php echo $tabEtudiants[$i]->getIdentifiantBDD(); ?>">
                    <img src="../../images/action_delete.png"/>
                  </a>
                </td>
              </tr>
              <?php
            }
            echo "</table>";
          } else {
            echo "<br/><center>Aucun étudiant n'a été trouvé.</center><br/>";
          }
          ?>
          <br/><br/>
          <?php
        } else {
          echo "<br/><center>Aucune promotion ne correspond à ces critères de recherche.</center><br/>";
        }
      }

      /**
      * Afficher le planning des soutenances par ordre chronologique des étudiants
      * d'une promotion
      * @param Promotion $promotion La promotion concernée
      * @param tableau d'objets $listeDateSoutenance La liste des dates de soutenances
      * @param tableau d'objets $listeConvention La liste des conventions concernés
      */
      public static function afficherPlanningPromotions($promotion, $listeDateSoutenance, $listeConvention) {
        $enteteTableau =
        "<table>
        <tr id='entete'>
        <td rowspan='2' style='width: 85px;'>Horaires</td>
        <td rowspan='2' style='width: 160px;'>Nom prénom</td>
        <td rowspan='2' style='width: 50px;'>Fiche de stage</td>
        <td colspan='2'>Jury</td>
        <td rowspan='2' style='width: 75px;'>Salle</td>
        </tr>
        <tr id='entete'>
        <td style='width: 110px;'>Référent</td>
        <td style='width: 110px;'>Examinateur</td>
        </tr>";

        $finTableau = "</table>";
        echo '<table>';

        $k = 0;
        foreach ($listeDateSoutenance as $dateActuelle) {
          $i = 0; $j = 0;

          // Pour chaque convention
          foreach ($listeConvention as $convention) {
            $soutenance = $convention->getSoutenance();

            // On test s'il y a une soutenance associee a la date
            if ($soutenance->getIdentifiantBDD()!=0 && $soutenance->getSalle()->getIdentifiantBDD()!=0) {
              if ($soutenance->getDateSoutenance()->getIdentifiantBDD()==$dateActuelle->getIdentifiantBDD()) {
                if ($j==0) {
                  echo $finTableau;
                  echo '<h2> Le '.$dateActuelle->getJour().' '.Utils::numToMois($dateActuelle->getMois()).' '.$dateActuelle->getAnnee().'</h2>';
                  echo $enteteTableau;
                }

                $j++; $k++;
                $nomSalle = ($soutenance->getSalle()->getIdentifiantBDD()!=0) ? $soutenance->getSalle()->getNom() : "Non attribuée";
                $etudiant = $convention->getEtudiant();
                $parcours = $promotion->getParcours();
                $filiere = $promotion->getFiliere();
                $parrain = $convention->getParrain();
                $examinateur = $convention->getExaminateur();

                // Gestion horaires
                $tempsSoutenance = $filiere->getTempsSoutenance();
                $heureDebut = $soutenance->getHeureDebut();
                $minuteDebut = $soutenance->getMinuteDebut();
                $heureFin = $heureDebut;
                $minuteFin = ($minuteDebut + $tempsSoutenance);
                if ($minuteFin>59) {
                  $minuteFin-=60;
                  $heureFin++;
                }
                $minuteDebut = ($minuteDebut!=0) ? $minuteDebut : "00";
                $minuteFin = ($minuteFin!=0) ? $minuteFin : "00";

                // Incrementation
                $i=($i+1)%2;

                // Affichage
                echo
                "<tr id='ligne".$i."'>
                <td>".$heureDebut."h".$minuteDebut." / ".$heureFin."h".$minuteFin."</td>
                <td>".strtoupper($etudiant->getNom())." ".$etudiant->getPrenom()."</td>
                <td><a href='fichedestage.php?idEtu=".$etudiant->getIdentifiantBDD()."&idPromo=".$promotion->getIdentifiantBDD()."' target='_blank'><img src='../images/resume.png' alt='Résumé'/></a></td>
                <td>".strtoupper($parrain->getNom())." ".$parrain->getPrenom()."
                <td>".strtoupper($examinateur->getNom())." ".$examinateur->getPrenom()."
                <td>".$nomSalle."</td>
                </tr>";
              }
            }
          }
        }

        echo $finTableau;

        // S'il n'y a pas de conventions
        if ($k == 0)
        echo "<br/><center>Il n'y a pas de soutenance associée à cette promotion.</center>";
      }
    }

    ?>
