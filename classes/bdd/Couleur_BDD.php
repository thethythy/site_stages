<?php

/**
 * Représentation et accès à la table n°20 : les couleurs utilisables associées
 * aux parrains, aux thèmes de stage et type d'entreprise
 */

class Couleur_BDD {

    /**
     * Sauvegarde en base de données un objet Couleur
     * @global ressource $db Référence sur la base ouverte
     * @global string $tab20 Nom de la table 'couleur'
     * @param Couleur $couleur L'objet à sauvegarder
     */
    public static function sauvegarder($couleur) {
	global $db;
	global $tab20;

	if ($couleur->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab20 VALUES ('" . $couleur->getIdentifiantBDD() . "', '" . $couleur->getNom() . "', '" . $couleur->getCode() . "')";
	} else {
	    $sql = "UPDATE $tab20 SET nomcouleur='" . $couleur->getNom() . "', codehexa='" . $couleur->getCode() . "' WHERE idcouleur='" . $couleur->getIdentifiantBDD() . "'";
	}
	$db->query($sql);
    }

    /**
     * Obtenir un enregistrement Couleur à partir de son identifiant
     * @global ressource $db Référence sur la base ouverte
     * @global string $tab20 Nom de la table 'couleur'
     * @param integer $identifiant Identifiant de la couleur recherchée
     * @return enregistrement ou FALSE
     */
    public static function getCouleur($identifiant) {
	global $db;
	global $tab20;

	$sql = "SELECT * FROM $tab20 WHERE idcouleur='$identifiant';";
	$res = $db->query($sql);

	if ($res) {
	    $enreg = $res->fetch_array();
	    $res->free();
	    return $enreg;
	} else
	    return FALSE;
    }

    /**
     * Obtenir les enregistrements de toutes les couleurs en base
     * @global ressource $db Référence sur la base ouverte
     * @global string $tab20 Nom de la table 'couleur'
     * @return tableau d'enregistrements
     */
    public static function listerCouleur() {
	global $db;
	global $tab20;

	$sql = "SELECT * FROM $tab20 ORDER BY nomcouleur ASC;";
	$result = $db->query($sql);

	$tabCouleur = array();

	if ($result) {
	    while ($couleur = $result->fetch_array()) {
		$tab = array();
		array_push($tab, $couleur["idcouleur"]);
		array_push($tab, $couleur["nomcouleur"]);
		array_push($tab, $couleur["codehexa"]);
		array_push($tabCouleur, $tab);
	    }
	    $result->free();
	}

	return $tabCouleur;
    }

    /**
     * Suppression d'un enregistrement Couleur à partir de son identifiant
     * @global ressource $db Référence sur la base ouverte
     * @global string $tab20 Nom de la table 'couleur'
     * @param integer $identifiantBDD Identifiant de l'enregistrement concerné
     */
    public static function delete($identifiantBDD) {
	global $db;
	global $tab20;

	$sql = "DELETE FROM $tab20 WHERE idcouleur='$identifiantBDD';";
	$db->query($sql);
    }

}

?>