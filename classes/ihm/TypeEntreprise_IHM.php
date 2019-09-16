<?php

class TypeEntreprise_IHM {

    /**
     * Afficher un formulaire de création d'un nouveau type d'entreprise
     */
    public static function afficherFormulaireSaisie() {
	$tabCouleur = Couleur::listerCouleur();
	?>
	<form action='' method=post>
	    <table>
		<tr id="entete2">
		    <td colspan=2>Saisir un type d'entreprise</td>
		</tr>
		<tr>
		    <th width="100">Nom :</th>
		    <td>
			<input type="text" name="type" value="Saisir un type d'entreprise">
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
		    <td colspan=2>
			<input type=submit value="Enregistrer le type"/>
			<input type=reset value="Effacer"/>
		    </td>
		</tr>
	    </table>
	</form>
	<script>
	    function showColor() {
		var couleurActuelHTML = document.getElementById("couleurActuel");
		var couleurHTML = document.getElementById("idcouleur");
		couleurActuelHTML.style.backgroundColor = couleurHTML.options[couleurHTML.selectedIndex].style.color;
	    }
	</script>
	<?php
    }

    /**
     * Afficher un formulaire d'édition d'un type d'entreprise
     * @param integer $idTypeEntreprise Identifiant du type à éditer
     */
    public static function afficherFormulaireModification($idTypeEntreprise) {
        $type = TypeEntreprise::getTypeEntreprise($idTypeEntreprise);
        $couleur = $type->getCouleur();
        $tabCouleur = Couleur::listerCouleur();
	?>
	<form action='' method=post>
	    <input type=hidden name='id' value=<?php echo $type->getIdentifiantBDD(); ?>>
	    <table>
		<tr id='entete2'>
		    <td colspan="2">Modification d'un type d'entreprise</td>
		</tr>
		<tr>
		    <th width="100">Nom : </th>
		    <td>
			<input type="text" name='type' value='<?php echo $type->getType(); ?>'>
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
		    <td colspan="2">
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
     * Afficher un tableau interactif pour éditer ou supprimer un type
     * d'entreprise parmi la liste affichée
     */
    public static function afficherListeTypeEntrepriseAEditer() {
	$tabTypes = TypeEntreprise::getListeTypeEntreprise();
	if (sizeof($tabTypes) > 0) {
	    echo
	    "<table>
		<tr id='entete'>
		    <td width='50%'>Type d'entreprise</td>
		    <td width='10%' align='center'>Modifier</td>
		    <td width='10%' align='center'>Supprimer</td>
		</tr>";
	    for ($i = 0; $i < sizeof($tabTypes); $i++) {
		$couleur = $tabTypes[$i]->getCouleur();
		?>
		<tr id="ligne<?php echo $i % 2; ?>">
		    <td>
			<table >
			    <tr>
				<td width="60%"><?php echo $tabTypes[$i]->getType(); ?></td>
				<td width='20%'><?php echo $couleur->getNom(); ?></td>
				<td width='20%'>
				    <input readonly="disabled" style="background-color:<?php echo '#' . $couleur->getCode(); ?>; width: 100px; border-width: 0px;"/>
				</td>
			    </tr>
			</table>
		    </td>
		    <td align="center">
			<a href="gestionTypeEntreprise.php?action=mod&id=<?php echo $tabTypes[$i]->getIdentifiantBDD(); ?>">
			    <img src="../../images/reply.png"/>
			</a>
		    </td>
		    <td align="center">
			<a href="gestionTypeEntreprise.php?action=sup&id=<?php echo $tabTypes[$i]->getIdentifiantBDD(); ?>">
			    <img src="../../images/action_delete.png"/>
			</a>
		    </td>
		</tr>
		<?php
	    }
	    echo "</table>";
	    echo "<br/><br/>";
	} else {
	    echo "<br/><center>Aucun type d'entreprise n'a été trouvé.</center><br/>";
	}
    }
}

?>