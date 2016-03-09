<?php


$cheminExcel = "frameworks/PHPExcel/Classes/";

include_once($cheminExcel."PHPExcel.php");
include_once($cheminExcel."PHPExcel/Writer/Excel2007.php");
   



function getStatsPromo($annee, $promo, $convention, $tabTypeEntreprise, $tabCptTypeEntreprise, $tabThemeStage, $tabCptTheme, $nbEtudiant, $nbSoutenance) {
	
	$workbook = new PHPExcel; 
     
	$sheet = $workbook->getActiveSheet();
	
	$tabEntreprise = lieuDuStage($convention);

	$sheet->setCellValue('B2', 'Statistiques stage '.$promo.' '.$annee);
	$sheet->setCellValue('C4', 'Promotion'.$annee);
	$sheet->setCellValue('E4', 'Totaux');
	$sheet->setCellValue('G4', 'Pourcentages');

	$sheet->setCellValue('B6', 'Nombre d\'etudiants');
	$sheet->setCellValue('C6', $nbEtudiant);
	$sheet->setCellValue('E6', $nbEtudiant);

	$sheet->setCellValue('B8', 'Nombre de soutenances');
	$sheet->setCellValue('C8', $nbSoutenance);
	$sheet->setCellValue('E8', $nbSoutenance);
	
	$sheet->setCellValue('B10', 'Lieu du stage');
	

	$tete = 10;
	$sommeEntreprise = array_sum($tabEntreprise);
	foreach($tabEntreprise as $i => $j) {
		$sheet->setCellValueByColumnAndRow(3, $tete, $i);
		$sheet->setCellValueByColumnAndRow(4, $tete, $j);
		$sheet->setCellValueByColumnAndRow(6, $tete, round($j/$sommeEntreprise*100, 2)." %");
		$tete++;
	}

	$temp = $tabCptTheme;
	if(sizeof($tabThemeStage)>0) {
		for ($i=0; $i<sizeof($tabThemeStage); $i++){
			$temp[$tabThemeStage[$i]->getIdTheme()]++;
		}
	}

	$sheet->setCellValue('C16', 'Contenu du stage');

	$tete=16;
	$sommeTheme = 0;
	foreach($temp as $i => $j) {
		$sommeTheme+=$j;
	}
	
	foreach($temp as $i => $j) {
		$sheet->setCellValueByColumnAndRow(3, $tete, ThemeDeStage::getThemeDeStage($i)->getTheme());
		$sheet->setCellValueByColumnAndRow(4, $tete, $j);
		$sheet->setCellValueByColumnAndRow(6, $tete, round($j/$sommeTheme*100, 2)." %");
		$tete++; 
	}
	$tete++;

	$sheet->setCellValueByColumnAndRow(2, $tete, 'Type entreprise');

	$temp = $tabCptTypeEntreprise;
	if(sizeof($tabTypeEntreprise)>0) {
		for ($i=0; $i<sizeof($tabTypeEntreprise); $i++){
			$temp[$tabTypeEntreprise[$i]->getIdentifiantBDD()]++;
		}
	}

	$sommeType = 0;
	foreach($temp as $i => $j) {
		$sommeType+=$j;
	}
	foreach($temp as $i => $j) {
		$sheet->setCellValueByColumnAndRow(3, $tete, TypeEntreprise::getTypeEntreprise($i)->getType());
		$sheet->setCellValueByColumnAndRow(4, $tete, $j);
		$sheet->setCellValueByColumnAndRow(6, $tete, round($j/$sommeType*100, 2)." %");
		$tete++; 
	}
	$tete++;
	
	

	$writer = new PHPExcel_Writer_Excel2007($workbook);

	$records = 'Statistiques_'.$promo.'_'.$annee.'.xlsx';
	                
	$writer->save("../../documents/statistiques/".$records);

	
	/*header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition:inline;filename=Stats_'.$promo.'_'.$annee.'.xlsx');
	$writer->save('php://output'); */
	

}


function getAllStats() {
	

	$workbook = new PHPExcel;         

	$sheet = $workbook->getActiveSheet();


}



?>