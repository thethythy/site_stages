<?php


for ($i=0; $i<sizeof($tabAU); $i++) {

	$conventionM1 = recupererDonneeM1($tabAU[$i]);
	$conventionM2 = recupererDonneeM2($tabAU[$i]);

	$tabEM1 = lieuDuStage($conventionM1);
	$tabEM2 = lieuDuStage($conventionM2);

	$tabM1 = themeDeStage($conventionM1);
	$tabM2 = themeDeStage($conventionM2);
	$tabMaster = array_merge($tabM1, $tabM2);

	$tabTM1 = typeEntreprise($conventionM1);
	$tabTM2 = typeEntreprise($conventionM2);
	$tabTMaster = array_merge($tabTM1, $tabTM2);

	echo "<div id='page".$i."' class='content'>";
	
	afficherEntreprise($tabEM1, $tabEM2, $tabAU[$i]);
	afficherTheme($tabM1, $tabM2, $tabMaster, $tabCptTheme, $tabAU[$i]);
	afficherType($tabTM1, $tabTM2, $tabTMaster, $tabCptTypeEntreprise, $tabAU[$i]);
	echo "</div>";
	$tabAU[$i]++;
}

function afficherType($tabM1, $tabM2, $tabMaster, $tabCptTypeEntreprise, $annee) {

	$temp = $tabCptTypeEntreprise;
	if(sizeof($tabM1)>0) {
		for ($i=0; $i<sizeof($tabM1); $i++){
			$temp[$tabM1[$i]->getIdentifiantBDD()]++;
		}
	}
	?>
	<section id="section_gauche">
		<table >
		<th colspan=3>Theme de stage M1</th>
				
				<?php
				foreach ($temp as $i => $j){
				?>
					<tr>
						<td bgcolor="red"></td>
						<td ><?php echo TypeEntreprise::getTypeEntreprise($i)->getType(); ?></td>
						<td><?php echo $j?></td>
					</tr>
	
				<?php
				}

			?>
		</table>

		</br></br>
		<canvas id="<?php echo 'mycanvastype'.$annee;?>" width="256" height="256">
		</canvas>

		<script>
			
			$(document).on('ready',function(){
				var ctx = $(<?php echo '"#mycanvastype'.$annee.'"';?>).get(0).getContext("2d");

				
				var data = [
				
					<?php
					foreach ($temp as $i => $j) {
						?>
						{
							value: <?php echo $j ?>,
							color: "darkred",
							label: <?php echo "'".TypeEntreprise::getTypeEntreprise($i)->getType()."'"; ?>
						},

						<?php

					}

					?>
					
				];

				var piechart = new Chart(ctx).Pie(data, { animateScale: true});

			});
		</script>
	</section>
	<?php
	$temp = $tabCptTypeEntreprise;
	if(sizeof($tabM2)>0) {
		for ($i=0; $i<sizeof($tabM2); $i++){
			$temp[$tabM2[$i]->getIdentifiantBDD()]++;
		}
	}
	?>
	<section id="section_centre">
		<table >
		<th colspan=3>Theme de stage M2</th>
				
				<?php
				foreach ($temp as $i => $j){
				?>
					<tr>
						<td bgcolor="red" ></td>
						<td ><?php echo TypeEntreprise::getTypeEntreprise($i)->getType(); ?></td>
						<td><?php echo $j?></td>
					</tr>
	
				<?php
				}

			?>
		</table>
		</br></br>
		<canvas id="<?php echo 'mycanvastype1'.$annee;?>" width="256" height="256">
		</canvas>

		<script>
			
			$(document).on('ready',function(){
				var ctx = $(<?php echo '"#mycanvastype1'.$annee.'"';?>).get(0).getContext("2d");
				
				var data = [
				
					<?php
					foreach ($temp as $i => $j) {
						?>
						{
							value: <?php echo $j ?>,
							color: "red",
							label: <?php echo "'".TypeEntreprise::getTypeEntreprise($i)->getType()."'"; ?>
						},

						<?php

					}

					?>
					
				];
				//draw
				var piechart = new Chart(ctx).Pie(data, { animateScale: true});
				//var linechart = new Chart(ctx).Line(data);
			});
		</script>
	</section>
	<?php
	$temp = $tabCptTypeEntreprise;
	if(sizeof($tabMaster)>0) {
		for ($i=0; $i<sizeof($tabMaster); $i++){
			$temp[$tabMaster[$i]->getIdentifiantBDD()]++;
		}
	}
	?>
	<section id="section_droite">
		<table >
		<th colspan=3>Theme de stage Master</th>
				
				<?php
				foreach ($temp as $i => $j){
				?>
					<tr>
						<td bgcolor="red"></td>
						<td ><?php echo TypeEntreprise::getTypeEntreprise($i)->getType(); ?></td>
						<td><?php echo $j?></td>
					</tr>
	
				<?php
				}
				

			?>
		</table>
		</br></br>
		<canvas id="<?php echo 'mycanvastype2'.$annee;?>" width="256" height="256">
		</canvas>

		<script>
			
			$(document).on('ready',function(){
				var ctx = $(<?php echo '"#mycanvastype2'.$annee.'"';?>).get(0).getContext("2d");

				
				var data = [
				
					<?php
					foreach ($temp as $i => $j) {
						?>
						{
							value: <?php echo $j ?>,
							color: "red",
							label: <?php echo "'".TypeEntreprise::getTypeEntreprise($i)->getType()."'"; ?>
						},

						<?php

					}

					?>
					
				];
		
				var piechart = new Chart(ctx).Pie(data, { animateScale: true});
	
			});
		</script>
	</section>
		<?php
}

function patternTableTheme($temp){
	foreach ($temp as $i => $j){
	?>
		<tr>
			<td bgcolor=<?php echo ThemeDeStage::getThemeDeStage($i)->getCouleur()->getCode(); ?> ></td>
			<td ><?php echo ThemeDeStage::getThemeDeStage($i)->getTheme(); ?></td>
			<td><?php echo $j?></td>
		</tr>

	<?php
	}
}

function patternScriptTheme($temp){
	foreach ($temp as $i => $j) {
		?>
		{
			value: <?php echo $j ?>,
			color: <?php echo "'#".ThemeDeStage::getThemeDeStage($i)->getCouleur()->getCode()."'"; ?>,
			label: <?php echo "'".ThemeDeStage::getThemeDeStage($i)->getTheme()."'"; ?>
		},

		<?php

	}
}

function afficherTheme($tabM1, $tabM2, $tabMaster, $tabCptTheme, $annee) {

	$temp = $tabCptTheme;
	if(sizeof($tabM1)>0) {
		for ($i=0; $i<sizeof($tabM1); $i++){
			$temp[$tabM1[$i]->getIdTheme()]++;
		}
	}
	?>
	<section id="section_gauche">
		<table >
		<th colspan=3>Theme de stage M1</th>
				<?php patternTableTheme($temp); ?>
		</table>

		</br></br>
		<canvas id="<?php echo 'mycanvastheme'.$annee;?>" width="256" height="256">
		</canvas>

		<script>
			
			$(document).on('ready',function(){
				var ctx = $(<?php echo '"#mycanvastheme'.$annee.'"';?>).get(0).getContext("2d");
				var data = [
					<?php patternScriptTheme($temp); ?>	
				];
		
				var piechart = new Chart(ctx).Pie(data, { animateScale: true});
			});
		</script>
	</section>
	<?php
	$temp = $tabCptTheme;
	if(sizeof($tabM2)>0) {
		for ($i=0; $i<sizeof($tabM2); $i++){
			$temp[$tabM2[$i]->getIdTheme()]++;
		}
	}
	?>
	<section id="section_centre">
		<table >
		<th colspan=3>Theme de stage M2</th>
				<?php patternTableTheme($temp); ?>
		</table>
		</br></br>
		<canvas id="<?php echo 'mycanvastheme1'.$annee;?>" width="256" height="256">
		</canvas>

		<script>
			
			$(document).on('ready',function(){
				var ctx = $(<?php echo '"#mycanvastheme1'.$annee.'"';?>).get(0).getContext("2d");
				var data = [
					<?php patternScriptTheme($temp); ?>	
				];
				var piechart = new Chart(ctx).Pie(data, { animateScale: true});
		
			});
		</script>
	</section>
	<?php
	$temp = $tabCptTheme;
	if(sizeof($tabMaster)>0) {
		for ($i=0; $i<sizeof($tabMaster); $i++){
			$temp[$tabMaster[$i]->getIdTheme()]++;
		}
	}
	?>
	<section id="section_droite">
		<table >
		<th colspan=3>Theme de stage Master</th>
				<?php patternTableTheme($temp); ?>
		</table>
		</br></br>
		<canvas id="<?php echo 'mycanvastheme2'.$annee;?>" width="256" height="256">
		</canvas>

		<script>
			
			$(document).on('ready',function(){
				var ctx = $(<?php echo '"#mycanvastheme2'.$annee.'"';?>).get(0).getContext("2d");
				var data = [
					<?php patternScriptTheme($temp); ?>	
				];
				var piechart = new Chart(ctx).Pie(data, { animateScale: true});
	
			});
		</script>
	</section>
		<?php
}

function afficherEntreprise($tabEM1, $tabEM2, $annee) {
	$tabCouleur = array("red","orange", "green", "blue", "darkviolet");
	$tabSelectCouleur = array("darkred","darkorange", "darkgreen", "darkblue", "indigo");
	$tete = 0;
	?>
	<h1 >Ann&eacute;e <?php echo $annee;?></h1>
 
	<section id="section_gauche">
		<h2 style="color:LightSkyBlue">Promotion M1</h2>
		
			<table  >
				<th colspan=3>Lieu du stage</th>
				<?php
				foreach($tabEM1 as $i => $j) {
					?>


				<tr>
					<td bgcolor=<?php echo $tabCouleur[$tete]; ?> ></td>
					<td > <?php echo $i; ?> </td>
					<td> <?php echo $j; ?> </td>
				</tr>

				<?php
					$tete++;
				}
				?>
			</table>

			</br></br>
			<canvas id="<?php echo 'mycanvas'.$annee;?>" width="256" height="256">
			</canvas>

			<script>
				
				$(document).on('ready',function(){
					var ctx = $(<?php echo '"#mycanvas'.$annee.'"';?>).get(0).getContext("2d");

					
					var data = [


					<?php
					$tete = 0;
					foreach ($tabEM1 as $i => $j) {
						?>

						{
							value: <?php echo $j;?>,
							color: <?php echo "'".$tabCouleur[$tete]."'";?>,
							highlight: <?php echo "'".$tabSelectCouleur[$tete]."'";?>,
							label:  <?php echo "'".$i."'";?>					
						},

						<?php
						$tete++;
					}
					?>
						
					];
	
					var piechart = new Chart(ctx).Pie(data, { animateScale: true});
		
				});
			</script>
		</section>

	<section id="section_centre">
		<h2 style="color:LightSkyBlue">Promotion M2</h2>
		
			<table  >
				<th colspan=3>Lieu du stage</th>
				<?php
				$tete=0;
				foreach($tabEM2 as $i =>$j) {
					?>


				<tr>
					<td bgcolor=<?php echo $tabCouleur[$tete]; ?> ></td>
					<td > <?php echo $i; ?> </td>
					<td><?php echo $j;?></td>
				</tr>

				<?php
					$tete++;
				}
				?>
			</table>

			</br></br>
			<canvas id="<?php echo 'mycanvas2'.$annee;?>" width="256" height="256">
			</canvas>

			<script>
				
				$(document).on('ready',function(){
					var ctx = $(<?php echo '"#mycanvas2'.$annee.'"';?>).get(0).getContext("2d");

					
					var data = [


					<?php
					$tete = 0;
					foreach ($tabEM2 as $i => $j) {
						?>

						{
							value: <?php echo $j;?>,
							color: <?php echo "'".$tabCouleur[$tete]."'";?>,
							highlight: <?php echo "'".$tabSelectCouleur[$tete]."'";?>,
							label:  <?php echo "'".$i."'";?>					
						},

						<?php
						$tete++;
					}
					?>
						
					];
	
					var piechart = new Chart(ctx).Pie(data, { animateScale: true});
		
				});
			</script>
		</section>

		<?php
		$tabEMaster = $tabEM1;
		foreach($tabEMaster as $i =>$j) {
			$tabEMaster[$i] = $tabEM1[$i]+$tabEM2[$i];
		}
		$tete=0;

		?>
		<section id="section_droite">
		<h2 style="color:LightSkyBlue">Promotion Master</h2>
		
			<table  >
				<th colspan=3>Lieu du stage</th>
				<?php
				foreach($tabEMaster as $i =>$j) {
					?>


				<tr>
					<td bgcolor=<?php echo $tabCouleur[$tete]; ?> ></td>
					<td > <?php echo $i; ?> </td>
					<td><?php echo $j;?></td>
				</tr>

				<?php
					$tete++;
				}
				?>
			</table>

			</br></br>
			<canvas id="<?php echo 'mycanvas3'.$annee;?>" width="256" height="256">
			</canvas>

			<script>
				
				$(document).on('ready',function(){
					var ctx = $(<?php echo '"#mycanvas3'.$annee.'"';?>).get(0).getContext("2d");

					
					var data = [


					<?php
					$tete = 0;
					foreach ($tabEMaster as $i => $j) {
						?>

						{
							value: <?php echo $j;?>,
							color: <?php echo "'".$tabCouleur[$tete]."'";?>,
							highlight: <?php echo "'".$tabSelectCouleur[$tete]."'";?>,
							label:  <?php echo "'".$i."'";?>					
						},

						<?php
						$tete++;
					}
					?>
						
					];
	
					var piechart = new Chart(ctx).Pie(data, { animateScale: true});
		
				});
			</script>
		</section>
			<?php
}
?>