<?php

class Filiere_BDD {
    /** M�thodes statiques * */

    /**
     * R�cup�re une fili�re suivant son identifiant
     * @param $identifiantBDD l'identifiant de la fili�re � r�cup�rer
     * @return String[] tableau contenant les informations d'une fili�re
     */
    public static function getFiliere($identifiantBDD) {
	global $tab10;
	global $db;
	$sql = "SELECT * FROM $tab10 WHERE idfiliere='$identifiantBDD'";
	//echo "getFiliere : $sql<br/>";
	$req = $db->query($sql);
	//if (!$req) echo "KO Filiere_BDD::getFiliere : $sql<br/>"; else echo "OK getFiliere : $sql<br/>";
	return mysqli_fetch_array($req);
    }

    /**
     * Renvoie la liste de toutes les fili�res
     * @return String[] tableau contenant les informations de toutes les fili�res
     */
    public static function listerFilieres() {
	global $tab10;
	global $db;

	$result = array();
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
	global $tab10;
	global $db;

	if ($f->getIdentifiantBDD() == "") {
	    // Cr�ation d'une fili�re
	    $requete = "INSERT INTO $tab10(nomfiliere, temps_soutenance) VALUES ('" . $f->getNom() . "', " . $f->getTempsSoutenance() . ")";
	    $db->query($req);
	    $sql2 = "SELECT LAST_INSERT_ID() AS ID FROM $tab10";
	    $req = $db->query($sql);
	    $result = mysqli_fetch_array($req);
	    return $result['ID'];
	} else {
	    // Mise � jour d'une fili�re
	    $requete = "UPDATE $tab10 SET nomfiliere = '" . $f->getNom() . "', temps_soutenance = '" . $f->getTempsSoutenance() . "'
			WHERE idfiliere = '" . $f->getIdentifiantBDD() . "'";
	    $db->query($req);
	    return $f->getIdentifiantBDD();
	}
    }

}

?>