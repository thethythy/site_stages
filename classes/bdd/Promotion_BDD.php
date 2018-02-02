<?php

/**
 * Représentation et accès à la table n°15 : les promotions d'étudiants
 */

class Promotion_BDD {

    /**
     * Enregistrer ou mettre à jour un objet Promotion
     * @global resource $db Référence sur la base ouverte
     * @global string $tab15 Nom de la table 'promotion'
     * @param Promotion $promotion L'objet à enregistrer
     * @return integer Identifiant de l'enregistrement
     */
    public static function sauvegarder($promotion) {
	global $db;
	global $tab15;

	$parcours = $promotion->getParcours();
	$idParcours = $parcours->getIdentifiantBDD();

	$filiere = $promotion->getFiliere();
	$idFiliere = $filiere->getIdentifiantBDD();

	if ($promotion->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab15(anneeuniversitaire, idparcours, idfiliere, email_promotion)
		    VALUES ('" . $promotion->getAnneeUniversitaire() . "',
			    '$idParcours',
			    '$idFiliere',
			    '" . $promotion->getEmailPromotion() . "');";
	    $db->query($sql);

	    $sql2 = "SELECT LAST_INSERT_ID() AS ID FROM $tab15";
	    $req = $db->query($sql2);
	    $result = mysqli_fetch_array($req);
	    return $result['ID'];
	} else {
	    $sql = "UPDATE $tab15
		    SET anneeuniversitaire='" . $promotion->getAnneeUniversitaire() . "',
			idparcours='$idParcours',
			idfiliere='$idFiliere',
			email_promotion='" . $promotion->getEmailPromotion() . "'
		    WHERE idpromotion ='" . $promotion->getIdentifiantBDD() . "'";

	    $db->query($sql);
	    return $promotion->getIdentifiantBDD();
	}
    }

    /**
     * Obtenir un enregistrement Promotion à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab15 Nom de la table 'promotion'
     * @param integer $identifiantBDD Identifiant de l'enregistrement recherché
     * @return enregistrement
     */
    public static function getPromotion($identifiantBDD) {
	global $db;
	global $tab15;
	$sql = "SELECT * FROM $tab15 WHERE idpromotion='$identifiantBDD'";
	$req = $db->query($sql);
	return mysqli_fetch_array($req);
    }

    /**
     * Obtenir un enregistrement Promotion à partir de l'année, la filière et le parcours
     * @global resource $db Référence sur la base ouverte
     * @global string $tab15 Nom de la table 'promotion'
     * @param integer $annee L'année recherchée
     * @param integer $idfiliere La filière recherchée
     * @param integer $idparcours Le parcours recherché
     * @return enregistrement
     */
    public static function getPromotionFromParcoursAndFiliere($annee, $idfiliere, $idparcours) {
	global $db;
	global $tab15;
	$sql = "SELECT * FROM $tab15 WHERE anneeuniversitaire='$annee' AND idparcours='$idparcours' AND idfiliere='$idfiliere'";
	$req = $db->query($sql);
	return mysqli_fetch_array($req);
    }

    /**
     * Obtenir la liste des années de toutes les promotions
     * @global resource $db Référence sur la base ouverte
     * @global string $tab15 Nom de la table 'promotion'
     * @return tableau d'integer
     */
    public static function getAnneesUniversitaires() {
	global $db;
	global $tab15;

	$sql = "SELECT DISTINCT anneeuniversitaire FROM $tab15 ORDER BY anneeuniversitaire DESC";
	$req = $db->query($sql);

	$tabAU = array();

	while ($au = mysqli_fetch_array($req))
	    array_push($tabAU, $au[0]);

	return $tabAU;
    }

    /**
     * Obtenir les enregistrements des promotions correspondes à un filtre
     * @global resource $db Référence sur la base ouverte
     * @global string $tab15 Nom de la table 'promotion'
     * @param Filtre $filtre Le filtre global à utiliser
     * @return tableau des enregistrements
     */
    public static function getListePromotions($filtre) {
	global $db;
	global $tab15;

	if ($filtre == "")
	    $requete = "SELECT * FROM $tab15";
	else
	    $requete = "SELECT * FROM $tab15 WHERE " . $filtre->getStrFiltres();

	$res = $db->query($requete);

	$tabPromos = array();
	while ($p = mysqli_fetch_array($res)) {
	    $tab = array();
	    array_push($tab, $p["idpromotion"]);
	    array_push($tab, $p["anneeuniversitaire"]);
	    array_push($tab, $p["idparcours"]);
	    array_push($tab, $p["idfiliere"]);
	    array_push($tab, $p["email_promotion"]);
	    array_push($tabPromos, $tab);
	}

	return $tabPromos;
    }

    /**
     * Obtenir l'année de la promotion la plus récente
     * @global resource $db Référence sur la base ouverte
     * @global string $tab15 Nom de la table 'promotion'
     * @return integer L'année la plus récente trouvée
     */
    public static function getLastAnnee() {
	global $db;
	global $tab15;

	$sql = "SELECT MAX(anneeuniversitaire) as maxAU FROM $tab15";
	$req = $db->query($sql);
	$result = mysqli_fetch_array($req);
	return $result['maxAU'];
    }

    /**
     * Suppression d'un enregistrement Promotion à parir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab15 Nom de la table 'promotion'
     * @param integer $identifiantBDD Identifant de la promotion à supprimer
     */
    public static function supprimerPromotion($identifiantBDD) {
	global $db;
	global $tab15;

	$sql = "DELETE FROM $tab15 WHERE idpromotion='$identifiantBDD'";
	$db->query($sql);
    }

    /**
     * Test si une certaine promotion existe déjà en base
     * @global resource $db Référence sur la base ouverte
     * @global string $tab15 Nom de la table 'promotion'
     * @param Promotion $promo L'objet dont l'existence est à tester
     * @return boolean
     */
    public static function existe($promo) {
	global $db;
	global $tab15;

	$filiere = $promo->getFiliere();
	$parcours = $promo->getParcours();

	$sql = "SELECT idpromotion FROM $tab15
		WHERE anneeuniversitaire='" . $promo->getAnneeUniversitaire() . "' AND
		      idfiliere='" . $filiere->getIdentifiantBDD() . "' AND
		      idparcours='" . $parcours->getIdentifiantBDD() . "' AND
		      email_promotion='" . $promo->getEmailPromotion() . "'";
	$result = $db->query($sql);

	if (mysqli_num_rows($result) == 0)
	    return false;
	else
	    return true;
    }

}

?>