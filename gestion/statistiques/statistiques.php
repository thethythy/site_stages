<?php

$chemin = '../../classes/';
include_once($chemin."moteur/Filtre.php");
include_once("statistiquesData.php");



?>

<!DOCTYPE html>
<html>
	<head>
		<title>Statistiques Reloaded</title>
		<script src="frameworksJS/jquery.js"></script>
		<script src="frameworksJS/Chart.js"></script>
		<style type="text/css">

			
		</style>
	</head>
	<body>
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
				
	</body>
</html>