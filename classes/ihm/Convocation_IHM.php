<?php

class Convocation_IHM {

    /**
     * Afficher un formulaire de sélection de la date de soutenance
     * @param string $page La page du traitement du formulaire
     */
    public static function afficherSelectionDateSoutenance($page) {
	$tabODS = DateSoutenance::listerDateSoutenance('', 'DESC');
	?>
	<form method=post action="javascript:">
	    <table width="100%">
		<tr>
		    <td align="center" >
			Sélectionnez la date de soutenance :
			<select id="date" name="date">
			    <?php
				echo "<option selected value='0'> ---------------- </option>";
				foreach ($tabODS as $oDS) {
				    $id = $oDS->getIdentifiantBDD();
				    $sDate = $oDS->getJour()." ".Utils::numToMois($oDS->getMois())." ".$oDS->getAnnee();
				    if (isset($_POST['date']) && ($_POST['date'] == $id))
					echo "<option selected value=$id>$sDate</option>";
				    else
					echo "<option value=$id>$sDate</option>";
				}
			    ?>
			</select>
		    </td>
		</tr>
	    </table>
	</form>

	<script type="text/javascript">
	    var table = new Array("date");
	    new LoadData(table, "<?php echo $page; ?>", "onchange");
	</script>
	<?php
    }

    /**
     * Afficher un formulaire de sélection des convocations à envoyer
     * Seules les convocations pas encore envoyées sont sélectionnables.
     * @param string $page La page de traitement du formulaire
     * @param tableau d'objet $tabOConvocation Tableau d'objets Convocation
     * @param integer $annee L'année des étudiants concernés
     * @param integer $iddate Identifiant de l'objet DateSoutenance
     */
    public static function afficherSelectionDestinairesConvocation($page, $tabOConvocation, $annee, $iddate) {
	if (sizeof($tabOConvocation) > 0) {
	    ?>
	    <form method="post" action="<?php echo $page; ?>">
		<table>
		    <tr id='entete'>
			<td width="20%">Promotion</td>
			<td width='20%'>Etudiant</td>
			<td width='15%'>Statut</td>
			<td width='35%'>Encadrant</td>
			<td width='10%'>Convocation</td>
		    </tr>

		    <?php
		    for ($i = 0; $i < sizeof($tabOConvocation); $i++) {
			$oSoutenance = Soutenance::getSoutenance($tabOConvocation[$i]->getIdsoutenance());

			$oConvention = Soutenance::getConvention($oSoutenance);
			$oContrat = Soutenance::getContrat($oSoutenance);

			if ($oConvention) {
			    $etudiant = $oConvention->getEtudiant();
			    $contact = $oConvention->getContact();
			    $entreprise = $oConvention->getEntreprise();
			} else {
			    $etudiant = $oContrat->getEtudiant();
			    $contact = $oContrat->getContact();
			    $entreprise = $oContrat->getEntreprise();
			}

			$promotion = $etudiant->getPromotion($annee);
			$nomParcours = $promotion->getParcours()->getNom();
			$nomFiliere = $promotion->GetFiliere()->getNom();

			$idConvocation = $tabOConvocation[$i]->getIdentifiantBDD();
			?>

			<tr id="ligne<?php echo $i % 2; ?>">
			    <td align="center">
				<?php echo $nomFiliere . " " . $nomParcours; ?>
			    </td>
			    <td align="center">
				<?php echo $etudiant->getPrenom() . " " . $etudiant->getNom(); ?>
			    </td>
			    <td align='centre'>
				<?php echo $oConvention ? "Stagiaire" : "Alternant"; ?>
			    </td>
			    <td align="center">
				<?php echo $contact->getPrenom() ." " . $contact->getNom() . " (". $entreprise->getNom() . ")" ?>
			    </td>
			    <td align="center">
				<?php
				    if ($tabOConvocation[$i]->getEnvoi() == 1)
					echo "<input type='checkbox' checked disabled name='convocations[]' value='$idConvocation'/>";
				    else
					echo "<input type='checkbox' name='convocations[]' value='$idConvocation'/>";
				?>
			    </td>
			<?php
		    }
		    ?>

		    <tr>
			<td colspan="2" width="50%" align="center">
			    <br/>
			    <?php echo "<input type='hidden' name='date' value='$iddate'/>"; ?>
			    <input type="submit" value="Convoquer" name="convocation"/>
			    <br/>&nbsp;
			</td>
			<td colspan="2" width="50%" align="center">
			    <br/>
			    <input type="submit" value="Annuler" formaction="../"/>
			    <br/>&nbsp;
			</td>
		    </tr>
		</table>
	    </form>
	    <?php
	} else {
	    echo "<center>Aucune convocation trouvée pour cette date.</center>";
	}
    }
}

?>