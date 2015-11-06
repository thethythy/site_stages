<?php

class Statistique_IHM {

	// $page = nom de la page sur laquelle sera renvoyée le résultat du formulaire
	// $tous = permet de savoir si on affiche ou pas la proposition "Tous" dans les combobox
	public static function afficherFormulaireRechercheLocalisation($page) {
		?>

		<form method=post action="<?php echo $page; ?>">
			<table width="100%">
				<tr>
					<td align="center">
						L'année initiale :
						<select name="annee_in">
						<?php
							$tabAU = Promotion_BDD::getAnneesUniversitaires();
							for ($i = 0; $i < sizeof($tabAU); $i++) {
								if((isset($_POST['annee_in'])) && ($_POST['annee_in'] == ($tabAU[$i]+1)))
									echo "<option selected value='".($tabAU[$i]+1)."'>".($tabAU[$i]+1)."</option>";
								else
  									echo "<option value='".($tabAU[$i]+1)."'>".($tabAU[$i]+1)."</option>";

							}
						?>
						</select>
						&nbsp;&nbsp;&nbsp;&nbsp;
						L'année finale :
						<select name="annee_fin">
						<?php
							$tabAU = Promotion_BDD::getAnneesUniversitaires();
							for ($i = 0; $i < sizeof($tabAU); $i++) {
								if((isset($_POST['annee_fin'])) && ($_POST['annee_fin'] == ($tabAU[$i]+1)))
									echo "<option selected value='".($tabAU[$i]+1)."'>".($tabAU[$i]+1)."</option>";
								else
  									echo "<option value='".($tabAU[$i]+1)."'>".($tabAU[$i]+1)."</option>";
							}
						?>
						</select>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="hidden" value="1" name="rech">
						<input type="submit" value="Afficher">
					</td>
				</tr>
			</table>
		</form>

	<?php
	}

	// $tabConventions = tableau contenant la liste des conventions à afficher
	// $page = nom de la page de map Google
	public static function afficherTableauLocalisation($tabConventions, $page) {
		?>

		<br/>
		<table width="100%">
			<tr id="entete">
				<td width="20%" onclick="sort(this)">Entreprise</td>
				<td width="32%" onclick="sort(this)">Adresse</td>
				<td width="12%" onclick="sort(this)">Ville</td>
				<td width="12%" onclick="sort(this)">Pays</td>
				<td width="24%" onclick="sort(this)">Etudiant</td>
			</tr>

			<?php
			$cpt = 0;
			for ($i = 0; $i < sizeof($tabConventions); $i++) {
				$nom = $tabConventions[$i][0];
				$adresse = $tabConventions[$i][1];
				$ville = $tabConventions[$i][2];
				$pays = $tabConventions[$i][3];
				$nometudiant = $tabConventions[$i][4];
				$prenometudiant = $tabConventions[$i][5];
			?>

			<tr id="ligne<?php echo $cpt%2; $cpt++; ?>">
				<td><?php echo $nom; ?></td>
				<td><a style="color:blue;" href="<?php echo $page; ?>?adr=<?php echo $pays.' '.$ville.' '.$adresse; ?>" target="_blank"><?php echo $adresse; ?></a></td>
				<td><?php echo $ville; ?></td>
				<td><?php echo $pays; ?></td>
				<td><?php echo $prenometudiant." ".$nometudiant; ?></td>
			</tr>

			<?php
			}
			?>

		</table>
		<br/>

		<?php
	}

}