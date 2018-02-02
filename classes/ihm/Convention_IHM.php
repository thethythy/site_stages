<?php

class Convention_IHM {

    /**
     * Afficher un formulaire de création ou de modification d'une convention de stage
     * Si $conv = "" alors il s'agit d'un formulaire de création (champs vide)
     * @param Entreprise $conv Objet qui est modifié et dont les informations son affichées.
     * @param tableau d'objets $tabEtu Tableau contenant les étudiants à afficher
     * @param integer $annee Année de la promotion
     * @param integer $parcours Identifiant du parcours de la promotion
     * @param integer $filiere Identifiant de la filière de la promotion
     */
    public static function afficherFormulaireSaisie($conv, $tabEtu, $annee, $parcours, $filiere) {

	if ($conv != "") {
	    $parrain = $conv->getParrain();
	    $examinateur = $conv->getExaminateur();
	    $etudiant = $conv->getEtudiant();
	    $contact = $conv->getContact();
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
				    if ($conv != "") {
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
					    if ((($conv != "") && ($parrain->getIdentifiantBDD() == $tabPar[$i]->getIdentifiantBDD())) ||
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
				<td>Examinateur</td>
				<td>
				    <select name="idExam" style="width: 300px;">
					<?php
					$tabExam = Parrain::listerParrain();
					for ($i = 0; $i < sizeof($tabExam); $i++) {
					    if ((($conv != "") && ($examinateur->getIdentifiantBDD() == $tabExam[$i]->getIdentifiantBDD())) ||
						((isset($_POST['idExam'])) && ($_POST['idExam'] == $tabPar[$i]->getIdentifiantBDD())))
						echo "<option selected value='" . $tabExam[$i]->getIdentifiantBDD() . "'>" . $tabExam[$i]->getNom() . " " . $tabExam[$i]->getPrenom() . "</option>";
					    else
						echo "<option value='" . $tabExam[$i]->getIdentifiantBDD() . "'>" . $tabExam[$i]->getNom() . " " . $tabExam[$i]->getPrenom() . "</option>";
					}
					?>
				    </select>
				</td>
			    </tr>
			    <tr>
				<td>Contact</td>
				<td>
				    <select name="idCont" style="width: 300px;">
					<?php
					$tabCont = Contact::getListeContacts("");
					for ($i = 0; $i < sizeof($tabCont); $i++) {
					    $entreprise = $tabCont[$i]->getEntreprise();
					    $nomEntreprise = " - " . $entreprise->getNom() . " (" . $entreprise->getVille() . ")";
					    if ((($conv != "") && ($contact->getIdentifiantBDD() == $tabCont[$i]->getIdentifiantBDD())) ||
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
					if (($conv != "") && $tabTheme[$i]->getIdentifiantBDD() == $conv->getIdTheme())
					    echo "<option selected value='" . $tabTheme[$i]->getIdentifiantBDD() . "'style='color: #" . $couleur->getCode() . ";'>" . $tabTheme[$i]->getTheme() . "</option>";
					else
					    echo "<option value='" . $tabTheme[$i]->getIdentifiantBDD() . "'style='color: #" . $couleur->getCode() . ";'>" . $tabTheme[$i]->getTheme() . "</option>";
				    }
				    ?>
				    </select>
				</td>
			    </tr>
			    <tr>
				<td>
				    <?php
				    if (($conv != "") && ($conv->getASonResume() == 1)) {
					echo "Résumé du stage";
				    } else {
					echo "Sujet de stage";
				    }
				    ?>
				</td>
				<td>
				    <?php
				    if (($conv != "") && ($conv->getASonResume() == 1)) {
					echo "<a href='../../documents/resumes/" . $conv->getSujetDeStage() . "'>" . $conv->getSujetDeStage() . "</a>";
				    } else if ($conv != "") {
					echo "<textarea name='sujet' style='width: 85%;'>" . $conv->getSujetDeStage() . "</textarea>";
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
			<input type="hidden" value="1" name="<?php if ($conv != "") echo "edit"; else echo "add"; ?>" />
			<input type="submit" value="Enregistrer" />
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
    public static function afficherListeConventions($annee, $tabEtudiants) {
	?>
	<table>
	    <tr id="entete">
		<td width="80%">Etudiant</td>
		<td width="20%" align="center">Convention</td>
	    </tr>
	    <?php
	    $nbConventions = 0;
	    $nbEtudiants = sizeof($tabEtudiants);

	    for ($i = 0; $i < $nbEtudiants; $i++) {
	    ?>
	    <tr id="ligne<?php echo $i % 2; ?>">
	    	<td>
		    <?php echo $tabEtudiants[$i]->getNom() . " " . $tabEtudiants[$i]->getPrenom(); ?>
	    	</td>
	    	<td align="center">
		    <?php
		    if ($tabEtudiants[$i]->getConvention($annee) != null) {
			$nbConventions++;
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
		    Total : <?php echo $nbConventions . " / " . $nbEtudiants; ?>
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
    public static function afficherListeConventionsAModifier($annee, $idPromo, $tabEtuWithConv) {
	echo "<table>
		<tr id='entete'>
			<td width='20%'>Etudiant</td>
			<td width='15%'>Référent</td>
			<td width='15%'>Examinateur</td>
			<td width='15%'>Contact</td>
			<td width='15%'>Entreprise</td>
			<td width='15%'>Thème</td>
			<td width='10%' align='center'>Modifier</td>
			<td width='10%' align='center'>Supprimer</td>
		</tr>";
	for ($i = 0; $i < sizeof($tabEtuWithConv); $i++) {
	    $conv = $tabEtuWithConv[$i]->getConvention($annee);
	    $parrain = $conv->getParrain();
	    $examinateur = $conv->getExaminateur();
	    $contact = $conv->getContact();
	    $entreprise = $contact->getEntreprise();
	    $theme = ThemeDeStage::getThemeDeStage($conv->getIdentifiantBDD());
	    ?>
	    <tr id="ligne<?php echo $i % 2; ?>">
	        <td>
		    <?php echo $tabEtuWithConv[$i]->getNom() . " " . $tabEtuWithConv[$i]->getPrenom(); ?>
	        </td>
	        <td>
		    <?php echo $parrain->getNom() . " " . $parrain->getPrenom(); ?>
	        </td>
	        <td>
		    <?php echo $examinateur->getNom() . " " . $examinateur->getPrenom(); ?>
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
	    	<a href="modifierConvention.php?promo=<?php echo $idPromo; ?>&id=<?php echo $conv->getIdentifiantBDD(); ?>">
	    	    <img src="../../images/reply.png"/>
	    	</a>
	        </td>
	        <td align="center">
	    	<a href="modifierListeConventions.php?promo=<?php echo $idPromo; ?>&id=<?php echo $conv->getIdentifiantBDD(); ?>">
	    	    <img src="../../images/action_delete.png"/>
	    	</a>
	        </td>
	    </tr>
	    <?php
	}
	echo "</table>";
    }

}
?>