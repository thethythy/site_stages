<?php
include_once("../../classes/moteur/TypeEntreprise.php");
include_once("../../classes/bdd/TypeEntreprise_BDD.php");
include_once("../../classes/bdd/connec.inc");
class TypeEntreprise_IHM {

	public static function afficherFormulaireSaisie(){ ?>
				<FORM METHOD="POST" ACTION="">
				<table>
					<tr>
						<th width="200">Ajoutez un type d'entreprise :</th>
						<td><input type="text" name="idtypeentreprise" <?php if(isset($_POST['idtypeentreprise'])) echo "value='".$_POST['idtypeentreprise']."'"; ?>></td>
					</tr>
					<tr>
						<th>Sélectionner un type d'entreprise :</th>
						<td>
							<!-- Récupération des types d'entreprise -->
							<?php
								$tabTypeEntreprise = TypeEntreprise::getListeTypeEntreprise();
								echo "<select name='typeEntreprise'>";
								for($i=0; $i<sizeof($tabTypeEntreprise); $i++) {
									$id = $tabTypeEntreprise[$i]->getIdentifiantBDD();
									$type = $tabTypeEntreprise[$i]->getTypeEntreprise($id)->getType();
									echo "<option value='$id'>$type</option>"; 
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
