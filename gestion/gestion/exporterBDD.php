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

    $creations = "";
    $insertions = "\n\n";
    $date = date("Y-m-d");

    $path = "../../telechargements/";
    $backupName = $path."base_stage_".$date.".sql";
    $zipName = $path."base_stage_".$date.".sql.zip";
 
    $listeTables = $db->query("SHOW TABLES");
    while($table = mysqli_fetch_array($listeTables)){

    	$creations .= "-- -----------------------------\n";
        $creations .= "-- creation de la table ".$table[0]."\n";
        $creations .= "-- -----------------------------\n";
        $listeCreationsTables = $db->query("SHOW CREATE TABLE ".$table[0]);

        while($creationTable = mysqli_fetch_array($listeCreationsTables))
        	$creations .= $creationTable[1].";\n\n";

        $donnees = $db->query("SELECT * FROM ".$table[0]);
        $insertions .= "-- -----------------------------\n";
        $insertions .= "-- insertions dans la table ".$table[0]."\n";
        $insertions .= "-- -----------------------------\n";

        while($nuplet = mysqli_fetch_array($donnees)){
            $insertions .= "INSERT INTO ".$table[0]." VALUES(";
            for($i=0; $i < mysqli_num_fields($donnees); $i++){
            	if($i != 0)
            		$insertions .=  ", ";

            	$insertions .=  "'";
            	$insertions .= addslashes($nuplet[$i]);
            	$insertions .=  "'";
            }
            $insertions .=  ");\n";
        }
        $insertions .= "\n";
    }

	$zip = new ZipArchive();

	if ($zip->open($zipName, ZipArchive::CREATE)!==TRUE){
	    echo "Impossible d'ouvrir le fichier <$zipName>";
	}
    else{
        $backup = fopen($backupName, "wb");
        fwrite($backup, utf8_encode($creations));
        fwrite($backup, utf8_encode($insertions));

        $zip->addFile($backupName);
        fclose($backup);
        $zip->close();

        @unlink($backupName);
        echo "La sauvegarde est terminée.";
    }  
    printf("<div><a href='../../gestion/index.php'>Retour</a></div>");
}

export();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");
?>

