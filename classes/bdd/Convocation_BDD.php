<?php

/**
 * Représentation et accès à la table n°24 : mémoriser les convocations/invitations
 * aux soutenances de stage
 */

class Convocation_BDD {

    /**
     * Enregistrement ou mise à jour en base d'une convocation
     * Sauvegarder un nouvelle objet ou mise à jour d'un objet existant
     * @global resource $db Référence à la base ouverte
     * @global string $tab24 Nom de la table 'convocation'
     * @param objet Convocation $convocation La covocation à enregistrer
     * @return FALSE ou identifiant de l'objet en base
     */
    public static function sauvegarder($convocation) {
	global $db;
	global $tab24;

	if ($convocation->getIdentifiantBDD() == '') {
	    $sql = "INSERT INTO $tab24 VALUES ('', '" . $convocation->getEnvoi() . "', '". $convocation->getIdsoutenance() ."');";
	} else {
	    $sql = "UPDATE $tab24 SET envoi='" . $convocation->getEnvoi() . "', idsoutenance='" . $convocation->getIdsoutenance() . "'
		    WHERE idconvocation=" . $convocation->getIdentifiantBDD() . ";";
	}
	$res = $db->query($sql);
	if ($res)
	    return ($convocation->getIdentifiantBDD() != '') ? $convocation->getIdentifiantBDD() : $db->insert_id;
	else
	    return FALSE;
    }

    /**
     * Supprimer un enregistrement donné par son identifiant
     * @global resource $db Référence à la base ouverte
     * @global string $tab24 Nom de la table 'convocation'
     * @param integer $idconvocation Identifiant de l'enregistrement
     * @return boolean Résultat de la requête
     */
    public static function supprimer($idconvocation) {
	global $db;
	global $tab24;

	$sql = "DELETE FROM $tab24 WHERE idconvocation=$idconvocation;";
	$res = $db->query($sql);
	return $res;
    }

    /**
     * Rechercher un enregistrement à partir de son identifiant
     * @global resource $db Référence à la base ouverte
     * @global string $tab24 Nom de la table 'convocation'
     * @param integer $idconvocation Identifiant de l'enregistrement
     * @return FALSE ou enregistrement
     */
    public static function getConvocation($idconvocation) {
	global $db;
	global $tab24;

	$sql = "SELECT * FROM $tab24 WHERE idconvocation='$idconvocation';";
	$res = $db->query($sql);

	if ($res)
	    return mysqli_fetch_array($res);
	else
	    return FALSE;
    }

    /**
     * Rechercher un enregistrement à partir de la soutenance
     * @global resource $db Référence à la base ouverte
     * @global string $tab24 Nom de la table 'convocation'
     * @param integer $idsoutenance Identifiant de la soutenance concernée
     * @return FALSE ou enregistrement
     */
    public static function getConvocationFromSoutenance($idsoutenance) {
	global $db;
	global $tab24;

	$sql = "SELECT * FROM $tab24 WHERE idsoutenance = $idsoutenance;";
	$res = $db->query($sql);

	if ($res)
	    return mysqli_fetch_array($res);
	else
	    return FALSE;
    }

    /**
     * Rechercher les enregistrements à partir de la date de soutenance
     * @global resource $db Référence à la base ouverte
     * @global string $tab17 Nom de la table 'soutenances'
     * @global string $tab24 Nom de la table 'convocation'
     * @param integer $iddatesoutenance Identifiant de la date de soutenance
     * @return tableau d'enregistrements
     */
    public static function getConvocationsFromDateSoutenance($iddatesoutenance) {
	global $db;
	global $tab17;
	global $tab24;

	$requete = "SELECT * FROM $tab24 WHERE idsoutenance IN
		    (SELECT idsoutenance FROM $tab17 WHERE iddatesoutenance = $iddatesoutenance);";

	$result = $db->query($requete);

	$tabC = array();

	while ($ods = mysqli_fetch_array($result)) {
	    $tab = array();
	    array_push($tab, $ods['idconvocation']);
	    array_push($tab, $ods['envoi']);
	    array_push($tab, $ods['idsoutenance']);

	    array_push($tabC, $tab);
	}

	return $tabC;
    }

}

?>