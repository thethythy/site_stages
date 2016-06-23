<?php

class Parcours_BDD {

    /** Méthodes statiques **/

    /**
     * Récupére un parcours suivant son identifiant
     * @param $identifiantBDD l'identifiant du parcours récupéré
     * @return String[] tableau contenant les informations d'un parcours
     */
    public static function getParcours($identifiantBDD) {
	global $db;
	global $tab13;
	$sql = "SELECT * FROM $tab13 WHERE idparcours='$identifiantBDD';";
	$req = $db->query($sql);
	return mysqli_fetch_array($req);
    }

    public static function listerParcours() {
	global $db;
	global $tab13;

	$sql = "SELECT * FROM $tab13 ORDER BY nomparcours ASC;";
	$result = $db->query($sql);

	$tabParcours = array();

	while ($parcours = mysqli_fetch_array($result)) {
	    $tab = array();
	    array_push($tab, $parcours["idparcours"]);
	    array_push($tab, $parcours["nomparcours"]);
	    array_push($tabParcours, $tab);
	}

	return $tabParcours;
    }

    // $p : Un objet Parcours
    public static function sauvegarder($p) {
	global $db;
	global $tab13;

	if ($p->getIdentifiantBDD() == "") {
	    // Création d'un parcours
	    $req = "INSERT INTO $tab13(nomparcours) VALUES ('" . $p->getNom() . "')";
	    $db->query($req);
	    $sql = "SELECT LAST_INSERT_ID() AS ID FROM $tab13";
	    $req = $db->query($sql);
	    $result = mysqli_fetch_array($req);
	    return $result['ID'];
	} else {
	    // Mise à jour d'un parcours
	    $req = "UPDATE $tab13 SET nomparcours = '" . $p->getNom() . "' WHERE idparcours = '" . $p->getIdentifiantBDD() . "'";
	    $db->query($req);
	    return $p->getIdentifiantBDD();
	}
    }

}

?>