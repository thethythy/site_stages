<?php

/**
 * Représentation et accès à la table n°34 : les responsables
 * (stage, alternance, site, etc.)
 */

class Responsable_BDD {

    /**
     * Sauvegarde en base de données un objet Responsable
     * @global ressource $db Référence sur la base ouverte
     * @global string $tab34 Nom de la table 'responsable'
     * @param Responsable $responsable L'objet à sauvegarder
     */
    public static function sauvegarder($responsable) {
	global $db;
	global $tab34;

	if ($responsable->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab34 VALUES ('0',
		'" . $responsable->getResponsabilite() . "',
		'" . $responsable->getNomresponsable() . "',
		'" . $responsable->getPrenomresponsable() . "',
		'" . $responsable->getEmailresponsable() . "');";
	} else {
	    $sql = "UPDATE $tab34 SET
		responsabilite='" . $responsable->getResponsabilite() . "',
		nomresponsable='" . $responsable->getNomresponsable() . "',
		prenomresponsable='" . $responsable->getPrenomresponsable() . "',
		emailresponsable='" . $responsable->getEmailresponsable() . "'
		WHERE idresponsable='" . $responsable->getIdentifiantBDD() . "';";
	}
	$db->query($sql);
    }

    /**
     * Obtenir un enregistrement Responsbale à partir de son identifiant
     * @global ressource $db Référence sur la base ouverte
     * @global string $tab34 Nom de la table 'responsable'
     * @param integer $identifiant Identifiant du responsable recherché
     * @return enregistrement ou FALSE
     */
    public static function getResponsable($identifiant) {
	global $db;
	global $tab34;

	$sql = "SELECT * FROM $tab34 WHERE idresponsable='$identifiant';";
	$res = $db->query($sql);

	if ($res) {
	    $enreg = $res->fetch_array();
	    $res->free();
	    return $enreg;
	} else
	    return FALSE;
    }

    /**
     * Obtenir un enregistrement Responsable correspond au paramètre
     * @param string $responsabilite
     * @return enregistrement ou FALSE
     */
    public static function getResponsableFromResponsabilite($responsabilite) {
	global $db;
	global $tab34;

	$sql = "SELECT * FROM $tab34 WHERE responsabilite LIKE '%$responsabilite%';";
	$res = $db->query($sql);

	if ($res) {
	    $enreg = $res->fetch_array();
	    $res->free();
	    return $enreg;
	} else {
	    return FALSE;
	}
    }

    /**
     * Obtenir les enregistrements de toutes les responsables en base
     * @global ressource $db Référence sur la base ouverte
     * @global string $tab34 Nom de la table 'responsable'
     * @return tableau d'enregistrements
     */
    public static function listerResponsable() {
	global $db;
	global $tab34;

	$sql = "SELECT * FROM $tab34 ORDER BY responsabilite ASC;";
	$result = $db->query($sql);

	$tabResponsable = array();

	if ($result) {
	    while ($responsable = $result->fetch_array()) {
		$tab = array();
		array_push($tab, $responsable["idresponsable"]);
		array_push($tab, $responsable["responsabilite"]);
		array_push($tab, $responsable["nomresponsable"]);
		array_push($tab, $responsable["prenomresponsable"]);
		array_push($tab, $responsable["emailresponsable"]);
		array_push($tabResponsable, $tab);
	    }
	    $result->free();
	}

	return $tabResponsable;
    }

    /**
     * Suppression d'un enregistrement Responsable à partir de son identifiant
     * @global ressource $db Référence sur la base ouverte
     * @global string $tab34 Nom de la table 'responsable'
     * @param integer $identifiantBDD Identifiant de l'enregistrement concerné
     */
    public static function delete($identifiantBDD) {
	global $db;
	global $tab34;

	$sql = "DELETE FROM $tab34 WHERE idresponsable='$identifiantBDD';";
	$db->query($sql);
    }

}

?>