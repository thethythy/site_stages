<?php

class Etudiant_BDD {
    /** M�thodes statiques **/

    /**
     * Sauvegarde un objet Etudiant
     * @param $etudiant l'�tudiant � sauvegarder
     */
    public static function sauvegarder($etudiant, $affiche = true) {
	global $tab9;
	global $db;

	if ($etudiant->getEmailInstitutionel() == "") {
	    // Tentative pour trouver l'email institutionnel de l'�tudiant dans le LDAP
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
	    $req = $db->query($sql);
	    $result = mysqli_fetch_array($req);
	    return $result['ID'];
	} else {
	    $sql = "UPDATE $tab9 SET
			nometudiant='" . $etudiant->getNom() . "',
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
     * R�cup�re un �tudiant suivant son identifiant
     * @param $identifiantBDD l'identifiant de l'�tudiant � r�cup�rer
     * @return String[] tableau contenant les informations d'un �tudiant
     */
    public static function getEtudiant($identifiantBDD) {
	global $tab9;
	global $db;

	$sql = "SELECT * FROM $tab9 WHERE idetudiant='$identifiantBDD'";
	$req = $db->query($sql);
	return mysqli_fetch_array($req);
    }

    // Suppression d'un �tudiant dans une promo --> Dans la table 'relation_promotion_etudiant_convention'
    public static function supprimerEtudiant($identifiantBDD, $idPromo) {
	global $tab19;
	global $db;

	$sql = "DELETE FROM $tab19 WHERE idetudiant='$identifiantBDD' AND idpromotion='$idPromo'";
	//echo $sql."<br/>";
	$db->query($sql);
    }

    // Suppression d�finitive d'un �tudiant --> Dans la table 'etudiant'
    public static function supprimerDefinitivementEtudiant($identifiantBDD) {
	global $tab9;
	global $db;

	$sql = "DELETE FROM $tab9 WHERE idetudiant='$identifiantBDD'";
	//echo $sql."<br/>";
	$db->query($sql);
    }

    /**
     * Renvoie la liste des �tudiants d'une promotion
     * @param $identifiantPromo l'identifiant de la promotion
     * @return String[] tableau contenant tous les �tudiants de la promotion
     */
    public static function getListeEtudiants($identifiantPromo) {
	$listeEtudiants = array();
	global $tab9;
	global $tab19;
	global $db;

	$result = array();
	$sql = "SELECT idetudiant FROM $tab19 WHERE idpromotion='$identifiantPromo'";
	//echo "REQUETE 1 : ".$sql."<br/>";
	$req = $db->query($sql);

	$sql2 = "SELECT * FROM $tab9 WHERE";
	$aucunEtudiant = true;

	while ($idEtu = mysqli_fetch_array($req, MYSQL_ASSOC)) {
	    $aucunEtudiant = false;
	    $sql2 .= " idetudiant='" . $idEtu["idetudiant"] . "' OR";
	}

	if ($aucunEtudiant == false) {
	    $sql2 = substr_replace($sql2, "", -3, 3);
	    $sql2 .= " ORDER BY nometudiant ASC;";
	    //echo "REQUETE 2 : ".$sql2."<br/>";
	    $req = $db->query($sqlb);

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
     * Permet de rattacher a un �tudiant � une nouvelle promotion
     * @param $etu		:	identifiant de l'�tudiant
     * @param $promo	:	identifiant de la promotion
     */
    public static function ajouterPromotion($etu, $promo) {
	global $tab19;
	global $db;

	$sql = "INSERT INTO $tab19(idetudiant, idpromotion) VALUES ('$etu', '$promo')";
	$req = $db->query($sql);
    }

    /**
     * Permet de rattacher a un �tudiant � une nouvelle convention
     * @param $idetu	:	identifiant de l'�tudiant
     * @param $idconv	:	identifiant de la convention
     * @param $idpromo	:	identifiant de la promotion
     */
    public static function ajouterConvention($idetu, $idconv, $idpromo) {
	global $tab19;
	global $db;

	$sql = "UPDATE $tab19 SET idconvention = '$idconv'
		WHERE idetudiant = '$idetu' AND idpromotion = '$idpromo'";
	$req = $db->query($sql);
    }

    public static function recherchePromotion($etu, $annee) {
	global $tab19;
	global $tab15;
	global $db;

	$sql = "SELECT $tab19.idpromotion AS idpromo FROM $tab19, $tab15
		WHERE $tab19.idetudiant LIKE '$etu'
		AND $tab15.anneeuniversitaire LIKE '$annee'
		AND $tab19.idpromotion = $tab15.idpromotion";

	// echo "REQUETE : ".$sql."<br/>";
	$req = $db->query($sql);
	$result = mysqli_fetch_array($req);
	// echo "RESULT : ".$result['idpromo']."<br/>";
	return $result['idpromo'];
    }

    public static function rechercheConvention($etu, $annee) {
	global $tab19;
	global $tab15;
	global $tab4;
	global $db;

	$sql = "SELECT $tab19.idconvention AS idconv FROM $tab19, $tab4, $tab15
		WHERE $tab19.idetudiant='$etu'
		AND $tab15.anneeuniversitaire='$annee'
		AND $tab19.idpromotion = $tab15.idpromotion
		AND $tab19.idconvention = $tab4.idconvention";

	//echo "REQUETE : ".$sql."<br/>";
	$req = $db->query($sql);
	$result = mysqli_fetch_array($req);
	//echo "Result : ".$result['idpromo']."<br/>";
	return $result['idconv'];
    }

    /**
     * Recherche les �tudiants s'appelant $nom $prenom
     * @global type $db
     * @global type $tab9
     * @param type $nom Le nom recherch�
     * @param type $prenom Le pr�nom recherch�
     * @return array La liste des donn�es des �tudiants trouv�s
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