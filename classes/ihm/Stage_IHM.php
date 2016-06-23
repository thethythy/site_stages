<?php

class Stage_IHM {

    public static function afficherListeAncienStages($tabEtuWithConv, $annee) {
	?>
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
	        <tr id="ligne<?php echo $i % 2; ?>">
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

			    if ($contact->getTelecopie() != "")
				echo "Fax : " . $contact->getTelecopie() . "<br/>";

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

    public static function afficherListeResumes($annee, $parcours, $filiere, $tabEtuWithConv) {
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
		for ($i = 0; $i < sizeof($tabEtuWithConv); $i++) {
		    $conv = $tabEtuWithConv[$i]->getConvention($annee);

		    if ($idConventions == "")
			$idConventions = $conv->getIdentifiantBDD();
		    else
			$idConventions .= ";" . $conv->getIdentifiantBDD();

		?>
		<tr id="ligne<?php echo $i % 2; ?>">
		    <td>
			<?php echo $tabEtuWithConv[$i]->getNom() . " " . $tabEtuWithConv[$i]->getPrenom(); ?>
		    </td>
		    <td><?php echo $conv->getSujetDeStage(); ?></td>
		    <td align="center">
			<?php
			$tabRes = Convention::getResumesPossible($tabEtuWithConv[$i]->getIdentifiantBDD(), "../../documents/resumes/");
			if (sizeof($tabRes) == 0) {
			    echo "<input style='width: 250px;' name='conv" . $conv->getIdentifiantBDD() . "' type='text' value='" . htmlentities($conv->getSujetDeStage(), ENT_QUOTES, 'utf-8') . "'/>";
			} else {
			    echo "<select name='conv" . $conv->getIdentifiantBDD() . "' style='width: 250px;'>";
			    echo "<option value=''></option>";
			    for ($j = 0; $j < sizeof($tabRes); $j++) {
				if (($conv->getASonResume() == "1") && ($conv->getSujetDeStage() == $tabRes[$j]))
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
			<input type="submit" value="Enregistrer" />
		    </td>
		</tr>
	    </table>
	</form>
	<?php
    }

    public static function afficherListeNotes($annee, $parcours, $filiere, $tabEtuWithConv) {
	?>
	<form method="post" action="saisirNotesStages.php">
	    <table>
		<tr id='entete'>
		    <td width='60%'>Etudiant</td>
		    <td width='20%'>Note actuelle</td>
		    <td width='20%'>Nouvelle note</td>
		</tr>
		<?php
		$idConventions = "";
		$somme = 0;

		for ($i = 0; $i < sizeof($tabEtuWithConv); $i++) {
		    $conv = $tabEtuWithConv[$i]->getConvention($annee);

		    if ($idConventions == "")
			$idConventions = $conv->getIdentifiantBDD();
		    else
			$idConventions .= ";" . $conv->getIdentifiantBDD();

		    $somme = $somme + $conv->getNote();
		?>
		<tr id="ligne<?php echo $i % 2; ?>">
		    <td>
		    <?php echo $tabEtuWithConv[$i]->getNom() . " " . $tabEtuWithConv[$i]->getPrenom(); ?>
		    </td>
		    <td align="center">
			    <?php echo $conv->getNote(); ?>
		    </td>
		    <td align="center">
			<input style="width: 50px;" name="conv<?php echo $conv->getIdentifiantBDD(); ?>" type="text" value="<?php echo $conv->getNote(); ?>" />
		    </td>
		</tr>
		<?php
		}
		?>
		<tr>
		    <td align="center">
			<br/>
			Moyenne = <?php echo number_format($somme / $i, 2, ",", "."); ?>
		    </td>
		</tr>
		<tr>
		    <td colspan="3" width="100%" align="center">
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
			<input type="submit" value="Enregistrer" />
		    </td>
		</tr>
	    </table>
	</form>
	<?php
    }

}

?>