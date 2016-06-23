<?php

class Filiere_BDD {

    /** Méthodes statiques **/

    /**
     * Récupérer une filière suivant son identifiant
     * @param $identifiantBDD l'identifiant de la filière réupérée
     * @return String[] tableau contenant les informations d'une filière
     */
    public static function getFiliere($identifiantBDD) {
	global $db;
	global $tab10;
	$sql = "SELECT * FROM $tab10 WHERE idfiliere='$identifiantBDD'";
	$req = $db->query($sql);
	return mysqli_fetch_array($req);
    }

    /**
     * Renvoie la liste de toutes les filières
     * @return String[] tableau contenant les informations de toutes les filières
     */
    public static function listerFilieres() {
	global $db;
	global $tab10;

	$sql = "SELECT * FROM $tab10 ORDER BY nomfiliere ASC";
	$result = $db->query($sql);

	$tabFilieres = array();

	while ($filiere = mysqli_fetch_array($result)) {
	    $tab = array();
	    array_push($tab, $filiere["idfiliere"]);
	    array_push($tab, $filiere["nomfiliere"]);
	    array_push($tab, $filiere["temps_soutenance"]);
	    array_push($tab, $filiere["affDepot"]);
	    array_push($tabFilieres, $tab);
	}

	return $tabFilieres;
    }

    // $f : Un objet Filiere
    public static function sauvegarder($f) {
	global $db;
	global $tab10;

	if ($f->getIdentifiantBDD() == "") {
	    // Création d'une filière
	    $req = "INSERT INTO $tab10(nomfiliere, temps_soutenance)
		    VALUES ('" . $f->getNom() . "', " . $f->getTempsSoutenance() . ")";
	    $db->query($req);
	    $sql2 = "SELECT LAST_INSERT_ID() AS ID FROM $tab10";
	    $req = $db->query($sql2);
	    $result = mysqli_fetch_array($req);
	    return $result['ID'];
	} else {
	    // Mise à jour d'une filière
	    $req = "UPDATE $tab10 SET nomfiliere = '" . $f->getNom() . "', temps_soutenance = '" . $f->getTempsSoutenance() . "'
		    WHERE idfiliere = '" . $f->getIdentifiantBDD() . "'";
	    $db->query($req);
	    return $f->getIdentifiantBDD();
	}
    }

}

?>