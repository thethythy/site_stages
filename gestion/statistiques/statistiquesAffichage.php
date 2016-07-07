<?php

for ($i = 0; $i < sizeof($tabAU); $i++) {

    $taille = 192;

    $conventionM1 = recupererDonnee($tabAU[$i], $filiere, $promoM1);
    $conventionM2 = recupererDonnee($tabAU[$i], $filiere, $promoM2);
    $convention = array_merge($conventionM1, $conventionM2);

    $tabEM1 = lieuDuStage($conventionM1);
    $tabEM2 = lieuDuStage($conventionM2);
    $tabEMaster = $tabEM1;
    foreach ($tabEMaster as $key => $value) {
	$tabEMaster[$key] = $tabEM1[$key] + $tabEM2[$key];
    }

    //$nbsoutenancesM1 = sommeSoutenances($conventionM1);
    //$nbsoutenancesM2 = sommeSoutenances($conventionM2);
    //$nbsoutenancesMaster = sommeSoutenances($convention);

    $tabM1 = themeDeStage($conventionM1);
    $tabM2 = themeDeStage($conventionM2);
    $tabMaster = array_merge($tabM1, $tabM2);

    $tabTM1 = typeEntreprise($conventionM1);
    $tabTM2 = typeEntreprise($conventionM2);
    $tabTMaster = array_merge($tabTM1, $tabTM2);

    echo "<div id='page" . $i . "' class='content'>";
    echo "<p style='font-size: 24px;font-weight:bold;color:#910'>Ann&eacute;e " . $tabAU[$i] . "</p>";

    echo "<div style='border-bottom : 1px solid #555;padding-bottom:10px'>";
    //getStatsPromo($tabAU[$i], "M1", $conventionM1, $tabTM1, $tabCptTypeEntreprise, $tabM1, $tabCptTheme, sizeof($conventionM1), $nbsoutenancesM1);
    //getStatsPromo($tabAU[$i], "M2", $conventionM2, $tabTM2, $tabCptTypeEntreprise, $tabM2, $tabCptTheme, sizeof($conventionM2), $nbsoutenancesM2);
    //getStatsPromo($tabAU[$i], "Master", $convention, $tabTMaster, $tabCptTypeEntreprise, $tabMaster, $tabCptTheme, sizeof($convention), $nbsoutenancesMaster);

    afficherTitre();
    echo "</div>";
    echo "<div style='border-bottom : 1px solid #555;padding-bottom:100px'>";
    afficherEntreprise($tabEM1, $tabEM2, $tabAU[$i], $taille);
    echo "</div>";
    echo "<div style='border-bottom : 1px solid #555;padding-bottom:100px'>";
    afficherTheme($tabM1, $tabM2, $tabMaster, $tabCptTheme, $tabAU[$i], $taille);
    echo "</div>";
    echo "<div style='border-bottom : 1px solid #555;padding-bottom:100px'>";
    afficherType($tabTM1, $tabTM2, $tabTMaster, $tabCptTypeEntreprise, $tabAU[$i], $taille);
    echo "</div>";

    echo "</div>";
    $tabAU[$i] ++;
}

//function sommeSoutenances($convention) {
//    $somme = 0;
//    for ($i = 0; $i < sizeof($convention); $i++) {
//	if ($convention[$i]->getIdSoutenance() != NULL) {
//	    $somme++;
//	}
//    }
//    return $somme;
//}

function somme($temp) {
    $somme = 0;
    foreach ($temp as $i => $j) {
	$somme+=$j;
    }
    return $somme;
}

function patternTableTheme($temp) {
    $somme = somme($temp);
    foreach ($temp as $i => $j) {
	?>
	<tr>
	    <td bgcolor=<?php echo ThemeDeStage::getThemeDeStage($i)->getCouleur()->getCode(); ?> ></td>
	    <td ><?php echo ThemeDeStage::getThemeDeStage($i)->getTheme(); ?></td>
	    <td><?php echo round($j / $somme * 100, 2) . " %" ?></td>
	</tr>
	<?php
    }
}

function patternTableType($temp) {
    $somme = somme($temp);
    foreach ($temp as $i => $j) {
	?>
	<tr>
	    <td bgcolor=<?php echo TypeEntreprise::getTypeEntreprise($i)->getCouleur()->getCode(); ?> ></td>
	    <td ><?php echo TypeEntreprise::getTypeEntreprise($i)->getType(); ?></td>
	    <td><?php echo round($j / $somme * 100, 2) . " %" ?></td>
	</tr>
	<?php
    }
}

function patternTableLieu($tab, $tabCouleur) {
    $somme = array_sum($tab);
    $tete = 0;
    foreach ($tab as $i => $j) {
	?>
	<tr>
	    <td bgcolor=<?php echo $tabCouleur[$tete]; ?> ></td>
	    <td > <?php echo $i; ?> </td>
	    <td><?php echo round($j / $somme * 100, 2) . " %" ?></td>
	</tr>
	<?php
	$tete++;
    }
}

function patternScriptTheme($temp) {
    $somme = somme($temp);
    foreach ($temp as $i => $j) {
	?>
	{
	value: <?php echo $j; ?>,
	color: <?php echo "'#" . ThemeDeStage::getThemeDeStage($i)->getCouleur()->getCode() . "'"; ?>,
	label: <?php echo "'" . ThemeDeStage::getThemeDeStage($i)->getTheme() . " : " . round($j / $somme * 100, 2) . "%'"; ?>
	},
	<?php
    }
}

function patternScriptType($temp) {
    $somme = somme($temp);
    foreach ($temp as $i => $j) {
	?>
	{
	value: <?php echo $j ?>,
	color: <?php echo "'#" . TypeEntreprise::getTypeEntreprise($i)->getCouleur()->getCode() . "'"; ?>,
	label: <?php echo "'" . TypeEntreprise::getTypeEntreprise($i)->getType() . " : " . round($j / $somme * 100, 2) . "%'"; ?>
	},
	<?php
    }
}

function patternScriptLieu($tab, $tabCouleur) {
    $somme = array_sum($tab);
    $tete = 0;
    foreach ($tab as $i => $j) {
	?>
	{
	value: <?php echo $j; ?>,
	color: <?php echo "'" . $tabCouleur[$tete] . "'"; ?>,
	label:  <?php echo "'" . $i . " : " . round($j / $somme * 100, 2) . "%'"; ?>
	},
	<?php
	$tete++;
    }
}

function afficherType($tabM1, $tabM2, $tabMaster, $tabCptTypeEntreprise, $annee, $taille) {

    $temp = $tabCptTypeEntreprise;
    if (sizeof($tabM1) > 0) {
	for ($i = 0; $i < sizeof($tabM1); $i++) {
	    $temp[$tabM1[$i]->getIdentifiantBDD()] ++;
	}
    }
    ?>
    <p style="font-size:16px;font-weight: bold;color:grey">Type de stage</p>
    <section id="section_gauche">

        <table>

    <?php patternTableType($temp); ?>
        </table>

        </br></br>
        <canvas id="<?php echo 'mycanvastype' . $annee; ?>" width="<?php echo $taille; ?>" height="<?php echo $taille; ?>">
        </canvas>

        <script>

    	$(document).on('ready', function () {
    	    var ctx = $(<?php echo '"#mycanvastype' . $annee . '"'; ?>).get(0).getContext("2d");
    	    var data = [
    <?php patternScriptType($temp); ?>
    	    ];
    	    var piechart = new Chart(ctx).Pie(data, {animateScale: true});
    	});

        </script>
    </section>
    <?php
    $temp = $tabCptTypeEntreprise;
    if (sizeof($tabM2) > 0) {
	for ($i = 0; $i < sizeof($tabM2); $i++) {
	    $temp[$tabM2[$i]->getIdentifiantBDD()] ++;
	}
    }
    ?>
    <section id="section_centre">
        <table >

    <?php patternTableType($temp); ?>
        </table>
        </br></br>
        <canvas id="<?php echo 'mycanvastype1' . $annee; ?>" width="<?php echo $taille; ?>" height="<?php echo $taille; ?>">
        </canvas>

        <script>

    	$(document).on('ready', function () {
    	    var ctx = $(<?php echo '"#mycanvastype1' . $annee . '"'; ?>).get(0).getContext("2d");
    	    var data = [
    <?php patternScriptType($temp); ?>
    	    ];
    	    var piechart = new Chart(ctx).Pie(data, {animateScale: true});
    	});

        </script>
    </section>
    <?php
    $temp = $tabCptTypeEntreprise;
    if (sizeof($tabMaster) > 0) {
	for ($i = 0; $i < sizeof($tabMaster); $i++) {
	    $temp[$tabMaster[$i]->getIdentifiantBDD()] ++;
	}
    }
    ?>
    <section id="section_droite">
        <table >

    <?php patternTableType($temp); ?>
        </table>
        </br></br>
        <canvas id="<?php echo 'mycanvastype2' . $annee; ?>" width="<?php echo $taille; ?>" height="<?php echo $taille; ?>">
        </canvas>

        <script>

    	$(document).on('ready', function () {
    	    var ctx = $(<?php echo '"#mycanvastype2' . $annee . '"'; ?>).get(0).getContext("2d");
    	    var data = [
    <?php patternScriptType($temp); ?>
    	    ];
    	    var piechart = new Chart(ctx).Pie(data, {animateScale: true});
    	});

        </script>
    </section>
    <?php
}

function afficherTheme($tabM1, $tabM2, $tabMaster, $tabCptTheme, $annee, $taille) {

    $temp = $tabCptTheme;
    if (sizeof($tabM1) > 0) {
	for ($i = 0; $i < sizeof($tabM1); $i++) {
	    $temp[$tabM1[$i]->getIdTheme()] ++;
	}
    }
    ?>
    <p style="font-size:16px;font-weight: bold;color:grey">Theme de stage</p>
    <section id="section_gauche">
        <table >
    <?php patternTableTheme($temp); ?>
        </table>

        </br></br>
        <canvas id="<?php echo 'mycanvastheme' . $annee; ?>" width="<?php echo $taille; ?>" height="<?php echo $taille; ?>">
        </canvas>

        <script>

    	$(document).on('ready', function () {
    	    var ctx = $(<?php echo '"#mycanvastheme' . $annee . '"'; ?>).get(0).getContext("2d");
    	    var data = [
    <?php patternScriptTheme($temp); ?>
    	    ];
    	    var piechart = new Chart(ctx).Pie(data, {animateScale: true});
    	});

        </script>
    </section>
    <?php
    $temp = $tabCptTheme;
    if (sizeof($tabM2) > 0) {
	for ($i = 0; $i < sizeof($tabM2); $i++) {
	    $temp[$tabM2[$i]->getIdTheme()] ++;
	}
    }
    ?>
    <section id="section_centre">
        <table >
    <?php patternTableTheme($temp); ?>
        </table>
        </br></br>
        <canvas id="<?php echo 'mycanvastheme1' . $annee; ?>" width="<?php echo $taille; ?>" height="<?php echo $taille; ?>">
        </canvas>

        <script>

    	$(document).on('ready', function () {
    	    var ctx = $(<?php echo '"#mycanvastheme1' . $annee . '"'; ?>).get(0).getContext("2d");
    	    var data = [
    <?php patternScriptTheme($temp); ?>
    	    ];
    	    var piechart = new Chart(ctx).Pie(data, {animateScale: true});
    	});

        </script>
    </section>
    <?php
    $temp = $tabCptTheme;
    if (sizeof($tabMaster) > 0) {
	for ($i = 0; $i < sizeof($tabMaster); $i++) {
	    $temp[$tabMaster[$i]->getIdTheme()] ++;
	}
    }
    ?>
    <section id="section_droite">
        <table >
    <?php patternTableTheme($temp); ?>
        </table>
        </br></br>
        <canvas id="<?php echo 'mycanvastheme2' . $annee; ?>" width="<?php echo $taille; ?>" height="<?php echo $taille; ?>">
        </canvas>

        <script>

    	$(document).on('ready', function () {
    	    var ctx = $(<?php echo '"#mycanvastheme2' . $annee . '"'; ?>).get(0).getContext("2d");
    	    var data = [
    <?php patternScriptTheme($temp); ?>
    	    ];
    	    var piechart = new Chart(ctx).Pie(data, {animateScale: true});
    	});

        </script>
    </section>
    <?php
}

function afficherEntreprise($tabEM1, $tabEM2, $annee, $taille) {
    $tabCouleur = array("red", "orange", "green", "blue", "darkviolet");
    ?>

    <p style="font-size:16px;font-weight: bold;color:grey">Lieu de stage</p>
    <section id="section_gauche">

        <table  >
    <?php patternTableLieu($tabEM1, $tabCouleur); ?>
        </table>

        </br></br>
        <canvas id="<?php echo 'mycanvas' . $annee; ?>" width="<?php echo $taille; ?>" height="<?php echo $taille; ?>">
        </canvas>

        <script>

    	$(document).on('ready', function () {
    	    var ctx = $(<?php echo '"#mycanvas' . $annee . '"'; ?>).get(0).getContext("2d");
    	    var data = [
    <?php patternScriptLieu($tabEM1, $tabCouleur); ?>
    	    ];
    	    var piechart = new Chart(ctx).Pie(data, {animateScale: true});

    	});
        </script>
    </section>

    <section id="section_centre">

        <table  >
    <?php patternTableLieu($tabEM2, $tabCouleur); ?>
        </table>

        </br></br>
        <canvas id="<?php echo 'mycanvas2' . $annee; ?>" width="<?php echo $taille; ?>" height="<?php echo $taille; ?>">
        </canvas>

        <script>

    	$(document).on('ready', function () {
    	    var ctx = $(<?php echo '"#mycanvas2' . $annee . '"'; ?>).get(0).getContext("2d");
    	    var data = [
    <?php patternScriptLieu($tabEM2, $tabCouleur); ?>
    	    ];
    	    var piechart = new Chart(ctx).Pie(data, {animateScale: true});

    	});
        </script>
    </section>

    <?php
    $tabEMaster = $tabEM1;
    foreach ($tabEMaster as $i => $j) {
	$tabEMaster[$i] = $tabEM1[$i] + $tabEM2[$i];
    }
    $tete = 0;
    ?>
    <section id="section_droite">

        <table>
    <?php patternTableLieu($tabEMaster, $tabCouleur); ?>
        </table>

        </br></br>
        <canvas id="<?php echo 'mycanvas3' . $annee; ?>" width="<?php echo $taille; ?>" height="<?php echo $taille; ?>">
        </canvas>

        <script>

    	$(document).on('ready', function () {
    	    var ctx = $(<?php echo '"#mycanvas3' . $annee . '"'; ?>).get(0).getContext("2d");
    	    var data = [
    <?php patternScriptLieu($tabEMaster, $tabCouleur); ?>
    	    ];
    	    var piechart = new Chart(ctx).Pie(data, {animateScale: true});
    	});
        </script>
    </section>
    <?php
}

function afficherTitre() {
    ?>
    <section id="section_gauche">
        <h2 style="color:LightSkyBlue">Promotion M1</h2>
    </section>

    <section style="padding-left:7%" id="section_centre">
        <h2 style="color:LightSkyBlue">Promotion M2</h2>
    </section>

    <section style="padding-left:7%" id="section_droite">
        <h2 style="color:LightSkyBlue;">Promotion Master</h2>
    </section>
    <?php
}

?>