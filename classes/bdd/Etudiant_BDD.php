<?php

class Etudiant_BDD {
    /** Méthodes statiques **/

    /**
     * Sauvegarde un objet Etudiant
     * @param $etudiant l'étudiant sauvegardé
     */
    public static function sauvegarder($etudiant, $affiche = true) {
	global $db;
	global $tab9;

	if ($etudiant->getEmailInstitutionel() == "") {
	    // Tentative pour trouver l'email institutionnel de l'étudiant dans le LDAP
	    $mailInstitutionnel = Utils::search_ldap($etudiant->getNom(), $etudiant->getPrenom(), $affiche);
	    $etudiant->setEmailInstitutionel($mailInstitutionnel);
	}

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
     * Récupérer un étudiant suivant son identifiant
     * @param $identifiantBDD l'identifiant de l'étudiant récupéré
     * @return String[] tableau contenant les informations d'un étudiant
     */
    public static function getEtudiant($identifiantBDD) {
	global $db;
	global $tab9;
	$sql = "SELECT * FROM $tab9 WHERE idetudiant='$identifiantBDD'";
	$req = $db->query($sql);
	return mysqli_fetch_array($req);
    }

    // Suppression d'un étudiant dans une promo --> Dans la table 'relation_promotion_etudiant_convention'
    public static function supprimerEtudiant($identifiantBDD, $idPromo) {
	global $db;
	global $tab19;
	$sql = "DELETE FROM $tab19 WHERE idetudiant='$identifiantBDD' AND idpromotion='$idPromo'";
	$db->query($sql);
    }

    // Suppression définitive d'un étudiant --> Dans la table 'etudiant'
    public static function supprimerDefinitivementEtudiant($identifiantBDD) {
	global $db;
	global $tab9;
	$sql = "DELETE FROM $tab9 WHERE idetudiant='$identifiantBDD'";
	$db->query($sql);
    }

    /**
     * Renvoie la liste des étudiants d'une promotion
     * @param $identifiantPromo l'identifiant de la promotion
     * @return String[] tableau contenant tous les étudiants de la promotion
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
     * Permet de rattacher a un étudiant une nouvelle promotion
     * @param $etu : identifiant de l'étudiant
     * @param $promo : identifiant de la promotion
     */
    public static function ajouterPromotion($etu, $promo) {
	global $db;
	global $tab19;

	$sql = "INSERT INTO $tab19(idetudiant, idpromotion) VALUES ('$etu', '$promo')";
	$db->query($sql);
    }

    /**
     * Permet de rattacher a un étudiant une nouvelle convention
     * @param $idetu : identifiant de l'étudiant
     * @param $idconv : identifiant de la convention
     * @param $idpromo : identifiant de la promotion
     */
    public static function ajouterConvention($idetu, $idconv, $idpromo) {
	global $db;
	global $tab19;

	$sql = "UPDATE $tab19 SET idconvention = '$idconv'
		WHERE idetudiant = '$idetu' AND idpromotion = '$idpromo'";
	$db->query($sql);
    }

    public static function recherchePromotion($etu, $annee) {
	global $db;
	global $tab19;
	global $tab15;

	$sql = "SELECT $tab19.idpromotion AS idpromo FROM $tab19, $tab15
		WHERE $tab19.idetudiant LIKE '$etu'
		AND $tab15.anneeuniversitaire LIKE '$annee'
		AND $tab19.idpromotion = $tab15.idpromotion";

	$req = $db->query($sql);
	$result = mysqli_fetch_array($req);
	return $result['idpromo'];
    }

    public static function rechercheConvention($etu, $annee) {
	global $db;
	global $tab19;
	global $tab15;
	global $tab4;

	$sql = "SELECT $tab19.idconvention AS idconv FROM $tab19, $tab4, $tab15
		WHERE $tab19.idetudiant='$etu'
		AND $tab15.anneeuniversitaire='$annee'
		AND $tab19.idpromotion = $tab15.idpromotion
		AND $tab19.idconvention = $tab4.idconvention";

	$req = $db->query($sql);
	$result = mysqli_fetch_array($req);
	return $result['idconv'];
    }

    /**
     * Recherche les étudiants s'appelant $nom $prenom
     * @global type $db
     * @global type $tab9
     * @param type $nom Le nom recherché
     * @param type $prenom Le prénom recherché�
     * @return array La liste des données des étudiants trouvés
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