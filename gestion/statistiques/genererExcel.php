<?php


$cheminExcel = "frameworks/PHPExcel/Classes/";

include_once($cheminExcel."PHPExcel.php");
include_once($cheminExcel."PHPExcel/Writer/Excel2007.php");

$workbook = new PHPExcel;         

   


function getStatsPromo($annee, $tabEntreprise, $tabTypeEntreprise, $tabThemeStage, $nbEtudiant) {
	$sheet = $workbook->getActiveSheet();

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

	$sheet->setCellValue('B2', 'Statistiques stage '.$promo.' '.$annee);
	$sheet->setCellValue('C4', 'Promotion'.$annee);
	$sheet->setCellValue('E4', 'Totaux');
	$sheet->setCellValue('G4', 'Pourcentages');

	$sheet->setCellValue('B6', 'Nombre d\'étudiants');
	$sheet->setCellValue('C6', $nbEtudiant);
	$sheet->setCellValue('E6', $nbEtudiant);

	$sheet->setCellValue('B8', 'Nombre de soutenances');
	$sheet->setCellValue('C8', $nbSoutenance);
	$sheet->setCellValue('E8', $nbSoutenance);
	
	$sheet->setCellValue('B10', 'Lieu du stage');
	for ($i=10; $i<15; $i++) {
		$sheet->setCellValue(3, $i, $tabEntreprise[$i-10]);
		$sheet->setCellValue(5, $i, $tabEntreprise2[$i-10]); 
	}

	$temp = $tabCptTheme;
	if(sizeof($tabThemeStage)>0) {
		for ($i=0; $i<sizeof($tabThemeStage); $i++){
			$temp[$tabThemeStage[$i]->getIdTheme()]++;
		}
	}

	$sheet->setCellValue('B16', 'Contenu du stage');
	
	$tete=16;
	foreach($temp as $i => $j) {
		$sheet->setCellValue(3, $tete, ThemeDeStage::getThemeDeStage($i)->getTheme());
		$sheet->setCellValue(5, $tete, $j);
		$tete++; 
	}
	$tete++;

	$sheet->setCellValue(2, $tete, 'Type entreprise');

	$temp = $tabCptTypeEntreprise;
	if(sizeof($tabTypeEntreprise)>0) {
		for ($i=0; $i<sizeof($tabTypeEntreprise); $i++){
			$temp[$tabTypeEntreprise[$i]->getIdentifiantBDD()]++;
		}
	}

	foreach($temp as $i => $j) {
		$sheet->setCellValue(3, $tete, TypeEntreprise::getTypeEntreprise($i)->getType());
		$sheet->setCellValue(5, $tete, $j);
		$tete++; 
	}
	$tete++;

	$writer = new PHPExcel_Writer_Excel2007($workbook);

	$records = './Stats_'.$promo.'_'.$annee.'.xlsx';
	                
	$writer->save($records);

	header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition:inline;filename=Stats_'.$promo.'_'.$annee.'.xlsx');
	$writer->save('php://output'); 

}


function getAllStats() {
	

	$workbook = new PHPExcel;         

	$sheet = $workbook->getActiveSheet()


}



?>