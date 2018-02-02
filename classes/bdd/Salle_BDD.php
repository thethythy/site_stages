<?php

/**
 * Représentation et accès à la table n°16 : les salles pour les soutenances
 */

class Salle_BDD {

    /**
     * Enregistrer ou mettre à jour un objet Salle
     * @global resource $db Référence sur la base ouverte
     * @global string $tab16 Nom de la table 'salle_soutenance'
     * @param type $salle
     */
    public static function sauvegarder($salle) {
	global $db;
	global $tab16;

	if ($salle->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab16 VALUES ('" . $salle->getIdentifiantBDD() . "', '" . $salle->getNom() . "')";
	} else {
	    $sql = "UPDATE $tab16 SET nomsalle='" . $salle->getNom() . "' WHERE idsalle=" . $salle->getIdentifiantBDD();
	}
	$db->query($sql);
    }

    /**
     * Obtenir un enregistrement Salle à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab16 Nom de la table 'salle_soutenance'
     * @param integer $identifiant Identifiant de l'enregistrement à chercher
     * @return enregistrement
     */
    public static function getSalle($identifiant) {
	global $db;
	global $tab16;

	$sql = "SELECT * FROM $tab16 WHERE idsalle='$identifiant'";
	$req = $db->query($sql);
	return mysqli_fetch_array($req);
    }

    /**
     * Obtenir les enregistrements de tous les objets Salle
     * @global resource $db Référence sur la base ouverte
     * @global string $tab16 Nom de la table 'salle_soutenance'
     * @return tableau d'enregistrements
     */
    public static function listerSalle() {
	global $db;
	global $tab16;

	$sql = "SELECT * FROM $tab16 ORDER BY nomsalle ASC;";
	$result = $db->query($sql);

	$tabSalle = array();

	while ($salle = mysqli_fetch_array($result)) {
	    $tab = array();
	    array_push($tab, $salle["idsalle"]);
	    array_push($tab, $salle["nomsalle"]);
	    array_push($tabSalle, $tab);
	}

	return $tabSalle;
    }

    /**
     * Suppression d'un enregistrement à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab16 Nom de la table 'salle_soutenance'
     * @param integer $identifiantBDD Identifiant de l'enregistrement concerné
     */
    public static function delete($identifiantBDD) {
	global $db;
	global $tab16;
	$sql = "DELETE FROM $tab16 WHERE idsalle='$identifiantBDD'";
	$db->query($sql);
    }

}

?>