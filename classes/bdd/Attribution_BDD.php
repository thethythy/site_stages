<?php

class Attribution_BDD {

    /**
     * Sauvegarder un nouvelle objet ou mise à jour d'un objet existant
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
     * @return résultat de la requête
     */
    public static function supprimer($idattribution) {
	global $db;
	global $tab25;

	$sql = "DELETE FROM $tab25 WHERE idattribution=$idattribution;";
	$res = $db->query($sql);
	return $res;
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

	if ($res)
	    return mysqli_fetch_array($res);
	else
	    return FALSE;
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

	if ($res)
	    return mysqli_fetch_array($res);
	else
	    return FALSE;
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
		    (SELECT idconvention FROM $tab4 WHERE idetudiant IN
			(SELECT idetudiant FROM $tab19 WHERE idpromotion =
			    (SELECT idpromotion FROM $tab15 WHERE anneeuniversitaire=$annee
				AND idparcours = $idparcours AND idfiliere = $idfiliere)));";

	$result = $db->query($requete);

	$tabA = array();

	while ($ods = mysqli_fetch_array($result)) {
	    $tab = array();
	    array_push($tab, $ods['idattribution']);
	    array_push($tab, $ods['envoi']);
	    array_push($tab, $ods['idconvention']);

	    array_push($tabA, $tab);
	}

	return $tabA;
    }

}

?>