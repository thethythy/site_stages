<?php

	class ThemeDeStage_IHM {
		
		// $theme = ThemeDeStage qui est modifier et dont les informations sont affichées.
		// si $theme = "", alors il s'agit d'un formulaire de création (champs vide)
		public static function afficherFormulaireSaisie($theme) {
			
			if($theme != "")
				$label = $theme->getTheme();
			?>
			<form method=post action="">

				<table width="100%">
					<tr>
						<td width="50%" align="center">
							<table>
								<tr>
									<td>Theme de stage</td>
									<td>
										<input type="text" name="theme" <?php if(isset($_POST['theme'])) echo "value='".$_POST['theme']."'"; ?> />
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
					<td colspan="2" align="center">
						Sélectionnez un theme :
						<select name="idTheme">
							<option value='-1'>--Selectionner un thème--</option>
							<?php
								$tabTheme = ThemeDeStage::getListeTheme();
								
								for ($i=0; $i<sizeof($tabTheme); $i++) {
									echo "<option value='".$tabTheme[$i]->getIdTheme()."'>".$tabTheme[$i]->getTheme()."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2" id="submit">
						<input type="hidden" value="1" name="<?php if($theme != "") echo "edit"; else echo "add";?>" />
						<input type="submit" value="Valider" />
					</td>
				</tr>
				</table>
			</form>
			
			<?php
		}
	}
?>