<?php
header ('Content-type:text/html; charset=utf-8');
include_once("../../classes/moteur/Filiere.php");
include_once("../../classes/bdd/Filiere_BDD.php");
include_once("../../classes/bdd/connec.inc");

class Filiere_IHM {
	
	public static function afficherFormulaireModificationTempsSoutenance(){ ?>
				<FORM METHOD="POST" ACTION="" name="sd">
					<table id="table_modifierTemps">
						<tr><td colspan=2>
						<table id="presentation_modifierTemps">
							<tr id="entete2">
								<td colspan=2>Modifier/Supprimer une durée de soutenance</td>
							</tr>
							<tr>
								<th width="220">Sélectionnez le diplôme : </th>
								<th>
							<?php
								$tabFiliere = Filiere::listerFilieres();
								echo "<select name=filiere>";
									echo "<option  value='-1' selected></option>";
								for($i=0; $i<sizeof($tabFiliere); $i++){
								
									echo "<option value='".$tabFiliere[$i]->getIdentifiantBDD()."'
									name='".$tabFiliere[$i]->getNom()."'> ".$tabFiliere[$i]->getNom()."</option>";
								
								}
								echo "</select>";								
							?>
							</th>
							</tr>
							<tr>
								<td colspan=2>
									<input type=submit value="Modifier un dipôme" />
								</td>
							</tr>
						</table>
					</table>
				</FORM>	
			<?php }
		
}
?>