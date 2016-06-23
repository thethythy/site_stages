<?php

class Filiere_IHM {

    public static function afficherFormulaireChoixFiliere() {
	$tabFiliere = Filiere::listerFilieres();
	?>
	<FORM METHOD="POST" ACTION="">
	    <table>
		<tr>
		    <td colspan=2>
			<table>
			    <tr id="entete2">
				<td colspan=2>Sélectionnez la filière</td>
			    </tr>
			    <tr>
				<th width="220">Sélectionnez le diplôme : </th>
				<td>
				    <?php
				    echo "<select name=filiere>";
				    echo "<option  value='-1' selected></option>";
				    for ($i = 0; $i < sizeof($tabFiliere); $i++) {
					echo "<option value='" . $tabFiliere[$i]->getIdentifiantBDD() . "'
					              name='" . $tabFiliere[$i]->getNom() . "'> " . $tabFiliere[$i]->getNom() . "</option>";
				    }
				    echo "</select>";
				    ?>
				</td>
			    </tr>
			    <tr>
				<td colspan=2>
				    <input type=submit value="Modifier un dipôme" />
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</FORM>
	<?php
    }

    public static function afficherFormulaireModificationTempsSoutenance($idFiliere) {
	$filiere = Filiere::getFiliere($idFiliere);
	?>
	<form action='modTempsSoutenance.php' method=post>
	    <input type=hidden name='id' value=<?php echo $idFiliere; ?>>
	    <table>
		<tr>
		    <td colspan=2>
			<table>
			    <tr id="entete2">
				<td colspan=2>Modification de la durée de la soutenance</td>
			    </tr>
			    <tr>
				<td width="200">Nom :</td>
				<td><?php echo $filiere->getNom(); ?></td>
			    </tr>
			    <tr>
				<td>Durée de la soutenance : </td>
				<td>
				    <input name='duree' size=3 value=<?php echo $filiere->getTempsSoutenance(); ?>> minutes
				</td>
			    </tr>
			    <tr>
				<td colspan="2">
				    <input type=submit value='Enregistrer les données'/>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</form>
	<?php
    }

}
?>