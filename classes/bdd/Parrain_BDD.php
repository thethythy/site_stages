<?php

/**
 * Représentation et accès à la table n°10 : les enseignants
 */

class Parrain_BDD {

    /**
     * Enregistrer ou mettre à jour un objet Parrain
     * @global resource $db Référence sur la base ouverte
     * @global string $tab14 Nom de la table 'parrain'
     * @param Parrain $parrain L'objet à enregistrer
     */
    public static function sauvegarder($parrain) {
	global $db;
	global $tab14;

	$couleur = $parrain->getCouleur();

	if ($parrain->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab14
		    VALUES ('',
			    '" . $parrain->getNom() . "',
			    '" . $parrain->getPrenom() . "',
			    '" . $parrain->getEmail() . "',
			    '" . $couleur->getIdentifiantBDD() . "')";
	} else {
	    $sql = "UPDATE $tab14
		    SET prenomparrain='" . $parrain->getPrenom() . "',
			nomparrain='" . $parrain->getNom() . "',
			emailparrain='" . $parrain->getEmail() . "',
			idcouleur='" . $couleur->getIdentifiantBDD() . "'
		    WHERE idparrain=" . $parrain->getIdentifiantBDD();
	}
	$db->query($sql);
    }

    /**
     * Obtenir un enregistrement d'un parrain à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab14 Nom de la table 'parrain'
     * @param integer $identifiant L'identifiant de l'enregistrement cherché
     * @return enregsitrement
     */
    public static function getParrain($identifiant) {
	global $db;
	global $tab14;

	$sql = "SELECT * FROM $tab14 WHERE idparrain='$identifiant';";
	$req = $db->query($sql);
	return mysqli_fetch_array($req);
    }

    /**
     * Obtenir les enregistrements de tous les parrains
     * @global resource $db Référence sur la base ouverte
     * @global string $tab14 Nom de la table 'parrain'
     * @return tableau d'enregistrements
     */
    public static function listerParrain() {
	global $db;
	global $tab14;

	$sql = "SELECT * FROM $tab14 ORDER BY nomparrain ASC;";
	$result = $db->query($sql);

	$tabParrain = array();

	while ($parrain = mysqli_fetch_array($result)) {
	    $tab = array();
	    array_push($tab, $parrain["idparrain"]);
	    array_push($tab, $parrain["nomparrain"]);
	    array_push($tab, $parrain["prenomparrain"]);
	    array_push($tab, $parrain["emailparrain"]);
	    array_push($tab, $parrain["idcouleur"]);
	    array_push($tabParrain, $tab);
	}

	return $tabParrain;
    }

    /**
     * Supprimer un enregistrement d'un parrain
     * @global resource $db Référence sur la base ouverte
     * @global string $tab14 Nom de la table 'parrain'
     * @param integer $identifiantBDD Identifiant de l'enregistrement à supprimer
     */
    public static function delete($identifiantBDD) {
	global $db;
	global $tab14;
	$sql = "DELETE FROM $tab14 WHERE idparrain='$identifiantBDD'";
	$db->query($sql);
    }

}

?>