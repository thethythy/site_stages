<?php

class Couleur_BDD {
    /** Méthodes statiques **/

    public static function sauvegarder($couleur) {
		global $tab20;
		global $db;

		if ($couleur->getIdentifiantBDD() == "") {
		    $sql = "INSERT INTO $tab20 VALUES ('" . $couleur->getIdentifiantBDD() . "', '" . $couleur->getNom() . "', '" . $couleur->getCode() . "')";
		} else {
		    $sql = "UPDATE $tab20 SET nomcouleur='" . $couleur->getNom() . "', codehexa='" . $couleur->getCode() . "' WHERE idcouleur='" . $couleur->getIdentifiantBDD() . "'";
		}
		$result = $db->query($sql);
    }

    public static function getCouleur($identifiant) {
		global $tab20;
		global $db;

		$result = array();
		$sql = "SELECT * FROM $tab20 WHERE idcouleur='$identifiant';";
		$req = $db->query($sql);
		return mysqli_fetch_array($req);
    }

    public static function listerCouleur() {
		global $tab20;
		global $db;
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
		global $tab20;
		global $db;
		$sql = "DELETE FROM $tab20 WHERE idcouleur='" . $identifiantBDD . "';";
		$result = $db->query($sql);
	}

}

?>