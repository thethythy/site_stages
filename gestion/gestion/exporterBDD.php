<?php

/**
 * Page exporterBDD.php
 * Utilisation : page d'exportation du schéma et des données de la base
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion des stages');

IHM_Generale::header("Exporter la ", "base de données", "../../", $tabLiens);

/**
 * Exporter dans un fichier le schéma de la base de données ainsi que les données
 * @global resource $db Référence sur la base de données ouverte
 */
function export() {
    global $db;

    $creations = "";
    $insertions = "\n\n";
    $date = date("Y-m-d");

    $path = "../../documents/exportations/";
    $backupName = $path . "base_stage_" . $date . ".sql";
    $zipName = $path . "base_stage_" . $date . ".sql.zip";

    $listeTables = $db->query("SHOW TABLES");
    while ($table = $listeTables->fetch_array()) {

	$creations .= "-- -----------------------------\n";
	$creations .= "-- creation de la table " . $table[0] . "\n";
	$creations .= "-- -----------------------------\n";

	$listeCreationTable = $db->query("SHOW CREATE TABLE " . $table[0]);

	while ($creationTable = $listeCreationTable->fetch_array())
	    $creations .= $creationTable[1] . ";\n\n";

	echo "Script pour la création de la table: $table[0]<br/>";

	$insertions .= "-- -----------------------------\n";
	$insertions .= "-- insertions dans la table " . $table[0] . "\n";
	$insertions .= "-- -----------------------------\n";

	$donnees = $db->query("SELECT * FROM " . $table[0]);

	while ($nuplet = $donnees->fetch_array()) {
	    $insertions .= "INSERT INTO " . $table[0] . " VALUES(";
	    for ($i = 0; $i < $donnees->field_count; $i++) {
		if ($i != 0) {
		    $insertions .= ", ";
		}

		$insertions .= "'";
		$insertions .= addslashes($nuplet[$i]);
		$insertions .= "'";
	    }
	    $insertions .= ");\n";
	}
	$insertions .= "\n";

	echo "Script pour l'insertion de données dans la table: $table[0]<br/>";
    }

    $zip = new ZipArchive();

    if ($zip->open($zipName, ZipArchive::CREATE) !== TRUE) {
	echo "Impossible d'ouvrir le fichier <$zipName>";
    } else {
	$backup = fopen($backupName, "wb");
	fwrite($backup, $creations);
	fwrite($backup, $insertions);

	$zip->addFile($backupName);
	fclose($backup);
	$zip->close();

	@unlink($backupName);
	echo "La sauvegarde est terminée [$backupName].";
    }
    printf("<div><a href='../../gestion/index.php'>Retour</a></div>");
}

export();
deconnexion();

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>
