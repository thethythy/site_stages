<?php

/**
 * Représentation et accès à la table n°5 : les dates de soutenance
 */

class DateSoutenance_BDD {

    /**
     * Enregistrer en base un objet DateSoutenance
     * @global resource $db Référence sur la base ouverte
     * @global string $tab5 Nom de la table 'datesoutenance'
     * @param DateSoutenance $dateSoutenance L'objet à enregistrer
     * @return integer L'identifiant de l'enregistrement
     */
    public static function sauvegarder($dateSoutenance) {
	global $db;
	global $tab5;

	if ($dateSoutenance->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab5 VALUES ('', '" . $dateSoutenance->getJour() . "','" . $dateSoutenance->getMois() . "','" . $dateSoutenance->getAnnee() . "', '". $dateSoutenance->getConvocation() ."')";
	} else {
	    $sql = "UPDATE $tab5 SET jour='" . $dateSoutenance->getJour() . "', mois='" . $dateSoutenance->getMois() . "', annee='" . $dateSoutenance->getAnnee() . "', convocation='". $dateSoutenance->getConvocation() ."'
		    WHERE iddatesoutenance=" . $dateSoutenance->getIdentifiantBDD();
	}
	$db->query($sql);
	return ($dateSoutenance->getIdentifiantBDD() != "") ? $dateSoutenance->getIdentifiantBDD() : $db->insert_id;
    }

    /**
     * Association d'une date de soutenance à une ou plusieurs promotions
     * @global resource $db Référence sur la base ouverte
     * @global string $tab1 Nom de la table 'relation_promotion_datesoutenance'
     * @param integer $idDateSoutenance Identifiant de la date de soutenance
     * @param tableau d'integer $promos Liste des identifants des promos
     */
    public static function sauvegarderRelationPromo($idDateSoutenance, $promos) {
	global $db;
	global $tab1;

	// Suppression des éventuelles anciennes associations
	DateSoutenance_BDD::deleteDatePromo($idDateSoutenance);

	// Association de la date avec chaque promotion
	foreach ($promos as $promo) {
	    $sql = "INSERT INTO $tab1 (iddatesoutenance, idpromotion) VALUES ('$idDateSoutenance', '$promo');";
	    $db->query($sql);
	}
    }

    /**
     * Obtenir un enregistrement à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab5 Nom de la table 'datesoutenance'
     * @param integer $identifiant Identifiant de l'enregistrement cherché
     * @return enregistrement ou FALSE
     */
    public static function getDateSoutenance($identifiant) {
	global $db;
	global $tab5;

	$sql = "SELECT * FROM $tab5 WHERE iddatesoutenance='$identifiant';";
	$res = $db->query($sql);

	if ($res) {
	    $enreg = $res->fetch_array();
	    $res->free();
	    return $enreg;
	}
	else
	    return FALSE;
    }

    /**
     * Obtenir des enregistrements DateSoutenance (correspondants à un filtre éventuel)
     * @global resource $db Référence sur la base ouverte
     * @global string $tab5 Nom de la table 'datesoutenance'
     * @param Filtre $filtre Filtre à utiliser éventuel
     * @param string $ordre L'ordre d'ordonnancement du résultat
     * @return tableau d'enregistrements
     */
    public static function listerDateSoutenance($filtre, $ordre) {
	global $db;
	global $tab5;

	if ($filtre == '')
	    $sql = "SELECT * FROM $tab5 ORDER BY annee $ordre, mois $ordre, jour $ordre;";
	else
	    $sql = "SELECT * FROM $tab5 WHERE " . $filtre->getStrFiltres() . " ORDER BY annee $ordre, mois $ordre, jour $ordre;";

	$result = $db->query($sql);

	$tabDateSoutenance = array();

	if ($result) {
	    while ($dateSoutenance = $result->fetch_array()) {
		$tab = array();
		array_push($tab, $dateSoutenance["iddatesoutenance"]);
		array_push($tab, $dateSoutenance["jour"]);
		array_push($tab, $dateSoutenance["mois"]);
		array_push($tab, $dateSoutenance["annee"]);
		array_push($tab, $dateSoutenance["convocation"]);
		array_push($tabDateSoutenance, $tab);
	    }
	    $result->free();
	}

	return $tabDateSoutenance;
    }

    /**
     * Obtenir la liste des promotions associées à une date de soutenance
     * @global resource $db Référence sur la base ouverte
     * @global string $tab1 Nom de la table 'relation_promotion_datesoutenance'
     * @param integer $idDate Identifiant de la date de soutenance associée
     * @return tableaux d'integer (identifiants des promotions associées)
     */
    public static function listerRelationPromoDate($idDate) {
	global $db;
	global $tab1;

	$sql = "SELECT idpromotion FROM $tab1 WHERE iddatesoutenance='$idDate';";
	$result = $db->query($sql);

	if ($result) {
	    $enreg = $result->fetch_array();
	    $result->free();
	    return $enreg;
	} else {
	    return FALSE;
	}
    }

    /**
     * Suppression d'un enregistrement DateSoutenance à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab5 Nom de la table 'datesoutenance'
     * @param integer $identifiantBDD Identifiant de l'enregistrement à supprimer
     */
    public static function delete($identifiantBDD) {
	global $db;
	global $tab5;
	$sql = "DELETE FROM $tab5 WHERE iddatesoutenance='$identifiantBDD';";
	$db->query($sql);
    }

    /**
     * Suppression de l'association entre une date de soutenance et des promotions
     * @global resource $db Référence sur la base ouverte
     * @global string $tab1 Nom de la table 'relation_promotion_datesoutenance'
     * @param integer $identifiantBDD Identifiant de la date de soutenance associée
     */
    public static function deleteDatePromo($identifiantBDD) {
	global $db;
	global $tab1;
	$sql = "DELETE FROM $tab1 WHERE iddatesoutenance='$identifiantBDD';";
	$db->query($sql);
    }

}

?>