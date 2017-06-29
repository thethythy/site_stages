<?php

class Etudiant_IHM {

    // $etu = Etudiant qui est modifié et dont les informations sont affichées.
    // si $etu = "", alors il s'agit d'un formulaire de création (champs vide)
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
					echo "value='" . $_POST['nom'] . "'";
				    else if ($etu != "")
					echo "value='" . $etu->getNom() . "'";
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
					echo "value='" . $_POST['prenom'] . "'";
				    else if ($etu != "")
					echo "value='" . $etu->getPrenom() . "'";
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
				    Les formats acceptés sont : PDF DOC DOCX.<br/>La taille doit être inférieure à 20 Mo.
				</td>
			    </tr>

			    <tr><td>&nbsp;</td></tr>

			    <tr>
				<td>Déposer votre rapport ici :</td>
				<td>
				    <input name="uploadRapport" type="file"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submitRapport" value="Déposer le rapport"/>
				</td>
			    </tr>
			    <tr>
				<td>Déposer votre résumé ici :</td>
				<td>
				    <input name="uploadResume" type="file"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submitResume" value="Déposer le résumé"/>
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

    public static function afficherListeEtudiants($annee, $tabEtudiants) {
	$nbEtudiants = sizeof($tabEtudiants);
	?>
	Nombre d'étudiants sélectionnés : <?php echo $nbEtudiants; ?><p/>
	<table>
	    <tr id='entete'>
		<td width='40%'>Nom et Prénom</td>
		<td width='40%'>Mail institutionnel</td>
		<td width='10%'>Diplôme</td>
		<td width='10%'>Spécialité</td>
	    </tr>
	<?php
	for ($i = 0; $i < $nbEtudiants; $i++) {
	    $promo = $tabEtudiants[$i]->getPromotion($annee);
	?>
	    <tr id="ligne<?php echo $i % 2; ?>">
	        <td>
		    <?php echo $tabEtudiants[$i]->getNom() . " " . $tabEtudiants[$i]->getPrenom(); ?>
	        </td>
	        <td>
		    <?php echo $tabEtudiants[$i]->getEmailInstitutionel(); ?>
	        </td>
	        <td>
		    <?php echo $promo->getFiliere()->getNom(); ?>
	        </td>
	        <td>
		    <?php echo $promo->getParcours()->getNom(); ?>
	        </td>
	    </tr>
	<?php
	}
	?>
	</table>
	<br/><br/>
	<?php
    }

    public static function afficherListeEtudiantsSansConventions($idPromo, $tabEtuSansConv) {
	if (sizeof($tabEtuSansConv) > 0) {
	    ?>
	    <table>
		<tr id='entete'>
		    <td width='90%'>Etudiant</td>
		    <td width='10%' align='center'>Supprimer</td>
		</tr>
	    <?php
	    for ($i = 0; $i < sizeof($tabEtuSansConv); $i++) {
	    ?>
		<tr id="ligne<?php echo $i % 2; ?>">
		    <td>
			<?php echo $tabEtuSansConv[$i]->getNom() . " " . $tabEtuSansConv[$i]->getPrenom(); ?>
		    </td>
		    <td align="center">
			<a href="supprimerEtudiant.php?promo=<?php echo $idPromo; ?>&id=<?php echo $tabEtuSansConv[$i]->getIdentifiantBDD(); ?>">
			    <img src="../../images/action_delete.png"/>
			</a>
		    </td>
		</tr>
	    <?php
	    }
	    ?>
	    </table>
	    <?php
	} else {
	    ?>
	    <br/>
		<center>
		    Aucune étudiant ne peut être supprimé dans cette promotion.
		    <br/>
		    Tous les étudiants de cette promotion ont déjà réalisé au moins un stage.
		</center>
	     <br/>
	    <?php
	}
    }
}

?>