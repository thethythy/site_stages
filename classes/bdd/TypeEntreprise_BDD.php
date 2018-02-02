<?php

/**
 * Représentation et accès à la table n°22 : les types d'entreprises
 */

class TypeEntreprise_BDD {

    /**
     * Enregistrer ou mettre à jour un objet TypeEntreprise
     * @global resource $db Référence sur la base ouverte
     * @global string $tab22 Nom de la table 'type_entreprise'
     * @param TypeEntreprise $typeEntreprise L'objet à enregistrer
     */
    public static function sauvegarder($typeEntreprise) {
	global $db;
	global $tab22;

	$couleur = $typeEntreprise->getCouleur();

	if ($typeEntreprise->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab22
		    VALUES ('" . $typeEntreprise->getIdentifiantBDD() . "',
			    '" . $typeEntreprise->getType() . "',
			    '" . $couleur->getIdentifiantBDD() . "')";
	} else {
	    $sql = "UPDATE $tab22
		    SET type = '" . $typeEntreprise->getType() . "',
			idcouleur = '" . $couleur->getIdentifiantBDD() . "'
		    WHERE idtypeentreprise = '" . $typeEntreprise->getIdentifiantBDD() . "'";
	}
	$db->query($sql);
    }

    /**
     * Obtenir l'enregistrement TypeEntreprise à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab22 Nom de la table 'type_entreprise'
     * @param integer $identifiant Identifiant de l'enregistrement
     * @return enregistrement
     */
    public static function getTypeEntreprise($identifiant) {
	global $db;
	global $tab22;

	$sql = "SELECT * FROM $tab22 WHERE idtypeentreprise='$identifiant'";
	$result = $db->query($sql);
	return mysqli_fetch_array($result);
    }

    /**
     * Obtenir l'enregistrement TypeEntreprise à partir de son nom
     * @global resource $db Référence sur la base ouverte
     * @global string $tab22 Nom de la table 'type_entreprise'
     * @param string $nom Le nom recherché
     * @return enregistrement
     */
    public static function getTypeEntrepriseFromNom($nom) {
	global $db;
	global $tab22;

	$sql = "SELECT * FROM $tab22 WHERE type LIKE '$nom'";
	$result = $db->query($sql);
	return mysqli_fetch_array($result);
    }

    /**
     * Obtenir les enregistrements de tous les objets TypeEntreprise
     * @global resource $db Référence sur la base ouverte
     * @global string $tab22 Nom de la table 'type_entreprise'
     * @return tableau d'enregistrements
     */
    public static function getListeTypeEntreprise() {
	global $db;
	global $tab22;

	$sql = "SELECT * FROM $tab22";
	$result = $db->query($sql);

	$tabTypeEntreprise = array();

	while ($type = mysqli_fetch_array($result)) {
	    $tab = array();
	    array_push($tab, $type["idtypeentreprise"]);
	    array_push($tab, $type["type"]);
	    array_push($tab, $type["idcouleur"]);
	    array_push($tabTypeEntreprise, $tab);
	}

	return $tabTypeEntreprise;
    }

    /**
     * Suppression d'un enregistrement TypeEntreprise à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab22 Nom de la table 'type_entreprise'
     * @param integer $identifiant L'identifiant de l'enregistrement à supprimer
     */
    public static function supprimerTypeEntreprise($identifiant) {
	global $db;
	global $tab22;

	$sql = "DELETE FROM $tab22 WHERE idtypeentreprise='$identifiant'";
	$db->query($sql);
    }

}

?>