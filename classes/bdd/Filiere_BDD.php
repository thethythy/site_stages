<?php

/**
 * Représentation et accès à la table n°10 : les filières (correspondant
 * aux formations post-BAC)
 */

class Filiere_BDD {

    /**
     * Obtenir un enregistrement Filière à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab10 Nom de la table 'filiere'
     * @param integer $identifiantBDD Identifiant de la filière recherchée
     * @return enregistrementou FALSE
     */
    public static function getFiliere($identifiantBDD) {
	global $db;
	global $tab10;

	$sql = "SELECT * FROM $tab10 WHERE idfiliere='$identifiantBDD'";
	$res = $db->query($sql);

	if ($res) {
	    $enreg = $res->fetch_assoc();
	    $res->free();
	    return $enreg;
	} else
	    return FALSE;
    }

    /**
     * Obtenir les enregistrements de toutes les filières
     * @global resource $db Référence sur la base ouverte
     * @global string $tab10 Nom de la table 'filiere'
     * @return tableau d'enregistrements
     */
    public static function listerFilieres() {
	global $db;
	global $tab10;

	$sql = "SELECT * FROM $tab10 ORDER BY nomfiliere ASC";
	$result = $db->query($sql);

	$tabFilieres = array();

	if ($result) {
	    while ($filiere = $result->fetch_array()) {
		$tab = array();
		array_push($tab, $filiere["idfiliere"]);
		array_push($tab, $filiere["nomfiliere"]);
		array_push($tab, $filiere["temps_soutenance"]);
		array_push($tab, $filiere["affDepot"]);
		array_push($tabFilieres, $tab);
	    }
	    $result->free();
	}

	return $tabFilieres;
    }

    /**
     * Enregistrer ou mettre à jour un objet Filiere
     * @global resource $db Référence sur la base ouverte
     * @global string $tab10 Nom de la table 'filiere'
     * @param Filiere $f L'objet à enregistrer
     * @return integer L'identifiant de l'enregistrement
     */
    public static function sauvegarder($f) {
	global $db;
	global $tab10;

	if ($f->getIdentifiantBDD() == "") {
	    // Création d'une filière
	    $req = "INSERT INTO $tab10(nomfiliere, temps_soutenance)
		    VALUES ('" . $f->getNom() . "', " . $f->getTempsSoutenance() . ")";
	} else {
	    // Mise à jour d'une filière
	    $req = "UPDATE $tab10 SET nomfiliere = '" . $f->getNom() . "', temps_soutenance = '" . $f->getTempsSoutenance() . "'
		    WHERE idfiliere = '" . $f->getIdentifiantBDD() . "'";
	}

	$db->query($req);

	return $f->getIdentifiantBDD() ? $f->getIdentifiantBDD() : $db->insert_id;
    }

}

?>
