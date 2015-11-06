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
					</tr>
					<tr>
						<th>Supprimez une compétence :</th>
						<td>
							<!-- Récupération des competences -->
							<?php
								$tabCompetences = Competence::listerCompetences();
								echo "<select name='competences'><option value='-1'>--Selectionner une compétence--</option>";
								for ($i = 0; $i < sizeof($tabCompetences); $i++) {
									echo "<option value='".$tabCompetences[$i]->getIdentifiantBDD()."'
										name='".$tabCompetences[$i]->getNom()."'> ".$tabCompetences[$i]->getNom()."</option>";
								}
								echo "</select>";
							?>
						</td>
					</tr>
					<tr>
						<td colspan=2>
							<input type=submit value="Enregistrer les données">
							<input type=submit value="Effacer">
						</td>
					</tr>
				</table>
				</FORM>
		<?php }
}
?>
