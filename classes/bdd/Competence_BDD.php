<?php

class Competence_BDD {

    /**
     * Sauvegarder en base un objet Competence
     * @global string $tab2 Le nom de la table 'competence'
     * @global resource $db Une référence sur la base ouverte
     * @param Competence $competence Une instance de la classe Competence
     * @return integer L'identifiant de la compétence
     */
    public static function sauvegarder($competence) {
	global $tab2;
	global $db;
	if ($competence->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab2 VALUES ('" . $competence->getIdentifiantBDD() . "','" . $competence->getNom() . "')";
	    $db->query($sql);

	    $sql2 = "SELECT LAST_INSERT_ID() AS ID FROM $tab2";
	    $req = $db->query($sql2);
	    $result = mysqli_fetch_array($req);
	    return $result['ID'];
	} else {
	    $sql = "UPDATE $tab2 SET nomcompetence='" . $competence->getNom() . "' WHERE idcompetence='" . $competence->getIdentifiantBDD() . "';";
	    $db->query($sql);
	    return $competence->getIdentifiantBDD();
	}
    }

    public static function getCompetence($identifiantBDD) {
	global $tab2;
	global $db;
	$sql = "SELECT * FROM $tab2 WHERE idcompetence='" . $identifiantBDD . "';";
	$result = $db->query($sql);
	return mysqli_fetch_array($result);
    }

    public static function listerCompetences() {
	global $tab2;
	global $db;
	$sql = "SELECT * FROM $tab2 ORDER BY nomcompetence ASC;";
	$result = $db->query($sql);

	$tabCompetences = array();

	while ($competence = mysqli_fetch_array($result)) {
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
	$db->query($sql);
    }

}

?>