<?php

class Soutenance_IHM {

    public static function afficherSelectionSoutenancesEnseignant($fichierPOST) {
	$tabParrain = Parrain::listerParrain();
	?>
	<form action="javascript:" name="ps">
	    <table>
		<tr>
		    <td colspan=2>
			<table>
			    <tr id="entete2">
				<td colspan=2>Affichage du planning des soutenances par enseignant</td>
			    </tr>
			    <tr>
				<th width="220">Sélectionnez l'enseignant : </th>
				<td>
				    <?php
				    echo "<select id='enseignant' name='enseignant'>";
				    echo "<option  value='-1' selected></option>";
				    for ($i = 0; $i < sizeof($tabParrain); $i++) {
					if (isset($_POST['enseignant']) && !empty($_POST['enseignant']) && $_POST['enseignant'] != -1 && $tabParrain[$i]->getIdentifiantBDD() == $_POST['enseignant'])
					    $selected = " selected";
					else
					    $selected = "";
					echo "<option value='" . $tabParrain[$i]->getIdentifiantBDD() . "'
					name='" . $tabParrain[$i]->getNom() . "' $selected>" . $tabParrain[$i]->getNom() . " " . $tabParrain[$i]->getPrenom() . "</option>";
				    }
				    echo "</select>";
				    ?>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</form>
	<script type="text/javascript">
	    var table_onchange = new Array("enseignant");
	    new LoadData(table_onchange, '<?php echo $fichierPOST; ?>', 'onchange');
	</script>
	<?php
    }

    public static function afficherSelectionSoutenancesPromotion($fichierPOST) {
	?>
	<form action="javascript:" name="pf">
	    <table id="table_afficherPlanningFiliere">
		<tr>
		    <td colspan=2>
			<table id="presentation_afficherPlanningFiliere">
			    <tr id="entete2">
				<td colspan=2>Affichage du planning des soutenances par diplôme</td>
			    </tr>
			    <tr>
				<th width="220">Sélectionnez le diplôme : </th>
				<td>
				    <?php
				    // Recuperation de l'annee promotion (la rentrée)
				    if (date('n')>=10)
					$annee = date('Y');
				    else
					$annee = date('Y')-1;

				    // Liste promotion de l'année
				    $filtrePromotion = new FiltreNumeric('anneeuniversitaire', $annee);
				    $tabPromotion = Promotion::listerPromotions($filtrePromotion);
				    echo "<select id='promotion' name='promotion'>";

				    for($i=0; $i<sizeof($tabPromotion); $i++){
					    $promotion = $tabPromotion[$i];
					    $parcours = $promotion->getParcours();
					    $filiere = $promotion->getFiliere();
					    $nomFP = $filiere->getNom().' '.$parcours->getNom();
					    if (isset($_POST['promotion']) &&
						!empty($_POST['promotion']) &&
						$_POST['promotion']!=-1 &&
						$promotion->getIdentifiantBDD() == $_POST['promotion'])
						    $selected =" selected";
					    else
						    $selected = "";
					    echo "<option value='".$promotion->getIdentifiantBDD()."' $selected>".$nomFP."</option>";
				    }
				    echo "</select>";
				    ?>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</form>

	<script type="text/javascript">
	    var table_onchange = new Array("promotion");
	    new LoadData(table_onchange, '<?php echo $fichierPOST; ?>', 'onchange');
	</script>
	<?php
    }

    public static function afficherSelectionSoutenancesSalle($annee, $fichierPOST) {
	$tabSalle = Salle::listerSalle();
	?>
	<form action="javascript:" name="ps">
	    <table id="table_afficherPlanningSalle">
		<tr>
		    <td colspan=2>
			<table id="presentation_afficherPlanningSalle">
			    <tr id="entete2">
				<td colspan=2>Affichage du planning des soutenances par salle</td>
			    </tr>
			    <tr>
				<th width="220">Sélectionnez la salle : </th>
				<td>
				    <?php
				    // Recuperation de la liste des salles
				    echo "<select id='salle' name='salle'>";
				    for ($i = 0; $i < sizeof($tabSalle); $i++) {
					$salle = $tabSalle[$i];
					if (isset($_POST['salle']) && $_POST['salle'] != -1 && $salle->getIdentifiantBDD() == $_POST['salle'])
					    $selected =" selected";
					else
					    $selected = "";
					echo "<option value='".$salle->getIdentifiantBDD()."' $selected>".$salle->getNom()."</option>";
				    }
				    echo "</select>";
				    ?>
				</td>
			    </tr>
			    <tr>
				<th width="220">Sélectionnez la date : </th>
				<td>
				    <?php
				    // Recuperation de la liste des dates
				    $filtreDate = new FiltreNumeric('annee', $annee+1);
				    $tabDate = DateSoutenance::listerDateSoutenance($filtreDate);
				    echo "<select id='date' name='date'>";
				    for ($i = 0; $i < sizeof($tabDate); $i++) {
					$date = $tabDate[$i];
					if (isset($_POST['date']) && $_POST['date'] != -1 && $date->getIdentifiantBDD() == $_POST['date'])
					    $selected = " selected";
					else
					    $selected = "";
					echo "<option value='".$date->getIdentifiantBDD()."' $selected>".$date->getJour()." ".Utils::numToMois($date->getMois())." ".$date->getAnnee()."</option>";
				    }
				    echo "</select>";
				    ?>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
	    </table>
	</form>
	<script type="text/javascript">
	    var table_onchange = new Array("salle", "date");
	    <?php if (sizeof($tabDate) > 0) echo "new LoadData(table_onchange, '$fichierPOST', 'onchange');"; ?>
	</script>
    <?php
    }
}

?>
