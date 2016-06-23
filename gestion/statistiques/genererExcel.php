<?php

$cheminExcel = "frameworks/PHPExcel/Classes/";

include_once($cheminExcel . "PHPExcel.php");
include_once($cheminExcel . "PHPExcel/Writer/Excel2007.php");

function getStatsPromo($annee, $promo, $convention,
			$tabTypeEntreprise, $tabCptTypeEntreprise,
			$tabThemeStage, $tabCptTheme,
			$nbEtudiant, $nbSoutenance) {

    $workbook = new PHPExcel;
    $sheet = $workbook->getActiveSheet();

    $tabEntreprise = lieuDuStage($convention);

    $sheet->setCellValue('B2', 'Statistiques stage ' . $promo . ' ' . $annee);
    $sheet->setCellValue('C4', 'Promotion' . $annee);
    $sheet->setCellValue('E4', 'Totaux');
    $sheet->setCellValue('G4', 'Pourcentages');

    $sheet->setCellValue('B6', 'Nombre d\'étudiants');
    $sheet->setCellValue('C6', $nbEtudiant);
    $sheet->setCellValue('E6', $nbEtudiant);

    $sheet->setCellValue('B8', 'Nombre de soutenances');
    $sheet->setCellValue('C8', $nbSoutenance);
    $sheet->setCellValue('E8', $nbSoutenance);

    $sheet->setCellValue('B10', 'Lieu du stage');

    $tete = 10;

    $labelSeriesLieuDebutLigne = 10;

    $sommeEntreprise = array_sum($tabEntreprise);
    foreach ($tabEntreprise as $i => $j) {
	$sheet->setCellValueByColumnAndRow(3, $tete, $i);
	$sheet->setCellValueByColumnAndRow(4, $tete, $j);
	$sheet->setCellValueByColumnAndRow(6, $tete, round($j / $sommeEntreprise * 100, 2) . " %");
	$tete++;
    }

    $labelSeriesLieuFinLigne = $tete - 1;
    $etendu = $labelSeriesLieuFinLigne - $labelSeriesLieuDebutLigne;

    $dataseriesLabel1 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$10', NULL, 1),
    );

    $xAxisTickValues1 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$' . $labelSeriesLieuDebutLigne . ':$D$' . $labelSeriesLieuFinLigne, NULL, $etendu),
    );

    $dataSeriesValues1 = array(
	new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$' . $labelSeriesLieuDebutLigne . ':$E$' . $labelSeriesLieuFinLigne, NULL, $etendu),
    );

    $series1 = new PHPExcel_Chart_DataSeries(
	    PHPExcel_Chart_DataSeries::TYPE_PIECHART, PHPExcel_Chart_DataSeries::GROUPING_STANDARD, range(0, count($dataSeriesValues1) - 1), $dataseriesLabel1, $xAxisTickValues1, $dataSeriesValues1
    );

    $layout1 = new PHPExcel_Chart_Layout();
    $layout1->setShowVal(TRUE);
    $layout1->setShowPercent(TRUE);

    $plotarea1 = new PHPExcel_Chart_PlotArea($layout1, array($series1));
    $legend1 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
    $title1 = new PHPExcel_Chart_Title('Lieu du stage');

    $chart1 = new PHPExcel_Chart(
	    'chart1', $title1, $legend1, $plotarea1, true, 0, NULL, NULL
    );

    $chart1->setTopLeftPosition('I2');
    $chart1->setBottomRightPosition('Q16');

    $sheet->addChart($chart1);

    $temp = $tabCptTheme;
    if (sizeof($tabThemeStage) > 0) {
	for ($i = 0; $i < sizeof($tabThemeStage); $i++) {
	    $temp[$tabThemeStage[$i]->getIdTheme()] ++;
	}
    }

    $sheet->setCellValue('B16', 'Contenu du stage');

    $tete = 16;
    $sommeTheme = 0;
    foreach ($temp as $i => $j) {
	$sommeTheme+=$j;
    }

    $labelSeriesThemeDebutLigne = $tete;

    foreach ($temp as $i => $j) {
	$sheet->setCellValueByColumnAndRow(3, $tete, ThemeDeStage::getThemeDeStage($i)->getTheme());
	$sheet->setCellValueByColumnAndRow(4, $tete, $j);
	$sheet->setCellValueByColumnAndRow(6, $tete, round($j / $sommeTheme * 100, 2) . " %");
	$tete++;
    }

    $labelSeriesThemeFinLigne = $tete - 1;

    $tete++;

    $etendu = $labelSeriesThemeFinLigne - $labelSeriesThemeDebutLigne;

    $dataseriesLabel2 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$16', NULL, 1),
    );

    $xAxisTickValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$' . $labelSeriesThemeDebutLigne . ':$D$' . $labelSeriesThemeFinLigne, NULL, $etendu),
    );

    $dataSeriesValues2 = array(
	new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$' . $labelSeriesThemeDebutLigne . ':$E$' . $labelSeriesThemeFinLigne, NULL, $etendu),
    );

    $series2 = new PHPExcel_Chart_DataSeries(
	    PHPExcel_Chart_DataSeries::TYPE_PIECHART, PHPExcel_Chart_DataSeries::GROUPING_STANDARD, range(0, count($dataSeriesValues2) - 1), $dataseriesLabel2, $xAxisTickValues2, $dataSeriesValues2
    );

    $layout2 = new PHPExcel_Chart_Layout();
    $layout2->setShowVal(TRUE);
    $layout2->setShowPercent(TRUE);

    $plotarea2 = new PHPExcel_Chart_PlotArea($layout2, array($series2));
    $legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
    $title2 = new PHPExcel_Chart_Title('Contenu du stage');

    $chart2 = new PHPExcel_Chart(
	    'chart2', $title2, $legend2, $plotarea2, true, 0, NULL, NULL
    );

    $chart2->setTopLeftPosition('I18');
    $chart2->setBottomRightPosition('Q32');

    $sheet->addChart($chart2);

    $sheet->setCellValueByColumnAndRow(1, $tete, 'Type entreprise');

    $temp = $tabCptTypeEntreprise;
    if (sizeof($tabTypeEntreprise) > 0) {
	for ($i = 0; $i < sizeof($tabTypeEntreprise); $i++) {
	    $temp[$tabTypeEntreprise[$i]->getIdentifiantBDD()] ++;
	}
    }

    $sommeType = 0;
    foreach ($temp as $i => $j) {
	$sommeType+=$j;
    }

    $labelSeriesTypeDebutLigne = $tete;

    foreach ($temp as $i => $j) {
	$sheet->setCellValueByColumnAndRow(3, $tete, TypeEntreprise::getTypeEntreprise($i)->getType());
	$sheet->setCellValueByColumnAndRow(4, $tete, $j);
	$sheet->setCellValueByColumnAndRow(6, $tete, round($j / $sommeType * 100, 2) . " %");
	$tete++;
    }

    $labelSeriesTypeFinLigne = $tete - 1;

    $tete++;

    $etendu = $labelSeriesTypeFinLigne - $labelSeriesTypeDebutLigne;

    $dataseriesLabel3 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$' . $labelSeriesTypeDebutLigne, NULL, 1),
    );

    $xAxisTickValues3 = array(
	new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$' . $labelSeriesTypeDebutLigne . ':$D$' . $labelSeriesTypeFinLigne, NULL, $etendu),
    );

    $dataSeriesValues3 = array(
	new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$' . $labelSeriesTypeDebutLigne . ':$E$' . $labelSeriesTypeFinLigne, NULL, $etendu),
    );

    $series3 = new PHPExcel_Chart_DataSeries(
	    PHPExcel_Chart_DataSeries::TYPE_PIECHART, PHPExcel_Chart_DataSeries::GROUPING_STANDARD, range(0, count($dataSeriesValues3) - 1), $dataseriesLabel3, $xAxisTickValues3, $dataSeriesValues3
    );

    $layout3 = new PHPExcel_Chart_Layout();
    $layout3->setShowVal(TRUE);
    $layout3->setShowPercent(TRUE);

    $plotarea3 = new PHPExcel_Chart_PlotArea($layout3, array($series3));
    $legend3 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
    $title3 = new PHPExcel_Chart_Title('Type du stage');

    $chart3 = new PHPExcel_Chart(
	    'chart3', $title3, $legend3, $plotarea3, true, 0, NULL, NULL
    );

    $chart3->setTopLeftPosition('I34');
    $chart3->setBottomRightPosition('Q50');

    $sheet->addChart($chart3);

    $writer = new PHPExcel_Writer_Excel2007($workbook);
    $writer->setIncludeCharts(TRUE);

    $records = 'Statistiques_' . $promo . '_' . $annee . '.xlsx';
    $writer->save("../../documents/statistiques/" . $records);
}

//function getAllStats() {
//	$workbook = new PHPExcel;
//	$sheet = $workbook->getActiveSheet();
//}
?>