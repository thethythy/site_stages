<?php 
$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");

function export(){
	global $db;
	
	$date = date("d-m-Y");


}

$backup = $db."bdd-backup_".$date.".sql.gz";
// Utilise les fonctions système : MySQLdump & GZIP pour générer un backup gzipé
$command = "mysqldump --databases $db -h$host -u$user -p$pass | gzip> $backup";
system($command);
// Démarre la procédure de téléchargement
$taille = filesize($backup);
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: application/gzip");
header("Content-Disposition: attachment; filename=$backup;");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".$taille);
@readfile($backup);
// Supprime le fichier temporaire du serveur
unlink($backup);
?>