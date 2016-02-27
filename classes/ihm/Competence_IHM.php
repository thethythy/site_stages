<?php
include_once("../../classes/moteur/Competence.php");
include_once("../../classes/bdd/Competence_BDD.php");
include_once("../../classes/bdd/connec.inc");
class Competence_IHM {

	public static function afficherFormulaireSaisie(){ ?>
		<FORM METHOD="POST" ACTION="">
		<table>
			<tr>
				<th width="200">Ajoutez une compétence :</th>
				<td><input type="text" name="nomCompetence"></td>
				<td><input type=submit value="Enregistrer les données"></td>
			</tr>
		</table>
		</FORM>
		<?php 
		$tabCompetences = Competence::listerCompetences();

		if(sizeof($tabCompetences) > 0){
			echo "<table>
				<tr id='entete'>
					<td width='20%'>Compétence</td>
					<td width='10%' align='center'>Modifier</td>
					<td width='10%' align='center'>Supprimer</td>
				</tr>";
			for ($i = 0; $i < sizeof($tabCompetences); $i++){
				$comp = $tabCompetences[$i];
				?>
				<tr id="ligne<?php echo $i%2; ?>">
					<td>
						<?php echo $comp->getNom(); ?>
					</td>
					<td align="center">
						<a href="modifierCompetence.php?id=<?php echo $comp->getIdentifiantBDD(); ?>">
							<img src="../../images/reply.png"/>
						</a>
					</td>
					<td align="center">
						<a href="gestionCompetence.php?id=<?php echo $comp->getIdentifiantBDD(); ?>">
							<img src="../../images/action_delete.png"/>
						</a>
					</td>
				</tr>
			<?php
			}echo "</table>";
		} else {
		echo "<br/><center>Aucune compétence n'a été trouvée.</center><br/>";
		}
	}
}
?>
