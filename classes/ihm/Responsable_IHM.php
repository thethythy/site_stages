<?php

class Responsable_IHM {

    /**
     * Afficher un formulaire de saisie d'un nouveau responsable
     */
    public static function afficherFormulaireSaisie() {
	?>
	<FORM METHOD="POST" ACTION="">
	    <table>
		<tr>
		    <td colspan=2>
			<table>
			    <tr id="entete2">
				<td colspan=2>Saisir un responsable</td>
			    </tr>
			    <tr>
				<th width="100">Responsabilité :</th>
				<td>
				    <input type="text" id='responsabilite' name="responsabilite" placeholder="La_responsabilite (sans accent ; sans espace)"/>
				</td>
			    </tr>
			    <tr>
				<th width="100">Nom :</th>
				<td>
				    <input type="text" id='nom' name="nomresponsable" placeholder="Le nom du responsable"/>
				</td>
			    </tr>
			    <tr>
				<th width="100">Prénom :</th>
				<td>
				    <input type="text" id='prenom' name="prenomresponsable" placeholder="Le prénom du responsable"/>
				</td>
			    </tr>
			    <tr>
				<th width="100">Email :</th>
				<td>
				    <input type="text" id='email' name="emailresponsable" placeholder="L'email du responsable"/>
				</td>
			    </tr>
			    <tr>
				<td colspan=2>
				    <input type=submit value="Enregistrer les données"/>
				    <input type=reset value="Effacer" onclick="effacer()"/>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</FORM>
	<script>
	    function effacer() {
		document.getElementById("responsabilite").value = '';
		document.getElementById("nom").value = '';
		document.getElementById("prenom").value = '';
		document.getElementById("email").value = '';
	    }
	</script>
	<?php
    }

    /**
     * Afficher un formulaire d'édition d'un responsable existant
     * @param integer $idResponsable Identifiant du responsable à éditer
     */
    public static function afficherFormulaireModification($idResponsable) {
	$responsable = Responsable::getResponsable($idResponsable);
	?>
	<FORM METHOD="POST" ACTION="">
	    <input type=hidden name='id' value=<?php echo $idResponsable;?>>
	    <table>
		<tr>
		    <td colspan=2>
			<table>
			    <tr id="entete2">
				<td colspan=2>Modifier un responsable</td>
			    </tr>
			    <tr>
				<th width="100">Responsabilité :</th>
				<td>
				    <input type="text" id='responsabilite' name="responsabilite" value="<?php echo $responsable->getResponsabilite(); ?>" placeholder="La_responsabilite (sans accent ; sans espace)"/>
				</td>
			    </tr>
			    <tr>
				<th width="100">Nom :</th>
				<td>
				    <input type="text" id='nom' name="nomresponsable" value="<?php echo $responsable->getNomresponsable(); ?>" placeholder="Le nom du responsable"/>
				</td>
			    </tr>
			    <tr>
				<th width="100">Prénom :</th>
				<td>
				    <input type="text" id='prenom' name="prenomresponsable" value="<?php echo $responsable->getPrenomresponsable(); ?>" placeholder="Le prénom du responsable"/>
				</td>
			    </tr>
			    <tr>
				<th width="100">Email :</th>
				<td>
				    <input type="text" id='email' name="emailresponsable" value="<?php echo $responsable->getEmailresponsable(); ?>" placeholder="L'email du responsable"/>
				</td>
			    </tr>
			    <tr>
				<td colspan=2>
				    <input type=submit value="Enregistrer les données"/>
				    <input type=reset value="Effacer" onclick="effacer()"/>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</FORM>
	<script>
	    function effacer() {
		document.getElementById("responsabilite").value = '';
		document.getElementById("nom").value = '';
		document.getElementById("prenom").value = '';
		document.getElementById("email").value = '';
	    }
	</script>
	<?php
    }

    /**
     * Afficher une liste de responsable dans un tableau interactif pour
     * éditer ou supprimer un responsable
     */
    public static function afficherListeResponsableAEditer() {
	$tabResponsables = Responsable::listerResponsable();
	if (sizeof($tabResponsables) > 0) {
	    echo
	    "<table>
		<tr id='entete'>
		    <td width='42%'>Responsabilité</td>
		    <td width='42%'>Responsable</td>
		    <td width='8%' align='center'>Modifier</td>
		    <td width='8%' align='center'>Supprimer</td>
		</tr>";
	    for ($i = 0; $i < sizeof($tabResponsables); $i++) {
		$resp = $tabResponsables[$i];
		?>
		<tr class="ligne<?php echo $i % 2; ?>">
		    <td align="center">
			<?php echo $resp->getResponsabilite(); ?>
		    </td>
		    <td align="center">
			<?php echo $resp->getPrenomresponsable() . " ". $resp->getNomresponsable() . " (" . $resp->getEmailresponsable() . ")"; ?>
		    </td>
		    <td align="center">
			<a href="gestionResponsable.php?action=mod&id=<?php echo $resp->getIdentifiantBDD(); ?>">
			    <img src="../../images/reply.png"/>
			</a>
		    </td>
		    <td align="center">
			<a href="gestionresponsable.php?action=sup&id=<?php echo $resp->getIdentifiantBDD(); ?>">
			    <img src="../../images/action_delete.png"/>
			</a>
		    </td>
		</tr>
		<?php
	    }
	    echo "</table>";
	    echo "<br/><br/>";
	} else {
	    echo "<br/><center>Aucun responsbale n'a été trouvé.</center><br/>";
	}
    }

}

?>
