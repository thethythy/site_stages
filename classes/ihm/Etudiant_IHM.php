<?php

class Etudiant_IHM {

    /**
     * Affiche un formulaire d'édition d'un étudiant
     * Si $etu = "", alors il s'agit d'un formulaire de création (champs vide)
     * @param Etudiant ou "" $etu L'étudiant à éditer ou rien
     */
    public static function afficherFormulaireEdition($etu) {
	?>
	<form method=post action="">
	    <table width="100%">
		<tr>
		    <td width="50%" align="center">
			<table>
			    <tr>
				<td>Nom</td>
				<td>
				    <input type="text" name="nom"
				    <?php
				    if (isset($_POST['nom']))
					echo "value=" . $_POST['nom'];
				    else if ($etu != "")
					echo "value=" . $etu->getNom();
				    ?>
					   />
				</td>
			    </tr>
			    <tr>
				<td>Prénom</td>
				<td>
				    <input type="text" name="prenom"
				    <?php
				    if (isset($_POST['prenom']))
					echo "value=" . $_POST['prenom'];
				    else if ($etu != "")
					echo "value=" . $etu->getPrenom();
				    ?>
					   />
				</td>
			    </tr>
			</table>
		    </td>
		    <td width="50%" align="center">
			<table>
			    <tr>
				<td>Email personnel</td>
				<td>
				    <input type="text" name="email"
				    <?php
				    if (isset($_POST['email']))
					echo "value='" . $_POST['email'] . "'";
				    else if ($etu != "")
					echo "value='" . $etu->getEmailPersonnel() . "'";
				    ?>
					   />
				</td>
			    </tr>
			    <tr>
				<td>Email institutionnel</td>
				<td>
				    <input type="text" name="emailinst"
				    <?php
				    if (isset($_POST['emailinst']))
					echo "value='" . $_POST['emailinst'] . "'";
				    else if ($etu != "")
					echo "value='" . $etu->getEmailInstitutionel() . "'";
				    ?>
					   />
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr>
		    <td colspan="2" id="submit">
			<input type="hidden" value="1" name="<?php if ($etu != "") echo "edit"; else echo "add"; ?>">
			<input type="submit" value="Valider">
		    </td>
		</tr>
	    </table>
	</form>
	<?php
    }

    /**
     * Afficher un formulaire de dépôt d'un document par un étudiant
     * @param tableau d'objets $tabEtu Les objets Etudiant concernés
     * @param integer $annee L'année concernée
     * @param integer $parcours L'identifiant du parcours concerné
     * @param integer $filiere L'identifiant de la filière concernée
     */
    public static function afficherFormulaireDepot($tabEtu, $annee, $parcours, $filiere) {
	?>
	<form enctype="multipart/form-data" method=post action="">
	    <table width="100%">
		<tr>
		    <td width="100%" align="center">
			<table>
			    <tr>
				<td>Etudiant</td>
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

			    <tr><td>&nbsp;</td></tr>

			    <tr>
				<td>
				    Les formats acceptés sont : PDF DOC DOCX.<br/>
				    La taille doit être inférieure à 20 Mo.<br/>
				    Déposer un seul document à la fois.
				</td>
			    </tr>

			    <tr><td>&nbsp;</td></tr>

			    <tr>
				<td>Déposer votre rapport ici :</td>
				<td>
				    <input name="uploadRapport" type="file"/>
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    <input type="submit" name="submitRapport" value="Déposer le rapport"/>
				</td>
			    </tr>

			    <tr><td>&nbsp;</td></tr>

			    <tr>
				<td>Déposer votre résumé ici :</td>
				<td>
				    <input name="uploadResume" type="file"/>
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    <input type="submit" name="submitResume" value="Déposer le résumé"/>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>

	    <input type="hidden" name="annee" value="<?php echo $annee; ?>"/>
	    <input type="hidden" name="parcours" value="<?php echo $parcours; ?>"/>
	    <input type="hidden" name="filiere" value="<?php echo $filiere; ?>"/>

	</form>
	<?php
    }

    /**
     * Afficher un tableau d'étudiants
     * @param integer $annee L'année concernée
     * @param tableau d'objets $tabEtudiants Tableau d'objets Etudiant
     */
    public static function afficherListeEtudiants($annee, $tabEtudiants) {
	$nbEtudiants = sizeof($tabEtudiants);
	?>
	Nombre d'étudiants sélectionnés : <?php echo $nbEtudiants; ?><p/>
	<table>
	    <tr id='entete'>
		<td width='50%'>Nom, Prénom, Email</td>
		<td width='10%'>Diplôme</td>
		<td width='10%'>Spécialité</td>
		<td width='10%'>Convention</td>
		<td width='10%'>Dernière promotion</td>
		<td width='10%'>Supression</td>
	    </tr>
	<?php
	for ($i = 0; $i < $nbEtudiants; $i++) {
	    $anneePromo = $conv = NULL;

	    if (! $annee) {
		$lastannee = Promotion_BDD::getLastAnnee();
		$promo = $tabEtudiants[$i]->getLastPromotion($lastannee);
		if ($promo) {
		    $anneePromo = $promo->getAnneeUniversitaire();
		    $conv = $tabEtudiants[$i]->getLastConvention($anneePromo);
		}
	    } else {
		$anneePromo = $annee;
		$promo = $tabEtudiants[$i]->getPromotion($anneePromo);
		$conv = $tabEtudiants[$i]->getLastConvention($anneePromo);
	    }
	?>
	    <tr id="ligne<?php echo $i % 2; ?>">
	        <td>
		    <?php echo $tabEtudiants[$i]->getNom() . " " . $tabEtudiants[$i]->getPrenom(); ?>
		    <br/>
		    <?php echo $tabEtudiants[$i]->getEmailInstitutionel(); ?>
	        </td>
	        <td>
		    <?php if ($promo) echo $promo->getFiliere()->getNom(); ?>
	        </td>
	        <td>
		    <?php if ($promo) echo $promo->getParcours()->getNom(); ?>
	        </td>
		<td>
		    <?php
			if ($conv)
			    echo '<img src="../../images/action_check.png"/>';
			else
			    echo '<img src="../../images/action_remove.png"/>';
		    ?>
		</td>
		<td>
		    <?php if ($anneePromo) echo $anneePromo.'-'.($anneePromo+1); ?>
		</td>
		<td>
		    <?php
		    if (!$anneePromo) {
			echo '<a href="gestionEtudiants.php?id='. $tabEtudiants[$i]->getIdentifiantBDD().'&supprime&">
				<img src="../../images/action_delete.png"/>
			      </a>';
		    } else {
			echo 'Impossible';
		    }
		    ?>
		</td>
	    </tr>
	<?php
	}
	?>
	</table>
	<br/><br/>
	<?php
    }

}

?>