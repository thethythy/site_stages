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
	$siret = $entreprise->getSiret() ? $entreprise->getSiret() : "NULL";


	if ($entreprise->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab6 (nom, adresse, codepostal, ville, pays, email, idtypeentreprise, siret)
		    VALUES (
			'" . $entreprise->getNom() . "',
			'" . $entreprise->getAdresse() . "',
			'" . $entreprise->getCodePostal() . "',
			'" . $entreprise->getVille() . "',
			'" . $entreprise->getPays() . "',
			'" . $entreprise->getEmail() . "',
			$idtype_entreprise,
			$siret);";
	    $db->query($sql);
	    $sql = "SELECT LAST_INSERT_ID() AS ID FROM $tab6";
	    $res = $db->query($sql);
	    $enreg = $res->fetch_array();
	    $res->free();
	    return $enreg['ID'];
	} else {
	    $sql = "UPDATE $tab6
		    SET nom='" . $entreprise->getNom() . "',
			adresse='" . $entreprise->getAdresse() . "',
			codepostal='" . $entreprise->getCodePostal() . "',
			ville='" . $entreprise->getVille() . "',
			pays='" . $entreprise->getPays() . "',
			email='" . $entreprise->getEmail() . "',
			idtypeentreprise=$idtype_entreprise,
			siret=$siret
			WHERE identreprise='" . $entreprise->getIdentifiantBDD() . "';";
	    $db->query($sql);
	    return $entreprise->getIdentifiantBDD();
	}
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
		array_push($tab, $entreprise["siret"]);
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

    /**
     * Retourne une liste de conventions liées à une entreprise donnée
     * classées par ordre descendant (les plus récentes en premier)
     * @global resource $db Référence sur la base ouverte
     * @global string $tab3 Nom de la table 'contact'
     * @global string $tab4 Nom de la table 'convention'
     * @param integer $idEnt Identifiant de l'entreprise
     * @return tableau Identifiants des conventions trouvées
     */
    public static function getListeConventionFromEntreprise($idEnt) {
	global $db;
	global $tab3;
	global $tab4;

	$sql = "SELECT idconvention
		FROM $tab3, $tab4
		WHERE $tab3.identreprise='$idEnt' AND
		      $tab3.idcontact=$tab4.idcontact
		ORDER BY idconvention DESC;";

	$result = $db->query($sql);

	$tabIDConventions = array();

	if ($result) {
	    while ($row = $result->fetch_array()) {
		array_push($tabIDConventions, $row["idconvention"]);
	    }
	    $result->free();
	}

	return $tabIDConventions;
    }

    /**
     * Retourne une liste de contrats liés à une entreprise donnée
     * classés par ordre descendant (les plus récents en premier)
     * @global resource $db Référence sur la base ouverte
     * @global string $tab3 Nom de la table 'contact'
     * @global string $tab31 Nom de la table 'contrat'
     * @param integer $idEnt Identifiant de l'entreprise
     * @return tableau Identifiants des conventions trouvées
     */
    public static function getListeContratFromEntreprise($idEnt) {
	global $db;
	global $tab3;
	global $tab31;

	$sql = "SELECT idcontrat
		FROM $tab3, $tab31
		WHERE $tab3.identreprise='$idEnt' AND
		      $tab3.idcontact=$tab31.idreferent
		ORDER BY idcontrat DESC;";

	$result = $db->query($sql);
	$tabIDContrats = array();

	if ($result) {
	    while ($row = $result->fetch_array()) {
		array_push($tabIDContrats, $row["idcontrat"]);
	    }
	    $result->free();
	}

	return $tabIDContrats;
    }

    /**
     * Retourne un tableau contenant des données Entreprise dont le nom commence
     * comme la chaine donnée en paramètre
     * 
     * @global resource $db Référence sur la base ouverte
     * @global string $tab6 Nom de la table 'entreprise'
     * 
     * @param string $debut_nom Le début du nom de l'entreprise
     * @param string $name Le nombre de réponse attendu au maximum
     * @return array Tableau contenant les données entreprises
     */
    public static function getListeEntreprisesByNom($debut_nom, $size) {
	global $db;
	global $tab6;
	
	$requete = "SELECT *
		    FROM $tab6
		    WHERE LOWER(nom) LIKE '$debut_nom%'
		    ORDER BY nom ASC
		    LIMIT 0, $size ;";
	
	$result = $db->query($requete);
	
	$tabEntreprises = array();
	
	if ($result) {	    
	    while ($entreprise = $result->fetch_array()) {
		$tab = array();
		$tab["identreprise"] = $entreprise["identreprise"];
		$tab["nom"] = $entreprise["nom"];
		$tab["adresse"] = $entreprise["adresse"];
		$tab["codepostal"] = $entreprise["codepostal"];
		$tab["ville"] = $entreprise["ville"];
		$tab["pays"] = $entreprise["pays"];
		$tab["email"] = $entreprise["email"];
		$tab["idtypeentreprise"] = $entreprise["idtypeentreprise"];
		$tab["siret"] = $entreprise["siret"];
		
		array_push($tabEntreprises, $tab);
	    }
	    $result->free();
	}

	return $tabEntreprises;
    }
}

?>
