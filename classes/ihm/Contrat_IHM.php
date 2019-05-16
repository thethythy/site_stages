<?php

class Contrat_IHM {

    /**
     * Afficher un formulaire de création ou de modification d'un contrat de stage
     * Si $contrat = "" alors il s'agit d'un formulaire de création (champs vide)
     * @param Contrat $contrat Objet qui est modifié et dont les informations son affichées.
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
				    echo "<input type='text' name='indemnite' size='100' value =" . $contrat->getIndemnites() . " >";
				} else {
				    echo "<input type='text' name='indemnite' size='100' >";
				}
				?>
				</td>
			    </tr>
			    <tr>
				<td>
				    <?php
				    if (($contrat != "") && ($contrat->getASonResume() == 1)) {
					echo "Résumé du contrat";
				    } else {
					echo "Sujet du contrat";
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
	<?php
    }

    /**
     * Affiche un formulaire de filtrage sur l'année, le parcours, la filière
     * le thème de contrat, le type d'entreprise et le lieu du contrat
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
					    echo "<option value='*'>Tous</option>";
					    for ($i=0; $i<sizeof($tabF); $i++) {
						$id = $tabF[$i]->getIdentifiantBDD();
						echo "<option ";
						if ((isset($_POST['filiere'])) && ($_POST['filiere'] == $id)) echo "selected";
						echo " value='$id'>".$tabF[$i]->getNom()."</option>";
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
						$id = $tabP[$i]->getIdentifiantBDD();
						echo "<option ";
						if ((isset($_POST['parcours'])) && ($_POST['parcours'] == $id)) echo "selected";
						echo " value='$id'>".$tabP[$i]->getNom()."</option>";
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
					    for ($i=0; $i<sizeof($tabT); $i++) {
						$id = $tabT[$i]->getIdentifiantBDD();
						echo "<option ";
						if (isset($_POST['technologie']) && $_POST['technologie'] == $id) echo "selected";
						echo " value='$id'>".$tabT[$i]->getTheme()."</option>";
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
					    for ($i=0; $i<sizeof($tabTE); $i++) {
						$id = $tabTE[$i]->getIdentifiantBDD();
						echo "<option ";
						if (isset($_POST['typeEntreprise']) && $_POST['typeEntreprise'] == $id) echo "selected";
						echo " value='$id'>".$tabTE[$i]->getType()."</option>";
					    }
					?>
				    </select>
				</td>
			    </tr>
			    <tr>
				<td align="center">
				    Sélectionnez le lieu :
				    <select id="lieucontrat" name="lieucontrat">
					<?php
					    echo "<option value='*'>Tous</option>";
					    foreach (Utils::getLieuxStage() as $key => $lieu) {
						echo "<option value='$key'>$lieu";
						if ($key > 0) echo " (précédents exclus)";
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
	    var table = new Array("annee", "filiere", "parcours", "technologie", "typeEntreprise", "lieucontrat");
	    new LoadData(table, "<?php echo $page; ?>", "onchange");
	</script>
	<?php
    }

    /**
     * Afficher une liste de contrats passés avec un lien vers le résumé s'il existe.
     * @param tableau d'objets $tabEtuWithContrat Liste des anciens étudiants concernés
     * @param integer $annee L'année concernée
     */
    public static function afficherListeAncienContrats($tabEtuWithContrat, $annee) {
	?>
	<?php echo sizeof($tabEtuWithContrat) . " contrat(s) trouvé(s) :"?>
	<br/><br/>
	<table>
	    <tr id='entete'>
		<td width='35%'>Entreprise</td>
		<td width='35%'>Contact</td>
		<td width='30%'>Alternant</td>
	    </tr>
	    <?php
	    for ($i = 0; $i < sizeof($tabEtuWithContrat); $i++) {
		$promotion = $tabEtuWithContrat[$i]->getPromotion($annee);
		$promo_parcours = $promotion->getParcours();
		$promo_filiere = $promotion->getFiliere();
		$contrat = $tabEtuWithContrat[$i]->getContrat($annee);
		$contact = $contrat->getContact();
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
				    <a href="./ficheDeContrat.php?annee=<?php echo $annee; ?>&parcours=<?php echo $promo_parcours->getIdentifiantBDD(); ?>&filiere=<?php echo $promo_filiere->getIdentifiantBDD(); ?>&idEtu=<?php echo $tabEtuWithContrat[$i]->getIdentifiantBDD(); ?>&idPromo=<?php echo $promotion->getIdentifiantBDD(); ?>" target="_blank">
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
     * Afficher une liste des contrats à éditer ou à supprimer (tableau interactif)
     * @param integer $annee Année de la promotion concernée
     * @param integer $idPromo Identifiant de la promotion
     * @param tableau d'objets $tabEtu Tableaux d'objets Etudiant
     */
    public static function afficherListeContratsAModifier($annee, $idPromo, $tabEtu) {
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
	for ($i = 0; $i < sizeof($tabEtu); $i++) {
	    $contrat = $tabEtu[$i]->getContrat($annee);
	    $parrain = $contrat->getParrain();

	    $contact = $contrat->getContact();
	    $entreprise = $contact->getEntreprise();
	    $theme = ThemeDeStage::getThemeDeStage($contrat->getIdTheme());
	    ?>
	    <tr class="ligne<?php echo $i % 2; ?>">
	        <td>
		    <?php echo $tabEtu[$i]->getNom() . " " . $tabEtu[$i]->getPrenom(); ?>
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
    public static function afficherListeContratsAExporter($annee, $idPromo, $tabEtuWithContrats) {
	echo "<table>
		<tr id='entete'>
			<td width='20%'>Etudiant</td>
			<td width='15%'>Référent</td>
			<td width='15%'>Contact</td>
			<td width='15%'>Entreprise</td>
			<td width='15%'>Thème</td>
			<td width='10%' align='center'>Exporter</td>
		</tr>";
	for ($i = 0; $i < sizeof($tabEtuWithContrats); $i++) {
	    $contrat = $tabEtuWithContrats[$i]->getContrat($annee);
	    $parrain = $contrat->getParrain();

	    $contact = $contrat->getContact();
	    $entreprise = $contact->getEntreprise();
	    $theme = ThemeDeStage::getThemeDeStage($contrat->getIdTheme());
	    ?>
	    <tr id="ligne<?php echo $i % 2; ?>">
	        <td>
		    <?php echo $tabEtuWithContrats[$i]->getNom() . " " . $tabEtuWithContrats[$i]->getPrenom(); ?>
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

    /**
     * Afficher une fiche de contrat récapitulative
     * @param integer $idEtu Identifiant de l'étudiant
     * @param integer $idPromo Identifiant de la promotion
     * @param string $chemin Chemin d'accès au fichier résumé s'il existe
     */
    public static function afficherFicheContrat($idEtu, $idPromo, $chemin) {
	$etudiant = Etudiant::getEtudiant($idEtu);
	$promotion = Promotion::getPromotion($idPromo);
	$filiere = $promotion->getFiliere();
	$parcours = $promotion->getParcours();
	$contrat = $etudiant->getContrat($promotion->getAnneeUniversitaire());
	$contact = $contrat->getContact();
	$entreprise = $contact->getEntreprise();
	$parrain = $contrat->getParrain();
	$annee = $promotion->getAnneeUniversitaire();
	?>

	<table>
	    <tr>
		<td style="border: 1px solid; padding: 15px;">
		    <h3>L'étudiant(e)</h3>
		    <?php echo $etudiant->getPrenom()." ".$etudiant->getNom(); ?><br/>
		    <?php echo "Email : ".$etudiant->getEmailInstitutionel(); ?><br/>
		    Promotion : <?php echo $filiere->getNom()." ".$parcours->getNom(); ?><br/>
		    Année : <?php echo $annee."-".($annee + 1); ?>
		</td>
		<td style="border: 1px solid; padding: 15px;">
		    <h3>Le référent universitaire</h3>
		    <?php echo $parrain->getPreNom()." ".$parrain->getNom(); ?><br/>
		    <?php echo "Email : ".$parrain->getEmail(); ?>
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
			echo $contact->getPrenom()." ".$contact->getNom()."<br/>";

			if ($contact->getTelephone() != "" && strlen($contact->getTelephone()) > 1)
			    echo "Tél. : ".$contact->getTelephone()."<br/>";

			if ($contact->getEmail() != "")
			    echo "Email : ".$contact->getEmail();
		    ?>
		</td>
	    </tr>
	    <tr>
		<td colspan="2" style="column-span: all; border: 1px solid; padding: 15px;">
		    <h3>Le contrat</h3>
		    <?php
			if ($contrat->aSonResume == "1"){
			    echo "<a href='".$chemin.$contrat->getSujetDeContrat()."'>Résumé du contrat</a>";
			} else {
			    echo "Sujet de l'aternance : ".$contrat->getSujetDeContrat()."<br/>";
			    echo "Durée du contrat : ".$contrat->getDuree()." an(s)<br/>";
			    echo "Indemnités mensuelles : ".$contrat->getIndemnites()." €<br/>";
			}
		    ?>
		</td>
	    </tr>
	</table>
	<?php
    }

}

?>
