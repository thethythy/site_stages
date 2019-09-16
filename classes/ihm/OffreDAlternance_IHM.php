<?php

class OffreDAlternance_IHM {

  /**
  * Afficher un formulaire de sélection des offres d'alternance
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
  * Afficher un tableau interactif des alternances disponibles
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
        if ($tabOffreDAlt[$i]->estVisible()) {//A changer ...
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
  * - une liste des offres d'alternance pas encore validées
  * - une liste des offres d'alternance déjà validées
  * Dans les cas, la sélection permet d'éditer l'offre
  * @param tableau d'objets $tabOffreDAlt Les objets OffreDAlternance concernés
  */
  public static function afficherListeOffresAEditer($tabOffreDAlt) {
    $cpt = 0;
    $enteteAffichee = false;

    for ($i = 0; $i < sizeof($tabOffreDAlt); $i++) {
      if (!$tabOffreDAlt[$i]->estVisible()) {
        if (!$enteteAffichee) {
          $enteteAffichee = true;
          ?>
          <p>Voici la liste des offres d'alternance qu'il reste à traiter :</p>
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
        <a href="./editionOffreDAlternance.php?id=<?php echo $tabOffreDAlt[$i]->getIdentifiantBDD(); ?>">
          <img src="../../images/search.png">
        </a>
      </td>
    </tr>
    <?php
  }
}

if ($cpt == 0) {
  echo "<p>Toutes les offres d'alternance ont été validées.</p>";
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
  echo "<p>Voici la liste des offres d'alternance disponibles sur le site des alternances : </p>";
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
    <a href="./editionOffreDAlternance.php?id=<?php echo $tabOffreDAlt[$i]->getIdentifiantBDD(); ?>">
      <img src="../../images/search.png">
    </a>
  </td>
</tr>
<?php
}
}
echo "</table>";
?>

<br/><br/>
<?php
}


/**
* Afficher un formulaire d'édition d'une offre d'alternance
* (utiliser notamment pour valider une offre)
*/
public static function afficherFormulaireModification() {
  ?>
  <script language="javascript">
  function ajout_competence() {
    var code = "";
    var compteur = parseInt(document.getElementById('compteur_competence').value);
    code = "Nom : <input type='text' name='competence_ajout" + compteur + "'/><br/> ";
    compteur += 1;
    document.getElementById('compteur_competence').value = compteur;
    document.getElementById('ajout_competence').innerHTML += code;
  }
  </script>

  <p>Les champs marqués d'une * sont obligatoires</p>

  <FORM METHOD="POST" ACTION="">
    <!-- Dans le cas d'une modification d'une offre d'alternance -->
    <?php
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
      ?>
      <input type="hidden" value="<?php echo $_GET['id']; ?>" name="idOffreDAlternance"/>

      <?php
      $modificationOffreDAlternance = OffreDAlternance::getOffreDAlternance($_GET['id']);
      $modificationCompetences = $modificationOffreDAlternance->getListesCompetences();
      $modificationThemes = $modificationOffreDAlternance->getThemes();
      $modificationProfils = $modificationOffreDAlternance->getListeProfilSouhaite();
      $modificationContact = $modificationOffreDAlternance->getContact();
      $modificationEntreprise = $modificationContact->getEntreprise();
    }
    ?>

    <input type="hidden" name="estVisible" value="<?php if (isset($modificationOffreDAlternance)) { echo $modificationOffreDAlternance->estVisible(); } ?>"/>

    <table id="table_saisieOffreDAlternance">
	<tr>
	    <td colspan=2>
		<table id="presentation_saisieOffreDAlternance">
		    <tr id="entete2">
			<td colspan=2>Alternance</td>
		    </tr>
		    <tr>
			<th>Titre de l'alternance (*) :</th>
			<td>
			    <input type="text" name="titre" size="100" value="<?php
			    if (isset($_POST['titre'])) {
				echo $_POST['titre'];
			    } else if (isset($modificationOffreDAlternance)) {
				echo htmlentities($modificationOffreDAlternance->getTitre(), ENT_QUOTES, 'utf-8');
			    }
			    ?>">
			</td>
		    </tr>
		    <tr>
			<th>Sujet de l'alternance (*) :</th>
			<td>
			    <textarea name="sujet"><?php
				if (isset($_POST['sujet'])) {
				    echo $_POST['sujet'];
				} else if (isset($modificationOffreDAlternance)) {
				    echo $modificationOffreDAlternance->getSujet();
				}
				?></textarea>
			</td>
		    </tr>
		    <tr>
			<th colspan="2">Profil souhaité :</th>
		    </tr>
		    <tr>
			<td colspan="2">
			    <table>
				<!-- Récupération des filières -->
				<?php
				$tabFilieres = Filiere::listerFilieres();
				for ($i = 0; $i < sizeof($tabFilieres); $i++) {
				    if ($i % 5 == 0) {
					echo "<tr>";
				    }

				    if (isset($_POST['filiere' . $tabFilieres[$i]->getIdentifiantBDD()])) {
					echo "<td width='150'><input checked='checked' type='checkbox' value='" . $tabFilieres[$i]->getIdentifiantBDD() . "'name='filiere" . $tabFilieres[$i]->getIdentifiantBDD() . "'> " . $tabFilieres[$i]->getNom() . "</td>";
				    } else {
					$profilTrouve = false;
					if (isset($modificationProfils)) {
					    for ($j = 0; $j < sizeof($modificationProfils); $j++) {
						if ($modificationProfils[$j]->getIdentifiantBDD() == $tabFilieres[$i]->getIdentifiantBDD()) {
						    $profilTrouve = true;
						}
					    }
					}
					if ($profilTrouve) {
					    echo "<td width='150'><input checked='checked' type='checkbox' value='" . $tabFilieres[$i]->getIdentifiantBDD() . "'name='filiere" . $tabFilieres[$i]->getIdentifiantBDD() . "'> " . $tabFilieres[$i]->getNom() . "</td>";
					} else {
					    echo "<td width='150'><input type='checkbox' value='" . $tabFilieres[$i]->getIdentifiantBDD() . "'name='filiere" . $tabFilieres[$i]->getIdentifiantBDD() . "'> " . $tabFilieres[$i]->getNom() . "</td>";
					}
				    }
				    if ($i % 5 == 5) {
					echo "</tr>";
				    }
				}
				?>
			    </table>
				</td>
			    </tr>
		    <tr>
			<td colspan="2">
			    Copier/coller le texte suivant pour insérer un lien html vers un document descriptif :<br/>
			    <?php echo htmlentities("<a href='http://info-stages.univ-lemans.fr/documents/sujetsDAlternances/nom_document'>Commentaire</a>", ENT_QUOTES, 'utf-8'); ?>
			</td>
		    </tr>
		    <tr>
			<th colspan="2"><p/><hr/><p/></th>
		    </tr>
		    <tr>
			<th>Durée (*) :</th>
			<td><select name="duree">
				<?php
				for ($i = 1; $i <= 2; $i++) {
				    if ((isset($modificationOffreDAlternance) && $modificationOffreDAlternance->getDuree() == $i) ||
					    (isset($_POST['duree']) && $_POST['duree'] == $i)) {
					echo"<option selected value='$i'>$i</option>";
				    } else {
					echo"<option value='$i'>$i</option>";
				    }
				}
				?>
			    </select> an(s)
			</td>
		    </tr>
		    <tr>
			<th>Indemnités :</th>
			<td>
			    <input type="text" name="indemnites" size="50" value="<?php
			    if (isset($_POST['indemnites'])) {
				echo $_POST['indemnites'];
			    } else if (isset($modificationOffreDAlternance)) {
				echo $modificationOffreDAlternance->getIndemnite();
			    }
			    ?>"/>
			</td>
		    </tr>
		    <tr id="divTypeContrat"><!--Choisir le type de contrat  -->
			<th>Type de contrat (*) :</th>
			<td>
			    <input type="radio" name ="typeContrat" <?php if ((isset($modificationOffreDAlternance) && $modificationOffreDAlternance->getTypeContrat() == 1) ||
				    (isset($_POST['typeContrat']) && $_POST['typeContrat'] == 1)) {
				echo 'checked="checked"';
			    }
			    ?> value="1"> Apprentissage
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    <input type="radio" name ="typeContrat" <?php if ((isset($modificationOffreDAlternance) && $modificationOffreDAlternance->getTypeContrat() == 0) ||
				    (isset($_POST['typeContrat']) && $_POST['typeContrat'] == 0)) {
				echo 'checked="checked"';
			    }
			    ?> value="0"> Professionnalisation
			</td>
		    </tr>
		    <tr>
			<th colspan="2"><p/><hr/><p/></th>
		    </tr>
		    <tr>
			<th colspan="2">Compétence(s) (*) :</th>
		    </tr>
		    <tr>
			<td colspan="2">
				    <table>
					<!-- Récupération des compétences -->
					<?php
					$tabCompetences = Competence::listerCompetences();
					for ($i = 0; $i < sizeof($tabCompetences); $i++) {
					    if ($i % 6 == 0) {
						echo "<tr>";
					    }

					    if (isset($_POST['competence' . $tabCompetences[$i]->getIdentifiantBDD()])) {
						echo "<td width='100'><input checked='checked' type='checkbox' value='" . $tabCompetences[$i]->getIdentifiantBDD() . "' name='competence" . $tabCompetences[$i]->getIdentifiantBDD() . "'> " . $tabCompetences[$i]->getNom() . "</td>";
					    } else {
						$competenceTrouve = false;
						if (isset($modificationCompetences)) {
						    for ($j = 0; $j < sizeof($modificationCompetences); $j++) {
							if ($modificationCompetences[$j]->getIdentifiantBDD() == $tabCompetences[$i]->getIdentifiantBDD()) {
							    $competenceTrouve = true;
							}
						    }
						}
						if ($competenceTrouve) {
						    echo "<td width='100'><input checked='checked' type='checkbox' value='" . $tabCompetences[$i]->getIdentifiantBDD() . "' name='competence" . $tabCompetences[$i]->getIdentifiantBDD() . "'> " . $tabCompetences[$i]->getNom() . "</td>";
						} else {
						    echo "<td width='100'><input type='checkbox' value='" . $tabCompetences[$i]->getIdentifiantBDD() . "' name='competence" . $tabCompetences[$i]->getIdentifiantBDD() . "'> " . $tabCompetences[$i]->getNom() . "</td>";
						}
					    }

					    if ($i % 6 == 6) {
						echo "</tr>";
					    }
					}
					?>
				    </table>
				</td>
		    </tr>
		    <tr>
			<td colspan="2">
			    <input type="button" value="Ajouter une compétence" onClick="ajout_competence()">
			    <input type="hidden" value="0" name="compteur_competence" id="compteur_competence"/>
			    <div id="ajout_competence"></div>
			</td>
		    </tr>
		    <tr>
			<th colspan="2">Thème de l'alternance :</th>
		    </tr>
		    <tr>
			<td colspan="2">
			    <table>
				<!-- Récupération des parcours -->
				<?php
				$tabParcours = Parcours::listerParcours();
				for ($i = 0; $i < sizeof($tabParcours); $i++) {
				    if ($i % 5 == 0) {
					echo "<tr>";
				    }

				    if (isset($_POST['parcours' . $tabParcours[$i]->getIdentifiantBDD()])) {
					echo "<td width='150'><input checked='checked' type='checkbox' value='" . $tabParcours[$i]->getIdentifiantBDD() . "'name='parcours" . $tabParcours[$i]->getIdentifiantBDD() . "'> " . $tabParcours[$i]->getNom() . "</td>";
				    } else {
					$themeTrouve = false;
					if (isset($modificationThemes)) {
					    for ($j = 0; $j < sizeof($modificationThemes); $j++) {
						if ($modificationThemes[$j]->getIdentifiantBDD() == $tabParcours[$i]->getIdentifiantBDD()) {
						    $themeTrouve = true;
						}
					    }
					}
					if ($themeTrouve) {
					    echo "<td width='150'><input checked='checked' type='checkbox' value='" . $tabParcours[$i]->getIdentifiantBDD() . "'name='parcours" . $tabParcours[$i]->getIdentifiantBDD() . "'> " . $tabParcours[$i]->getNom() . "</td>";
					} else {
					    echo "<td width='150'><input type='checkbox' value='" . $tabParcours[$i]->getIdentifiantBDD() . "'name='parcours" . $tabParcours[$i]->getIdentifiantBDD() . "'> " . $tabParcours[$i]->getNom() . "</td>";
					}
				    }
				    if ($i % 5 == 5) {
					echo "</tr>";
				    }
				}
				?>
			    </table>
			</td>
		    </tr>
		    <tr>
			<th colspan="2"><p/><hr/><p/></th>
		    </tr>
		    <tr>
			<th>Remarques diverses :</th>
			<td>
			    <textarea name="rmq"><?php
				if (isset($_POST['rmq'])) {
				    echo $_POST['rmq'];
				} else if (isset($modificationOffreDAlternance)) {
				    echo $modificationOffreDAlternance->getRemarques();
				}
				?></textarea>
			</td>
		    </tr>
		</table>
	    </td>
	</tr>
	<tr>
	    <td colspan=2>
		<table id="presentation_saisieOffreDAlternance">
		    <tr id="entete2">
			<td colspan=2>Entreprise</td>
		    </tr>
		    <tr>
			<th width="170">Nom (*) :</th>
			<td>
			    <input type="text" name="nom_entreprise" size="50" value="<?php
			    if (isset($_POST['nom_entreprise'])) {
				echo $_POST['nom_entreprise'];
			    } else if (isset($modificationEntreprise)) {
				echo htmlentities($modificationEntreprise->getNom(), ENT_QUOTES, 'UTF-8');
			    }
			    ?>"
				   />
			</td>
		    </tr>
		    <tr>
			<th>Adresse (*) :</th>
			<td>
			    <input type="text" name="adresse" size="50" value="<?php
			    if (isset($_POST['adresse'])) {
				echo $_POST['adresse'];
			    } else if (isset($modificationEntreprise)) {
				echo htmlentities($modificationEntreprise->getAdresse(), ENT_QUOTES, 'UTF-8');
			    }
			    ?>"
				   />
			</td>
		    </tr>
		    <tr>
			<th>Ville (*) :</th>
			<td>
			    <input type="text" name="ville" size="50" value="<?php
			    if (isset($_POST['ville'])) {
				echo $_POST['ville'];
			    } else if (isset($modificationEntreprise)) {
				echo htmlentities($modificationEntreprise->getVille(), ENT_QUOTES, 'UTF-8');
			    }
			    ?>"
				   />
			</td>
		    </tr>
		    <tr>
			<th>Code postal (*) :</th>
			<td>
			    <input type="text" name="codePostal" size="50" value="<?php
			    if (isset($_POST['codePostal'])) {
				echo $_POST['codePostal'];
			    } else if (isset($modificationEntreprise)) {
				echo htmlentities($modificationEntreprise->getcodePostal(), ENT_QUOTES, 'UTF-8');
			    }
			    ?>"
				   />
			</td>
		    </tr>
		    <tr>
			<th>Pays :</th>
			<td>
			    <input type="text" name="pays" size="50" value="<?php
			    if (isset($_POST['pays'])) {
				echo $_POST['pays'];
			    } else if (isset($modificationEntreprise)) {
				echo $modificationEntreprise->getPays();
			    } else {
				echo 'FRANCE';
			    }
			    ?>"
				   />
			</td>
		    </tr>
		    <tr>
			<th>Email DRH ou équivalent :</th>
			<td>
			    <input type="text" name="email_entreprise" size="50" value="<?php
			    if (isset($_POST['email_entreprise'])) {
				echo $_POST['email_entreprise'];
			    } else {
				echo "";
			    }
			    ?>"
				   />
			</td>
		    </tr>
		    <tr>
			<th>SIRET (*) : </th>
			<td>
			    <input type="text" name="siret" size="50" value="<?php
			    if (isset($_POST['siret'])) {
				echo $_POST['siret'];
			    } else if (isset($modificationEntreprise)) {
				echo $modificationEntreprise->getSiret();
			    } else {
				echo 'SIRET VIDE';
			    }
			    ?>"
				   />
			</td>
		    </tr>
		</table>
	    </td>
	</tr>
	<tr>
	    <td colspan="2">
		<table id="presentation_saisieOffreDAlternance">
		    <tr id="entete2">
			<td colspan=2>Contact ou Maître d'alternance</td>
		    </tr>
		    <tr>
			<th width="170">Nom (*) :</th>
			<td>
			    <input type="text" name="nom_contact" size="50" value="<?php
				   if (isset($_POST['nom_contact'])) {
				       echo $_POST['nom_contact'];
				   } else if (isset($modificationContact)) {
				       echo htmlentities($modificationContact->getNom(), ENT_QUOTES, 'utf-8');
				   }
				   ?>"
				   />
			</td>
		    </tr>
		    <tr>
			<th>Prénom (*) :</th>
			<td>
			    <input type="text" name="prenom_contact" size="50" value="<?php
				   if (isset($_POST['prenom_contact'])) {
				       echo $_POST['prenom_contact'];
				   } else if (isset($modificationContact)) {
				       echo htmlentities($modificationContact->getPrenom(), ENT_QUOTES, 'utf-8');
				   }
				   ?>"
				   />
			</td>
		    </tr>
		    <tr>
			<th>Tel (*) :</th>
			<td>
			    <input type="text" name="tel_contact" size="50" value="<?php
				   if (isset($_POST['tel_contact'])) {
				       echo $_POST['tel_contact'];
				   } else if (isset($modificationContact)) {
				       echo htmlentities($modificationContact->getTelephone(), ENT_QUOTES, 'UTF-8');
				   }
				   ?>"
				   />
			</td>
		    </tr>
		    <tr>
			<th>Email (*) :</th>
			<td>
			    <input type="text" name="email_contact" size="50" value="<?php
				   if (isset($_POST['email_contact'])) {
				       echo $_POST['email_contact'];
				   } else if (isset($modificationContact)) {
				       echo htmlentities($modificationContact->getEmail(), ENT_QUOTES, 'utf-8');
				   }
				   ?>"
				   />
			</td>
		    </tr>
		</table>
	    </td>
	</tr>
	<tr>
	    <td colspan="2">
		<input type="submit" name="valider" value="Valider l'offre d'alternance">
		<input type="submit" name="cancel" value="Effacer l'offre d'alternance">
	    </td>
	</tr>
    </table>
</FORM>
<br/><br/>
<?php
}


/**
* Afficher le contenu d'une offre d'alternance (sans modification possible)
* @param OffreDAlternance $offreDAlternance L'objet à visualiser
* @param string $page La page de retour
* @param string $nom_init Nom de l'entreprise
* @param string $ville_init Nom de la ville de l'entreprise
* @param string $cp_init Code postal de l'entreprise
* @param string $pays_init Le pays du lieu de l'alternance
* @param string $filiere_init La filière concernée
* @param string $parcours_init Le parcours concerné
* @param string $duree_init La durée de l'alternance
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
  ?>
  <table>
    <tr>
      <td colspan=2>
        <table id="presentation_saisieOffreDAlternance">
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
        <table id="presentation_saisieOffreDAlternance">
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
	  <tr>
	      <th>Siret :</th>
	      <td><?php echo $entreprise->getSiret(); ?></td>
	  </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <table id="presentation_saisieOffreDAlternance">
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
* Afficher un formulaire de sélection des offres d'alternance
* @param string $fichier La page de traitement du formulaire
*/
public static function afficherFormulaireSuivi($tabOffreDAlt, $tabEtu) {
  ?>
  <form action="javascript:">
    <table width="100%">
      <tr>
        <td width='50%' align='center'>Nom de l'etudiant :
          <!-- <select name="idEtudiant" id="idEtudiant"> -->
          <select name="idEtudiant" id="idEtudiant" onchange='populateEtudiant()'>
            <option value="-1">-------------------------</option>
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
        <td width = '50%'></td>
      </tr>
    </table>
  </form>
  <form action='' method='POST' class='formToTableCheatStyle'>
    <table class='tableToFormCheatStyle'>
      <tr id="entete">
        <td width="30%" class='cellBordersCheatStyle'>Titre</td>
        <td width="35%" class='cellBordersCheatStyle'>Entreprise</td>
        <td width="15%" class='cellBordersCheatStyle'>Etat</td>
      </tr>
      <?php
      $cpt = 0;
      for ($i = 0; $i < sizeof($tabOffreDAlt); $i++) {
        ?>
        <tr id="ligne<?php echo $cpt % 2; $cpt++; ?>">
          <td class='cellBordersCheatStyle' id="idOffre-<?php echo $tabOffreDAlt[$i]->getIdentifiantBDD(); ?>"><?php echo $tabOffreDAlt[$i]->getTitre(); ?></td>
          <td class='cellBordersCheatStyle' id="idEntreprise-<?php echo $tabOffreDAlt[$i]->getEntreprise()->getIdentifiantBDD(); ?>">
            <?php
            $entreprise = $tabOffreDAlt[$i]->getEntreprise();
            echo $entreprise->getNom();
            ?>
          </td>
          <td align="center"  class='cellBordersCheatStyle'>
            <select <?php echo 'id="idStatut-'.$i.'" name="statut'.$i.'"'; ?> >
              <option value="-------------">-------------</option>
              <option value="Pas intéressé">Pas intéressé</option>
              <option value="Postulé">Postulé</option>
              <option value="Entretien en attente">Entretien en attente</option>
              <option value="Entretien passé">Entretien passé</option>
              <option value="Accepté">Accepté</option>
              <option value="Refusé">Refusé</option>
            </select>
          </td>
        </tr>
        <?php
      }
      ?>
    </table>
  </form>
  <div class="align-center"><button type="button" onclick="postForm()">Enregistrer</button></div>

  <?php
}

/**
* Afficher un formulaire de sélection des offres d'alternance
* @param string $fichier La page de traitement du formulaire
*/
public static function afficherFormulaireSuiviGestion($tabC, $tabEtu) {
  ?>
  <form action="javascript:">
    <table width="100%">
      <tr>
        <td width='50%' align='center'>Nom de l'etudiant :
          <!-- <select name="idEtudiant" id="idEtudiant"> -->
          <select name="idEtudiant" id="idEtudiant" onchange='populateEtudiant();'>
            <option value="0">Tous</option>
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
        <td width = '50%'></td>
      </tr>
    </table>
  </form>
  <?php if(sizeof($tabC) != 0){ ?>
    <table>
      <tr id="entete">
        <td id="idEtu-0" name='nomEtu-0'>Nom Étudiant</td>
        <td>Titre</td>
        <td>Entreprise</td>
        <td>Etat</td>
      </tr>
      <?php
      $cpt = 0;
      for ($i = 0; $i < sizeof($tabC); $i++) {
        ?>
        <tr id="ligne<?php echo $cpt % 2; $cpt++; ?>" id="ligneCandidature-<?php echo $cpt;?>">
          <?php echo '<td id="idEtu-'.$tabC[$i]->getEtudiant().'"  name="nomEtu-'.$cpt.'">'. Etudiant::getEtudiant($tabC[$i]->getEtudiant())->getNom().' '. Etudiant::getEtudiant($tabC[$i]->getEtudiant())->getPrenom().'</td>';?>
          <?php echo '<td>'. OffreDAlternance::getOffreDAlternance($tabC[$i]->getOffre())->getTitre().'</td>'; ?>
          <?php echo '<td>'.Entreprise::getEntreprise($tabC[$i]->getEntreprise())->getNom().'</td>'; ?>
          <?php echo '<td id="statut-<?php echo $cpt;?>">'.$tabC[$i]->getStatut().'</td>' ?>
        </tr>
        <?php
      }
      ?>
    </table >

  <?php
}
}

}
?>
