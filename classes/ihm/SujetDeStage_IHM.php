<?php

class SujetDeStage_IHM {

    /**
     * Afficher un formulaire de demande de validation d'une proposition de stage
     * La proposition peut être décrite ou donnée dans un fichier à uploader
     * @param tableau d'objets $tabEtu Liste des étudiants concernés
     */
    public static function afficherDemandeValidation($tabEtu) {
	?>
	<form enctype="multipart/form-data" method=post action="">
	    <input type="hidden" name="annee" value="<?php if ((isset($_POST['annee']))) { echo $_POST['annee']; } ?>"/>
	    <table width="100%">
		<tr>
		    <td width="100%" align="center">
			<table>
			    <tr>
				<td>Etudiant</td>
				<td>
				    <select name="idetudiant">
					<option value="-1"></option>
					<?php
					for ($i = 0; $i < sizeof($tabEtu); $i++) {
					    if ((isset($_POST['idEtu'])) && ($_POST['idetudiant'] == $tabEtu[$i]->getIdentifiantBDD()))
						echo "<option selected value='" . $tabEtu[$i]->getIdentifiantBDD() . "'>" . $tabEtu[$i]->getNom() . " " . $tabEtu[$i]->getPrenom() . "</option>";
					    else
						echo "<option value='" . $tabEtu[$i]->getIdentifiantBDD() . "'>" . $tabEtu[$i]->getNom() . " " . $tabEtu[$i]->getPrenom() . "</option>";
					}
					?>
				    </select>
				</td>
			    </tr>
			    <tr>
				<td>Description</td>
				<td>
				    <textarea name="desc" rows="75" cols="15"></textarea>
				</td>
			    </tr>
			    <tr>
				<td>Sujet de stage <br/>
				    (extension acceptée .pdf, .doc, .docx, .odt)</td>
				<td>
				    <input name="uploadSujet" type="file">
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr>
		    <td id="submit">
			<input type="submit" value="Enregistrer" />
		    </td>
		</tr>
	    </table>
	</form>
    <?php
    }

    /**
     * Afficher un tableau interactif des demandes de validation
     * d'une proposition de stage. L'utilisateur doit sélectionner une demande.
     * @param tableau d'objets $tabSDS La liste des objets SujetDeStage
     */
    public static function afficherTableauSDSAValider($tabSDS) {
	$cpt = 0;
	$enteteAffichee = false;
	for ($i = 0; $i < sizeof($tabSDS); $i++) {
	    $etudiant = $tabSDS[$i]->getEtudiant();
	    $promotion = $tabSDS[$i]->getPromotion();
	    $filiere = $promotion->getFiliere();
	    $parcours = $promotion->getParcours();
	    if (!$enteteAffichee) {
		$enteteAffichee = true;
		?>
		<p>Voici la liste des sujets de stage qui restent à traiter : </p>
		<table width="100%">
		    <tr id="entete">
			<td width="30%">Nom</td>
			<td width="30%">Prenom</td>
			<td width="10%">Diplôme</td>
			<td width="10%">Spécialité</td>
			<td width="5%">Année</td>
			<td width="15%">Traiter</td>
		    </tr>
		<?php

	    }
	    ?>
		    <tr id="ligne<?php echo $cpt % 2; $cpt++; ?>">
			<td><?php echo $etudiant->getNom(); ?></td>
			<td><?php echo $etudiant->getPrenom(); ?></td>
			<td><?php echo $filiere->getNom(); ?></td>
			<td><?php echo $parcours->getNom(); ?></td>
			<td><?php echo $promotion->getAnneeUniversitaire() ?></td>
			<td align="center">
			    <a href="./traiterSDS.php?id=<?php echo $tabSDS[$i]->getIdentifiantBDD(); ?>">
				<img src="../../images/search.png">
			    </a>
			</td>
		    </tr>
	<?php
	}
	echo "</table>";
    }

    /**
     * Afficher un formulaire de validation ou de refus d'une proposition
     * de stage faite par un étudiant
     * @param SujetDeStage $sds L'objet SujeDestage à traiter
     * @param boolean $afficherBoutton Indicateur à true pour les boutons de traitement
     */
    public static function afficherSDS($sds, $afficherBoutton) {
	$etudiant = $sds->getEtudiant();
	$promotion = $sds->getPromotion();
	$filiere = $promotion->getFiliere();
	$parcours = $promotion->getParcours();
	?>
	<form method=post action="./traiterSDS.php">
	    <input type="hidden" value="<?php echo $_GET['id']; ?>" name="idSds">
	    <table width="100%">
		<tr>
		    <th width="10%">Nom</th>
		    <td><?php echo $etudiant->getNom(); ?></td>
		</tr>
		<tr>
		    <th>Prenom</th>
		    <td><?php echo $etudiant->getPrenom(); ?></td>
		</tr>
		<tr>
		    <th>Diplôme</th>
		    <td><?php echo $filiere->getNom(); ?></td>
		</tr>
		<tr>
		    <th>Spécialité</th>
		    <td><?php echo $parcours->getNom(); ?></td>
		</tr>
		<tr>
		    <th>Année</th>
		    <td><?php echo $promotion->getAnneeUniversitaire() ?></td>
		</tr>
		<tr>
		    <th>Sujet</th>
		    <td>
			<?php
			$filename = explode(".", $sds->getDescription());
			if (sizeof($filename) != 0)
			    $extension = $filename[sizeof($filename) - 1];
			if ($extension == "pdf" || $extension == "doc" || $extension == "odt" || $extension == "docx" || $extension == "txt") {
			    echo "<a href='../../documents/sujetsDeStages/" . $sds->getDescription() . "' target='_blank'>" . $sds->getDescription() . "</a>";
			} else {
			    echo $sds->getDescription();
			}
			?>
		    </td>
		</tr>
	<?php if ($afficherBoutton) { ?>
		<tr>
		    <td colspan=2>
			<input type="submit" name="accept" value="Accepter">
			<input type="submit" name="refus" value="Refuser">
		    </td>
		</tr>
	<?php } ?>
	    </table>
	</form>
	<?php
    }

    /**
     * Afficher un tableau des demandes de validation déjà traitées
     * Un lien permet d'accéder à chaque demande déjà validée
     * @param tableau d'objets $tabSDS Les objets SujetDeStage validés
     */
    public static function afficherTableauSDSValide($tabSDS) {
	$cpt = 0;
	$enteteAffichee = false;
	for ($i = 0; $i < sizeof($tabSDS); $i++) {
	    $etudiant = $tabSDS[$i]->getEtudiant();
	    $promotion = $tabSDS[$i]->getPromotion();
	    $filiere = $promotion->getFiliere();
	    $parcours = $promotion->getParcours();
	    if (!$enteteAffichee) {
		$enteteAffichee = true;
		?>
		<p>Voici la liste des sujets de stage qui ont été validés : </p>
		<table width="100%">
		    <tr id="entete">
			<td width="30%">Nom</td>
			<td width="30%">Prenom</td>
			<td width="10%">Diplôme</td>
			<td width="10%">Spécialité</td>
			<td width="5%">Année</td>
			<td width="15%">Visualiser</td>
		    </tr>
	    <?php
	}
	?>
	    <tr id="ligne<?php echo $cpt % 2; $cpt++; ?>">
		<td><?php echo $etudiant->getNom(); ?></td>
		<td><?php echo $etudiant->getPrenom(); ?></td>
		<td><?php echo $filiere->getNom(); ?></td>
		<td><?php echo $parcours->getNom(); ?></td>
		<td><?php echo $promotion->getAnneeUniversitaire() ?></td>
		<td align="center">
		    <a href="./visualiserSDS.php?id=<?php echo $tabSDS[$i]->getIdentifiantBDD(); ?>">
			<img src="../../images/search.png">
		    </a>
		</td>
	    </tr>
		<?php
	    }
	    echo "</table>";
	}

}

?>