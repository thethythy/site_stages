<?php
header ('Content-type:text/html; charset=utf-8');
class Convention_IHM {
 
	// Méthodes statiques
		
	// $conv = Entreprise qui est modifier et dont les informations son affichées.
	// si $conv = "", alors il s'agit d'un formulaire de création (champs vide)
	// $tabEtu = tableau contenant les étudiants à afficher
	public static function afficherFormulaireSaisie($conv, $tabEtu, $annee, $parcours, $filiere) {

		if ($conv != "") {
			$parrain = $conv->getParrain();
			$examinateur = $conv->getExaminateur();
			$etudiant = $conv->getEtudiant();
			$contact = $conv->getContact();
			$idTheme = $conv->getIdTheme(); ////////////////////////////// Ajout de $idTheme.------------------------------------------------------
		}
		
		?>
		<form method=post action="">
			<table width="100%">
				<tr>
					<td width="100%" align="center">
						<table>
							<tr>
								<td>Etudiant</td>
								<td>
									<?php
										if ($conv != "") {
											echo $etudiant->getNom()." ".$etudiant->getPrenom();
										} else {
									?>
									<select name="idEtu" style="width: 300px;">
										<?php
											for ($i = 0; $i < sizeof($tabEtu); $i++ ) {
												if ((isset($_POST['idEtu'])) && ($_POST['idEtu'] == $tabEtu[$i]->getIdentifiantBDD()))
													echo "<option selected value='".$tabEtu[$i]->getIdentifiantBDD()."'>".$tabEtu[$i]->getNom()." ".$tabEtu[$i]->getPrenom()."</option>";
												else
			  										echo "<option value='".$tabEtu[$i]->getIdentifiantBDD()."'>".$tabEtu[$i]->getNom()." ".$tabEtu[$i]->getPrenom()."</option>";
											}
										?>
									</select>
									<?php
										}
									?>
								</td>
							</tr>
							<tr>
								<td>Référent</td>
								<td>
									<select name="idPar" style="width: 300px;">
										<?php 
											$tabPar = Parrain::listerParrain();
											
											for ($i = 0; $i < sizeof($tabPar); $i++){
												if ((($conv != "") && ($parrain->getIdentifiantBDD() == $tabPar[$i]->getIdentifiantBDD())) || ((isset($_POST['idPar'])) && ($_POST['idPar'] == $tabPar[$i]->getIdentifiantBDD())))
													echo "<option selected value='".$tabPar[$i]->getIdentifiantBDD()."'>".$tabPar[$i]->getNom()." ".$tabPar[$i]->getPrenom()."</option>";
												else
			  										echo "<option value='".$tabPar[$i]->getIdentifiantBDD()."'>".$tabPar[$i]->getNom()." ".$tabPar[$i]->getPrenom()."</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>Examinateur</td>
								<td>
									<select name="idExam" style="width: 300px;">
										<?php 
											$tabExam = Parrain::listerParrain();
											
											for ($i = 0; $i < sizeof($tabExam); $i++) {
													if ((($conv != "") && ($examinateur->getIdentifiantBDD() == $tabExam[$i]->getIdentifiantBDD())) || ((isset($_POST['idExam'])) && ($_POST['idExam'] == $tabPar[$i]->getIdentifiantBDD())))
														echo "<option selected value='".$tabExam[$i]->getIdentifiantBDD()."'>".$tabExam[$i]->getNom()." ".$tabExam[$i]->getPrenom()."</option>";
													else
														echo "<option value='".$tabExam[$i]->getIdentifiantBDD()."'>".$tabExam[$i]->getNom()." ".$tabExam[$i]->getPrenom()."</option>";
											}
										?>	
									</select>
								</td>
							</tr>
							<tr>
								<td>Contact</td>
								<td>
									<select name="idCont" style="width: 300px;">
										<?php 
											$tabCont = Contact::getListeContacts("");
											
											for($i = 0; $i < sizeof($tabCont); $i++) {
												
												$entreprise = $tabCont[$i]->getEntreprise();
												$nomEntreprise = " - ".$entreprise->getNom()." (".$entreprise->getVille().")";
												
												if ((($conv != "") && ($contact->getIdentifiantBDD() == $tabCont[$i]->getIdentifiantBDD())) || ((isset($_POST['idCont'])) && ($_POST['idCont'] == $tabCont[$i]->getIdentifiantBDD())))
													echo "<option selected value='".$tabCont[$i]->getIdentifiantBDD()."'>".$tabCont[$i]->getNom()." ".$tabCont[$i]->getPrenom().$nomEntreprise."</option>";
												else
			  										echo "<option value='".$tabCont[$i]->getIdentifiantBDD()."'>".$tabCont[$i]->getNom()." ".$tabCont[$i]->getPrenom().$nomEntreprise."</option>";
											}
										?>
									</select>
								</td>
							</tr>
								<!-- Ajout du theme de stage *************************************************************************** -->
							<tr>
								<td>Thème de stage</td>
								<td>
									<select name="idTheme" style="width: 300px;">
										<?php 
											$tabTheme = ThemeDeStage::getListeTheme();
			                                //echo "<option  value='-1' selected>---Theme de stage---</option>";
			                                for ($i = 0; $i < sizeof($tabTheme); $i++) {

			                                    $couleur = $tabTheme[$i]->getCouleur();

												if ($tabTheme[$i]->getIdTheme() == $conv->getIdTheme())
													echo "<option selected value='".$tabTheme[$i]->getIdTheme()."'style='color: #" . $couleur->getCode() . ";'>".$tabTheme[$i]->getTheme()."</option>";
												else
													echo "<option value='".$tabTheme[$i]->getIdTheme()."'style='color: #" . $couleur->getCode() . ";'>".$tabTheme[$i]->getTheme()."</option>";
			                                }
										?>	
									</select>
								</td>
							</tr>

							<tr>
								<td>
									<?php
										if (($conv != "") && ($conv->getASonResume() == 1)) {
											echo "Résumé du stage";
										} else {
											echo "Sujet de stage";
										}
									?>
								</td>
								<td>
									<?php
										if (($conv != "") && ($conv->getASonResume() == 1)) {
											echo "<a href='../../documents/resumes/".$conv->getSujetDeStage()."'>".$conv->getSujetDeStage()."</a>";
										} else if ($conv != "") {
											echo "<textarea name='sujet' style='width: 85%;'>".$conv->getSujetDeStage()."</textarea>";
										} else {
											echo "<textarea name='sujet' style='width: 85%;'></textarea>";
										}
									?>
								</td>
							</tr>

							

						</table>
					</td>
				</tr>
				<tr>
					<td id="submit">
						<br/>
						<input type="hidden" name="annee" value="<?php echo $annee; ?>"/>
						<input type="hidden" name="parcours" value="<?php echo $parcours; ?>"/>
						<input type="hidden" name="filiere" value="<?php echo $filiere; ?>"/>
						<input type="hidden" value="1" name="<?php if($conv != "") echo "edit"; else echo "add";?>" />
						<input type="submit" value="Enregistrer" />
					</td>
				</tr>
			</table>
		</form>
		<script>
	        function showColor() {
	            var couleurActuelHTML = document.getElementById("couleurActuel");
	            var couleurHTML = document.getElementById("idCouleur");
	            couleurActuelHTML.style.backgroundColor = couleurHTML.options[couleurHTML.selectedIndex].style.color;
	        }
    	</script>
		<?php 
	}
}

?>