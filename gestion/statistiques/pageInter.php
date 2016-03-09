<?php


for ($i=0; $i<sizeof($tabAU); $i++) {

	$conventionM1 = recupererDonneeM1($tabAU[$i]);
	$conventionM2 = recupererDonneeM2($tabAU[$i]);

	$tabM1 = themeDeStage($conventionM1);
	$tabM2 = themeDeStage($conventionM2);
	$tabMaster = array_merge($tabM1, $tabM2);

	$tabTM1 = typeEntreprise($conventionM1);
	$tabTM2 = typeEntreprise($conventionM2);
	$tabTMaster = array_merge($tabTM1, $tabTM2);

	echo "<div id='page".$i."' class='content'>";
	afficherEntreprise($conventionM1, $conventionM2, $tabAU[$i]);
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
				
				<?php
				foreach ($temp as $i => $j){
				?>
					<tr>
						<td bgcolor=<?php echo ThemeDeStage::getThemeDeStage($i)->getCouleur()->getCode(); ?> ></td>
						<td ><?php echo ThemeDeStage::getThemeDeStage($i)->getTheme(); ?></td>
						<td><?php echo $j?></td>
					</tr>
	
				<?php
				}

			?>
		</table>

		</br></br>
		<canvas id="<?php echo 'mycanvastheme'.$annee;?>" width="256" height="256">
		</canvas>

		<script>
			
			$(document).on('ready',function(){
				var ctx = $(<?php echo '"#mycanvastheme'.$annee.'"';?>).get(0).getContext("2d");
				//pie chart data
				//sum of values = peu importe
				
				var data = [
				
					<?php
					foreach ($temp as $i => $j) {
						?>
						{
							value: <?php echo $j ?>,
							color: <?php echo "'#".ThemeDeStage::getThemeDeStage($i)->getCouleur()->getCode()."'"; ?>,
							label: <?php echo "'".ThemeDeStage::getThemeDeStage($i)->getTheme()."'"; ?>
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
				
				<?php
				foreach ($temp as $i => $j){
				?>
					<tr>
						<td bgcolor=<?php echo ThemeDeStage::getThemeDeStage($i)->getCouleur()->getCode(); ?> ></td>
						<td ><?php echo ThemeDeStage::getThemeDeStage($i)->getTheme(); ?></td>
						<td><?php echo $j?></td>
					</tr>
	
				<?php
				}

			?>
		</table>
		</br></br>
		<canvas id="<?php echo 'mycanvastheme1'.$annee;?>" width="256" height="256">
		</canvas>

		<script>
			
			$(document).on('ready',function(){
				var ctx = $(<?php echo '"#mycanvastheme1'.$annee.'"';?>).get(0).getContext("2d");
	
				
				var data = [
				
					<?php
					foreach ($temp as $i => $j) {
						?>
						{
							value: <?php echo $j ?>,
							color: <?php echo "'#".ThemeDeStage::getThemeDeStage($i)->getCouleur()->getCode()."'"; ?>,
							label: <?php echo "'".ThemeDeStage::getThemeDeStage($i)->getTheme()."'"; ?>
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
				
				<?php
				foreach ($temp as $i => $j){
				?>
					<tr>
						<td bgcolor=<?php echo ThemeDeStage::getThemeDeStage($i)->getCouleur()->getCode(); ?> ></td>
						<td ><?php echo ThemeDeStage::getThemeDeStage($i)->getTheme(); ?></td>
						<td><?php echo $j?></td>
					</tr>
	
				<?php
				}
				

			?>
		</table>
		</br></br>
		<canvas id="<?php echo 'mycanvastheme2'.$annee;?>" width="256" height="256">
		</canvas>

		<script>
			
			$(document).on('ready',function(){
				var ctx = $(<?php echo '"#mycanvastheme2'.$annee.'"';?>).get(0).getContext("2d");
	
				
				var data = [
				
					<?php
					foreach ($temp as $i => $j) {
						?>
						{
							value: <?php echo $j ?>,
							color: <?php echo "'#".ThemeDeStage::getThemeDeStage($i)->getCouleur()->getCode()."'"; ?>,
							label: <?php echo "'".ThemeDeStage::getThemeDeStage($i)->getTheme()."'"; ?>
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

function afficherEntreprise($conventionM1, $conventionM2, $annee) {


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

			if (strlen($codepostalM1) == 5) 
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


			if (strlen($codepostalM2) == 5) 
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

	<h1 >Ann&eacute;e <?php echo $annee;?></h1>
 
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
			<canvas id="<?php echo 'mycanvas'.$annee;?>" width="256" height="256">
			</canvas>

			<script>
				
				$(document).on('ready',function(){
					var ctx = $(<?php echo '"#mycanvas'.$annee.'"';?>).get(0).getContext("2d");

					
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
	
					var piechart = new Chart(ctx).Pie(data, { animateScale: true});
		
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
		
			<canvas id="<?php echo 'mycanvas2'.$annee;?>" width="256" height="256">
			</canvas>

			<script>
				$(document).on('ready',function(){
					var ctx = $(<?php echo '"#mycanvas2'.$annee.'"';?>).get(0).getContext("2d");

					
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
	
					var piechart = new Chart(ctx).Pie(data, { animateScale: true});
	
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
		

		
			<canvas id="<?php echo 'mycanvas3'.$annee;?>" width="256" height="256">
			</canvas>

			<script>
				$(document).on('ready',function(){
					var ctx = $(<?php echo '"#mycanvas3'.$annee.'"';?>).get(0).getContext("2d");
		
					
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
		
					var piechart = new Chart(ctx).Pie(data, { animateScale: true});
			
				});
			</script>
		
	</section>



<?php
}
?>