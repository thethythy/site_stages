<?php

/**
 * Classe StatistiquesGenerateurExcel : exportation des statistiques des alternances en fichier Excel
 */

$cheminExcel = "frameworks/PHPExcel/Classes/";

include_once($cheminExcel . "PHPExcel.php");
include_once($cheminExcel . 'PHPExcel/Cell/AdvancedValueBinder.php');
include_once($cheminExcel . "PHPExcel/Writer/Excel2007.php");

class StatistiquesGenerateurExcel {

    var $chemin_complet;  // Chemin d'exportation du fichier Excel
    var $worksheet;  // La page Excel utilisée
    var $titre1 = 'B2';  // Cellule du titre général
    var $titre2 = 'B3';  // Cellule du sous-titre
    var $rowNomSerie = 5; // Numéro de ligne du début des séries
    var $colNomSerie = 1;  // 'B'
    var $ecart_horiz = 3;  // Ecart horizontal entre les séries de données
    var $haut_graph = 15;  // Hauteur des graphiques

    /**
     * Constructeur
     * @param string $chemin_complet Chemin d'exportation du fichier Excel
     */
    public function __construct($chemin_complet) {
	$this->chemin_complet = $chemin_complet;

	// Indication de la méthode de stockage en mémoire
	$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
	PHPExcel_Settings::setCacheStorageMethod($cacheMethod);

	// Indication de la langue utilisée
	PHPExcel_Settings::setLocale("fr");

	// Mise en forme automatique
	PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder());
    }

    /**
     * Générer les titres du document
     * @param type $periode
     */
    private function genereTitres($periode) {
	$styleFont = $this->worksheet->getStyle($this->titre1)->getFont();
	$styleFont->setBold(true);
	$styleFont->setSize(16);
	$this->worksheet->setCellValue($this->titre1, 'Statistiques des alternances');

	$styleFont = $this->worksheet->getStyle($this->titre2)->getFont();
	$styleFont->setBold(true);
	$styleFont->setSize(14);
	$this->worksheet->setCellValue($this->titre2, 'Période '.$periode);
    }

    /**
     * Générer l'entête des séries
     * @param array $data
     * @return string
     */
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
		$nbEtudiants = $data["s" . $index]["Lieu de l alternance"]["somme"];
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

    /**
     * Obtenir le nombre de lignes des 3 séries
     * @param array $data
     * @return array
     */
    private function donneTaillesTableaux($data) {
	$taille_donnees_lieu_alternance = $data['s'.$data['nbSerie']]['Lieu de l alternance']['nbLieu'];
	$taille_donnees_theme_alternance = $data['s'.$data['nbSerie']]['Thème de l alternance']['nbTheme'];
	$taille_donnees_type_entreprise = $data['s'.$data['nbSerie']]["Type d'entreprise"]['nbType'];
	return array($taille_donnees_lieu_alternance, $taille_donnees_theme_alternance, $taille_donnees_type_entreprise);
    }

    /**
     * Générer le tableau et le graphique pour chaque type de statistique
     * @param integer $numero
     * @param array $data
     * @param integer $posDeb
     * @param string $nomData
     * @param integer $tailleTableau
     * @return integer
     */
    private function genereTableEtGraphique($numero, $data, $posDeb, $nomData, $tailleTableau) {

	if ($nomData == "Lieu de l alternance") {
	    $nbData = "nbLieu";
	    $prefix = 'l';
	}

	if ($nomData == "Thème de l alternance") {
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

    /**
     * Générer une série de statistique
     * @param integer $index
     * @param array $data
     * @param integer $tailles_tableaux
     */
    private function genereUneSerie($index, $data, $tailles_tableaux) {
	// Génère données du lieu de l alternance
	$posFin = $this->genereTableEtGraphique($index, $data["Lieu de l alternance"], $this->rowNomSerie + 2, "Lieu de l alternance", $tailles_tableaux[0]);

	// Génère données du thème de l alternance
	$posFin = $this->genereTableEtGraphique($index, $data["Thème de l alternance"], $posFin + 2, "Thème de l alternance", $tailles_tableaux[1]);

	// Génère données du type d'entreprise
	$this->genereTableEtGraphique($index, $data["Type d'entreprise"], $posFin + 2, "Type d'entreprise", $tailles_tableaux[2]);
    }

    /**
     * Générer le fichier Excel complet
     * @param array $data
     */
    public function genereFichierExcel($data) {
	// Période
	//$annee_fin = $data['annee_fin'] + 1;
	$periode = $data['annee_deb'] . "-".($data['annee_fin'] + 1);

	// Nouveau workbook et son worksheet
	$workbook = new PHPExcel();
	$workbook->getProperties()->setCreator("Responsable des alternances");
	$workbook->getProperties()->setLastModifiedBy("Responsable des alternances");
	$workbook->getProperties()->setManager("Responsable des alternances");
	$workbook->getProperties()->setTitle("Statistiques ".$periode);
	$workbook->getProperties()->setSubject("Statistiques sur la période ".$periode);
	$workbook->getProperties()->setDescription("Statisques sur le lieu de l alternance, le thème de l alternance et le type d'entreprise.");
	$workbook->getProperties()->setCategory("Gestion des alternances");
	$workbook->getProperties()->setKeywords("alternance statistique");
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
