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

IHM_Generale::header("Planning soutenance ", "par diplôme", "../",$tabLiens);

Menu::menuSoutenance();

?>

<form action="javascript:" name="pf">
	<table id="table_afficherPlanningFiliere">
		<tr><td colspan=2>
		<table id="presentation_afficherPlanningFiliere">
			<tr id="entete2">
				<td colspan=2>Affichage du planning des soutenances par diplôme</td>
			</tr>
			<tr>
				<th width="220">Sélectionnez le diplôme : </th>
				<th>
			<?php
				// Recuperation de l'annee promotion (la rentrée)
				if (date('n')>=10) $annee = date('Y');
				else $annee = date('Y')-1;
				//$annee = 2011; // Pour tester
				
				// Liste promotion de l'année
				$filtrePromotion = new FiltreNumeric('anneeuniversitaire', $annee);
				$tabPromotion = Promotion::listerPromotions($filtrePromotion);
				echo "<select id='promotion' name='promotion'>";	
				//echo "<option  value='-1' selected></option>";			
				for($i=0; $i<sizeof($tabPromotion); $i++){
					$promotion = $tabPromotion[$i];
					$parcours = $promotion->getParcours();
					$filiere = $promotion->getFiliere();
					$nomFP = $filiere->getNom().' '.$parcours->getNom();
					if (isset($_POST['promotion'])&&!empty($_POST['promotion'])&&$_POST['promotion']!=-1&&$promotion->getIdentifiantBDD()==$_POST['promotion'])
						$selected =" selected";
					else
						$selected = "";
					echo "<option value='".$promotion->getIdentifiantBDD()."' $selected>".$nomFP."</option>";
				}
				echo "</select>";								
			?>
			</th>
			</tr>
		</table>
	</table>
</form>

<script type="text/javascript">
	var table_onchange = new Array("promotion");
	new LoadData(table_onchange, 'planning_filieresData.php', 'onchange');
</script>

<?php

// Affichage des données
echo "<br/>";
echo "<div id='data'>\n";
include_once("planning_filieresData.php");
echo "\n</div>";

deconnexion();
IHM_Generale::endHeader(true);
IHM_Generale::footer("../");

?>