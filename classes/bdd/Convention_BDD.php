<?php

/**
 * Représentation et accès à la table n°4 : les conventions de stage
 */

class Convention_BDD {

    /**
     * Sauvegarde ou et met à jour un objet Convention
     * @global resource $db Référence à la base ouverte
     * @global string $tab4 Nom de la table 'convention'
     * @param Convention $convention La convention à sauvegarder
     */
    public static function sauvegarder($convention) {
	global $db;
	global $tab4;

	$parrain = $convention->getParrain();
	$examinateur = $convention->getExaminateur();
	$etudiant = $convention->getEtudiant();
	$contact = $convention->getContact();

	// Test si la chaîne contenant le sujet n'est pas déjà échappé
	if (strpos($convention->getSujetDeStage(), '\\') === false) {
	    $convention->setSujetDeStage(mysqli_real_escape_string($db, $convention->getSujetDeStage()));
	}

	// Permet de vérifier si la Convention existe déjà dans la BDD
	if ($convention->getIdentifiantBDD() == "") {
	    // Création de la Convention
	    $requete = "INSERT INTO $tab4(idparrain, idexaminateur, idetudiant, idcontact, sujetdestage, idTheme)
			VALUES ('" . $parrain->getIdentifiantBDD() . "',
				'" . $examinateur->getIdentifiantBDD() . "',
				'" . $etudiant->getIdentifiantBDD() . "',
				'" . $contact->getIdentifiantBDD() . "',
				'" . $convention->getSujetDeStage() . "',
				'" . $convention->getIdTheme() . "')";
	    $db->query($requete);

	    $sql = "SELECT LAST_INSERT_ID() AS ID FROM $tab4";
	    $req = $db->query($sql);
	    $result = mysqli_fetch_array($req);
	    return $result['ID'];
	} else {
	    // Mise à jour de la Convention
	    $requete = "UPDATE $tab4 SET idparrain = '" . $parrain->getIdentifiantBDD() . "',
					 idexaminateur = '" . $examinateur->getIdentifiantBDD() . "',
					 idetudiant = '" . $etudiant->getIdentifiantBDD() . "',
					 idsoutenance = '" . $convention->getIdSoutenance() . "',
					 idcontact = '" . $contact->getIdentifiantBDD() . "',
					 sujetdestage = '" . $convention->getSujetDeStage() . "',
					 asonresume ='" . $convention->getASonResume() . "',
					 note = '" . $convention->getNote() . "',
					 idtheme = '" . $convention->getIdTheme() . "'
			WHERE idconvention = '" . $convention->getIdentifiantBDD() . "'";

	    $req = $db->query($requete);
	    if (!$req) { return FALSE; }

	    return $convention->getIdentifiantBDD();
	}
    }

    /**
     * Obtenir une convention à partir de son identifiant
     * @global resource $db Référence à la base ouverte
     * @global string $tab4 Nom de la table 'convention'
     * @param integer $id Identifiant de la convention
     * @return Un enregistrement ou NULL
     */
    public static function getConvention($id) {
	global $db;
	global $tab4;

	$requete = "SELECT * FROM $tab4 WHERE idconvention='$id'";
	$convention = $db->query($requete);
	return mysqli_fetch_array($convention);
    }

    /**
     * Retourne la convention d'un étudiant d'une certaine promotion
     * @global resource $db Référence à la base ouverte
     * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
     * @global string $tab4 Nom de la table 'convention'
     * @param integer $idetudiant Identifiant de l'étudiant
     * @param integer $idpromotion Identifiant de la promotion
     * @return enregistrement ou NULL
     */
    public static function getConvention2($idetudiant, $idpromotion) {
	global $db;
	global $tab19;
	global $tab4;

	$requete = "SELECT $tab4.idconvention
		    FROM $tab19, $tab4
		    WHERE $tab19.idetudiant = $idetudiant AND
			  $tab19.idpromotion = $idpromotion AND
			  $tab4.idconvention=$tab19.idconvention";
	$result = $db->query($requete);
	$dConvention = mysqli_fetch_array($result);
	return Convention_BDD::getConvention($dConvention["idconvention"]);
    }

    /**
     * Obtenir une liste de conventions filtrées
     * @global resource $db Référence à la base ouverte
     * @global string $tab4 Nom de la table 'convention'
     * @global string $tab15 Nom de la table 'promotion'
     * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
     * @param objet Filtre $filtre Le filtre global à appliquer
     * @return Tableau d'enregistrements
     */
    public static function getListeConvention($filtre) {
	global $db;
	global $tab4;
	global $tab15;
	global $tab19;

	if ($filtre == "") {
	    $requete = "SELECT * FROM $tab4 ORDER BY $tab4.idparrain";
	} else {
	    $requete = "SELECT *
			FROM $tab4, $tab15, $tab19
			WHERE $tab4.idconvention=$tab19.idconvention AND
			      $tab15.idpromotion=$tab19.idpromotion AND
			      ". $filtre->getStrFiltres() ."
			ORDER BY $tab4.idparrain ";
	}

	$result = $db->query($requete);

	$tabC = array();

	while ($ods = mysqli_fetch_array($result)) {
	    $tab = array();
	    array_push($tab, $ods['idconvention']);
	    array_push($tab, $ods['sujetdestage']);
	    array_push($tab, $ods['asonresume']);
	    array_push($tab, $ods['note']);
	    array_push($tab, $ods['idparrain']);
	    array_push($tab, $ods['idexaminateur']);
	    array_push($tab, $ods['idetudiant']);
	    array_push($tab, $ods['idsoutenance']);
	    array_push($tab, $ods['idcontact']);
	    array_push($tab, $ods['idtheme']);

	    array_push($tabC, $tab);
	}

	return $tabC;
    }

    /**
     * Calcul le nombre de parrainage pour un référent et pour une promotion
     * @global resource $db Référence à la base ouverte
     * @global string $tab15 Nom de la table 'promotion'
     * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
     * @param integer $annee L'année de la promotion concernée
     * @param integer $parrain L'identifiant du parrain concerné
     * @param integer $filiere L'identifiant de la filière concernée
     * @param integer $parcours L'identifiant du parcours concerné
     * @return integer
     */
    public static function compteConvention($annee, $parrain, $filiere, $parcours) {
	global $db;
	global $tab15;
	global $tab19;

	$requete = "SELECT $tab19.idconvention
		    FROM $tab15, $tab19
		    WHERE $tab15.anneeuniversitaire='$annee' AND
			  $tab15.idfiliere='$filiere' AND
			  $tab15.idparcours='$parcours' AND
			  $tab19.idpromotion=$tab15.idpromotion";

	$result = $db->query($requete);

	$compte = 0;
	while ($ods = mysqli_fetch_array($result)) {
	    if (Convention::getConvention($ods["idconvention"])->getParrain()->getIdentifiantBDD() == $parrain)
		$compte++;
	}

	return $compte;
    }

    /**
     * Test si une convention existe ou pas pour un étudiant pour une certaine année
     * @global resource $db Référence à la base ouverte
     * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
     * @param objet Convention $conv Une convention pour un étudiant
     * @param integer $annee L'année de la convention
     * @return boolean
     */
    public static function existe($conv, $annee) {
	global $db;
	global $tab19;

	$etu = $conv->getEtudiant();
	$promo = $etu->getPromotion($annee);

	if ($promo == "")
	    return false;

	$sql = "SELECT idconvention
		FROM $tab19
		WHERE idpromotion='" . $promo->getIdentifiantBDD() . "' AND
		      idetudiant='" . $etu->getIdentifiantBDD() . "' AND
		      idconvention <> 0";

	$result = $db->query($sql);

	if (mysqli_num_rows($result) == 0)
	    return false;
	else
	    return true;
    }

    /**
     * Test si une convention existe ou pas pour un contact
     * @global resource $db Référence à la base ouverte
     * @global string $tab15 Nom de la table 'promotion'
     * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
     * @param integer $idcontact Identifiant du contact
     * @param objet Filtre $filtre Filtre éventuel sur l'année, la filière et le parcours
     * @return boolean
     */
    public static function existe2($idcontact, $filtre) {
	global $db;
	global $tab15;
	global $tab19;

	if ($filtre != '')
	    $requete = "SELECT $tab19.idconvention
			FROM $tab15, $tab19
			WHERE " . $filtre->getStrFiltres() . " AND
			      $tab19.idpromotion=$tab15.idpromotion";
	else
	    $requete = "SELECT $tab19.idconvention FROM $tab19";

	$result = $db->query($requete);

	$compte = 0;
	while ($ods = mysqli_fetch_array($result)) {
	    if (Convention::getConvention($ods["idconvention"])->getContact()->getIdentifiantBDD() == $idcontact)
		$compte++;
	}

	if ($compte > 0)
	    return true;
	else
	    return false;
    }

    /**
     * Suppression d'une convention en base
     *
     * Du fait des contraintes d'intégrité référentielle, la table n°19
     * 'relation_promotion_etudiant_convention' est mise à jour automatiquement
     *
     * Du fait des contraintes d'intégrité référentielle, la table n°25
     * 'attribution' est mise à jour automatiquement
     *
     * @global resource $db Référence à la base ouverte
     * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
     * @global string $tab4 Nom de la table 'convention'
     * @param integer $identifiantBDD Identifiant de la convention à supprimer
     * @param integer $idEtu Identifiant de l'étudiant concerné
     * @param integer $idPromo Identifiant de la promotion de l'étudiant concerné
     */
    public static function supprimerConvention($identifiantBDD) {
	global $db;
	global $tab4;

	// Suppression de l'enregistrement dans la table 'convention'
	$sql2 = "DELETE FROM $tab4 WHERE idconvention='$identifiantBDD'";
	$db->query($sql2);
    }

    /**
     * Retourne l'identifiant de la promotion d'un étudiant d'une convention donnée
     * @global resource $db Référence à la base ouverte
     * @global string $tab4 Nom de la table 'convention'
     * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
     * @param integer $idConvention Identifiant de la convention concernée
     * @return integer
     */
    public static function getPromotion($idConvention) {
	global $db;
	global $tab4;
	global $tab19;

	$sql = "SELECT $tab19.idpromotion AS idpromo
		FROM $tab19, $tab4
		WHERE $tab19.idconvention = $tab4.idconvention AND
		      $tab4.idconvention = $idConvention";

	$req = $db->query($sql);
	$result = mysqli_fetch_array($req);
	return $result['idpromo'];
    }

}

?>