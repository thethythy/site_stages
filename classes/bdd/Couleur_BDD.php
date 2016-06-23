<?php

/**
 * Méthodes d'interfaçage avec la base de données des objets Couleurs
 */
class Couleur_BDD {

    /**
     * Sauvegarde en base de données un objet Couleur
     * @global ressource $db Référence sur la base ouverte
     * @global string $tab20 Nom de la table couleur
     * @param Couleur $couleur L'objet Couleur à sauvegarder
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

    public static function getCouleur($identifiant) {
	global $db;
	global $tab20;

	$sql = "SELECT * FROM $tab20 WHERE idcouleur='$identifiant';";
	$req = $db->query($sql);
	return mysqli_fetch_array($req);
    }

    public static function listerCouleur() {
	global $db;
	global $tab20;

	$sql = "SELECT * FROM $tab20 ORDER BY nomcouleur ASC;";
	$result = $db->query($sql);

	$tabCouleur = array();

	while ($couleur = mysqli_fetch_array($result)) {
	    $tab = array();
	    array_push($tab, $couleur["idcouleur"]);
	    array_push($tab, $couleur["nomcouleur"]);
	    array_push($tab, $couleur["codehexa"]);
	    array_push($tabCouleur, $tab);
	}

	return $tabCouleur;
    }

    public static function delete($identifiantBDD) {
	global $db;
	global $tab20;

	$sql = "DELETE FROM $tab20 WHERE idcouleur='" . $identifiantBDD . "';";
	$db->query($sql);
    }

}

?>