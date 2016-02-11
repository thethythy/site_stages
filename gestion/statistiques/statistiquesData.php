<?php

$chemin = '../../classes/';

include_once($chemin."bdd/connec.inc");
include_once($chemin."bdd/Entreprise_BDD.php");
include_once($chemin."bdd/Etudiant_BDD.php");
include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."bdd/Promotion_BDD.php");
include_once($chemin."bdd/ThemeDeStage_BDD.php");
include_once($chemin."bdd/TypeEntreprise_BDD.php");


include_once($chemin."ihm/Entreprise_IHM.php");
include_once($chemin."ihm/Etudiant_IHM.php");
include_once($chemin."ihm/Promotion_IHM.php");
include_once($chemin."ihm/Contact_IHM.php");
include_once($chemin."ihm/Convention_IHM.php");
include_once($chemin."ihm/ThemeDeStage_IHM.php");
include_once($chemin."ihm/IHM_Generale.php");


include_once($chemin."moteur/Entreprise.php");
include_once($chemin."moteur/Etudiant.php");
include_once($chemin."moteur/Promotion.php");
include_once($chemin."moteur/Contact.php");
include_once($chemin."moteur/ThemeDeStage.php");
include_once($chemin."moteur/TypeEntreprise.php");
include_once($chemin."moteur/Convention.php");

include_once($chemin."moteur/Filtre.php");
include_once($chemin."moteur/FiltreNumeric.php");
include_once($chemin."moteur/FiltreString.php");

//recuperer une année universitaire

//construire un filtre selon la bonne année universitaire
if (!isset($_POST['annee'])) {
	$annee = "2015";
} else {
	$annee = $_POST['annee'];
}
$parcoursISI = "9";
$filiereMaster1 = "4";
$filiereMaster2 = "1";

$filtreAnnee = new FiltreString('anneeuniversitaire', $annee);
$filtreFiliere1 = new FiltreNumeric('idfiliere', $filiereMaster1);
$filtreFiliere2 = new FiltreNumeric('idfiliere', $filiereMaster2);

$filtreM1 = new Filtre($filtreAnnee, $filtreFiliere1, "AND");
$filtreM2 = new Filtre($filtreAnnee, $filtreFiliere2, "AND");

// recuperation de liste de convention
$filtreConventionM1 = new Filtre($filtreAnnee, $filtreFiliere1, "AND");
$conventionM1 = Convention::getListeConvention($filtreConventionM1);

$filtreConventionM2 = new Filtre($filtreAnnee, $filtreFiliere2, "AND");
$conventionM2 = Convention::getListeConvention($filtreConventionM2);

// get type possible
$tabtype = TypeEntreprise::getListeTypeEntreprise("");

if( ($taille=sizeof($tabtype))>0) {
	
}

$mansM1 = 0;
$sartheM1 = 0;
$regionM1 = 0;
$franceM1 = 0;
$mondeM1 = 0;
$depM1 = 0;

$mansM2 = 0;
$sartheM2 = 0;
$regionM2 = 0;
$franceM2 = 0;
$mondeM2 = 0;
$depM2 = 0;


if(sizeof($conventionM1)>0) {
	for ($i=0; $i<sizeof($conventionM1); $i++){
		$entreprise = $conventionM1[$i]->getEntreprise();

		$nomM1 = $entreprise->getNom();	
		$adresseM1 = $entreprise->getAdresse();	
		$codepostalM1 = $entreprise->getCodePostal();
		$villeM1 = strtolower($entreprise->getVille());
		$paysM1 = strtolower($entreprise->getPays());	
		$emailM1 = $entreprise->getEmail();
		$typeentrepriseM1 = $entreprise->getType();

		$depM1 = $codepostalM1[0].$codepostalM1[1];
		
		$deps = array("53","85","49","44");

		if(strstr($villeM1, "mans") && ($codepostalM1 == "72000" || $codepostalM1 == "72100") && strstr($paysM1, "france") ) {
			$mansM1++;
		}
		else if($depM1 == "72"  && strstr($paysM1, "france")  && ($codepostalM1 != "72000" || $codepostalM1 != "72100") ) {
			$sartheM1++;
		}
		else if(in_array($depM1, $deps) && strstr($paysM1, "france")) {
			$regionM1++;
		}
		else if(strstr($paysM1, "france")) {
			$franceM1++;
		}
		else {
			$mondeM1++;
		}
	}
}

if(sizeof($conventionM2)>0) {
	for ($i=0; $i<sizeof($conventionM2); $i++){
		$entreprise = $conventionM2[$i]->getEntreprise();

		$nomM2 = $entreprise->getNom();	
		$adresseM2 = $entreprise->getAdresse();	
		$codepostalM2 = $entreprise->getCodePostal();
		$villeM2 = strtolower($entreprise->getVille());
		$paysM2 = strtolower($entreprise->getPays());	
		$emailM2 = $entreprise->getEmail();
		$typeentrepriseM2 = $entreprise->getType();


		$depM2 = $codepostalM2[0].$codepostalM2[1];
		
		$deps = array("53","85","49","44");

		if(strstr($villeM2, "mans") && ($codepostalM2 == "72000" || $codepostalM2 == "72100") && strstr($paysM2, "france") ) {
			$mansM2++;
		}
		else if($depM2 == "72"  && strstr($paysM2, "france")  && ($codepostalM2 != "72000" || $codepostalM2 != "72100") ) {
			$sartheM2++;
		}
		else if(in_array($depM2, $deps) && strstr($paysM2, "france")) {
			$regionM2++;
		}
		else if(strstr($paysM2, "france")) {
			$franceM2++;
		}
		else {
			$mondeM2++;
		}
	}
}


?>

<h1>Ann&eacute;e <?php echo $annee;?></h1>

<section id="section_gauche">
	<h2 style="color:LightSkyBlue">Promotion M1</h2>
	
		<table  >
			<th colspan=3>Lieu du stage</th>
			<tr>
				<td bgcolor=red ></td>
				<td >Le Mans</td>
				<td><?php echo $mansM1;?></td>
			</tr>
			<tr>
				<td bgcolor=orange ></td>
				<td>Sarthe</td>
				<td><?php echo $sartheM1;?></td>
			</tr>
			<tr>
				<td bgcolor=green ></td>
				<td>Pays de la Loire</td>
				<td><?php echo $regionM1;?></td>
			</tr>
			<tr>
				<td bgcolor=blue ></td>
				<td>France</td>
				<td><?php echo $franceM1;?></td>
			</tr>
			<tr>
				<td bgcolor=darkviolet></td>
				<td>Monde</td>
				<td><?php echo $mondeM1;?></td>
			</tr>
		</table>

		</br></br>
		<canvas id="mycanvas" width="256" height="256">
		</canvas>

		<script>
			$(document).ready(function(){
				var ctx = $("#mycanvas").get(0).getContext("2d");
				//pie chart data
				//sum of values = peu importe
				
				var data = [
					{
						value: <?php echo $mansM1;?>,
						color: "red",
						highlight: "darkred",
						label:  "Le Mans "					},
					{
						value: <?php echo $sartheM1;?>,
						color: "orange",
						highlight: "darkorange",
						label: "Sarthe "
					},
					{
						value: <?php echo $regionM1;?>,
						color: "green",
						highlight: "darkgreen",
						label: "Pays de la Loire "
					},
					{
						value: <?php echo $franceM1;?>,
						color: "blue",
						highlight: "darkblue",
						label: "France "
					},
					{
						value: <?php echo $mondeM1;?>,
						color: "darkviolet",
						highlight: "indigo",
						label: "Monde "
					}
				];
				//draw
				var piechart = new Chart(ctx).Pie(data, { animateScale: true});
				//var linechart = new Chart(ctx).Line(data);
			});
		</script>
	
</section>




<section id="section_centre">
	<h2 style="color:SteelBlue">Promotion M2</h2>
	
		<table  >
			<th colspan=3>Lieu du stage</th>
			<tr>
				<td bgcolor=red ></td>
				<td >Le Mans</td>
				<td><?php echo $mansM2;?></td>
			</tr>
			<tr>
				<td bgcolor=orange ></td>
				<td>Sarthe</td>
				<td><?php echo $sartheM2;?></td>
			</tr>
			<tr>
				<td bgcolor=green ></td>
				<td>Pays de la Loire</td>
				<td><?php echo $regionM2;?></td>
			</tr>
			<tr>
				<td bgcolor=blue ></td>
				<td>France</td>
				<td><?php echo $franceM2;?></td>
			</tr>
			<tr>
				<td bgcolor=darkviolet></td>
				<td>Monde</td>
				<td><?php echo $mondeM2;?></td>
			</tr>
		</table>

		</br></br>
	
		<canvas id="mycanvas2" width="256" height="256">
		</canvas>

		<script>
			$(document).ready(function(){
				var ctx = $("#mycanvas2").get(0).getContext("2d");
				//pie chart data
				//sum of values = peu importe
				
				var data = [
					{
						value: <?php echo $mansM2;?>,
						color: "red",
						highlight: "darkred",
						label:  "Le Mans "					},
					{
						value: <?php echo $sartheM2;?>,
						color: "orange",
						highlight: "darkorange",
						label: "Sarthe "
					},
					{
						value: <?php echo $regionM2;?>,
						color: "green",
						highlight: "darkgreen",
						label: "Pays de la Loire "
					},
					{
						value: <?php echo $franceM2;?>,
						color: "blue",
						highlight: "darkblue",
						label: "France "
					},
					{
						value: <?php echo $mondeM2;?>,
						color: "darkviolet",
						highlight: "indigo",
						label: "Monde "
					}
				];
				//draw
				var piechart = new Chart(ctx).Pie(data, { animateScale: true});
				//var linechart = new Chart(ctx).Line(data);
			});
		</script>
	
</section>



<section id="section_droite">
	<h2 style="color:RoyalBlue">Promotion Master</h2>
	
		<table  >
			<th colspan=3>Lieu du stage</th>
			<tr>
				<td bgcolor=red ></td>
				<td >Le Mans</td>
				<td><?php echo $mansM1+$mansM2;?></td>
			</tr>
			<tr>
				<td bgcolor=orange ></td>
				<td>Sarthe</td>
				<td><?php echo $sartheM1+$sartheM2;?></td>
			</tr>
			<tr>
				<td bgcolor=green ></td>
				<td>Pays de la Loire</td>
				<td><?php echo $regionM1+$regionM2;?></td>
			</tr>
			<tr>
				<td bgcolor=blue ></td>
				<td>France</td>
				<td><?php echo $franceM1+$franceM2;?></td>
			</tr>
			<tr>
				<td bgcolor=darkviolet></td>
				<td>Monde</td>
				<td><?php echo $mondeM1+$mondeM2;?></td>
			</tr>
		</table>

		</br></br>
	

	
		<canvas id="mycanvas3" width="256" height="256">
		</canvas>

		<script>
			$(document).ready(function(){
				var ctx = $("#mycanvas3").get(0).getContext("2d");
				//pie chart data
				//sum of values = peu importe
				
				var data = [
					{
						value: <?php echo $mansM1+$mansM2;?>,
						color: "red",
						highlight: "darkred",
						label:  "Le Mans "					},
					{
						value: <?php echo $sartheM1+$sartheM2;?>,
						color: "orange",
						highlight: "darkorange",
						label: "Sarthe "
					},
					{
						value: <?php echo $regionM1+$regionM2;?>,
						color: "green",
						highlight: "darkgreen",
						label: "Pays de la Loire "
					},
					{
						value: <?php echo $franceM1+$franceM2;?>,
						color: "blue",
						highlight: "darkblue",
						label: "France "
					},
					{
						value: <?php echo $mondeM1+$mondeM2;?>,
						color: "darkviolet",
						highlight: "indigo",
						label: "Monde "
					}
				];
				//draw
				var piechart = new Chart(ctx).Pie(data, { animateScale: true});
				//var linechart = new Chart(ctx).Line(data);
			});
		</script>
	
</section>

