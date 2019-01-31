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














  /**
  * Afficher un tableau interactif des stages disponibles
  * (utilisé pour sélection une offre puis la visualiser)
  * @param tableau d'objets $tabOffreDAlt Tableau des objets OffreDAlternance
  */

  public static function afficherListeOffres($tabOffreDAlt) {
    ?>
    <br/>
    <table width="100%">
      <tr id="entete">
        <td width="30%">Titre</td>
        <td width="35%">Entreprise</td>
        <td width="15%">Diplôme</td>
        <td width="15%">Spécialité</td>
        <td align="center" width="5%">Visualiser</td>
      </tr>

      <?php
      $cpt = 0;
      for ($i = 0; $i < sizeof($tabOffreDAlt); $i++) {
        if (!$tabOffreDAlt[$i]->estVisible()) {//A changer ...
          ?>
          <tr id="ligne<?php echo $cpt % 2; $cpt++; ?>">
            <td><?php echo $tabOffreDAlt[$i]->getTitre(); ?></td>
            <td>
              <?php

              $entreprise = $tabOffreDAlt[$i]->getEntreprise();
              echo $entreprise->getNom();
              ?>
            </td>
            <td>
              <?php
              $profil = $tabOffreDAlt[$i]->getListeProfilSouhaite();
              for ($j = 0; $j < sizeof($profil); $j++) {
                if ($j == (sizeof($profil) - 1)) {
                  echo $profil[$j]->getNom();
                } else {
                  echo $profil[$j]->getNom() . " / ";
                }
              }
              ?>
            </td>
            <td>
              <?php
              $themes = $tabOffreDAlt[$i]->getThemes();
              for ($j = 0; $j < sizeof($themes); $j++) {
                if ($j == (sizeof($themes) - 1)) {
                  echo $themes[$j]->getNom();
                } else {
                  echo $themes[$j]->getNom() . " / ";
                }
              }
              ?>
            </td>
            <td align="center">
              <a href="./visualiserOffre.php?id=<?php
              $chaine = $tabOffreDAlt[$i]->getIdentifiantBDD();
              if (isset($_POST['nom'])) $chaine = $chaine . "&nom=" . $_POST['nom'];
              if (isset($_POST['ville'])) $chaine = $chaine . "&ville=" . $_POST['ville'];
              if (isset($_POST['cp'])) $chaine = $chaine . "&cp=" . $_POST['cp'];
              if (isset($_POST['pays'])) $chaine = $chaine . "&pays=" . $_POST['pays'];
              if (isset($_POST['duree'])) $chaine = $chaine . "&duree=" . $_POST['duree'];
              if (isset($_POST['filiere'])) $chaine = $chaine . "&filiere=" . $_POST['filiere'];
              if (isset($_POST['parcours'])) $chaine = $chaine . "&parcours=" . $_POST['parcours'];
              if (isset($_POST['competence'])) $chaine = $chaine . "&competence=" . $_POST['competence'];
              echo $chaine;
              ?>">
              <img src="../images/search.png"></a>
            </td>
          </tr>
          <?php
        }
      }
      ?>
    </table>
    <br/><br/>
    <?php
  }






  /**
  * Afficher deux listes :
  * - une liste des offres de stage pas encore validées
  * - une liste des offres de stage déjà validées
  * Dans les cas, la sélection permet d'éditer l'offre
  * @param tableau d'objets $tabOffreDAlt Les objets OffreDeStage concernés
  */
  public static function afficherListeOffresAEditer($tabOffreDAlt) {
    $cpt = 0;
    $enteteAffichee = false;

    for ($i = 0; $i < sizeof($tabOffreDAlt); $i++) {
      if (!$tabOffreDAlt[$i]->estVisible()) {
        if (!$enteteAffichee) {
          $enteteAffichee = true;
          ?>
          <p>Voici la liste des offres de stage qui restent à traiter :</p>
          <table width="100%">
            <tr id="entete">
              <td width="30%">Titre</td>
              <td width="35%">Entreprise</td>
              <td width="13%">Diplôme</td>
              <td width="13%">Spécialité</td>
              <td align="center" width="9%">A Valider</td>
            </tr>
            <?php
          }
          ?>
          <tr id="ligne<?php echo $cpt % 2; $cpt++; ?>">
            <td><?php echo $tabOffreDAlt[$i]->getTitre(); ?></td>
            <td><?php
            $entreprise = $tabOffreDAlt[$i]->getEntreprise();
            echo $entreprise->getNom();
            ?>
          </td>
          <td><?php
          $profil = $tabOffreDAlt[$i]->getListeProfilSouhaite();
          for ($j = 0; $j < sizeof($profil); $j++) {
            if ($j == (sizeof($profil) - 1)) {
              echo $profil[$j]->getNom();
            } else {
              echo $profil[$j]->getNom() . " / ";
            }
          }
          ?>
        </td>
        <td><?php
        $themes = $tabOffreDAlt[$i]->getThemes();
        for ($j = 0; $j < sizeof($themes); $j++) {
          if ($j == (sizeof($themes) - 1)) {
            echo $themes[$j]->getNom();
          } else {
            echo $themes[$j]->getNom() . " / ";
          }
        }
        ?>
      </td>
      <td align="center">
        <a href="./editionOffreDeStage.php?id=<?php echo $tabOffreDAlt[$i]->getIdentifiantBDD(); ?>">
          <img src="../../images/search.png">
        </a>
      </td>
    </tr>
    <?php
  }
  }

  if ($cpt == 0) {
    echo "<p>Toutes les offres de stages ont été validées.</p>";
  }

  ?>
  <table width="100%">
    <tr id="entete">
      <td width="30%">Titre</td>
      <td width="35%">Entreprise</td>
      <td width="13%">Diplôme</td>
      <td width="13%">Spécialité</td>
      <td align="center" width="9%">Visualiser</td>
    </tr>

    <?php
    $cpt = 0;
    echo "<p>Voici la liste des offres de stage disponibles sur le site des stages : </p>";
    for ($i = 0; $i < sizeof($tabOffreDAlt); $i++) {
      if ($tabOffreDAlt[$i]->estVisible()) {
        ?>
        <tr id="ligne<?php echo $cpt % 2; $cpt++; ?>">
          <td><?php echo $tabOffreDAlt[$i]->getTitre(); ?></td>
          <td><?php
          $entreprise = $tabOffreDAlt[$i]->getEntreprise();
          echo $entreprise->getNom();
          ?>
        </td>
        <td><?php
        $profil = $tabOffreDAlt[$i]->getListeProfilSouhaite();
        for ($j = 0; $j < sizeof($profil); $j++) {
          if ($j == (sizeof($profil) - 1)) {
            echo $profil[$j]->getNom();
          } else {
            echo $profil[$j]->getNom() . " / ";
          }
        }
        ?>
      </td>
      <td><?php
      $themes = $tabOffreDAlt[$i]->getThemes();
      for ($j = 0; $j < sizeof($themes); $j++) {
        if ($j == (sizeof($themes) - 1)) {
          echo $themes[$j]->getNom();
        } else {
          echo $themes[$j]->getNom() . " / ";
        }
      }
      ?>
    </td>
    <td align="center">
      <a href="./editionOffreDeStage.php?id=<?php echo $tabOffreDAlt[$i]->getIdentifiantBDD(); ?>">
        <img src="../../images/search.png">
      </a>
    </td>
  </tr>
  <?php
  }
  }
  ?>

  <br/><br/>
  <?php
  }


  /**
  * Afficher le contenu d'une offre de stage (sans modification possible)
  * @param OffreDeStage $offreDeStage L'objet à visualiser
  * @param string $page La page de retour
  * @param string $nom_init Nom de l'entreprise
  * @param string $ville_init Nom de la ville de l'entreprise
  * @param string $cp_init Code postal de l'entreprise
  * @param string $pays_init Le pays du lieu du stage
  * @param string $filiere_init La filière concernée
  * @param string $parcours_init Le parcours concerné
  * @param string $duree_init La durée du stage
  * @param string $competence_init Les compétences demandées
  */





  public static function visualiserOffre($offreDAlt, $page, $nom_init,
  $ville_init, $cp_init, $pays_init, $filiere_init, $parcours_init,
  $duree_init, $competence_init) {
    $competences = $offreDAlt->getListesCompetences();
    $themes = $offreDAlt->getThemes();
    $profils = $offreDAlt->getListeProfilSouhaite();
    $contact = $offreDAlt->getContact();
    $entreprise = $offreDAlt->getEntreprise();
    $environnement = explode(";", $offreDAlt->getListeEnvironnements());
    ?>
    <table>
      <tr>
        <td colspan=2>
          <table id="presentation_saisieOffreDeStage">
            <tr id="entete2">
              <td colspan="2">Alternance</td>
            </tr>
            <tr>
              <th>Titre de l'aternance :</th>
              <td><?php echo $offreDAlt->getTitre(); ?></td>
            </tr>
            <tr>
              <th>Sujet de l'alternance :</th>
              <td><?php echo $offreDAlt->getSujet(); ?></td>
            </tr>
            <tr>
              <th colspan="2"><p/><hr/><p/></th>
            </tr>
            <tr>
              <th>Compétence(s) :</th>
              <td>
                <!-- Récupération des compétences -->
                <?php
                for ($i = 0; $i < sizeof($competences); $i++) {
                  $competence = Competence::getCompetence($competences[$i]->getIdentifiantBDD());
                  if ($i == (sizeof($competences) - 1)) {
                    echo $competence->getNom();
                  } else {
                    echo $competence->getNom() . ", ";
                  }
                }
                ?>
              </td>
            </tr>

            <tr>
              <th width="160">Environnement(s) :</th>
              <td>
                <?php
                $winTrouve = false;
                $unixTrouve = false;
                $macTrouve = false;
                if (isset($environnement)) {
                  for ($i = 0; $i < sizeof($environnement); $i++) {
                    if ($environnement[$i] == "win")
                    echo " Windows ";
                    if ($environnement[$i] == "unix")
                    echo " Unix/Linux ";
                    if ($environnement[$i] == "mac")
                    echo " Macintosh ";
                  }
                }
                ?>
              </td>
            </tr>
            <tr>
              <th>Thème de l'aternance :</th>
              <td>
                <!-- Récupération des parcours -->
                <?php
                for ($i = 0; $i < sizeof($themes); $i++) {
                  $parcours = Parcours::getParcours($themes[$i]->getIdentifiantBDD());
                  if ($i == (sizeof($themes) - 1)) {
                    echo $parcours->getNom();
                  } else {
                    echo $parcours->getNom() . ", ";
                  }
                }
                ?>
              </td>
            </tr>
            <tr>
              <th>Profil souhaité :</th>
              <td>
                <!-- Récupération des filières -->
                <?php
                for ($i = 0; $i < sizeof($profils); $i++) {
                  $filiere = Filiere::getFiliere($profils[$i]->getIdentifiantBDD());
                  if ($i == (sizeof($profils) - 1)) {
                    echo $filiere->getNom();
                  } else {
                    echo $filiere->getNom() . ", ";
                  }
                }
                ?>
              </td>
            </tr>
            <tr>
              <th colspan="2"><p/><hr/><p/></th>
            </tr>
            <tr>
              <th>Durée :</th>
              <td> <?php echo $offreDAlt->getDuree(); ?> an(s)</td>
            </tr>
            <tr>
              <th>Indemnités :</th>
              <td><?php if ($offreDAlt->getIndemnite()) { echo $offreDAlt->getIndemnite(); } else { echo " "; } ?></td>
            </tr>
            <tr>
              <th>Remarques diverses :</th>
              <td><?php echo $offreDAlt->getRemarques(); ?></td>
            </tr>

            <tr>
              <th>type de contrat :</th>
              <td><?php echo $offreDAlt->getTypeContratStr(); ?></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan=2>
          <table id="presentation_saisieOffreDeStage">
            <tr id="entete2">
              <td colspan="2">Entreprise</td>
            </tr>
            <tr>
              <th width="160">Nom :</th>
              <td><?php echo $entreprise->getNom(); ?></td>
            </tr>
            <tr>
              <th>Adresse :</th>
              <td><?php echo $entreprise->getAdresse(); ?></td>
            </tr>
            <tr>
              <th>Ville :</th>
              <td><?php echo $entreprise->getVille(); ?></td>
            </tr>
            <tr>
              <th>Code postal :</th>
              <td><?php echo $entreprise->getcodePostal(); ?></td>
            </tr>
            <tr>
              <th>Pays :</th>
              <td><?php echo $entreprise->getPays(); ?></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <table id="presentation_saisieOffreDeStage">
            <tr id="entete2">
              <td colspan="2">Contact ou tuteur/maître d’apprentissage</td>
            </tr>
            <tr>
              <th width="160">Nom :</th>
              <td><?php echo $contact->getNom(); ?></td>
            </tr>
            <tr>
              <th>Prénom :</th>
              <td><?php echo $contact->getPrenom(); ?></td>
            </tr>
            <tr>
              <th>Tel :</th>
              <td><?php echo $contact->getTelephone(); ?></td>
            </tr>
            <tr>
              <th>Fax :</th>
              <td><?php echo $contact->getTelecopie(); ?></td>
            </tr>
            <tr>
              <th>Email :</th>
              <td><?php echo $contact->getEmail(); ?></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align="center">
          <FORM width="500" method="post" action="<?php echo $page; ?>">
            <?php if ($nom_init != "") echo "<input type='hidden' value='" . $nom_init . "' name='nom'/>" ?>
            <?php if ($ville_init != "") echo "<input type='hidden' value='" . $ville_init . "' name='ville'/>" ?>
            <?php if ($cp_init != "") echo "<input type='hidden' value=" . $cp_init . " name='cp'/>" ?>
            <?php if ($pays_init != "") echo "<input type='hidden' value=" . $pays_init . " name='pays'/>" ?>
            <?php if ($filiere_init != "") echo "<input type='hidden' value=$filiere_init name='filiere'/>" ?>
            <?php if ($parcours_init != "") echo "<input type='hidden' value=$parcours_init name='parcours'/>" ?>
            <?php if ($duree_init != "") echo "<input type='hidden' value=$duree_init name='duree'/>" ?>
            <?php if ($competence_init != "") echo "<input type='hidden' value=$competence_init name='competence'/>" ?>
            <input type="hidden" value="1" name="rech" />
            <input type="submit" value="Retour"/>
          </form>
        </td>
      </tr>
    </table>
    <?php
  }


  /**
  * Afficher un formulaire de sélection des offres de stage
  * @param string $fichier La page de traitement du formulaire
  */
  public static function afficherFormulaireSuivi($tabEtu, $annee, $parcours, $filiere) {
    $tabE = Entreprise::getListeEntreprises('');
    ?>
    <form action="javascript:">
      <table width="100%">
        <tr>
          <td width="50%" align="center">
            <table>
              <tr>
                <td>Nom de l'etudiant</td>
                <td>
                  <select name="idEtudiant">
                    <option value="-1"></option>
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
          </td>
          <td width="50%">
            <table>
              <tr>
                <td>Nom de l'entreprise</td>
                <td>
                  <select id="filiere" name="filiere">
                    <?php
                    echo "<option value='*'>Tous</option>";
                    for ($i = 0; $i < sizeof($tabE); $i++) {
                      if (isset($_POST['filiere']) && $_POST['filiere'] == $tabE[$i]->getIdentifiantBDD())
                      echo "<option selected value='" . $tabE[$i]->getIdentifiantBDD() . "'>" . $tabE[$i]->getNom() . "</option>";
                      else
                      echo "<option value='" . $tabE[$i]->getIdentifiantBDD() . "'>" . $tabE[$i]->getNom() . "</option>";
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
    <?php
  }
}
?>
