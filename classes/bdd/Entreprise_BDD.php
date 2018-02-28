<?php

/**
 * Représentation et accès à la table n°6 : les entreprises
 */

class Entreprise_BDD {

    /**
     * Enregistrement ou mise à jour d'une entreprise
     * @global resource $db Référence sur la base ouverte
     * @global string $tab6 Nom de la table 'entreprise'
     * @param Entreprise $entreprise L'objet Entreprise à sauvegarder
     * @return integer Identifiant de l'enregistrement
     */
    public static function sauvegarder($entreprise) {
	global $db;
	global $tab6;

	$typeEntreprise = $entreprise->getType();
	$idtype_entreprise = $typeEntreprise->getIdentifiantBDD() ? $typeEntreprise->getIdentifiantBDD() : "NULL";

	if ($entreprise->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab6
		    VALUES ('" . $entreprise->getIdentifiantBDD() . "',
			    '" . $entreprise->getNom() . "',
			    '" . $entreprise->getAdresse() . "',
			    '" . $entreprise->getCodePostal() . "',
			    '" . $entreprise->getVille() . "',
			    '" . $entreprise->getPays() . "',
			    '" . $entreprise->getEmail() . "',
			    $idtype_entreprise);";
	    $db->query($sql);
	} else {
	    $sql = "UPDATE $tab6
		    SET nom='" . $entreprise->getNom() . "',
			adresse='" . $entreprise->getAdresse() . "',
			codepostal='" . $entreprise->getCodePostal() . "',
			ville='" . $entreprise->getVille() . "',
			pays='" . $entreprise->getPays() . "',
			email='" . $entreprise->getEmail() . "',
			idtypeentreprise=$idtype_entreprise
		    WHERE identreprise='" . $entreprise->getIdentifiantBDD() . "';";
	    $db->query($sql);
	}

	return $entreprise->getIdentifiantBDD() ? $entreprise->getIdentifiantBDD() : $db->insert_id;
    }

    /**
     * Obtenir une entreprise à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab6 Nom de la table 'entreprise'
     * @param $identifiantBDD Identifiant de l'entreprise recherchée
     * @return enregistrement ou FALSE
     */
    public static function getEntreprise($identifiantBDD) {
	global $db;
	global $tab6;

	$sql = "SELECT * FROM $tab6 WHERE identreprise='$identifiantBDD';";
	$req = $db->query($sql);

	if ($req == FALSE) {
	    return FALSE;
	} else {
	    $enreg = $req->fetch_array();
	    $req->free();
	    return $enreg;
	}
    }

    /**
     * Retourne une liste d'entreprise correspondant à un filtre
     * ordonnée par nom de l'entreprise
     *
     * @global resource $db Référence sur la base ouverte
     * @global string $tab6 Nom de la table 'entreprise'
     * @param Filtre $filtre Le filtre de la recherche
     * @return tableau d'enregistrements
     */
    public static function getListeEntreprises($filtre) {
	global $db;
	global $tab6;

	if ($filtre == "")
	    $requete = "SELECT * FROM $tab6 ORDER BY nom ASC;";
	else
	    $requete = "SELECT * FROM $tab6 WHERE " . $filtre->getStrFiltres() . " ORDER BY nom ASC;";

	$result = $db->query($requete);

	$tabEntreprises = array();

	if ($result) {
	    while ($entreprise = $result->fetch_array()) {
		$tab = array();
		array_push($tab, $entreprise["identreprise"]);
		array_push($tab, $entreprise["nom"]);
		array_push($tab, $entreprise["adresse"]);
		array_push($tab, $entreprise["codepostal"]);
		array_push($tab, $entreprise["ville"]);
		array_push($tab, $entreprise["pays"]);
		array_push($tab, $entreprise["email"]);
		array_push($tab, $entreprise["idtypeentreprise"]);
		array_push($tabEntreprises, $tab);
	    }
	    $result->free();
	}

	return $tabEntreprises;
    }

    /**
     * Suppression d'un enregistrement Entreprise à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab6 Nom de la table 'entreprise'
     * @param integer $identifiantBDD Identifiant de l'enregistrement concerné
     */
    public static function supprimerEntreprise($identifiantBDD) {
	global $db;
	global $tab6;
	$sql = "DELETE FROM $tab6 WHERE identreprise='$identifiantBDD'";
	$db->query($sql);
    }

    /**
     * Test si une certaine entreprise existe déjà en base
     * en utilisant le nom, la ville et le pays
     *
     * @global resource $db Référence sur la base ouverte
     * @global string $tab6 Nom de la table 'entreprise'
     * @param Entreprise $ent Objet Entreprise recherché
     * @return boolean
     */
    public static function existe($ent) {
	global $db;
	global $tab6;

	$sql = "SELECT identreprise
		FROM $tab6
		WHERE nom LIKE '" . $ent->getNom() . "' AND
		      ville LIKE '" . $ent->getVille() . "' AND
		      pays LIKE '" . $ent->getPays() . "'";
	$result = $db->query($sql);

	if ($result) {
	    $ok = $result->num_rows > 0;
	    $result->free();
	    return $ok;
	} else
	    return false;
    }

}

?>