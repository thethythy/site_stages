<?php

include_once("../../classes/moteur/Salle.php");
include_once("../../classes/bdd/Salle_BDD.php");
include_once("../../classes/bdd/connec.inc");

class Salle_IHM {
	
	public static function afficherFormulaireSaisie(){ ?>
				<FORM METHOD="POST" ACTION="">
					<table id="table_saisieSalle">
						<tr><td colspan=2>
						<table id="presentation_saisieSalle">
						<tr id="entete2">
							<td colspan=2>Saisir une salle</td>
						</tr>
						<tr>
							<th width="100">Nom :</th>
							<td><input type="text" name="nom" ></td>
						</tr>
						<tr>
							<td colspan=2><input type=submit value="Enregistrer les données"/><input type=reset value="Effacer"/></td>
						</tr>
						</table>
					</table>
				</FORM>		
			<?php }
	
	public static function afficherFormulaireModification(){ ?>
				<FORM METHOD="POST" ACTION="" name="sd">
					<table id="table_modifierSalle">
						<tr><td colspan=2>
						<table id="presentation_modifierSalle">
							<tr id="entete2">
								<td colspan=2>Modifier/Supprimer une salle</td>
							</tr>
							<tr>
								<th width="220">Sélectionnez la salle : </th>
								<th>
							<?php
								$tabSalle = Salle::listerSalle();	
								echo "<select name=salle>";	
									echo "<option  value='-1' selected></option>";			
								for($i=0; $i<sizeof($tabSalle); $i++){
								
									echo "<option value='".$tabSalle[$i]->getIdentifiantBDD()."' 
									name='".$tabSalle[$i]->getNom()."'> ".$tabSalle[$i]->getNom()."</option>";
								
								}
								echo "</select>";								
							?>
							</th>
							</tr>
							<tr>
								<td colspan=2>
									<input type=submit value="Modifier une salle" />
									<input type=submit value="Supprimer une salle" onclick="this.form.action='../../gestion/soutenances/supprimerSalle.php'"/>
								</td>
							</tr>
						</table>
					</table>
				</FORM>	
			<?php }
		
}
?>