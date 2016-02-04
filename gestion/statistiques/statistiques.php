<?php

$chemin = '../../classes/';
include_once($chemin."moteur/Filtre.php");
include_once("statistiquesData.php");


echo "</br>";echo "</br>";echo "</br>";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Statistiques Reloaded</title>
		<script src="frameworksJS/jquery.js"></script>
		<script src="frameworksJS/Chart.js"></script>
	</head>
	<body>
		<section>
			<section >
				<table CELLSPACING=8 >
					<th colspan=3>Lieu du stage</th>
					<tr>
						<td bgcolor=red width=16></td>
						<td width=16%>Le Mans</td>
						<td><?php echo $mans;?></td>
					</tr>
					<tr>
						<td bgcolor=orange ></td>
						<td>Sarthe</td>
						<td><?php echo $sarthe;?></td>
					</tr>
					<tr>
						<td bgcolor=green ></td>
						<td>Pays de la Loire</td>
						<td><?php echo $region;?></td>
					</tr>
					<tr>
						<td bgcolor=blue ></td>
						<td>France</td>
						<td><?php echo $france;?></td>
					</tr>
					<tr>
						<td bgcolor=darkviolet></td>
						<td>Monde</td>
						<td><?php echo $monde;?></td>
					</tr>
				</table>

				</br></br>
			</section>

			<section >
				<h3>Lieu du stage</h3>
				<canvas id="mycanvas" width="256" height="256">
				</canvas>

				<script>
					$(document).ready(function(){
						var ctx = $("#mycanvas").get(0).getContext("2d");
						//pie chart data
						//sum of values = peu importe
						
						var data = [
							{
								value: <?php echo $mans;?>,
								color: "red",
								highlight: "darkred",
								label:  "Le Mans "					},
							{
								value: <?php echo $sarthe;?>,
								color: "orange",
								highlight: "darkorange",
								label: "Sarthe "
							},
							{
								value: <?php echo $region;?>,
								color: "green",
								highlight: "darkgreen",
								label: "Pays de la Loire "
							},
							{
								value: <?php echo $france;?>,
								color: "blue",
								highlight: "darkblue",
								label: "France "
							},
							{
								value: <?php echo $monde;?>,
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
				

				<!--
				<canvas id="mycanvas2" width="256" height="256">
				</canvas>

				<script>
					$(document).ready(function(){
						var ctx = $("#mycanvas2").get(0).getContext("2d");
						//pie chart data
						//sum of values = peu importe
						
						var data = [
							{
								value: <?php echo $mans;?>,
								color: "red",
								highlight: "darkred",
								label:  "Le Mans "					},
							{
								value: <?php echo $sarthe;?>,
								color: "orange",
								highlight: "darkorange",
								label: "Sarthe "
							},
							{
								value: <?php echo $region;?>,
								color: "green",
								highlight: "darkgreen",
								label: "Pays de la Loire "
							},
							{
								value: <?php echo $france;?>,
								color: "blue",
								highlight: "darkblue",
								label: "France "
							},
							{
								value: <?php echo $monde;?>,
								color: "darkviolet",
								highlight: "indigo",
								label: "Monde "
							}
						];
						//draw
						var piechart = new Chart(ctx).Pie(data);
						//var linechart = new Chart(ctx).Line(data);
					});
				</script>
			-->
			</section>
		</section>
				
	</body>
</html>