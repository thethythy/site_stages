<?php

class Stage_IHM {

    /**
     * Affiche un formulaire de filtrage sur l'année, le parcours, la filière
     * le thème de stage, le type d'entreprise et le lieu du stage
     * @param string $page Indique la page du traitement des requêtes Ajax
     */
    public static function afficherFormulaireRechercheAvancee($page) {
	$tabAU = Promotion_BDD::getAnneesUniversitaires();
	$tabF = Filiere::listerFilieres();
	$tabP = Parcours::listerParcours();
	$tabT = ThemeDeStage::getListeTheme();
	$tabTE = TypeEntreprise::getListeTypeEntreprise();
	?>
	<form method=post action="javascript:">
	    <table width="100%">
	        <tr>
		    <td align="center">
			Sélectionnez l'année :
			<select id="annee" name="annee">
			    <?php
			    echo "<option value=''>----------</option>";
			    for ($i = 0; $i < sizeof($tabAU); $i++) {
				if ((isset($_POST['annee'])) && ($_POST['annee'] == $tabAU[$i]))
				    echo "<option selected value='$tabAU[$i]'>" . $tabAU[$i] . "-" . ($tabAU[$i] + 1) . "</option>";
				else
				    echo "<option value='$tabAU[$i]'>" . $tabAU[$i] . "-" . ($tabAU[$i] + 1) . "</option>";
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
					echo "<option value='*'>Tous</option>";
					for ($i = 0; $i < sizeof($tabF); $i++) {
					    $id = $tabF[$i]->getIdentifiantBDD();
					    echo "<option ";
					    if ((isset($_POST['filiere'])) && ($_POST['filiere'] == $id))
						echo "selected";
					    echo " value='$id'>" . $tabF[$i]->getNom() . "</option>";
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
					for ($i = 0; $i < sizeof($tabP); $i++) {
					    $id = $tabP[$i]->getIdentifiantBDD();
					    echo "<option ";
					    if ((isset($_POST['parcours'])) && ($_POST['parcours'] == $id))
						echo "selected";
					    echo " value='$id'>" . $tabP[$i]->getNom() . "</option>";
					}
					?>
				    </select>
				</td>
			    </tr>
			</table>
		    </td>
		    <td>
			<table>
			    <tr>
				<td align="center">
				    Sélectionnez la technologie :
				    <select id="technologie" name="technologie">
					<?php
					echo "<option value='*'>Toutes</option>";
					for ($i = 0; $i < sizeof($tabT); $i++) {
					    $id = $tabT[$i]->getIdentifiantBDD();
					    echo "<option ";
					    if (isset($_POST['technologie']) && $_POST['technologie'] == $id)
						echo "selected";
					    echo " value='$id'>" . $tabT[$i]->getTheme() . "</option>";
					}
					?>
				    </select>
				</td>
			    </tr>
			    <tr>
				<td align="center">
				    Sélectionnez le type entreprise :
				    <select id="typeEntreprise" name="typentreprise">
					<?php
					echo "<option value='*'>Tous</option>";
					for ($i = 0; $i < sizeof($tabTE); $i++) {
					    $id = $tabTE[$i]->getIdentifiantBDD();
					    echo "<option ";
					    if (isset($_POST['typeEntreprise']) && $_POST['typeEntreprise'] == $id)
						echo "selected";
					    echo " value='$id'>" . $tabTE[$i]->getType() . "</option>";
					}
					?>
				    </select>
				</td>
			    </tr>
			    <tr>
				<td align="center">
				    Sélectionnez le lieu :
				    <select id="lieustage" name="lieustage">
					<?php
					echo "<option value='*'>Tous</option>";
					foreach (Utils::getLieuxStage() as $key => $lieu) {
					    echo "<option value='$key'>$lieu";
					    if ($key > 0)
						echo " (précédents exclus)";
					    echo "</option>";
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
	    var table = new Array("annee", "filiere", "parcours", "technologie", "typeEntreprise", "lieustage");
	    new LoadData(table, "<?php echo $page; ?>", "onchange");
	</script>
	<?php
    }

    /**
     * Afficher une liste de stages passés avec un lien vers le résumé s'il existe.
     * @param tableau d'objets $tabEtuWithConv Liste des anciens étudiants concernés
     * @param integer $annee L'année concernée
     */
    public static function afficherListeAncienStages($tabEtuWithConv, $annee) {
	?>
	<?php echo sizeof($tabEtuWithConv) . " stage(s) trouvé(s) :" ?>
	<br/><br/>
	<table>
	    <tr id='entete'>
	        <td width='35%'>Entreprise</td>
	        <td width='35%'>Contact</td>
	        <td width='30%'>Stagiaire</td>
	    </tr>
	    <?php
	    for ($i = 0; $i < sizeof($tabEtuWithConv); $i++) {
		$promotion = $tabEtuWithConv[$i]->getPromotion($annee);
		$promo_parcours = $promotion->getParcours();
		$promo_filiere = $promotion->getFiliere();
		$conv = $tabEtuWithConv[$i]->getConvention($annee);
		$contact = $conv->getContact();
		$entreprise = $contact->getEntreprise();
		?>
	        <tr class="ligne<?php echo $i % 2; ?>">
	    	<td>
	                <br/>
	    <?php echo $entreprise->getNom(); ?> <br/>
	    <?php echo $entreprise->getAdresse(); ?> <br/>
			<?php echo $entreprise->getCodePostal() . " "; ?>
			<?php echo $entreprise->getVille(); ?> <br/>
			<?php echo $entreprise->getPays(); ?>
	                <br/><br/>
	    	</td>
	    	<td>
			<?php
			echo $contact->getNom() . " " . $contact->getPrenom() . "<br/>";

			if ($contact->getTelephone() != "")
			    echo "Tel : " . $contact->getTelephone() . "<br/>";

			if ($contact->getEmail() != "")
			    echo "Email : " . $contact->getEmail();
			?>
	    	</td>
	    	<td>
	                <table>
	    		<tr>
	    		    <td colspan="2">
	    <?php
	    echo "Etudiant en " . $promo_filiere->getNom() . " " . $promo_parcours->getNom() . "<br/>";
	    ?>
	    		    </td>
	    		</tr>

	    		<tr>
	    		    <td width="50%">
	    			Résumé :
	    		    </td>
	    		    <td width="50%">
	    			<a href="./ficheDeStage.php?annee=<?php echo $annee; ?>&parcours=<?php echo $promo_parcours->getIdentifiantBDD(); ?>&filiere=<?php echo $promo_filiere->getIdentifiantBDD(); ?>&idEtu=<?php echo $tabEtuWithConv[$i]->getIdentifiantBDD(); ?>&idPromo=<?php echo $promotion->getIdentifiantBDD(); ?>" target="_blank">
	    			    <img src="../images/resume.png" />
	    			</a>
	    		    </td>
	    		</tr>
	                </table>
	    	</td>
	        </tr>
		<?php
	    }
	    echo "</table>";
	}

    /**
     * Afficher un tableau interactif d'attribution des fichiers de résumés
     * @param integer $annee L'année concernée
     * @param integer $parcours L'identifiant du parcours concerné
     * @param integer $filiere L'identifiant de la filière concernée
     * @param tableau d'objets $tabEtu Liste des objets Etudiants
     */
    public static function afficherListeResumes($annee, $parcours, $filiere, $tabEtu) {
	?>
	<form method=post action="">
	    <table>
		<tr id='entete'>
		    <td>Etudiant</td>
		    <td>Résumé actuelle</td>
		    <td width='25%'>Nouveau résumé</td>
		</tr>

		<?php
		$idConventions = "";
		$idContrats = "";

		for ($i = 0; $i < sizeof($tabEtu); $i++) {
		    $conv = $tabEtu[$i]->getConvention($annee);
		    $cont = $tabEtu[$i]->getContrat($annee);

		    if ($conv) {
			if ($idConventions == "")
			    $idConventions = $conv->getIdentifiantBDD();
			else
			    $idConventions .= ";" . $conv->getIdentifiantBDD();
		    }

		    if ($cont) {
			if ($idContrats == "")
			    $idContrats = $cont->getIdentifiantBDD();
			else
			    $idContrats .= ";" . $cont->getIdentifiantBDD();
		    }
		    ?>
		    <tr class="ligne<?php echo $i % 2; ?>">
			<td width="20%">
				<?php echo $tabEtu[$i]->getNom() . " " . $tabEtu[$i]->getPrenom(); ?>
			</td>
			<td width="40%"><?php echo $conv ? $conv->getSujetDeStage() : $cont->getSujetDeContrat() ; ?></td>
			<td width="40%" align="center">
				<?php
				$tabRes = Convention::getResumesPossible($tabEtu[$i]->getIdentifiantBDD(), "../../documents/resumes/");
				$name = $conv ? "conv" . $conv->getIdentifiantBDD() : "cont" . $cont->getIdentifiantBDD();
				$resume = $conv ? $conv->getSujetDeStage() : $cont->getSujetDeContrat();
				if (sizeof($tabRes) == 0) {
				    $value = htmlentities($resume, ENT_QUOTES, 'utf-8');
				    echo "<input style='width: 250px;' name='$name' type='text' value='$value'/>";
				} else {
				    echo "<select name='$name' style='width: 250px;'>";
				    echo "<option value=''></option>";
				    $aSonResume = $conv ? $conv->getASonResume() : $cont->getASonResume();
				    for ($j = 0; $j < sizeof($tabRes); $j++) {
					if (($aSonResume == "1") && ($resume == $tabRes[$j]))
					    echo "<option selected value='$tabRes[$j]'>" . $tabRes[$j] . "</option>";
					else
					    echo "<option value='$tabRes[$j]'>" . $tabRes[$j] . "</option>";
				    }
				    echo "</select>";
				}
				?>
			</td>
		    </tr>
		<?php
		}
		?>
		<tr>
		    <td colspan="3" width="100%" align="center">
			<br/>
			<input type="hidden" value="1" name="save" />
			<input type="hidden" value="<?php echo $annee; ?>" name="annee" />
			<input type="hidden" value="<?php echo $parcours; ?>" name="parcours" />
			<input type="hidden" value="<?php echo $filiere; ?>" name="filiere" />
			<input type="hidden" name="idConventions" value="<?php echo $idConventions; ?>" />
			<input type="hidden" name="idContrats" value="<?php echo $idContrats; ?>" />
			<input type="submit" value="Enregistrer" />
		    </td>
		</tr>
	    </table>
	</form>
	<?php
    }

    /**
     * Afficher un tableau interactif d'attribution des notes
     * @param integer $annee L'année concernée
     * @param integer $parcours L'identifiant du parcours concerné
     * @param integer $filiere L'identifiant de la filière concernée
     * @param tableau d'objets $tabEtuWithConv Liste des objets Etudiants
     */
    public static function afficherListeNotes($annee, $parcours, $filiere, $tabEtu, $url) {
	?>
	<form method="post" action=<?php echo $url; ?>>
	    <table>
		<tr id='entete'>
		    <td width='50%'>Etudiant</td>
		    <td width="20%">Statut</td>
		    <td width='15%'>Note actuelle</td>
		    <td width='15%'>Nouvelle note</td>
		</tr>
		<?php
		$idConventions = "";
		$idContrats = "";
		$somme = 0;

		for ($i = 0; $i < sizeof($tabEtu); $i++) {
		    $conv = $tabEtu[$i]->getConvention($annee);
		    $cont = $tabEtu[$i]->getContrat($annee);

		    if ($conv) {
			if ($idConventions == "")
			    $idConventions = $conv->getIdentifiantBDD();
			else
			    $idConventions .= ";" . $conv->getIdentifiantBDD();
			$somme += $conv->getNote();
		    }

		    if ($cont) {
			if ($idContrats == "")
			    $idContrats = $cont->getIdentifiantBDD();
			else
			    $idContrats .= ";" . $cont->getIdentifiantBDD();
			$somme += $cont->getNote();
		    }
		    ?>
		    <tr class="ligne<?php echo $i % 2; ?>">
		    <td align="center">
			    <?php echo $tabEtu[$i]->getNom() . " " . $tabEtu[$i]->getPrenom(); ?>
		    </td>
		    <td align="center">
			    <?php echo $conv ? "Stagiaire" : "Alternant"; ?>
		    </td>
		    <td align="center">
	<?php echo $conv ? $conv->getNote() : $cont->getNote(); ?>
		    </td>
		    <td align="center">
			<input style="width: 50px;"
			       name="<?php echo $conv ? "conv" . $conv->getIdentifiantBDD() : "cont" . $cont->getIdentifiantBDD(); ?>"
			       type="text"
			       value="<?php echo $conv ? $conv->getNote() : $cont->getNote(); ?>" />
		    </td>
		    </tr>
	<?php
    }
    ?>
		<tr>
		    <td></td><td></td><td></td>
		    <td align="center" >
			<br/>
			Moyenne = <?php echo number_format($somme / $i, 2, ",", "."); ?>
		    </td>
		</tr>
		<tr>
		    <td colspan="4" width="100%" align="center">
			<br/>
			<input type="hidden" value="1" name="save" />
			<input type="hidden" value="<?php echo $annee; ?>" name="annee" />
			<?php if (isset($parcours)) { ?>
			<input type="hidden" value="<?php echo $parcours; ?>" name="parcours" />
			<?php } ?>
    <?php if (isset($filiere)) { ?>
			<input type="hidden" value="<?php echo $filiere; ?>" name="filiere" />
    <?php } ?>
			<input type="hidden" name="idConventions" value="<?php echo $idConventions; ?>" />
			<input type="hidden" name="idContrats" value="<?php echo $idContrats; ?>" />
			<input type="submit" value="Valider modification" />
		    </td>
		</tr>
	    </table>
	</form>
	<?php
    }

    /**
     * Afficher une fiche de stage récapitulative
     * @param integer $idEtu Identifiant de l'étudiant
     * @param integer $idPromo Identifiant de la promotion
     * @param string $chemin Chemin d'accès au fichier résumé s'il existe
     */
    public static function afficherFicheStage($idEtu, $idPromo, $chemin) {
	$etudiant = Etudiant::getEtudiant($idEtu);
	$promotion = Promotion::getPromotion($idPromo);
	$filiere = $promotion->getFiliere();
	$parcours = $promotion->getParcours();
	$convention = $etudiant->getConvention($promotion->getAnneeUniversitaire());
	$contact = $convention->getContact();
	$entreprise = $contact->getEntreprise();
	$parrain = $convention->getParrain();
	$annee = $promotion->getAnneeUniversitaire();
	?>

	<table>
	    <tr>
		<td style="border: 1px solid; padding: 15px;">
		    <h3>L'étudiant(e)</h3>
    <?php echo $etudiant->getPrenom() . " " . $etudiant->getNom(); ?><br/>
    <?php echo "Email : " . $etudiant->getEmailInstitutionel(); ?><br/>
		    Promotion : <?php echo $filiere->getNom() . " " . $parcours->getNom(); ?><br/>
		    Année : <?php echo $annee . "-" . ($annee + 1); ?>
		</td>
		<td style="border: 1px solid; padding: 15px;">
		    <h3>Le référent universitaire</h3>
    <?php echo $parrain->getPreNom() . " " . $parrain->getNom(); ?><br/>
    <?php echo "Email : " . $parrain->getEmail(); ?>
		</td>
	    </tr>
	    <tr>
		<td style="border: 1px solid; padding: 15px;">
		    <h3>L'entreprise</h3>
		    <?php echo $entreprise->getNom(); ?> <br/>
		    <?php echo $entreprise->getAdresse(); ?> <br/>
    <?php echo $entreprise->getCodePostal(); ?>&nbsp;
    <?php echo $entreprise->getVille(); ?> <br/>
		    <?php echo $entreprise->getPays(); ?>
		</td>
		<td style="border: 1px solid; padding: 15px;">
		    <h3>Le contact dans l'entreprise</h3>
		    <?php
		    echo $contact->getPrenom() . " " . $contact->getNom() . "<br/>";

		    if ($contact->getTelephone() != "" && strlen($contact->getTelephone()) > 1)
			echo "Tél. : " . $contact->getTelephone() . "<br/>";

		    if ($contact->getEmail() != "")
			echo "Email : " . $contact->getEmail();
		    ?>
		</td>
	    </tr>
	    <tr>
		<td colspan="2" style="column-span: all; border: 1px solid; padding: 15px;">
		    <h3>Le stage</h3>
		    <?php
		    if ($convention->aSonResume == "1") {
			echo "<a href='" . $chemin . $convention->getSujetDeStage() . "'>Résumé du stage</a>";
		    } else {
			$chaine = $convention->getSujetDeStage();
			echo $chaine;
		    }
		    ?>
		</td>
	    </tr>
	</table>
	<?php
    }

}
    ?>
