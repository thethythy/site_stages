<?php

class DateSoutenance_IHM {

    public static function afficherFormulaireSaisie() {
	?>
	<form method="POST" action="">
	    <table id="table_saisieDateSoutenance">
		<tr>
		    <td colspan=2>
			<table id="presentation_saisieDateSoutenance">
			    <tr id="entete2">
				<td colspan=2>Saisir une date de soutenance</td>
			    </tr>
			    <tr>
				<th width="150">Date :</th>
				<td>
				    <input id="date" type="date" name="date" value="<?php echo date("Y-m-d"); ?>" style="width: auto;"/>
				</td>
			    </tr>
			    <tr>
				<th></th>
				<td>&nbsp;</td>
			    </tr>
			    <tr>
				<th width="200">Sélectionner les<br />promotions associées :</th>
				<td>
				    <?php
				    // Recuperation de l'annee promotion (la rentrée)
				    if (date('n') >= 9)
					$annee = date('Y');
				    else
					$annee = date('Y') - 1;
				    $tabPromo = Promotion::listerPromotions(new FiltreString('anneeuniversitaire', $annee));
				    foreach ($tabPromo as $promo)
					echo '<input type="checkbox" name="promo[]" value="' . $promo->getIdentifiantBDD() . '">' . $promo->getFiliere()->getNom() . ' ' . $promo->getParcours()->getNom() . '<br />';
				    ?>
				</td>
			    </tr>
			    <tr>
				<th></th>
				<td>&nbsp;</td>
			    </tr>
			    <tr>
				<td colspan=2>
				    <input type=submit value="Enregistrer les données"/>
				    <input type=reset value="Effacer"/>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</form>
	<?php
    }

    public static function afficherFormulaireChoixDate() {
	?>
	<FORM id="formModifDate" METHOD="POST" ACTION="" name="sd">
	    <table id="table_msDateSoutenance">
		<tr>
		    <td colspan=2>
			<table id="presentation_msDateSoutenance">
			    <tr id="entete2">
				<td colspan=2>Modifier/Supprimer une date de soutenance</td>
			    </tr>
			    <tr>
				<th width="220">Sélectionnez la date : </th>
				<td>
				    <?php
				    $tabDateSoutenance = DateSoutenance::listerDateSoutenance();
				    echo "<select name=date>";
				    echo "<option  value='-1' selected></option>";
				    for ($i = 0; $i < sizeof($tabDateSoutenance); $i++) {
					echo "<option value='" . $tabDateSoutenance[$i]->getIdentifiantBDD() . "'name='" . $tabDateSoutenance[$i]->getIdentifiantBDD() . "'> " . $tabDateSoutenance[$i]->getJour() . "/" . $tabDateSoutenance[$i]->getMois() . "/" . $tabDateSoutenance[$i]->getAnnee() . "</option>";
				    }
				    echo "</select>";
				    ?>
				</td>
			    </tr>
			    <tr>
				<td colspan=2>
				    <input type=submit value="Modifier une date de soutenance" />
				    <input type=submit value="Supprimer une date de soutenance" onclick="this.form.action = '../../gestion/soutenances/supprimerDate.php'"/>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</FORM>
	<?php
    }

    public static function afficherFormulaireModification($idDate) {
	$date = DateSoutenance::getDateSoutenance($idDate);
	$date_formatee = date('Y-m-d', mktime(0, 0, 0, $date->getMois(), $date->getJour(), $date->getAnnee()));
	$tabPromoDate = DateSoutenance::listerRelationPromoDate($idDate);
	$tabPromo = Promotion::listerPromotions(new FiltreString('anneeuniversitaire', $date->getAnnee() - 1));
	?>
	<form action='modDate.php' method='post'>
	    <input type=hidden name='id' value=<?php echo $date->getIdentifiantBDD(); ?>>
	    <table>
		<tr>
		    <td colspan="2">
			<table>
			    <tr id="entete2">
				<td colspan="2">Modification d'une date</td>
			    </tr>
			    <tr>
				<th>Date : </th>
				<td>
				    <input id='newdate' type='date' name='newdate' value='<?php echo $date_formatee; ?>'/>
				</td>
			    </tr>
			    <tr>
				<th></th>
				<td>&nbsp;</td>
			    </tr>
			    <tr>
				<th size=200>Sélectionner les<br />promotions associées :</th>
				<td>
				    <?php
				    foreach ($tabPromo as $promo) {
					$check = "";
					foreach ($tabPromoDate as $promo2)
					    if ($promo2 == $promo->getIdentifiantBDD())
						$check = "checked";
					echo '<input type="checkbox" name="promo[]" value="' . $promo->getIdentifiantBDD() . '" ' . $check . '>' . $promo->getFiliere()->getNom() . ' ' . $promo->getParcours()->getNom() . '<br />';
				    }
				    ?>
				</td>
			    </tr>
			    <tr>
				<th></th>
				<td>&nbsp;</td>
			    </tr>
			    <tr>
				<td colspan="2">
				    <input type=submit value='Enregistrer les données'/>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</form>

	<script>
	    document.getElementById('formModifDate').hidden = true;
	</script>

	<?php
    }

}
?>