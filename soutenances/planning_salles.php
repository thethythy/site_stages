<?php

$chemin = "../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Parrain_BDD.php");
include_once($chemin."moteur/Parrain.php");
include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Convention.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."bdd/Parcours_BDD.php");
include_once($chemin."moteur/Parcours.php");
include_once($chemin."bdd/Filiere_BDD.php");
include_once($chemin."moteur/Filiere.php");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."bdd/Salle_BDD.php");
include_once($chemin."moteur/Salle.php");
include_once($chemin."bdd/DateSoutenance_BDD.php");
include_once($chemin."moteur/DateSoutenance.php");
include_once($chemin."bdd/Soutenance_BDD.php");
include_once($chemin."moteur/Soutenance.php");
include_once($chemin."bdd/SujetDeStage_BDD.php");
include_once($chemin."moteur/SujetDeStage.php");
include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/Utils.php");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."ihm/Menu.php");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Soutenances');

IHM_Generale::header("Planning soutenance ", "par salles", "../",$tabLiens);

Menu::menuSoutenance();

// Recuperation de l'annee promotion (la rentrée)
if (date('n')>=10) $annee = date('Y');
else $annee = date('Y')-1;
//$annee = 2011; // Pour tester

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
						<th>
							<?php
								// Recuperation de la liste des salles
								$tabSalle = Salle::listerSalle();
								echo "<select id='salle' name='salle'>";
								// echo "<option  value='-1' selected></option>";
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
						</th>
					</tr>
					<tr>
						<th width="220">Sélectionnez la date : </th>
						<th>
							<?php
								// Recuperation de la liste des dates
								$filtreDate = new FiltreNumeric('annee', $annee+1);
								$tabDate = DateSoutenance::listerDateSoutenance($filtreDate);
								echo "<select id='date' name='date'>";
								//echo "<option  value='-1' selected></option>";
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
						</th>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>

<script type="text/javascript">
	var table_onchange = new Array("salle", "date");
	<?php if (sizeof($tabDate) > 0) echo "new LoadData(table_onchange, 'planning_sallesData.php', 'onchange');"; ?>
</script>

<?php
	
// Affichage des données
echo "<br/>";
echo "<div id='data'>\n";
include_once("planning_sallesData.php");
echo "\n</div>";

deconnexion();
IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>