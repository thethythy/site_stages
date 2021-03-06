<?php

/**
 * Représentation et accès à la table n°25 : mémoriser la notification
 * des attributions des conventions aux enseignants
 */

class Attribution_BDD {

    /**
     * Sauvegarder un nouvel objet ou mise à jour d'un objet existant
     * @global resource $db
     * @global string $tab25
     * @param Attribution $attribution
     * @return FALSE ou identifiant de l'objet en base
     */
    public static function sauvegarder($attribution) {
	global $db;
	global $tab25;

	if ($attribution->getIdentifiantBDD() == '') {
	    $sql = "INSERT INTO $tab25 VALUES ('', '" . $attribution->getEnvoi() . "', '". $attribution->getIdconvention() ."');";
	} else {
	    $sql = "UPDATE $tab25 SET envoi='" . $attribution->getEnvoi() . "', idconvention='" . $attribution->getIdconvention() . "'
		    WHERE idattribution=" . $attribution->getIdentifiantBDD() . ";";
	}
	$res = $db->query($sql);

	if ($res)
	    return ($attribution->getIdentifiantBDD() != '') ? $attribution->getIdentifiantBDD() : $db->insert_id;
	else
	    return FALSE;
    }

    /**
     * Supprimer un enregistrement donné par son identifiant
     * @global resource $db
     * @global string $tab25
     * @param integer $idattribution
     * @return boolean Résultat de la requête
     */
    public static function supprimer($idattribution) {
	global $db;
	global $tab25;

	$sql = "DELETE FROM $tab25 WHERE idattribution=$idattribution;";
	return $db->query($sql);
    }

    /**
     * Rechercher un enregistrement à partir de son identifiant
     * @global resource $db
     * @global string $tab25
     * @param integer $idattribution
     * @return FALSE ou enregistrement
     */
    public static function getAttribution($idattribution) {
	global $db;
	global $tab25;

	$sql = "SELECT * FROM $tab25 WHERE idattribution='$idattribution';";
	$res = $db->query($sql);

	$ok = $res != FALSE;

	if ($ok) {
	    $enreg = $res->fetch_array();
	    $res->free();
	}

	return $ok ? $enreg : FALSE;
    }

    /**
     * Rechercher un enregistrement à partir de la convention
     * @global resource $db
     * @global string $tab25
     * @param integer $idconvention
     * @return FALSE ou enregistrement
     */
    public static function getAttributionFromConvention($idconvention) {
	global $db;
	global $tab25;

	$sql = "SELECT * FROM $tab25 WHERE idconvention = $idconvention;";
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
     * @global string $tab4
     * @global string $tab15
     * @global string $tab19
     * @global string $tab25
     * @param integer $annee L'année de la promotion
     * @param integer $idparcours Identifiant du parcours
     * @param integer $idfiliere Identifiant de la filière
     * @return tableau d'enregistrements
     */
    public static function getListeAttributionFromPromotion($annee, $idparcours, $idfiliere) {
	global $db;
	global $tab4;
	global $tab15;
	global $tab19;
	global $tab25;

	$requete = "SELECT * FROM $tab25 WHERE idconvention IN
		    (SELECT $tab4.idconvention FROM $tab4, $tab19, $tab15
			WHERE anneeuniversitaire = $annee AND
			      idparcours = $idparcours AND
			      idfiliere = $idfiliere AND
			      $tab15.idpromotion = $tab19.idpromotion AND
			      $tab19.idconvention = $tab4.idconvention);";

	$result = $db->query($requete);

	$tabA = array();

	if ($result) {
	    while ($ods = $result->fetch_array()) {
		$tab = array();
		array_push($tab, $ods['idattribution']);
		array_push($tab, $ods['envoi']);
		array_push($tab, $ods['idconvention']);

		array_push($tabA, $tab);
	    }
	    $result->free();
	}

	return $tabA;
    }

}

?>