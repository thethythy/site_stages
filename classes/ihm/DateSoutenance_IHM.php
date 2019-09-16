<?php

class DateSoutenance_IHM {

    /**
     * Afficher un formulaire de saisie d'une nouvelle date de soutenance ainsi
     * que des promotions associées
     */
    public static function afficherFormulaireSaisie() {
	?>
	<form method="POST" action="">
	    <table>
		<tr id="entete2">
		    <td colspan=2>Saisir une date de soutenance</td>
		</tr>
		<tr>
		    <th width="150">Date :</th>
		    <td>
			<input type="date" name="date" value="<?php echo date("Y-m-d"); ?>"/>
		    </td>
		</tr>
		<tr>
		    <th></th>
		    <td>&nbsp;</td>
		</tr>
		<tr>
		    <th width="200">Promotions associées :</th>
		    <td>
			<?php
			// Recuperation de l'annee promotion (la rentrée)
			if (date('n') >= 9)
			    $annee = date('Y');
			else
			    $annee = date('Y') - 1;
			$tabPromo = Promotion::listerPromotions(new FiltreString('anneeuniversitaire', $annee));
			foreach ($tabPromo as $promo)
			    echo '<input type="checkbox" name="promo[]" value="' . $promo->getIdentifiantBDD() . '"> ' . $promo->getFiliere()->getNom() . ' ' . $promo->getParcours()->getNom() . '<br />';
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
	</form>
	<?php
    }

    /**
     * Afficher un formulaire d'édition d'une date de soutenance déjà existante
     * ainsi que les promotions associées et la convocation
     * @param integer $idDate Identifiant de la date de soutenance
     */
    public static function afficherFormulaireModification($idDate) {
	$date = DateSoutenance::getDateSoutenance($idDate);
	$date_formatee = date('Y-m-d', mktime(0, 0, 0, $date->getMois(), $date->getJour(), $date->getAnnee()));
	$tabPromoDate = DateSoutenance::listerRelationPromoDate($idDate);
	$tabPromo = Promotion::listerPromotions(new FiltreString('anneeuniversitaire', $date->getAnnee() - 1));
	?>
	<form action='' method='post'>
	    <input type=hidden name='id' value=<?php echo $date->getIdentifiantBDD(); ?>>
	    <table>
		<tr id="entete2">
		    <td colspan="2">Modification d'une date</td>
		</tr>
		<tr>
		    <th>Date : </th>
		    <td>
			<input type='date' name='date' value='<?php echo $date_formatee; ?>'/>
		    </td>
		</tr>
		<tr>
		    <th></th>
		    <td>&nbsp;</td>
		</tr>
		<tr>
		    <th width="200">Promotions associées :</th>
		    <td>
			<?php
			foreach ($tabPromo as $promo) {
			    $check = "";
			    foreach ($tabPromoDate as $promo2)
				if ($promo2 == $promo->getIdentifiantBDD())
				    $check = "checked";
			    echo '<input type="checkbox" name="promo[]" value="' . $promo->getIdentifiantBDD() . '" ' . $check . '> ' . $promo->getFiliere()->getNom() . ' ' . $promo->getParcours()->getNom() . '<br/>';
			}
			?>
		    </td>
		</tr>
		<tr>
		    <th></th>
		    <td>&nbsp;</td>
		</tr>
		<tr>
		    <th>Convocation faite ou non :</th>
		    <td>
			<?php
			if ($date->getConvocation() == 0)
			    echo '<input type="checkbox" name="convocation" value="0">';
			else
			    echo '<input type="checkbox" name="convocation" value="1" checked>';
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
	</form>
	<?php
    }

    /**
     * Afficher un tableau interactif pour éditer ou supprimer les dates de soutenance
     */
    public static function afficherListeDateSoutenanceAEditer() {
	$tabDates = DateSoutenance::listerDateSoutenance();
	if (sizeof($tabDates) > 0) {
	    echo
	    "<table>
		<tr id='entete'>
		    <td width='50%'>Date de soutenance</td>
		    <td width='10%' align='center'>Modifier</td>
		    <td width='10%' align='center'>Supprimer</td>
		</tr>";
	    for ($i = sizeof($tabDates) - 1; $i >= 0; $i--) {
		$oDate = DateSoutenance::getDateSoutenance($tabDates[$i]->getIdentifiantBDD());
		$date_formatee = date('Y-m-d', mktime(0, 0, 0, $oDate->getMois(), $oDate->getJour(), $oDate->getAnnee()));
		$tabPromoDate = DateSoutenance::listerRelationPromoDate($tabDates[$i]->getIdentifiantBDD());
		$tabPromo = Promotion::listerPromotions(new FiltreString('anneeuniversitaire', $oDate->getAnnee() - 1));
		?>
		<tr id="ligne<?php echo $i % 2; ?>">
		    <td>
			<table >
			    <tr>
				<td width='50%'><?php echo $date_formatee; ?></td>
				<td>
				    <?php
				    foreach ($tabPromo as $promo) {
					$check = "";
					foreach ($tabPromoDate as $promo2)
					    if ($promo2 == $promo->getIdentifiantBDD())
						$check = "checked";
				    echo '<input type="checkbox" disabled name="promo[]" value="' . $promo->getIdentifiantBDD() . '" ' . $check . '> ' . $promo->getFiliere()->getNom() . ' ' . $promo->getParcours()->getNom() . '<br/>';
				    }
				    ?>
				</td>
				<td>
				    <?php
				    if ($oDate->getConvocation() == 0)
					echo '<input type="checkbox" disabled name="convocation" value="0"> convocation';
				    else
					echo '<input type="checkbox" disabled name="convocation" value="1" checked> convocation';
				    ?>
				</td>
			    </tr>
			</table>
		    </td>
		    <td align="center">
			<a href="gestionDate.php?action=mod&id=<?php echo $tabDates[$i]->getIdentifiantBDD(); ?>">
			    <img src="../../images/reply.png"/>
			</a>
		    </td>
		    <td align="center">
			<a href="gestionDate.php?action=sup&id=<?php echo $tabDates[$i]->getIdentifiantBDD(); ?>">
			    <img src="../../images/action_delete.png"/>
			</a>
		    </td>
		</tr>
		<?php
	    }
	    echo "</table>";
	    echo "<br/><br/>";
	} else {
	    echo "<br/><center>Aucune date n'a été trouvée.</center><br/>";
	}
    }

}
?>