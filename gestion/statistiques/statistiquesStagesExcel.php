<?php

$cheminExcel = "frameworks/PHPExcel/Classes/";

include_once($cheminExcel . "PHPExcel.php");
include_once($cheminExcel . 'PHPExcel/Cell/AdvancedValueBinder.php');
include_once($cheminExcel . "PHPExcel/Writer/Excel2007.php");

class StatistiquesGenerateurExcel {

    var $chemin_complet;
    var $worksheet;
    var $titre1 = 'B2';
    var $titre2 = 'B3';
    var $rowNomSerie = 5;
    var $colNomSerie = 1; // 'B'
    var $ecart_horiz = 3; // Ecart horizontal entre les séries de données
    var $haut_graph = 15; // Hauteur des graphiques

    public function StatistiquesGenerateurExcel($chemin_complet) {
	$this->chemin_complet = $chemin_complet;

	// Indication de la méthode de stockage en mémoire
	$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
	PHPExcel_Settings::setCacheStorageMethod($cacheMethod);

	// Indication de la langue utilisée
	PHPExcel_Settings::setLocale("fr");

	// Mise en forme automatique
	PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder());
    }

    private function genereTitres($periode) {
	$styleFont = $this->worksheet->getStyle($this->titre1)->getFont();
	$styleFont->setBold(true);
	$styleFont->setSize(16);
	$this->worksheet->setCellValue($this->titre1, 'Statistiques des stages');

	$styleFont = $this->worksheet->getStyle($this->titre2)->getFont();
	$styleFont->setBold(true);
	$styleFont->setSize(14);
	$this->worksheet->setCellValue($this->titre2, 'Période '.$periode);
    }

    private function genereEnteteSeries($data) {
	$nbSeries = $data["nbSerie"];
	$nom_series = "";
	$total = 0;

	// Nom de la série
	for ($index = 1; $index <= $nbSeries; $index++) {
	    if ($index != $nbSeries || $nbSeries == 1) {
		$annee = $data["s" . $index]["annee"];
		$periode = $annee."-".($annee+1);
		$filiere = $data["s" . $index]["filiere"];
		$parcours = $data["s" . $index]["parcours"];
		$nbEtudiants = $data["s" . $index]["Lieu du stage"]["somme"];
		$total += $nbEtudiants;

		$nom = $filiere." ".$parcours." ".$periode." (".$nbEtudiants." étudiants)";

		if (!strpos($nom_series, $filiere."-".$parcours))
		    $nom_series .= "_".$filiere."-".$parcours;
	    } else {
		$nom = "Total"." (".$total." étudiants)";
	    }

	    // Style
	    $coord = PHPExcel_Cell::stringFromColumnIndex($this->colNomSerie + $this->ecart_horiz*($index - 1)) . $this->rowNomSerie;
	    $styleFont = $this->worksheet->getStyle($coord)->getFont();
	    $styleFont->setBold(false);
	    $styleFont->setSize(14);
	    $styleFont->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKGREEN);

	    // Contenu
	    $this->worksheet->setCellValue($coord, $nom);
	}

	return $nom_series;
    }

    private function donneTaillesTableaux($data) {
	$taille_donnees_lieu_stage = $data['s'.$data['nbSerie']]['Lieu du stage']['nbLieu'];
	$taille_donnees_theme_stage = $data['s'.$data['nbSerie']]['Thème du stage']['nbTheme'];
	$taille_donnees_type_entreprise = $data['s'.$data['nbSerie']]["Type d'entreprise"]['nbType'];
	return array($taille_donnees_lieu_stage, $taille_donnees_theme_stage, $taille_donnees_type_entreprise);
    }

    private function genereUneSerie($index, $data, $tailles_tableaux) {
	// Génère données du lieu de stage
	$posFin = $this->genereTableEtGraphique($index, $data["Lieu du stage"], $this->rowNomSerie + 2, "Lieu du stage", $tailles_tableaux[0]);

	// Génère données du thème de stage
	$posFin = $this->genereTableEtGraphique($index, $data["Thème du stage"], $posFin + 2, "Thème de stage", $tailles_tableaux[1]);

	// Génère données du type d'entreprise
	$this->genereTableEtGraphique($index, $data["Type d'entreprise"], $posFin + 2, "Type d'entreprise", $tailles_tableaux[2]);
    }

    private function genereTableEtGraphique($numero, $data, $posDeb, $nomData, $tailleTableau) {

	if ($nomData == "Lieu du stage") {
	    $nbData = "nbLieu";
	    $prefix = 'l';
	}

	if ($nomData == "Thème de stage") {
	    $nbData = "nbTheme";
	    $prefix = 't';
	}

	if ($nomData == "Type d'entreprise") {
	    $nbData = "nbType";
	    $prefix = 'e';
	}

	// Ajoute le titre des données
	// ---------------------------

	if ($numero == 1) {
	    $coord = PHPExcel_Cell::stringFromColumnIndex($this->colNomSerie).$posDeb;
	    $styleFont = $this->worksheet->getStyle($coord)->getFont();
	    $styleFont->setSize(14);
	    $styleFont->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
	    $this->worksheet->setCellValueByColumnAndRow($this->colNomSerie, $posDeb, $nomData);
	}

	// Ajoute les données
	// ----------------------------
	$posDeb += 2;

	for ($index = 1; $index <= $data[$nbData]; $index++) {
	    $nom = $data[$prefix.$index]['nom'];
	    $nombre = $data[$prefix.$index]['nombre'];

	    // La catégorie
	    $column = PHPExcel_Cell::stringFromColumnIndex($this->colNomSerie + $this->ecart_horiz*($numero - 1));
	    $this->worksheet->getColumnDimension($column)->setAutoSize(true);
	    $coord = $column.($posDeb + $index - 1);
	    $this->worksheet->setCellValue($coord, $nom);

	    // Le pourcentage
	    $coord = PHPExcel_Cell::stringFromColumnIndex($this->colNomSerie + $this->ecart_horiz*($numero - 1) + 1).($posDeb + $index - 1);
	    $this->worksheet->setCellValue($coord, round($nombre / $data['somme'] * 100, 0) . " %");
	    $this->worksheet->getStyle($coord)->getNumberFormat() ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
	}

	// Ajoute le donut
	// -------------------

	// Label principal
	$column = PHPExcel_Cell::stringFromColumnIndex($this->colNomSerie);
	$zone = 'Statistiques!$'.$column.'$'.($posDeb - 2);
	$dataseriesLabels = array(new PHPExcel_Chart_DataSeriesValues('String', $zone, NULL, 1));

	// Echelle des données
	$column = PHPExcel_Cell::stringFromColumnIndex($this->colNomSerie + $this->ecart_horiz*($numero - 1));
	$zone = 'Statistiques!$'.$column.'$'.$posDeb.':$'.$column.'$'.($posDeb + $data[$nbData]);
	$xAxisTickValues = array(new PHPExcel_Chart_DataSeriesValues('String', $zone, NULL, $data[$nbData]));

	// Données
	$column = PHPExcel_Cell::stringFromColumnIndex($this->colNomSerie + $this->ecart_horiz*($numero - 1) + 1);
	$zone = 'Statistiques!$'.$column.'$'.$posDeb.':$'.$column.'$'.($posDeb + $data[$nbData]);
	$dataSeriesValues = array(new PHPExcel_Chart_DataSeriesValues('Number', $zone, NULL, $data[$nbData]));

	// Série
	$series = new PHPExcel_Chart_DataSeries(
		PHPExcel_Chart_DataSeries::TYPE_DONUTCHART,	// plotType
		PHPExcel_Chart_DataSeries::GROUPING_STANDARD,	// plotGrouping
		range(0, count($dataSeriesValues)-1),		// plotOrder
		$dataseriesLabels,				// plotLabel
		$xAxisTickValues,				// plotCategory
		$dataSeriesValues				// plotValues
	);

	// Mise en forme
	$layout = new PHPExcel_Chart_Layout();
	$layout->setShowVal(TRUE);

	// Création du graphique
	$plotarea = new PHPExcel_Chart_PlotArea($layout, array($series));
	$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
	$title = new PHPExcel_Chart_Title(NULL);
	$chart = new PHPExcel_Chart(
		'chart',	// name
		$title,		// title
		$legend,	// legend
		$plotarea,	// plotArea
		false,		// plotVisibleOnly
		0,		// displayBlanksAs
		NULL,		// xAxisLabel
		NULL		// yAxisLabel
	);

	// Position du graphique
	$coord = PHPExcel_Cell::stringFromColumnIndex($this->colNomSerie + $this->ecart_horiz*($numero - 1)).($posDeb + $tailleTableau + 1);
	$chart->setTopLeftPosition($coord);
	$coord = PHPExcel_Cell::stringFromColumnIndex($this->colNomSerie + $this->ecart_horiz*($numero - 1) + $this->ecart_horiz - 1).($posDeb + $tailleTableau + 1 + $this->haut_graph - 1);
	$chart->setBottomRightPosition($coord);

	// Add the chart to the worksheet
	$this->worksheet->addChart($chart);

	return $posDeb + $tailleTableau + $this->haut_graph;
    }

    public function genereFichierExcel($data) {
	// Période
	//$annee_fin = $data['annee_fin'] + 1;
	$periode = $data['annee_deb'] . "-".($data['annee_fin'] + 1);

	// Nouveau workbook et son worksheet
	$workbook = new PHPExcel();
	$workbook->getProperties()->setCreator("Responsable des stages");
	$workbook->getProperties()->setLastModifiedBy("Responsable des stages");
	$workbook->getProperties()->setManager("Responsable des stages");
	$workbook->getProperties()->setTitle("Statistiques ".$periode);
	$workbook->getProperties()->setSubject("Statistiques sur la période ".$periode);
	$workbook->getProperties()->setDescription("Statisques sur le lieu du stage, le thème du stage et le type d'entreprise.");
	$workbook->getProperties()->setCategory("Gestion des stages");
	$workbook->getProperties()->setKeywords("stage statistique");
	$workbook->getProperties()->setCompany("Département informatique - Institut Informatique Claude Chappe");
	$this->worksheet = $workbook->getActiveSheet();
	$this->worksheet->setTitle("Statistiques");

	// Valeurs par défaut
	$this->worksheet->getDefaultStyle()->getFont()->setName('Arial');
	$this->worksheet->getDefaultColumnDimension()->setWidth(8);
	$this->worksheet->getDefaultRowDimension()->setRowHeight(17);

	// Ajoute les titres
	$this->genereTitres($periode);

	// Ajoute l'entête des séries
	$nom_series = $this->genereEnteteSeries($data);

	// Ajoute les séries
	$tailles_tableaux = $this->donneTaillesTableaux($data);
	for ($index = 1; $index <= $data['nbSerie']; $index++) {
	    $this->genereUneSerie($index, $data["s".$index], $tailles_tableaux);
	}

	// Ecrire le workbook dans le fichier
	$writer = new PHPExcel_Writer_Excel2007($workbook);
	$writer->setIncludeCharts(TRUE);
	$records = 'statistiques_' . $periode . $nom_series .'.xlsx';
	$writer->save($this->chemin_complet . "/" . $records);

	// Vider la mémoire
	$workbook->disconnectWorksheets();
	unset($workbook);
    }

}

?>