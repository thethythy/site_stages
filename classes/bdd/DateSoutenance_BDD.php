<?php

class DateSoutenance_BDD {
    /*     * Méthodes statiques* */

    public static function sauvegarder($dateSoutenance) {
	global $tab5;
	global $db;
	if ($dateSoutenance->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab5 VALUES ('" . $dateSoutenance->getIdentifiantBDD() . "', '" . $dateSoutenance->getJour() . "','" . $dateSoutenance->getMois() . "','" . $dateSoutenance->getAnnee() . "')";
	} else {
	    $sql = "UPDATE $tab5 SET jour='" . $dateSoutenance->getJour() . "', mois='" . $dateSoutenance->getMois() . "', annee='" . $dateSoutenance->getAnnee() . "'
		    WHERE iddatesoutenance=" . $dateSoutenance->getIdentifiantBDD();
	}
	$result = mysql_query($sql, $db);
	return ($dateSoutenance->getIdentifiantBDD() != "") ? $dateSoutenance->getIdentifiantBDD() : mysql_insert_id($db);
    }

    public static function sauvegarderRelationPromo($idDateSoutenance, $promos) {
	global $tab1;
	global $db;

	DateSoutenance_BDD::deleteDatePromo($idDateSoutenance);
	foreach ($promos as $promo) {
	    $sql = "INSERT INTO $tab1 (iddatesoutenance, idpromotion) VALUES ('$idDateSoutenance', $promo);";
	    $result = mysql_query($sql, $db);
	}
    }

    public static function getDateSoutenance($identifiant) {
	global $tab5;
	global $db;

	$result = array();
	$sql = "SELECT * FROM $tab5 WHERE iddatesoutenance='$identifiant';";
	$req = mysql_query($sql, $db);
	return mysql_fetch_array($req);
    }

    public static function listerDateSoutenance($filtres) {
	global $tab5;
	global $db;

	if ($filtres == '')
	    $sql = "SELECT * FROM $tab5 ORDER BY annee,mois,jour ASC;";
	else
	    $sql = "SELECT * FROM $tab5 WHERE " . $filtres->getStrFiltres() . " ORDER BY annee,mois,jour ASC;";

	//echo $sql;
	$result = mysql_query($sql, $db);
	$tabDateSoutenance = array();

	while ($dateSoutenance = mysql_fetch_assoc($result)) {
	    $tab = array();
	    array_push($tab, $dateSoutenance["iddatesoutenance"]);
	    array_push($tab, $dateSoutenance["jour"]);
	    array_push($tab, $dateSoutenance["mois"]);
	    array_push($tab, $dateSoutenance["annee"]);
	    array_push($tabDateSoutenance, $tab);
	}

	return $tabDateSoutenance;
    }

    public static function listerRelationPromoDate($idDate) {
	global $tab1;
	global $db;

	$sql = "SELECT idpromotion,iddatesoutenance FROM $tab1 WHERE iddatesoutenance='$idDate';";
	$result = mysql_query($sql, $db);

	$tabIdPromo = array();
	while ($idpromo = mysql_fetch_row($result)) {
	    array_push($tabIdPromo, $idpromo[0]);
	}

	return $tabIdPromo;
    }

    public static function delete($identifiantBDD) {
	global $tab5;
	$sql = "DELETE FROM $tab5 WHERE iddatesoutenance='$identifiantBDD';";
	$result = mysql_query($sql);
    }

    public static function deleteDatePromo($identifiantBDD) {
	global $tab1;
	$sql = "DELETE FROM $tab1 WHERE iddatesoutenance='$identifiantBDD';";
	$result = mysql_query($sql);
    }

}

?>