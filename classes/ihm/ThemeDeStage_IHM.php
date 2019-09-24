<?php

class ThemeDeStage_IHM {

    /**
     * Afficher un formulaire de création d'un thème de stage
     */
    public static function afficherFormulaireSaisie() {
	$tabCouleur = Couleur::listerCouleur();
	?>
	<form method=post action="">
	    <table>
		<tr id="entete2">
		    <td colspan="2">Saisir un thème de stage</td>
		</tr>
		<tr>
		    <th>Nom :</td>
		    <td>
			<input id="theme" type="text" name="theme" value="Le nom du thème">
		    </td>
		</tr>
		<tr>
		    <th>Couleur :</th>
		    <td>
			<select id="idcouleur" name="idcouleur" onchange='showColor()'>
			    <?php
			    for ($i = 0; $i < sizeof($tabCouleur); $i++)
				echo "<option value='" . $tabCouleur[$i]->getIdentifiantBDD() . "' style='color: #" . $tabCouleur[$i]->getCode() . ";'>" . $tabCouleur[$i]->getNom() . "</option>";
			    ?>
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="couleurActuel" readonly="disabled" style="background-color: <?php echo '#' . $tabCouleur[0]->getCode(); ?>; width: 100px; border-width: 0px;"/>
		    </td>
		</tr>
		<tr>
		    <td colspan="2">
			<input type=submit value="Ajouter"/>
			<input type=reset value="Effacer" onclick="effacer()"/>
		    </td>
		</tr>
	    </table>
	</form>
	<script>
	    function effacer() {
		document.getElementById("theme").value = 'Le nom du thème';
		document.getElementById("idcouleur").value = '#FFFFFF';
		document.getElementById("couleurActuel").style.backgroundColor = '#FFFFFF';
	    }
	    function showColor() {
		var couleurActuelHTML = document.getElementById("couleurActuel");
		var couleurHTML = document.getElementById("idcouleur");
		couleurActuelHTML.style.backgroundColor = couleurHTML.options[couleurHTML.selectedIndex].style.color;
	    };
	</script>
	<?php
    }

    /**
     * Afficher un formulaire d'édition d'un thème existant
     * @param integer $idtheme Identifiant du thème à éditer
     */
    public static function afficherFormulaireModification($idtheme) {
	$theme = ThemeDeStage::getThemeDeStage($idtheme);
	$couleur = $theme->getCouleur();
	$tabCouleur = Couleur::listerCouleur();
	?>
	<form action='' method=post>
	    <input type=hidden name='id' value=<?php echo $idtheme; ?>>
	    <table>
		<tr id="entete2">
		    <td colspan="2">Modification d'un thème de stage</td>
		</tr>
		<tr>
		    <th>Nom : </th>
		    <td>
			<input name='theme' type="text" value="<?php echo $theme->getTheme(); ?>">
		    </td>
		</tr>
		<tr>
		    <th>Couleur : </th>
		    <td>
			<select id='idcouleur' name='idcouleur' onchange='showColor()'>
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
	</form>
	<script>
	    function showColor() {
		var couleurActuelHTML = document.getElementById('couleurActuel');
		var couleurHTML = document.getElementById('idcouleur');
		couleurActuelHTML.style.backgroundColor = couleurHTML.options[couleurHTML.selectedIndex].style.color;
	    }
	</script>
	<?php
    }

    /**
     * Afficher un tableau interactif des thèmes de stages pour édition
     * ou suppression
     */
    public static function afficherListeThemeDeStageAEditer() {
	$tabThemes = ThemeDeStage::getListeTheme();
	if (sizeof($tabThemes) > 0) {
	    echo
	    "<table>
		<tr id='entete'>
		    <td width='50%'>Thème de stage</td>
		    <td width='10%' align='center'>Modifier</td>
		    <td width='10%' align='center'>Supprimer</td>
		</tr>";
	    for ($i = 0; $i < sizeof($tabThemes); $i++) {
		$couleur = $tabThemes[$i]->getCouleur();
		?>
		<tr class="ligne<?php echo $i % 2; ?>">
		    <td>
			<table >
			    <tr>
				<td width="60%"><?php echo $tabThemes[$i]->getTheme(); ?></td>
				<td width='20%'><?php echo $couleur->getNom(); ?></td>
				<td width='20%'>
				    <input readonly="disabled" style="background-color:<?php echo '#' . $couleur->getCode(); ?>; width: 100px; border-width: 0px;"/>
				</td>
			    </tr>
			</table>
		    </td>
		    <td align="center">
			<a href="gestionThemeDeStage.php?action=mod&id=<?php echo $tabThemes[$i]->getIdentifiantBDD(); ?>">
			    <img src="../../images/reply.png"/>
			</a>
		    </td>
		    <td align="center">
			<a href="gestionThemeDeStage.php?action=sup&id=<?php echo $tabThemes[$i]->getIdentifiantBDD(); ?>">
			    <img src="../../images/action_delete.png"/>
			</a>
		    </td>
		</tr>
		<?php
	    }
	    echo "</table>";
	    echo "<br/><br/>";
	} else {
	    echo "<br/><center>Aucun thème n'a été trouvé.</center><br/>";
	}
    }
}

?>