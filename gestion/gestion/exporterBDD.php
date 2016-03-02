<?php 
$chemin = "../../classes/";
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin . "bdd/connec.inc");
$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Exportation de la base');

IHM_Generale::header("Exporter la ", "base de données", "../../", $tabLiens);


function export(){
	global $db;
	global $tab23;
	
	$date = date("Y-m-d");
	$backup = "../../telechargements/base_stage_".$date.".sql.zip";
	$tabulation = "\t";
	$retour = "\n";

	$sql = "SELECT * INTO OUTFILE $backup 
				FIELDS TERMINATED BY ".$tabulation." LINES TERMINATED BY ".$retour." 
				FROM $tab23";

	if($db->query($sql))
		echo "Success !";
	echo "$sql";
}

export();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>