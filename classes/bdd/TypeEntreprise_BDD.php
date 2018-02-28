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
		    VALUES ('',
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
     * @return enregistrement ou FALSE
     */
    public static function getTypeEntreprise($identifiant) {
	global $db;
	global $tab22;

	$sql = "SELECT * FROM $tab22 WHERE idtypeentreprise='$identifiant'";
	$result = $db->query($sql);

	if ($result) {
	    $enreg = $result->fetch_array();
	    $result->free();
	    return $enreg;
	} else
	    return FALSE;
    }

    /**
     * Obtenir l'enregistrement TypeEntreprise à partir de son nom
     * @global resource $db Référence sur la base ouverte
     * @global string $tab22 Nom de la table 'type_entreprise'
     * @param string $nom Le nom recherché
     * @return enregistrement ou FALSE
     */
    public static function getTypeEntrepriseFromNom($nom) {
	global $db;
	global $tab22;

	$sql = "SELECT * FROM $tab22 WHERE type LIKE '$nom'";
	$result = $db->query($sql);

	if ($result) {
	    $enreg = $result->fetch_array();
	    $result->free();
	    return $enreg;
	} else
	    return FALSE;
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

	if ($result) {
	    while ($type = $result->fetch_array()) {
		$tab = array();
		array_push($tab, $type["idtypeentreprise"]);
		array_push($tab, $type["type"]);
		array_push($tab, $type["idcouleur"]);
		array_push($tabTypeEntreprise, $tab);
	    }
	    $result->free();
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