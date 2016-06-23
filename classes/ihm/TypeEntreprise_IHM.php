<?php

class TypeEntreprise_IHM {

    public static function afficherFormulaireSaisie() {
	?>
	<FORM METHOD="POST" ACTION="">
	    <table id="table_saisieType">
		<tr>
		    <td colspan=2>
			<table id="presentation_saisieType">
			    <tr id="entete2">
				<td colspan=2>Saisir un type d'entreprise</td>
				<td>
				    <input type="text" name="type" >
				</td>
			    </tr>
			    <tr id="entete2">
				<th>Sélectionnez la couleur :</th>
				<td>
				    <select id="idCouleur" name="idCouleur" onchange='showColor()'>
					<?php
					$tabCouleur = Couleur::listerCouleur();
					for ($i = 0; $i < sizeof($tabCouleur); $i++)
					    echo "<option value='" . $tabCouleur[$i]->getIdentifiantBDD() . "' style='color: #" . $tabCouleur[$i]->getCode() . ";'>" . $tabCouleur[$i]->getNom() . "</option>";
					?>
				    </select>
				    &nbsp;&nbsp;&nbsp;&nbsp;
				    <input id="couleurActuel" readonly="disabled" style="background-color: <?php echo '#' . $tabCouleur[0]->getCode(); ?>; width: 100px; border-width: 0px;"/>
				</td>
			    </tr>
			    <tr>
				<td colspan=2>
				    <input type=submit value="Enregistrer le type"/>
				    <input type=reset value="Effacer"/>
				</td>
			    </tr>
			    <tr id="entete2">
				<td colspan=2>Liste des types</td>
			    </tr>
			</table>
			<?php
			$tabType = TypeEntreprise::getListeTypeEntreprise();
			for ($i = 0; $i < sizeof($tabType); $i++) {
			    $couleur = $tabType[$i]->getCouleur();
			    ?>
			<table id="presentation_type">
			    <tr>
				<td width="220" align="right">
				    <?php
				    echo "<FONT COLOR=#" . $couleur->getCode() . ">";
				    echo $tabType[$i]->getType() . " -";
				    ?>
				    </FONT>
				</td>
				<td>
				    <?php echo "- " . $couleur->getNom(); ?>
				</td>
			    </tr>
			<?php
			}
			?>
			</table>
		    </td>
		</tr>
	    </table>
	</FORM>
	<script>
	    function showColor() {
		var couleurActuelHTML = document.getElementById("couleurActuel");
		var couleurHTML = document.getElementById("idCouleur");
		couleurActuelHTML.style.backgroundColor = couleurHTML.options[couleurHTML.selectedIndex].style.color;
	    }
	</script>
	<?php
    }

    public static function afficherFormulaireSelection() {
	?>
	<FORM id="formModifType" METHOD="POST" ACTION="">
	    <table id="table_modifType">
		<tr>
		    <td colspan=2>
			<table id="presentation_modifType">
			    <tr id="entete2">
				<td colspan=2>Sélection d'un type d'entreprise</td>
			    </tr>
			    <tr>
				<th width="220">Sélectionnez le type : </th>
				<th>
				    <?php
				    $tabTypeEntreprise = TypeEntreprise::getListeTypeEntreprise();
				    echo "<select name='type'>";
				    echo "<option value='-1' selected>---Type Entreprise---</option>";
				    for ($i = 0; $i < sizeof($tabTypeEntreprise); $i++) {
					$couleur = $tabTypeEntreprise[$i]->getCouleur();
					echo "<option value='" . $tabTypeEntreprise[$i]->getIdentifiantBDD() . "'style='color: #" . $couleur->getCode() . ";'>" . $tabTypeEntreprise[$i]->getType() . "</option>";
				    }
				    echo "</select>";
				    ?>
				</th>
			    </tr>
			    <tr>
				<td colspan=2>
				    <input type=submit value="Modifier" />
				    <input type=submit value="Supprimer" onclick="this.form.action = '../../gestion/entreprises/supTypeEntreprise.php'"/>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</FORM>
	<?php
    }

    public static function afficherFormulaireModification($idTypeEntreprise) {
        $type = TypeEntreprise::getTypeEntreprise($idTypeEntreprise);
        $couleur = $type->getCouleur();
        $tabCouleur = Couleur::listerCouleur();
	?>
	<form action='modTypeEntreprise.php' method=post>
	    <input type=hidden name='id' value=<?php echo $type->getIdentifiantBDD(); ?>>
	    <table>
		<tr>
		    <td colspan="2">
			<table>
			    <tr id='entete2'>
				<td colspan="2">Modification d'un type d'entreprise</td>
			    </tr>
			    <tr>
				<th>Type d'entreprise : </th>
				<td>
				    <input name='label' size=100 value='<?php echo $type->getType(); ?>'>
				</td>
			    </tr>
			    <tr>
				<th>Couleur : </th>
				    <td>
					<select id='couleur' name='couleur' onchange='showColor()'>
					    <?php
					    for ($i = 0; $i < sizeof($tabCouleur); $i++) {
						if ($couleur->getIdentifiantBDD() == $tabCouleur[$i]->getIdentifiantBDD())
						    echo "<option style='color: #" . $tabCouleur[$i]->getCode() . ";' selected value='" . $tabCouleur[$i]->getIdentifiantBDD() . "'>" . $tabCouleur[$i]->getNom() . "</option>";
						else
						    echo "<option style='color: #" . $tabCouleur[$i]->getCode() . ";' value='" . $tabCouleur[$i]->getIdentifiantBDD() . "'>" . $tabCouleur[$i]->getNom() . "</option>";
					    }
					    ?>
					</select>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input id='couleurActuel' readonly='disabled' style='background-color: <?php echo '#' . $couleur->getCode(); ?>; width: 100px; border-width: 0px;'/>
				    </td>
			    </tr>
			    <tr>
				<td colspan="2">
				    <input type=submit value='Modifier'/>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</form>
	<script>
	    function showColor() {
		var couleurActuelHTML = document.getElementById('couleurActuel');
		var couleurHTML = document.getElementById('couleur');
		couleurActuelHTML.style.backgroundColor = couleurHTML.options[couleurHTML.selectedIndex].style.color;
	    }
	</script>
	<?php
    }
}

?>