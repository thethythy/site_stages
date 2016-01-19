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
	$result = $db->query($sql);
	return ($dateSoutenance->getIdentifiantBDD() != "") ? $dateSoutenance->getIdentifiantBDD() : mysql_insert_id($db);
    }

    public static function sauvegarderRelationPromo($idDateSoutenance, $promos) {
	global $tab1;
	global $db;

	DateSoutenance_BDD::deleteDatePromo($idDateSoutenance);
	foreach ($promos as $promo) {
	    $sql = "INSERT INTO $tab1 (iddatesoutenance, idpromotion) VALUES ('$idDateSoutenance', $promo);";
	    $result = $db->query($sql);
	}
    }

    public static function getDateSoutenance($identifiant) {
	global $tab5;
	global $db;

	$result = array();
	$sql = "SELECT * FROM $tab5 WHERE iddatesoutenance='$identifiant';";
	$req = $db->query($sql);
	return mysqli_fetch_array($req);
    }

    public static function listerDateSoutenance($filtres) {
	global $tab5;
	global $db;

	if ($filtres == '')
	    $sql = "SELECT * FROM $tab5 ORDER BY annee,mois,jour ASC;";
	else
	    $sql = "SELECT * FROM $tab5 WHERE " . $filtres->getStrFiltres() . " ORDER BY annee,mois,jour ASC;";

	//echo $sql;
	$result = $db->query($sql);
	$tabDateSoutenance = array();

	while ($dateSoutenance = mysqli_fetch_array($result)) {
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
	$result = $db->query($sql);

	$tabIdPromo = array();
	while ($idpromo = mysqli_fetch_row($result)) {
	    array_push($tabIdPromo, $idpromo[0]);
	}

	return $tabIdPromo;
    }

    public static function delete($identifiantBDD) {
	global $tab5;
	$sql = "DELETE FROM $tab5 WHERE iddatesoutenance='$identifiantBDD';";
	$result = $db->query($sql);
	  }

    public static function deleteDatePromo($identifiantBDD) {
	global $tab1;
	$sql = "DELETE FROM $tab1 WHERE iddatesoutenance='$identifiantBDD';";
	$result = $db->query($sql);
	  }

}

?>