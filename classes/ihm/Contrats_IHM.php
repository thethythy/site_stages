<?php

class Contrats_IHM {

    /**
     * Afficher un formulaire de création ou de modification d'une convention de stage
     * Si $contrat = "" alors il s'agit d'un formulaire de création (champs vide)
     * @param Entreprise $contrat Objet qui est modifié et dont les informations son affichées.
     * @param tableau d'objets $tabEtu Tableau contenant les étudiants à afficher
     * @param integer $annee Année de la promotion
     * @param integer $parcours Identifiant du parcours de la promotion
     * @param integer $filiere Identifiant de la filière de la promotion
     */
    public static function afficherFormulaireSaisie($contrat, $tabEtu, $annee, $parcours, $filiere) {

	if ($contrat != "") {
	    $parrain = $contrat->getParrain();
	    $etudiant = $contrat->getEtudiant();
	    $contact = $contrat->getContact();
	}
	?>
	<form method=post action="">
	    <table width="100%">
		<tr>
		    <td width="100%" align="center">
			<table>
			    <tr>
				<td>Etudiant</td>
				<td>
				    <?php
				    if ($contrat != "") {
					echo $etudiant->getNom() . " " . $etudiant->getPrenom();
				    } else {
				    ?>
				    <select name="idEtu" style="width: 300px;">
					<?php
					for ($i = 0; $i < sizeof($tabEtu); $i++) {
					    if ((isset($_POST['idEtu'])) && ($_POST['idEtu'] == $tabEtu[$i]->getIdentifiantBDD()))
						echo "<option selected value='" . $tabEtu[$i]->getIdentifiantBDD() . "'>" . $tabEtu[$i]->getNom() . " " . $tabEtu[$i]->getPrenom() . "</option>";
					    else
						echo "<option value='" . $tabEtu[$i]->getIdentifiantBDD() . "'>" . $tabEtu[$i]->getNom() . " " . $tabEtu[$i]->getPrenom() . "</option>";
					}
					?>
				    </select>
					    <?php
					}
					?>
				</td>
			    </tr>
			    <tr>
				<td>Référent</td>
				<td>
				    <select name="idPar" style="width: 300px;">
					<?php
					$tabPar = Parrain::listerParrain();
					for ($i = 0; $i < sizeof($tabPar); $i++) {
					    if ((($contrat != "") && ($parrain->getIdentifiantBDD() == $tabPar[$i]->getIdentifiantBDD())) ||
						((isset($_POST['idPar'])) && ($_POST['idPar'] == $tabPar[$i]->getIdentifiantBDD())))
						echo "<option selected value='" . $tabPar[$i]->getIdentifiantBDD() . "'>" . $tabPar[$i]->getNom() . " " . $tabPar[$i]->getPrenom() . "</option>";
					    else
						echo "<option value='" . $tabPar[$i]->getIdentifiantBDD() . "'>" . $tabPar[$i]->getNom() . " " . $tabPar[$i]->getPrenom() . "</option>";
					}
					?>
				    </select>
				</td>
			    </tr>
			    <tr>
			    </tr>
			    <tr>
				<td>Référent entreprise</td>
				<td>
				    <select name="idCont" style="width: 300px;">
					<?php
					$tabCont = Contact::getListeContacts("");
					for ($i = 0; $i < sizeof($tabCont); $i++) {
					    $entreprise = $tabCont[$i]->getEntreprise();
					    $nomEntreprise = " - " . $entreprise->getNom() . " (" . $entreprise->getVille() . ")";
					    if ((($contrat != "") && ($contact->getIdentifiantBDD() == $tabCont[$i]->getIdentifiantBDD())) ||
						((isset($_POST['idCont'])) && ($_POST['idCont'] == $tabCont[$i]->getIdentifiantBDD())))
						echo "<option selected value='" . $tabCont[$i]->getIdentifiantBDD() . "'>" . $tabCont[$i]->getNom() . " " . $tabCont[$i]->getPrenom() . $nomEntreprise . "</option>";
					    else
						echo "<option value='" . $tabCont[$i]->getIdentifiantBDD() . "'>" . $tabCont[$i]->getNom() . " " . $tabCont[$i]->getPrenom() . $nomEntreprise . "</option>";
					}
					?>
				    </select>
				</td>
			    </tr>
			    <tr>
				<td>Thème de stage</td>
				<td>
				    <select name="idTheme" style="width: 300px;">
				    <?php
				    $tabTheme = ThemeDeStage::getListeTheme();
				    for ($i = 0; $i < sizeof($tabTheme); $i++) {
					$couleur = $tabTheme[$i]->getCouleur();
					if (($contrat != "") && $tabTheme[$i]->getIdentifiantBDD() == $contrat->getIdTheme())
					    echo "<option selected value='" . $tabTheme[$i]->getIdentifiantBDD() . "'style='color: #" . $couleur->getCode() . ";'>" . $tabTheme[$i]->getTheme() . "</option>";
					else
					    echo "<option value='" . $tabTheme[$i]->getIdentifiantBDD() . "'style='color: #" . $couleur->getCode() . ";'>" . $tabTheme[$i]->getTheme() . "</option>";
				    }
				    ?>
				    </select>
				</td>
			    </tr>


			    <tr>
            <td>Type Offre</td>
    				<td>

              <?php
  				    if (($contrat != "") && ($contrat->getTypeDeContrat() == 0)) {
  					         echo "<input type='radio' id='' name ='typeContrat'  value='1' onclick=''> Apprentissage
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type='radio'  id='' name ='typeContrat' checked='checked' value='0' onclick=''> Professionnalisation";
  				    } else {
                echo "<input type='radio' id='' name ='typeContrat' checked='checked' value='1' onclick=''> Apprentissage
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <input type='radio'  id='' name ='typeContrat'  value='0' onclick=''> Professionnalisation";
  				    }
  				    ?>

    				</td>
          </tr>

          <tr>
            <td>Durée du contrat</td>
    				<td>

              <?php
  				    if (($contrat != "") && ($contrat->getDuree() == 2)) {
  					         echo "<input type='radio' id='' name ='dureeContrat'  value='1' onclick=''> 1 an
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type='radio'  id='' name ='dureeContrat' checked='checked' value='2' onclick=''> 2 ans";
  				    } else {
                echo "<input type='radio' id='' name ='dureeContrat' checked='checked' value='1' onclick=''> 1 an
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <input type='radio'  id='' name ='dureeContrat'  value='2' onclick=''> 2 ans";
  				    }
  				    ?>

    				</td>
          </tr>


          <tr>
            <td>Indemnités mensuelles</td>
    				<td>

              <?php
              if ($contrat != "") {
              echo "<input type='text' name='indemnite' size='100' value =". $contrat->getIndemnites() ." >";
              } else {
              echo "<input type='text' name='indemnite' size='100' >";
              }
  				    ?>

    				</td>
          </tr>


				<td>
				    <?php
				    if (($contrat != "") && ($contrat->getASonResume() == 1)) {
					echo "Résumé du stage";
				    } else {
					echo "Sujet de stage";
				    }
				    ?>
				</td>
				<td>
				    <?php
				    if (($contrat != "") && ($contrat->getASonResume() == 1)) {
					echo "<a href='../../documents/resumes/" . $contrat->getSujetDeContrat() . "'>" . $contrat->getSujetDeContrat() . "</a>";
				    } else if ($contrat != "") {
					echo "<textarea name='sujet' style='width: 85%;'>" . $contrat->getSujetDeContrat() . "</textarea>";
				    } else {
					echo "<textarea name='sujet' style='width: 85%;'></textarea>";
				    }
				    ?>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr>
		    <td id="submit">
			<br/>
			<input type="hidden" name="annee" value="<?php echo $annee; ?>"/>
			<input type="hidden" name="parcours" value="<?php echo $parcours; ?>"/>
			<input type="hidden" name="filiere" value="<?php echo $filiere; ?>"/>
			<input type="hidden" value="1" name="<?php if ($contrat != "") echo "edit"; else echo "add"; ?>" />
			<input type="submit" value="Enregistrer" name="<?php if ($contrat != "") echo "edit"; else echo "add"; ?>" />
		    </td>
		</tr>
	    </table>
	</form>
	<script>
	    function showColor() {
		var couleurActuelHTML = document.getElementById("couleurActuel");
		var couleurHTML = document.getElementById("idCouleur");
		couleurActuelHTML.style.backgroundColor = couleurHTML.options[couleurHTML.selectedIndex].style.color;
	    }
	</script>
	<?php
    }

    /**
     * Afficher une liste des étudiants avec ou sans convention (tableau statique)
     * @param integer $annee L'année concernée
     * @param tableau d'objets $tabEtudiants Les étudiants concernés
     */
    public static function afficherListeContrats($annee, $tabEtudiants) {
	?>
	<table>
	    <tr id="entete">
		<td width="80%">Etudiant</td>
		<td width="20%" align="center">Contrat</td>
	    </tr>
	    <?php
	    $nbContrats = 0;
	    $nbEtudiants = sizeof($tabEtudiants);

	    for ($i = 0; $i < $nbEtudiants; $i++) {
	    ?>
	    <tr id="ligne<?php echo $i % 2; ?>">
	    	<td>
		    <?php echo $tabEtudiants[$i]->getNom() . " " . $tabEtudiants[$i]->getPrenom(); ?>
	    	</td>
	    	<td align="center">
		    <?php
		    if ($tabEtudiants[$i]->getContrat($annee) != null) {
			$nbContrats++;
			echo "<img src='../../images/action_check.png' />";
		    } else
			echo "<img src='../../images/action_remove.png' />";
		    ?>
	    	</td>
	    </tr>
	    <?php
	    }
	    ?>
	    <tr id='entete'>
		<td colspan="2" align="center">
		    Total : <?php echo $nbContrats . " / " . $nbEtudiants; ?>
		</td>
	    </tr>
	</table>
	<?php
    }

    /**
     * Afficher une liste de conventions à éditer ou à supprimer (tableau interactif)
     * @param integer $annee Année de la promotion concernée
     * @param integer $idPromo Identifiant de la promotion
     * @param tableau d'objets $tabEtuWithConv Tableaux d'objets Etudiant
     */
    public static function afficherListeContratsAModifier($annee, $idPromo, $tabEtuWithConv) {
	echo "<table>
		<tr id='entete'>
			<td width='20%'>Etudiant</td>
			<td width='15%'>Référent</td>
			<td width='15%'>Contact</td>
			<td width='15%'>Entreprise</td>
			<td width='15%'>Thème</td>
			<td width='10%' align='center'>Modifier</td>
			<td width='10%' align='center'>Supprimer</td>
		</tr>";
	for ($i = 0; $i < sizeof($tabEtuWithConv); $i++) {
	    $contrat = $tabEtuWithConv[$i]->getContrat($annee);
	    $parrain = $contrat->getParrain();

	    $contact = $contrat->getContact();
	    $entreprise = $contact->getEntreprise();
	    $theme = ThemeDeStage::getThemeDeStage($contrat->getIdTheme());
	    ?>
	    <tr id="ligne<?php echo $i % 2; ?>">
	        <td>
		    <?php echo $tabEtuWithConv[$i]->getNom() . " " . $tabEtuWithConv[$i]->getPrenom(); ?>
	        </td>
	        <td>
		    <?php echo $parrain->getNom() . " " . $parrain->getPrenom(); ?>
	        </td>
	        <td>
		    <?php echo $contact->getNom() . " " . $contact->getPrenom(); ?>
	        </td>
	        <td>
		    <?php echo $entreprise->getNom(); ?>
	        </td>
	        <td>
		    <?php echo $theme->getTheme(); ?>
	        </td>
	        <td align="center">
		    <a href="modifierContrat.php?promo=<?php echo $idPromo; ?>&id=<?php echo $contrat->getIdentifiantBDD(); ?>">
		        <img src="../../images/reply.png"/>
		    </a>
	        </td>
	        <td align="center">
		    <?php
		    if (!$contrat->getSoutenance()->getIdentifiantBDD()) {
			echo '<a href="modifierListeContrat.php?promo='.$idPromo.'&id='.$contrat->getIdentifiantBDD().'">
				<img src="../../images/action_delete.png"/>
			      </a>';
		    } else {
			echo '<img src="../../images/action_remove.png"/>';
		    }
		    ?>
	        </td>
	    </tr>
	    <?php
	}
	echo "</table>";
    }

    /**
     * Afficher une liste des contrats à exporter
     * @param integer $annee Année de la promotion concernée
     * @param integer $idPromo Identifiant de la promotion
     * @param tableau d'objets $tabEtuWithContrats Tableaux d'objets Etudiant
     */
    public static function afficherListeContratsAExporter($annee, $idPromo, $tabEtuWithConv) {
	echo "<table>
		<tr id='entete'>
			<td width='20%'>Etudiant</td>
			<td width='15%'>Référent</td>
			<td width='15%'>Contact</td>
			<td width='15%'>Entreprise</td>
			<td width='15%'>Thème</td>
			<td width='10%' align='center'>Exporter</td>
		</tr>";
	for ($i = 0; $i < sizeof($tabEtuWithConv); $i++) {
	    $contrat = $tabEtuWithConv[$i]->getContrat($annee);
	    $parrain = $contrat->getParrain();

	    $contact = $contrat->getContact();
	    $entreprise = $contact->getEntreprise();
	    $theme = ThemeDeStage::getThemeDeStage($contrat->getIdTheme());
	    ?>
	    <tr id="ligne<?php echo $i % 2; ?>">
	        <td>
		    <?php echo $tabEtuWithConv[$i]->getNom() . " " . $tabEtuWithConv[$i]->getPrenom(); ?>
	        </td>
	        <td>
		    <?php echo $parrain->getNom() . " " . $parrain->getPrenom(); ?>
	        </td>
	        <td>
		    <?php echo $contact->getNom() . " " . $contact->getPrenom(); ?>
	        </td>
	        <td>
		    <?php echo $entreprise->getNom(); ?>
	        </td>
	        <td>
		    <?php echo $theme->getTheme(); ?>
	        </td>
	        <td align="center">
		    <a href="exporterContrat.php?promo=<?php echo $idPromo; ?>&id=<?php echo $contrat->getIdentifiantBDD(); ?>">
		        <img src="../../images/download.png"/>
		    </a>
	        </td>
	    </tr>
	    <?php
	}
	echo "</table>";
    }


}
?>
