<?php

class Entreprise_IHM {
 
	// Méthodes statiques
	
	public static function afficherFormulaireRecherche($page){
		?>
		
		<form method=post action="<?php echo $page; ?>">
			<table width="100%">
				<tr>
					<td width="50%" align="center">
						<table>
							<tr>
								<td>Nom de l'entreprise</td>
								<td>
									<input type="text" name="nom" <?php if(isset($_POST['nom'])) echo "value='".$_POST['nom']."'"; ?> />
								</td>
							</tr>
							<tr>
								<td>Code Postal</td>
								<td>
									<input type="text" name="cp" <?php if(isset($_POST['cp'])) echo "value='".$_POST['cp']."'"; ?> />
								</td>
							</tr>
						</table>
					</td>
					<td width="50%">
						<table>
							<tr>
								<td>Ville</td>
								<td>
									<input type="text" name="ville" <?php if(isset($_POST['ville'])) echo "value='".$_POST['ville']."'"; ?> />
								</td>
							</tr>
							<tr>
								<td>Pays</td>
								<td>
									<input type="text" name="pays" <?php if(isset($_POST['pays'])) echo "value='".$_POST['pays']."'"; ?> />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" id="submit">
						<input type="hidden" value="1" name="rech" />
						<input type="submit" value="Afficher" />
					</td>
				</tr>
			</table>
		</form>
		
		<?php
	}
	
	// $ent = Entreprise qui est modifier et dont les informations son affichées.
	// si $ent = "", alors il s'agit d'un formulaire de création (champs vide)
	public static function afficherFormulaireSaisie($ent){
		
		if($ent != "")
			$typ = $ent->getTypeEntreprise();
		?>
		<form method=post action="">
			
			<table width="100%">
				<tr>
					<td width="50%" align="center">
						<table>
							<tr>
								<td>Nom de l'entreprise</td>
								<td>
									<input type="text" name="nom" <?php if(isset($_POST['nom'])) echo "value='".$_POST['nom']."'"; else if($ent != "") echo "value='".$ent->getNom()."'"; ?> />									
								</td>
							</tr>
							<tr>
								<td>Adresse</td>
								<td>
									<input type="text" name="adresse" <?php if(isset($_POST['adresse'])) echo "value='".$_POST['adresse']."'"; else if($ent != "") echo "value='".$ent->getAdresse()."'"; ?> />
								</td>
							</tr>
							<tr>
								<td>Email DRH ou équivalent</td>
								<td>
									<input type="text" name="email" <?php if(isset($_POST['email'])) echo "value='".$_POST['email']."'"; else if($ent != "") echo "value='".$ent->getEmail()."'"; ?> />
								</td>
							</tr>
						</table>
					</td>
					<td width="50%" align="center">
						<table>
							<tr>
								<td>Code Postal</td>
								<td>
									<input type="text" name="cp" <?php if(isset($_POST['cp'])) echo "value='".$_POST['cp']."'"; else if($ent != "") echo "value='".$ent->getCodePostal()."'"; ?> />
								</td>
							</tr>
							<tr>
								<td>Ville</td>
								<td>
									<input type="text" name="ville" <?php if(isset($_POST['ville'])) echo "value='".$_POST['ville']."'"; else if($ent != "") echo "value='".$ent->getVille()."'"; ?> />
								</td>
							</tr>
							<tr>
								<td>Pays</td>
								<td>
									<input type="text" name="pays" <?php if(isset($_POST['pays'])) echo "value='".$_POST['pays']."'"; else if($ent != "") echo "value='".$ent->getPays()."'"; ?> />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left">
						Type de l'entreprise :
						<select name="idtype">
							<?php
								$tabTypeEntreprise = TypeEntreprise::getListeTypeEntreprise("");

								for ($i = 0; $i < sizeof($tabTypeEntreprise); $i++){
									if (((isset($_POST['idtype'])) && ($_POST['idtype'] == $tabTypeEntreprise[$i]->getIdentifiantBDD())) || (($ent != "") && ($typ->getIdentifiantBDD() == $tabTypeEntreprise[$i]->getIdentifiantBDD())))
										echo "<option selected value='".$tabTypeEntreprise[$i]->getIdentifiantBDD()."'>".$tabTypeEntreprise[$i]->getTypeEntreprise()." </option>";
									else
  										echo "<option value='".$tabTypeEntreprise[$i]->getIdentifiantBDD()."'>".$tabTypeEntreprise[$i]->getTypeEntreprise()." </option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" id="submit">
						<input type="hidden" value="1" name="<?php if($ent != "") echo "edit"; else echo "add";?>" />
						<input type="submit" value="Valider" />
					</td>
				</tr>
			</table>
		</form>
		<?php 
	}
	
}

?>