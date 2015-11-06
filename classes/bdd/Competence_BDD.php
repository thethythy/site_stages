<?php

class Competence_BDD {

    public static function sauvegarder($competence) {
	global $tab2;
	global $db;
	if ($competence->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab2 VALUES ('" . $competence->getIdentifiantBDD() . "','" . $competence->getNom() . "')";
	    $result = mysql_query($sql, $db);

	    $sql2 = "SELECT LAST_INSERT_ID() AS ID FROM $tab2";
	    $req = mysql_query($sql2);
	    $result = mysql_fetch_assoc($req);
	    return $result['ID'];
	} else {
	    $sql = "UPDATE $tab2 SET nomcompetence='" . $competence->getNom() . "' WHERE idcompetence='" . $competence->getIdentifiant() . "';";
	    $result = mysql_query($sql, $db);
	    return $competence->getIdentifiantBDD();
	}
    }

    public static function getCompetence($identifiantBDD) {
	global $tab2;
	$sql = "SELECT * FROM $tab2 WHERE idcompetence='" . $identifiantBDD . "';";
	$result = mysql_query($sql);
	return mysql_fetch_assoc($result);
    }

    public static function listerCompetences() {
	global $tab2;
	global $db;
	$sql = "SELECT * FROM $tab2 ORDER BY nomcompetence ASC;";
	$result = mysql_query($sql, $db);

	$tabCompetences = array();

	while ($competence = mysql_fetch_assoc($result)) {
	    $tab = array();
	    array_push($tab, $competence["idcompetence"]);
	    array_push($tab, $competence["nomcompetence"]);
	    array_push($tabCompetences, $tab);
	}

	return $tabCompetences;
    }

    public static function delete($identifiant) {
	global $tab2;
	global $db;
	$sql = "DELETE FROM $tab2 WHERE idcompetence='" . $identifiant . "';";
	mysql_query($sql, $db);
    }

}

?>