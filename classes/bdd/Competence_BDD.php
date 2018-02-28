<?php

/**
 * Représentation et accès à la table n°2 : les compétences nécessaires pour une
 * offre de stage
 */

class Competence_BDD {

    /**
     * Sauvegarder en base un objet Competence
     * @global resource $db Une référence sur la base ouverte
     * @global string $tab2 Le nom de la table 'competence'
     * @param Competence $competence Une instance de la classe Competence
     * @return integer L'identifiant de la compétence
     */
    public static function sauvegarder($competence) {
	global $db;
	global $tab2;

	if ($competence->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab2 VALUES ('" . $competence->getIdentifiantBDD() . "','" . $competence->getNom() . "')";
	    $db->query($sql);

	    $sql = "SELECT LAST_INSERT_ID() AS ID FROM $tab2";
	    $res = $db->query($sql);
	    $result = $res->fetch_array();
	    $res->free();
	    return $result['ID'];
	} else {
	    $sql = "UPDATE $tab2 SET nomcompetence='" . $competence->getNom() . "' WHERE idcompetence='" . $competence->getIdentifiantBDD() . "';";
	    $db->query($sql);
	    return $competence->getIdentifiantBDD();
	}
    }

    /**
     * Obtenir un objet Competence à partir de son identifiant
     * @global resource $db Une référence sur la base ouverte
     * @global string $tab2 Le nom de la table 'competence'
     * @param integer $identifiantBDD L'identifiant de la compétence
     * @return enregistrement ou FALSE
     */
    public static function getCompetence($identifiantBDD) {
	global $db;
	global $tab2;

	$sql = "SELECT * FROM $tab2 WHERE idcompetence='" . $identifiantBDD . "';";
	$result = $db->query($sql);

	$ok = $result != FALSE;

	if ($ok) {
	    $enreg = $result->fetch_array();
	    $result->free();
	}

	return $ok ? $enreg : FALSE;
    }

    /**
     * Obtenir la liste de toutes compétences
     * @global resource $db Une référence sur la base ouverte
     * @global string $tab2 Le nom de la table 'competence'
     * @return tableau d'enregistrements
     */
    public static function listerCompetences() {
	global $db;
	global $tab2;

	$sql = "SELECT * FROM $tab2 ORDER BY nomcompetence ASC;";
	$result = $db->query($sql);

	$tabCompetences = array();

	if ($result) {
	    while ($competence = $result->fetch_array()) {
		$tab = array();
		array_push($tab, $competence["idcompetence"]);
		array_push($tab, $competence["nomcompetence"]);
		array_push($tabCompetences, $tab);
	    }
	    $result->free();
	}

	return $tabCompetences;
    }

    /**
     * Supprimer en base l'enregistrement d'une compétence à partir de son identifiant
     *
     * La table relation_competence_offredestage est mise à jour du fait
     * des contraintes d'intégrité relationnelles
     *
     * @global resource $db Une référence sur la base ouverte
     * @global string $tab2 Le nom de la table 'competence'
     * @param integer $identifiant L'identifiant de la compétence
     */
    public static function delete($identifiant) {
	global $db;
	global $tab2;

	$sql = "DELETE FROM $tab2 WHERE idcompetence='" . $identifiant . "';";
	$db->query($sql);
    }

}

?>