<?php

/**
 * Représentation et accès à la table n°35 : mémoriser l'affectation
 * du suivi d'alternance aux enseignants
 */

class Affectation_BDD {

    /**
     * Sauvegarder un nouvel objet ou mise à jour d'un objet existant
     * @global resource $db
     * @global string $tab35
     * @param Affectation $affectation
     * @return FALSE ou identifiant de l'objet en base
     */
    public static function sauvegarder($affectation) {
	global $db;
	global $tab35;

	if ($affectation->getIdentifiantBDD() == '') {
	    $sql = "INSERT INTO $tab35 VALUES ('', '" . $affectation->getEnvoi() . "', '". $affectation->getIdContrat() ."');";
	} else {
	    $sql = "UPDATE $tab35 SET envoi='" . $affectation->getEnvoi() . "', idcontrat='" . $affectation->getIdContrat() . "'
		    WHERE idaffectation=" . $affectation->getIdentifiantBDD() . ";";
	}
	$res = $db->query($sql);

	if ($res)
	    return ($affectation->getIdentifiantBDD() != '') ? $affectation->getIdentifiantBDD() : $db->insert_id;
	else
	    return FALSE;
    }

    /**
     * Supprimer un enregistrement donné par son identifiant
     * @global resource $db
     * @global string $tab35
     * @param integer $idaffectation
     * @return boolean Résultat de la requête
     */
    public static function supprimer($idaffectation) {
	global $db;
	global $tab35;

	$sql = "DELETE FROM $tab35 WHERE idaffectation=$idaffectation;";
	return $db->query($sql);
    }

    /**
     * Rechercher un enregistrement à partir de son identifiant
     * @global resource $db
     * @global string $tab35
     * @param integer $idaffectation
     * @return FALSE ou enregistrement
     */
    public static function getAffectation($idaffectation) {
	global $db;
	global $tab35;

	$sql = "SELECT * FROM $tab35 WHERE idaffectation='$idaffectation';";
	$res = $db->query($sql);

	$ok = $res != FALSE;

	if ($ok) {
	    $enreg = $res->fetch_array();
	    $res->free();
	}

	return $ok ? $enreg : FALSE;
    }

    /**
     * Rechercher un enregistrement à partir du contrat
     * @global resource $db
     * @global string $tab35
     * @param integer $idcontrat
     * @return FALSE ou enregistrement
     */
    public static function getAffectationFromContrat($idcontrat) {
	global $db;
	global $tab35;

	$sql = "SELECT * FROM $tab35 WHERE idcontrat = $idcontrat;";
	$res = $db->query($sql);

	$ok = $res != FALSE;

	if ($ok) {
	    $enreg = $res->fetch_array();
	    $res->free();
	}

	return $ok ? $enreg : FALSE;
    }

    /**
     * Rechercher les enregistrements à partir de la promotion
     * @global resource $db
     * @global string $tab15
     * @global string $tab31
     * @global string $tab32
     * @global string $tab35
     * @param integer $annee L'année de la promotion
     * @param integer $idparcours Identifiant du parcours
     * @param integer $idfiliere Identifiant de la filière
     * @return tableau d'enregistrements
     */
    public static function getListeAffectationFromPromotion($annee, $idparcours, $idfiliere) {
	global $db;
	global $tab15;
	global $tab31;
	global $tab32;
	global $tab35;

	$requete = "SELECT * FROM $tab35 WHERE idcontrat IN
		    (SELECT $tab31.idcontrat FROM $tab31, $tab32, $tab15
			WHERE anneeuniversitaire = $annee AND
			      idparcours = $idparcours AND
			      idfiliere = $idfiliere AND
			      $tab15.idpromotion = $tab32.idpromotion AND
			      $tab32.idcontrat = $tab31.idcontrat);";

	$result = $db->query($requete);

	$tabA = array();

	if ($result) {
	    while ($ods = $result->fetch_array()) {
		$tab = array();
		array_push($tab, $ods['idaffectation']);
		array_push($tab, $ods['envoi']);
		array_push($tab, $ods['idcontrat']);

		array_push($tabA, $tab);
	    }
	    $result->free();
	}

	return $tabA;
    }

}

?>
