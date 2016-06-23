<?php

class ThemeDeStage_IHM {

    public static function afficherFormulaireSaisie() {
	?>
	<FORM METHOD="POST" ACTION="">
	    <table id="table_saisieTheme">
		<tr>
		    <td colspan=2>
			<table id="presentation_saisieTheme">
			    <tr id="entete2">
				<td colspan=2>Saisir un thème de stage</td>
				<td>
				    <input type="text" name="theme" >
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
				<td colspan=2><input type=submit value="Ajouter"/><input type=reset value="Effacer"/></td>
			    </tr>
			    <tr id="entete2">
				<td colspan=2>Liste des themes</td>
			    </tr>
			</table>
			<?php
			$tabTheme = ThemeDeStage::getListeTheme();
			for ($i = 0; $i < sizeof($tabTheme); $i++) {
			    $couleur = $tabTheme[$i]->getCouleur();
			    ?>
			<table id="presentation_theme">
			    <tr>
				<td width="220" align="right">
				    <?php echo "<FONT COLOR=#" . $couleur->getCode() . ">"; echo $tabTheme[$i]->getTheme() . " -"; ?>
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
	<FORM id="formModifTheme" METHOD="POST" ACTION="">
	    <table id="table_msTheme">
		<tr>
		    <td colspan=2>
			<table id="presentation_msTheme">
			    <tr id="entete2">
				<td colspan=2>Sélection du thème de stage</td>
			    </tr>
			    <tr>
				<th width="220">Sélectionnez le thème : </th>
				<th>
				    <?php
				    $tabTheme = ThemeDeStage::getListeTheme();
				    echo "<select name=theme>";
				    echo "<option  value='-1' selected>---Theme de stage---</option>";
				    for ($i = 0; $i < sizeof($tabTheme); $i++) {
					$couleur = $tabTheme[$i]->getCouleur();
					echo "<option value='" . $tabTheme[$i]->getIdTheme() . "'style='color: #" . $couleur->getCode() . ";'>" . $tabTheme[$i]->getTheme() . "</option>";
				    }
				    echo "</select>";
				    ?>
				</th>
			    </tr>
			    <tr>
				<td colspan=2>
				    <input type=submit value="Modifier" />
				    <input type=submit value="Supprimer" onclick="this.form.action = '../../gestion/conventions/sup_themeDeStage.php'"/>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</FORM>
	<?php
    }

    public static function afficherFormulaireModification($theme) {
	$couleur = $theme->getCouleur();
	$tabCouleur = Couleur::listerCouleur();
	?>
	<form action='mod_themeDeStage.php' method=post>
	    <input type=hidden name='id' value=<?php echo $theme->getIdTheme(); ?>>
	    <table>
		<tr>
		    <td colspan ='2'>
			<table>
			    <tr id="entete2">
				<td colspan="2">Modification d'un thème de stage</td>
			    </tr>
			    <tr>
				<th>Thème de stage : </th>
				<td>
				    <input name='label' size=100 value=<?php echo $theme->getTheme(); ?>>
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
				<td>
				    <input type=submit value='Modifier'/>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</form>

	<script>
	    document.getElementById('formModifTheme').hidden = true;
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