<?php

header ("Content-type:text/html; charset=utf-8");

function afficherFormulaireRecherche($fichier){ ?>
	<form action="javascript:">
		<table width="100%">
			<tr>
				<td>
					<table width="100%">
						<tr>
							<td>
								Sélectionnez l'année :
								<select id="annee" name="annee">
									<?php
										$tabAU = Promotion_BDD::getAnneesUniversitaires();
										
										for ($i=0; $i<sizeof($tabAU); $i++) {
											if ((isset($_POST['annee'])) && ($_POST['annee'] == $tabAU[$i]))
												echo "<option selected value='$tabAU[$i]'>".$tabAU[$i]."-".($tabAU[$i]+1)."</option>";
											else
												echo "<option value='$tabAU[$i]'>".$tabAU[$i]."-".($tabAU[$i]+1)."</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Sélectionnez le nom du référent :
								<select id="nom" name="nom">
									<?php
										echo "<option value='*'>Tous</option>";
										
										$tabP = Parrain::listerParrain();
										
										for ($i=0; $i<sizeof($tabP); $i++) {
											$couleur = $tabP[$i]->getCouleur();
											if ((isset($_POST['nom'])) && ($_POST['nom'] == $tabP[$i]->getIdentifiantBDD()))
												echo "<option selected value='".$tabP[$i]->getIdentifiantBDD()."'>".$tabP[$i]->getNom()." ".$tabP[$i]->getPrenom()."</option>";
											else
												echo "<option value='".$tabP[$i]->getIdentifiantBDD()."'>".$tabP[$i]->getNom()." ".$tabP[$i]->getPrenom()."</option>";
										}
									?>
								</select>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table width="100%">
						<tr>
							<td>
								Sélectionnez le diplôme :
								<select id="filiere" name="filiere">
									<?php
										echo "<option value='*'>Tous</option>";
										$tabF = Filiere::listerFilieres();
										for ($i=0; $i<sizeof($tabF); $i++) {
											if((isset($_POST['filiere'])) && ($_POST['filiere'] == $tabF[$i]->getIdentifiantBDD()))	
												echo "<option selected value='".$tabF[$i]->getIdentifiantBDD()."'>".$tabF[$i]->getNom()."</option>";
											else
												echo "<option value='".$tabF[$i]->getIdentifiantBDD()."'>".$tabF[$i]->getNom()."</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Sélectionnez la spécialité :
								<select id="parcours" name="parcours">
									<?php 
										echo "<option value='*'>Tous</option>";
										$tabP = Parcours::listerParcours();
										for ($i=0; $i<sizeof($tabP); $i++) {
											if((isset($_POST['parcours'])) && ($_POST['parcours'] == $tabP[$i]->getIdentifiantBDD()))
												echo "<option selected value='".$tabP[$i]->getIdentifiantBDD()."'>".$tabP[$i]->getNom()."</option>";
											else
												echo "<option value='".$tabP[$i]->getIdentifiantBDD()."'>".$tabP[$i]->getNom()."</option>";
										}
									?>
								</select>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
	
	<script type="text/javascript">
		var table = new Array("annee", "nom", "filiere", "parcours");
		new LoadData(table, "<?php echo $fichier; ?>", "onchange");
	</script>

	<?php }
	
?>	