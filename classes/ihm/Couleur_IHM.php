<?php

class Couleur_IHM {

    /**
     * Afficher un formulaire de saisie d'une nouvelle couleur (son nom et son code héxadécimal)
     */
    public static function afficherFormulaireSaisie() {
	?>
	<FORM METHOD="POST" ACTION="">
	    <table>
		<tr>
		    <td colspan=2>
			<table>
			    <tr id="entete2">
				<td colspan=2>Saisir une couleur</td>
			    </tr>
			    <tr>
				<th width="100">Nom :</th>
				<td>
				    <input type="text" id='name' name="nomcouleur" value="Le nom de la couleur"/>
				</td>
			    </tr>
			    <tr>
				<th>Couleur :</th>
				<td>
				    <input id="colorPicker" type="color" name="codehexa" value="#FFFFFF" oninput='showColor()' />
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    <input id="couleurActuel" readonly="disabled" style="background-color: '#FFFFFF'; width: 100px; border-width: 0px;"/>
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
		document.getElementById("name").value = 'Le nom de la couleur';
		document.getElementById("colorPicker").value = '#FFFFFF';
		document.getElementById("couleurActuel").style.backgroundColor = '#FFFFFF';
	    }
	    function showColor() {
		var couleurActuelHTML = document.getElementById("couleurActuel");
		var couleurHTML = document.getElementById("colorPicker");
		couleurActuelHTML.style.backgroundColor = couleurHTML.value;
	    }
	</script>
	<?php
    }

    /**
     * Afficher un formulaire d'édition d'une couleur existante (son nom et son code héxadécimal)
     * @param integer $idCouleur Identifiant de la couleur à éditer
     */
    public static function afficherFormulaireModification($idCouleur) {
	$couleur = Couleur::getCouleur($idCouleur);
	?>
	<form action='' method=post>
	    <input type=hidden name='id' value=<?php echo $idCouleur;?>>
	    <table>
		<tr>
		    <td colspan="2">
			<table>
			    <tr id="entete2">
				<td colspan="2">Modifier d'une couleur</td>
			    </tr>
			    <tr>
				<th width='100'>Nom : </th>
				<td>
				    <input id='name' type="text" name='nomcouleur' value='<?php echo $couleur->getNom();?>'>
				</td>
			    </tr>
			    <tr>
				<th>Couleur : </th>
				<td>
				    <input id='colorPicker' type='color' name='codehexa' value='<?php echo "#" . $couleur->getCode(); ?>' oninput="showColor()">
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    <input id="couleurActuel" readonly="disabled" style="background-color:<?php echo '#' . $couleur->getCode(); ?>; width: 100px; border-width: 0px;"/>
				</td>
			    </tr>
			    <tr>
				<td colspan="2">
				    <input type=submit value='Enregistrer les données'/>
				    <input type=reset value="Effacer" onclick="effacer()"/>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</form>
	<script>
	    function effacer() {
		document.getElementById("name").value = 'Le nom de la couleur';
		document.getElementById("colorPicker").value = '#FFFFFF';
	    }
	    function showColor() {
		var couleurActuelHTML = document.getElementById("couleurActuel");
		var couleurHTML = document.getElementById("colorPicker");
		couleurActuelHTML.style.backgroundColor = couleurHTML.value;
	    }
	</script>
	<?php
    }

    /**
     * Afficher une liste de couleur dans un tableau interactif pour
     * éditer ou supprimer une couleur
     */
    public static function afficherListeCouleurAEditer() {
	$tabCouleurs = Couleur::listerCouleur();
	if (sizeof($tabCouleurs) > 0) {
	    echo
	    "<table>
		<tr id='entete'>
		    <td width='50%'>Couleur</td>
		    <td width='10%' align='center'>Modifier</td>
		    <td width='10%' align='center'>Supprimer</td>
		</tr>";
	    for ($i = 0; $i < sizeof($tabCouleurs); $i++) {
		$coul = $tabCouleurs[$i];
		?>
		<tr class="ligne<?php echo $i % 2; ?>">
		    <td>
			<table >
			    <tr>
				<td width='50%'><?php echo $coul->getNom(); ?></td>
				<td width='50%'>
				    <input readonly="disabled" style="background-color:<?php echo '#' . $coul->getCode(); ?>; width: 100px; border-width: 0px;"/>
				</td>
			    </tr>
			</table>
		    </td>
		    <td align="center">
			<a href="gestionCouleur.php?action=mod&id=<?php echo $coul->getIdentifiantBDD(); ?>">
			    <img src="../../images/reply.png"/>
			</a>
		    </td>
		    <td align="center">
			<a href="gestionCouleur.php?action=sup&id=<?php echo $coul->getIdentifiantBDD(); ?>">
			    <img src="../../images/action_delete.png"/>
			</a>
		    </td>
		</tr>
		<?php
	    }
	    echo "</table>";
	    echo "<br/><br/>";
	} else {
	    echo "<br/><center>Aucune couleur n'a été trouvée.</center><br/>";
	}
    }
}

?>