<?php

class Contact_IHM {
 
	// M�thodes statiques
	
	public static function afficherFormulaireRecherche($page) {
		?>
		
		<form method=post action="<?php echo $page; ?>">
			<table width="100%">
				<tr>
					<td width="50%" align="center">
						<table>
							<tr>
								<td>Nom</td>
								<td>
									<input type="text" name="nom" <?php if(isset($_POST['nom'])) echo "value='".$_POST['nom']."'"; ?> />
								</td>
							</tr>
							<tr>
								<td>Pr�nom</td>
								<td>
									<input type="text" name="prenom" <?php if(isset($_POST['prenom'])) echo "value='".$_POST['prenom']."'"; ?> />
								</td>
							</tr>
						</table>
					</td>
					<td width="50%">
						<table>
							<tr>
								<td>T�l�phone</td>
								<td>
									<input type="text" name="tel" <?php if(isset($_POST['tel'])) echo "value='".$_POST['tel']."'"; ?> />
								</td>
							</tr>
							<tr>
								<td>Fax</td>
								<td>
									<input type="text" name="fax" <?php if(isset($_POST['fax'])) echo "value='".$_POST['fax']."'"; ?> />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" id="submit">
						<input type="hidden" value="1" name="rech">
						<input type="submit" value="Afficher">
					</td>
				</tr>
			</table>
		</form>
		
		<?php
	}
	
	// $cont = Contact qui est modifier et dont les informations son affich�es.
	// si $cont = "", alors il s'agit d'un formulaire de cr�ation (champs vide)
	public static function afficherFormulaireSaisie($cont) {
		
		if($cont != "")
			$ent = $cont->getEntreprise();
		?>
		<form method=post action="">
			
			<table width="100%">
				<tr>
					<td width="50%" align="center">
						<table>
							<tr>
								<td>Nom</td>
								<td>
									<input type="text" name="nom" <?php if(isset($_POST['nom'])) echo "value='".$_POST['nom']."'"; else if($cont != "") echo "value='".$cont->getNom()."'"; ?> />
								</td>
							</tr>
							<tr>
								<td>Pr�nom</td>
								<td>
									<input type="text" name="prenom" <?php if(isset($_POST['prenom'])) echo "value='".$_POST['prenom']."'"; else if($cont != "") echo "value='".$cont->getPrenom()."'"; ?> />
								</td>
							</tr>
						</table>
					</td>
					<td width="50%" align="center">
						<table>
							<tr>
								<td>T�l�phone</td>
								<td>
									<input type="text" name="tel" <?php if(isset($_POST['tel'])) echo "value='".$_POST['tel']."'"; else if($cont != "") echo "value='".$cont->getTelephone()."'"; ?> />
								</td>
							</tr>
							<tr>
								<td>Fax</td>
								<td>
									<input type="text" name="fax" <?php if(isset($_POST['fax'])) echo "value='".$_POST['fax']."'"; else if($cont != "") echo "value='".$cont->getTelecopie()."'"; ?> />
								</td>
							</tr>
							<tr>
								<td>Email</td>
								<td>
									<input type="text" name="email" <?php if(isset($_POST['email'])) echo "value='".$_POST['email']."'"; else if($cont != "") echo "value='".$cont->getEmail()."'"; ?> />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						S�lectionnez l'entreprise :
						<select name="idEntreprise">
							<?php
								$tabEnt = Entreprise::getListeEntreprises("");
								
								for ($i=0; $i<sizeof($tabEnt); $i++) {
									if (((isset($_POST['idEntreprise'])) && ($_POST['idEntreprise'] == $tabEnt[$i]->getIdentifiantBDD())) || (($cont != "") && ($ent->getIdentifiantBDD() == $tabEnt[$i]->getIdentifiantBDD())))
										echo "<option selected value='".$tabEnt[$i]->getIdentifiantBDD()."'>".$tabEnt[$i]->getNom()." (".$tabEnt[$i]->getVille().")</option>";
									else
  										echo "<option value='".$tabEnt[$i]->getIdentifiantBDD()."'>".$tabEnt[$i]->getNom()." (".$tabEnt[$i]->getVille().")</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" id="submit">
						<input type="hidden" value="1" name="<?php if($cont != "") echo "edit"; else echo "add";?>" />
						<input type="submit" value="Valider" />
					</td>
				</tr>
			</table>
		</form>
		<?php 
	}
	
}

?>