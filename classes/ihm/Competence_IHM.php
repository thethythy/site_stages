<?php

class Competence_IHM {

    public static function afficherFormulaireSaisie() {
	?>
	<FORM METHOD="POST" ACTION="">
	    <table>
		<tr id="entete2">
		    <td colspan=2>Saisir une compétence</td>
		</tr>
		<tr>
		    <th width="200">La compétence :</th>
		    <td>
			<input type="text" id='name' name="nomcompetence" value='Le nom de la compétence'>
		    </td>
		</tr>
		<tr>
		    <td colspan="2">
			<input type=submit value="Enregistrer les données">
			<input type=reset value="Effacer" onclick="effacer()"/>
		    </td>
		</tr>
	    </table>
	</FORM>
	<script>
	    function effacer() {
		document.getElementById("name").value = 'Le nom de la compétence';
	    }
	</script>
	<?php
    }

    public static function afficherFormulaireModification($idComp) {
	$competence = Competence::getCompetence($idComp);
	?>
	<form method=post action=''>
	    <input type=hidden name='id' value=<?php echo $idComp; ?>/>
	    <table>
		<tr id="entete2">
		    <td colspan=2>Editer une compétence</td>
		</tr>
		<tr>
		    <th width="200">La compétence : </th>
		    <td>
			<input type="text" id='name' name="nomcompetence"value='<?php echo $competence->getNom(); ?>'>
		    </td>
		</tr>
		<tr>
		    <td colspan="2">
			<input type=submit value="Enregistrer les données">
			<input type=reset value="Effacer" onclick="effacer()"/>
		    </td>
		</tr>
	    </table>
	</FORM>
	<script>
	    function effacer() {
		document.getElementById("name").value = 'Le nom de la compétence';
	    }
	</script>
	<?php
    }

    public static function afficherListeCompetenceAEditer() {
	$tabCompetences = Competence::listerCompetences();
	if (sizeof($tabCompetences) > 0) {
	    echo
	    "<table>
		<tr id='entete'>
		    <td width='20%'>Compétence</td>
		    <td width='10%' align='center'>Modifier</td>
		    <td width='10%' align='center'>Supprimer</td>
		</tr>";
	    for ($i = 0; $i < sizeof($tabCompetences); $i++) {
		$comp = $tabCompetences[$i];
		?>
		<tr id="ligne<?php echo $i % 2; ?>">
		    <td>
			<?php echo $comp->getNom(); ?>
		    </td>
		    <td align="center">
			<a href="gestionCompetence.php?action=mod&id=<?php echo $comp->getIdentifiantBDD(); ?>">
			    <img src="../../images/reply.png"/>
			</a>
		    </td>
		    <td align="center">
			<a href="gestionCompetence.php?action=sup&id=<?php echo $comp->getIdentifiantBDD(); ?>">
			    <img src="../../images/action_delete.png"/>
			</a>
		    </td>
		</tr>
		<?php
	    }
	    echo "</table>";
	    echo "<br/><br/>";
	} else {
	    echo "<br/><center>Aucune compétence n'a été trouvée.</center><br/>";
	}
    }

}
?>
