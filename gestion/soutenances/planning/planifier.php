<?php

/**
 * Page planifier.php
 * Utilisation : page pour planifier les soutenances de stage
 * Dépendance(s) : planifier_compresse.js --> affichage et gestion des interactions
 * Accès : restreint par authentification HTTP
 */

include_once("../../../classes/bdd/connec.inc");

include_once('../../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level3');

$tabLiens = array();
$tabLiens[0] = array('../../../', 'Accueil');
$tabLiens[1] = array('../../', 'Gestion de la base');

IHM_Generale::header("Planifier les ", "soutenances", "../../../", $tabLiens, "planifieur");

// Affichage du formulaire de sélection
Promotion_IHM::afficherFormulaireSelectionAnnee(true);

// Affichage de l'arborescence et du planning
echo "<br/>";
echo "<div id='dhtmlxtree'></div>\n";
echo "<div id='dhtmlxscheduler' class='dhx_cal_container'>\n
		<div class='dhx_cal_navline' id='identpourajax'>\n
			<div class='dhx_cal_prev_button' style='display:none;'>&nbsp;</div>\n
			<div class='dhx_cal_next_button' style='display:none;'>&nbsp;</div>\n
			<div class='dhx_cal_today_button' style='display:none;'></div>\n
			<div class='dhx_cal_date' style='display:none;'></div>\n
			<div class='dhx_cal_tab' name='day_tab' style='right:204px; display:none;'></div>\n
			<div class='dhx_cal_tab' name='week_tab' style='right:140px; display:none;'></div>\n
			<div class='dhx_cal_tab' name='month_tab' style='right:76px; display:none;'></div>\n
		</div>\n
		<div class='dhx_cal_header'></div>\n
		<div class='dhx_cal_data'></div>\n
	</div>\n";
echo "<div id='logline'></div>\n";

// Création de la liste des salles
$salles = Salle::listerSalle();
echo "<script type='text/javascript'>var salles=[";
for ($i = 0; $i < sizeof($salles); $i++)
	echo "{key:".$salles[$i]->getIdentifiantBDD().", label:'".$salles[$i]->getNom()."'},";
echo "];</script>\n";

// Création de la liste des temps de soutenances selon les filieres
$filieres = Filiere::listerFilieres();
echo "<script type='text/javascript'>var temps_soutenances=[";
for ($i = 0; $i < sizeof($filieres); $i++)
	echo "{key:".$filieres[$i]->getIdentifiantBDD().", temps:'".$filieres[$i]->getTempsSoutenance()."'},";
echo "];</script>\n";

// Chargement des traitements (affichage et contrôle) liées à la planification
echo "<script type='text/javascript' src='planifier_compresse.js'></script>\n";

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../../");

?>