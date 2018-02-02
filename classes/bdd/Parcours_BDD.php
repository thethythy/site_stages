<?php

/**
 * Représentation et accès à la table n°13 : les parcours des filières
 */

class Parcours_BDD {

    /**
     * Enregistrer ou mettre à jour un objet Parcours
     * @global resource $db Référence sur la base ouverte
     * @global string $tab13 Nom de la table 'parcours'
     * @param Parcours $p L'objet à enregistrer
     * @return integer L'identifiant de l'objet enregistré
     */
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

    /**
     * Obtenir un enregistrement Parcours à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab13 Nom de la table 'parcours'
     * @param integer $identifiantBDD L'identifiant de l'enregistrement cherché
     * @return enregistrement
     */
    public static function getParcours($identifiantBDD) {
	global $db;
	global $tab13;
	$sql = "SELECT * FROM $tab13 WHERE idparcours='$identifiantBDD';";
	$req = $db->query($sql);
	return mysqli_fetch_array($req);
    }

    /**
     * Obtenir les enregistrements de tous les parcours
     * @global resource $db Référence sur la base ouverte
     * @global string $tab13 Nom de la table 'parcours'
     * @return tableau d'enregistrements
     */
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

}

?>