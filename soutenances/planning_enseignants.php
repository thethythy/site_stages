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

header ("Content-type:text/html; charset=utf-8");

$tabLiens = array();
$tabLiens[0] = array('../', 'Accueil');
$tabLiens[1] = array('./', 'Soutenances');

IHM_Generale::header("Planning soutenance ", "par enseignants", "../",$tabLiens);

Menu::menuSoutenance();

?>

<form action="javascript:" name="ps">
	<table id="table_afficherPlanningEnseignants">
		<tr><td colspan=2>
		<table id="presentation_afficherPlanningEnseignants">
			<tr id="entete2">
				<td colspan=2>Affichage du planning des soutenances par enseignant</td>
			</tr>
			<tr>
				<th width="220">Sélectionnez l'enseignant : </th>
				<th>
			<?php
				$tabParrain = Parrain::listerParrain();
				echo "<select id='enseignant' name='enseignant'>";	
				echo "<option  value='-1' selected></option>";
				for($i=0; $i<sizeof($tabParrain); $i++){
					if (isset($_POST['enseignant'])&&!empty($_POST['enseignant'])&&$_POST['enseignant']!=-1&&$tabParrain[$i]->getIdentifiantBDD()==$_POST['enseignant'])
						$selected =" selected";
					else
						$selected = "";
					echo "<option value='".$tabParrain[$i]->getIdentifiantBDD()."' 
					name='".$tabParrain[$i]->getNom()."' $selected>".$tabParrain[$i]->getNom()." ".$tabParrain[$i]->getPrenom()."</option>";
				}
				echo "</select>";
			?>
			</th>
			</tr>
		</table>
	</table>
</FORM>

<script type="text/javascript">
	var table_onchange = new Array("enseignant");
	new LoadData(table_onchange, 'planning_enseignantsData.php', 'onchange');
</script>

<?php

// Affichage des données
echo "<br/>";
echo "<div id='data'>\n";
include_once("planning_enseignantsData.php");
echo "\n</div>";

deconnexion();
IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>