<?php

header ('Content-type:text/html; charset=utf-8');

class Promotion_IHM {

    // Méthodes statiques

    // $vide = permet de savoir si on affiche ou pas une année vide
    public static function afficherFormulaireSelectionAnnee($vide) {
	?>
	    <form method=post action="javascript:">
		<table width="100%">
		    <tr>
			<td align="center" >
			    Sélectionnez l'année :
			    <select id="annee" name="annee">
				<?php
				    if ($vide) echo "<option value=''></option>";
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
		</table>
	    </form>

	    <script type="text/javascript">
		var table = new Array("annee");
		
		new LoadData(table, "", "onchange");
	    </script>
	<?php
    }

    // $page = nom de la page sur laquelle sera renvoyée le résultat du formulaire
    // $tous = permet de savoir si on affiche ou pas la proposition "Tous" dans les combobox
    public static function afficherFormulaireRecherche($page, $tous, $vide=FALSE) {
	?>
	    <form method=post action="javascript:">
		<table width="100%">
		    <tr>
			<td align="center" >
			    Sélectionnez l'année :
			    <select id="annee" name="annee">
				<?php
				    if ($vide) echo "<option value=''>----------</option>";
				    if ($tous) echo "<option value='*'>Toutes</option>";
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
			<td>
			    <table width="100%">
				<tr>
				    <td align="center">
					Sélectionnez le diplôme :
					<select id="filiere" name="filiere">
					    <?php
						if ($tous) echo "<option value='*'>Tous</option>";
						$tabF = Filiere::listerFilieres();
						for ($i=0; $i<sizeof($tabF); $i++) {
						    if ((isset($_POST['filiere'])) && ($_POST['filiere'] == $tabF[$i]->getIdentifiantBDD()))
							echo "<option selected value='".$tabF[$i]->getIdentifiantBDD()."'>".$tabF[$i]->getNom()."</option>";
						    else
							echo "<option value='".$tabF[$i]->getIdentifiantBDD()."'>".$tabF[$i]->getNom()."</option>";
						}
					    ?>
					</select>
				    </td>
				</tr>
				<tr>
				    <td align="center">
					Sélectionnez la spécialité :
					<select id="parcours" name="parcours">
					    <?php
						if ($tous) echo "<option value='*'>Tous</option>";
						$tabP = Parcours::listerParcours();
						for ($i=0; $i<sizeof($tabP); $i++) {
						    if ((isset($_POST['parcours'])) && ($_POST['parcours'] == $tabP[$i]->getIdentifiantBDD()))
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
		var table = new Array("annee", "filiere", "parcours");
		new LoadData(table, "<?php echo $page; ?>", "onchange");
	    </script>
	<?php
    }

    public static function afficherFormulaireAjout() {
	?>
	    <form method=post action="">
		<table width="100%">
		    <tr>
			<td colspan="3" align="center">
			    Année :&nbsp;
			    <?php
				if((isset($_POST['annee'])) && ($_POST['annee'] != ""))
				    echo "<input type='text' value='".$_POST['annee']."' name='annee'>";
				else
				    echo "<input type='text' value='".date("Y")."' name='annee'>";
			    ?>
			</td>
		    </tr>
		    <tr>
			<td width="45%" align="center">
			    <br/>
			    Sélectionnez le diplôme :&nbsp;
			    <select name="filiere1">
				<?php
				    $tabF = Filiere::listerFilieres();
				    for($i=0; $i<sizeof($tabF); $i++){
					if($_POST['filiere'] == $tabF[$i]->getIdentifiantBDD())
					    echo "<option selected value='".$tabF[$i]->getIdentifiantBDD()."'>".$tabF[$i]->getNom()."</option>";
					else
					    echo "<option value='".$tabF[$i]->getIdentifiantBDD()."'>".$tabF[$i]->getNom()."</option>";
				    }
				?>
			    </select>
			</td>
			<td width="10%" align="center">OU</td>
			<td width="45%" align="center">Créez un nouveau diplôme :&nbsp;<input type="text" value="<?php if(isset($_POST['filiere2'])) $_POST['filiere2'] ?>" name="filiere2"></td>
		    </tr>
		    <tr>
			<td width="45%" align="center">
			    <br/>
			    Sélectionnez la spécialité :&nbsp;
			    <select name="parcours1">
				<?php
				    $tabP = Parcours::listerParcours();
				    for ($i=0; $i<sizeof($tabP); $i++) {
					if($_POST['parcours'] == $tabP[$i]->getIdentifiantBDD())
					    echo "<option selected value='".$tabP[$i]->getIdentifiantBDD()."'>".$tabP[$i]->getNom()."</option>";
					else
					    echo "<option value='".$tabP[$i]->getIdentifiantBDD()."'>".$tabP[$i]->getNom()."</option>";
				    }
				?>
			    </select>
			</td>
			<td width="10%" align="center">OU</td>
			<td width="45%" align="center">Crééz une nouveau parcours :&nbsp;<input type="text" value="<?php if(isset($_POST['parcours2'])) $_POST['parcours2'] ?>" name="parcours2"></td>
		    </tr>
		    <tr>
			<td colspan="3" align="center">
			    <br/>
			    Email :&nbsp;
				<?php
				    if ((isset($_POST['email'])) && ($_POST['email'] != ""))
					echo "<input type='text' value='".$_POST['email']."' name='email'>";
				    else
					echo "<input type='text' value='' name='email'>";
				?>
			</td>
		    </tr>
		    <tr>
			<td colspan="3" align="center">
			    <br/>
			    <input type="hidden" value="1" name="add"/>
			    <input type="submit" value="Ajouter"/>
			</td>
		    </tr>
		</table>
	    </form>
	<?php
    }

}

?>