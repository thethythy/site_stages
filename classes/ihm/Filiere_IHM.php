<?php

class Filiere_IHM {

    /**
     * Afficher un formulaire d'édition du temps de soutenance d'une filière
     * @param integer $idFiliere Identifiant de la filière
     */
    public static function afficherFormulaireModification($idFiliere) {
	$filiere = Filiere::getFiliere($idFiliere);
	?>
	<form method=post>
	    <table>
		<tr id="entete2">
		    <td colspan=2>Modification de la durée de la soutenance</td>
		</tr>
		<tr>
		    <td width="200">Diplôme :</td>
		    <td><?php echo $filiere->getNom(); ?></td>
		</tr>
		<tr>
		    <td>Durée de la soutenance : </td>
		    <td>
			<input name='duree' size=3 value=<?php echo $filiere->getTempsSoutenance(); ?>> minutes
		    </td>
		</tr>
		<tr>
		    <td>
			<input type=hidden name='id' value=<?php echo $idFiliere; ?>>
			<input type=hidden name='action' value="mod">
			<input type=submit value='Enregistrer les données'/>
		    </td>
		</tr>
	    </table>
	</form>
	<?php
    }

    /**
     * Afficher un tableau interactif pour éditer les temps de soutenance
     */
    public static function afficherListeTempsSoutenanceAEditer() {
	$tabFiliere = Filiere::listerFilieres();
	if (sizeof($tabFiliere) > 0) {
	    echo
	    "<table>
		<tr id='entete'>
		    <td width='50%'>Diplôme</td>
		    <td width='10%' align='center'>Modifier</td>
		    <td width='10%' align='center'>Mise à zéro</td>
		</tr>";
	    for ($i = 0 ; $i < sizeof($tabFiliere); $i++) {
		$nom = $tabFiliere[$i]->getNom();
		$tps_soutenance = $tabFiliere[$i]->getTempsSoutenance();
		?>
		<tr class="ligne<?php echo $i % 2; ?>">
		    <td>
			<table >
			    <tr>
				<td width='50%'><?php echo $nom; ?></td>
				<td><?php echo "Durée : ".$tps_soutenance." min"; ?></td>
			    </tr>
			</table>
		    </td>
		    <td align="center">
			<a href="gestionTempsSoutenance.php?action=mod&id=<?php echo $tabFiliere[$i]->getIdentifiantBDD(); ?>">
			    <img src="../../images/reply.png"/>
			</a>
		    </td>
		    <td align="center">
			<a href="gestionTempsSoutenance.php?action=sup&id=<?php echo $tabFiliere[$i]->getIdentifiantBDD(); ?>">
			    <img src="../../images/action_delete.png"/>
			</a>
		    </td>
		</tr>
		<?php
	    }
	    echo "</table>";
	    echo "<br/>";
	} else {
	    echo "<br/><center>Aucun diplôme n'a été trouvé.</center><br/>";
	}
    }
}
?>