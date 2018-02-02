<?php

/**
 * Représentation et accès à la table n°9 : les étudiants
 */

class Etudiant_BDD {

    /**
     * Enregistrement ou mise à jour d'un objet Etudiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab9 Nom de la table 'etudiant'
     * @param Etudiant $etudiant L'objet à sauvegarder
     */
    public static function sauvegarder($etudiant) {
	global $db;
	global $tab9;

	if ($etudiant->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab9 (nometudiant, prenometudiant, email_institutionnel, email_personnel, codeetudiant)
		    VALUES ('" . $etudiant->getNom() . "',
			    '" . $etudiant->getPrenom() . "',
			    '" . $etudiant->getEmailInstitutionel() . "',
			    '" . $etudiant->getEmailPersonnel() . "',
			    '" . $etudiant->getCodeEtudiant() . "')";

	    $db->query($sql);

	    $sql2 = "SELECT LAST_INSERT_ID() AS ID FROM $tab9";
	    $req = $db->query($sql2);
	    $result = mysqli_fetch_array($req);
	    return $result['ID'];
	} else {
	    $sql = "UPDATE $tab9
		    SET nometudiant='" . $etudiant->getNom() . "',
			prenometudiant='" . $etudiant->getPrenom() . "',
			email_institutionnel='" . $etudiant->getEmailInstitutionel() . "',
			email_personnel='" . $etudiant->getEmailPersonnel() . "',
			codeetudiant='" . $etudiant->getCodeEtudiant() . "'
		    WHERE idetudiant = '" . $etudiant->getIdentifiantBDD() . "'";
	    $db->query($sql);
	    return $etudiant->getIdentifiantBDD();
	}
    }

    /**
     * Obtenir un enregistrement Etudiant à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab9 Nom de la table 'etudiant'
     * @param integer $identifiantBDD L'identifiant de l'étudiant recherché
     * @return enregistrement
     */
    public static function getEtudiant($identifiantBDD) {
	global $db;
	global $tab9;
	$sql = "SELECT * FROM $tab9 WHERE idetudiant='$identifiantBDD'";
	$req = $db->query($sql);
	return mysqli_fetch_array($req);
    }

    /**
     * Suppression d'un étudiant dans une promotion
     * @global resource $db Référence sur la base ouverte
     * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
     * @param integer $identifiantBDD Identifiant de l'étudiant concerné
     * @param integer $idPromo Identifiant de la promotion concernée
     */
    public static function supprimerLienPromotionEtudiant($identifiantBDD, $idPromo) {
	global $db;
	global $tab19;
	$sql = "DELETE FROM $tab19 WHERE idetudiant='$identifiantBDD' AND idpromotion='$idPromo'";
	$db->query($sql);
    }

    /**
     * Suppression d'un enregistrement Etudiant à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab9 Nom de la table 'etudiant'
     * @param integer $identifiantBDD Identifiant de l'enregistrement à supprimer
     */
    public static function supprimerEtudiant($identifiantBDD) {
	global $db;
	global $tab9;
	$sql = "DELETE FROM $tab9 WHERE idetudiant='$identifiantBDD'";
	$db->query($sql);
    }

    /**
     * Obtenir la liste des étudiants d'une promotion
     * @global resource $db Référence sur la base ouverte
     * @global string $tab9 Nom de la table 'etudiant'
     * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
     * @param integer $identifiantPromo L'identifiant de la promotion
     * @return tableau d'enregistrements
     */
    public static function getListeEtudiants($identifiantPromo) {
	global $db;
	global $tab9;
	global $tab19;

	$sql = "SELECT idetudiant FROM $tab19 WHERE idpromotion='$identifiantPromo'";
	$req = $db->query($sql);

	$sql2 = "SELECT * FROM $tab9 WHERE";
	$aucunEtudiant = true;

	while ($idEtu = mysqli_fetch_array($req, MYSQL_ASSOC)) {
	    $aucunEtudiant = false;
	    $sql2 .= " idetudiant='" . $idEtu["idetudiant"] . "' OR";
	}

	$listeEtudiants = array();

	if ($aucunEtudiant == false) {
	    $sql2 = substr_replace($sql2, "", -3, 3);
	    $sql2 .= " ORDER BY nometudiant ASC;";
	    $req = $db->query($sql2);

	    while ($etu = mysqli_fetch_array($req, MYSQL_ASSOC)) {
		$tab = array();
		array_push($tab, $etu["idetudiant"]);
		array_push($tab, $etu["nometudiant"]);
		array_push($tab, $etu["prenometudiant"]);
		array_push($tab, $etu["email_institutionnel"]);
		array_push($tab, $etu["email_personnel"]);
		array_push($tab, $etu["codeetudiant"]);
		array_push($listeEtudiants, $tab);
	    }
	}
	return $listeEtudiants;
    }

    /**
     * Ajouter un étudiant à une promotion
     * @global resource $db Référence sur la base ouverte
     * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
     * @param integer $etu Identifiant de l'étudiant
     * @param integer $promo Identifiant de la promotion
     */
    public static function ajouterPromotion($etu, $promo) {
	global $db;
	global $tab19;

	$sql = "INSERT INTO $tab19(idetudiant, idpromotion) VALUES ('$etu', '$promo')";
	$db->query($sql);
    }

    /**
     * Associer une convention à un étudiant et une promotion existants
     * @global resource $db Référence sur la base ouverte
     * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
     * @param integer $idetu Identifiant de l'étudiant
     * @param integer $idconv Identifiant de la convention
     * @param integer $idpromo Identifiant de la promotion
     */
    public static function ajouterConvention($idetu, $idconv, $idpromo) {
	global $db;
	global $tab19;

	$sql = "UPDATE $tab19 SET idconvention = '$idconv'
		WHERE idetudiant = '$idetu' AND idpromotion = '$idpromo'";
	$db->query($sql);
    }

    /**
     * Obtenir la promotion d'un étudiant pour une certaine année
     * @global resource $db Référence sur la base ouverte
     * @global string $tab15  Nom de la table 'promotion'
     * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
     * @param integer $idetu Identifiant de l'étudiant concerné
     * @param integer $annee Année de la promotion recherchée
     * @return integer Identifiant de la promotion trouvée
     */
    public static function recherchePromotion($idetu, $annee) {
	global $db;
	global $tab15;
	global $tab19;

	$sql = "SELECT $tab19.idpromotion AS idpromo FROM $tab19, $tab15
		WHERE $tab19.idetudiant = '$idetu'
		AND $tab15.anneeuniversitaire LIKE '$annee'
		AND $tab19.idpromotion = $tab15.idpromotion";

	$req = $db->query($sql);
	$result = mysqli_fetch_array($req);
	return $result['idpromo'];
    }

    /**
     * Obtenir l'identifiant de la convention d'un étudiant et une année donnée
     * @global resource $db Référence sur la base ouverte
     * @global string $tab4 Nom de la table 'convention'
     * @global string $tab15 Nom de la table 'promotion'
     * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
     * @param integer $idetu Identifiant de l'étudiant concerné
     * @param integer $annee Année de la convention recherchée
     * @return integer ou ""
     */
    public static function rechercheConvention($idetu, $annee) {
	global $db;
	global $tab4;
	global $tab15;
	global $tab19;

	$sql = "SELECT $tab19.idconvention AS idconv FROM $tab19, $tab4, $tab15
		WHERE $tab19.idetudiant='$idetu'
		AND $tab15.anneeuniversitaire='$annee'
		AND $tab19.idpromotion = $tab15.idpromotion
		AND $tab19.idconvention = $tab4.idconvention";

	$req = $db->query($sql);
	$result = mysqli_fetch_array($req);
	return $result['idconv'];
    }

    /**
     * Recherche les étudiants s'appelant $nom $prenom
     * @global resource $db Référence sur la base ouverte
     * @global string $tab9 Nom de la table 'etudiant'
     * @param string $nom Le nom recherché
     * @param string $prenom Le prénom recherché�
     * @return tableau d'enregistrements
     */
    public static function searchEtudiants($nom, $prenom) {
	global $db;
	global $tab9;

	$sql = "SELECT * FROM $tab9 WHERE nometudiant LIKE '$nom' AND prenometudiant LIKE '$prenom'";
	$req = $db->query($sql);

	$tabSEtudiants = array();

	while ($etu = mysqli_fetch_array($req, MYSQL_ASSOC)) {
	    $tab = array();
	    array_push($tab, $etu["idetudiant"]);
	    array_push($tab, $etu["nometudiant"]);
	    array_push($tab, $etu["prenometudiant"]);
	    array_push($tab, $etu["email_institutionnel"]);
	    array_push($tab, $etu["email_personnel"]);
	    array_push($tab, $etu["codeetudiant"]);
	    array_push($tabSEtudiants, $tab);
	}

	return $tabSEtudiants;
    }

}

?>