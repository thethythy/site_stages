<?php

/**
 * Représentation et accès à la table n°12 : les offres d'alternance proposées par
 * les entreprises
 */

class offreDAlternance_BDD {

    /**
     * Enregistrer ou mettre à jour un objet OffreDAlternance ansi que les associations
     * avec les compétences, les filières et les parcours
     *
     * @global resource $db Référence sur la base ouverte
     * @global string $tab26 Nom de la table 'profilsouhaite_offredalternance'
     * @global string $tab27 Nom de la table 'theme_offredalternance'
     * @global string $tab28 Nom de la table 'relation_competence_offredalternance'
     * @global string $tab29 Nom de la table 'offredalternance'
     * @global string $tab36 Nom de la table "relation_promotion_offredalternance"
     * @param OffreDAlternance $offreDAlternance L'objet à enregistrer
     * @return integer L'identifiant de l'enregistrement
     */
    public static function sauvegarder($offreDAlternance) {
	global $db;
	global $tab26;
	global $tab27;
	global $tab28;
	global $tab29;
	global $tab36;

	$estVisible = $offreDAlternance->estVisible() ? 1 : 0;
	if ($offreDAlternance->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab29
		    VALUES ('0',
			    '" . $offreDAlternance->getSujet() . "',
			    '" . $offreDAlternance->getTitre() . "',
			    '" . $offreDAlternance->getDuree() . "',
			    '" . $offreDAlternance->getIndemnite() . "',
			    '" . $offreDAlternance->getRemarques() . "',
			    '$estVisible',
			    '" . $offreDAlternance->getIdContact() . "',
          '" . $offreDAlternance->getTypeContrat() . "');";

	    $db->query($sql);
	    $lastId = $db->insert_id;
	} else {
	    $sql = "UPDATE $tab29
		    SET sujet='" . $offreDAlternance->getSujet() . "',
			titre='" . $offreDAlternance->getTitre() . "',
			duree='" . $offreDAlternance->getDuree() . "',
			indemnite='" . $offreDAlternance->getIndemnite() . "',
			remarques='" . $offreDAlternance->getRemarques() . "',
			estVisible='$estVisible',
			idcontact='" . $offreDAlternance->getIdContact() . "'
		    WHERE idoffre='" . $offreDAlternance->getIdentifiantBDD() . "';";
	    $db->query($sql);

	    // Themes
	    $sql = "DELETE FROM $tab27 WHERE idoffre='" . $offreDAlternance->getIdentifiantBDD() . "';";
	    $db->query($sql);

	    // Profils
	    $sql = "DELETE FROM $tab26 WHERE idoffre='" . $offreDAlternance->getIdentifiantBDD() . "';";
	    $db->query($sql);

	    // Competences
	    $sql = "DELETE FROM $tab28 WHERE idoffre='" . $offreDAlternance->getIdentifiantBDD() . "';";
	    $db->query($sql);

	    // Promotions
	    $sql = "DELETE FROM $tab36 WHERE idoffre='". $offreDAlternance->getIdentifiantBDD() . "';";
	    $db->query($sql);

	    $lastId = $offreDAlternance->getIdentifiantBDD();
	}

	// Themes = Parcours
	$tabThemes = $offreDAlternance->getThemes();
	for ($i = 0; $i < sizeof($tabThemes); $i++) {
	    $sql = "INSERT INTO $tab27 VALUES('" . $tabThemes[$i]->getIdentifiantBDD() . "', '" . $lastId . "');";
	    $db->query($sql);
	}

	// Profils = Filière
	$tabProfils = $offreDAlternance->getListeProfilSouhaite();
	for ($i = 0; $i < sizeof($tabProfils); $i++) {
	    $sql = "INSERT INTO $tab26 VALUES('" . $lastId . "', '" . $tabProfils[$i]->getIdentifiantBDD() . "')";
	    $db->query($sql);
	}

	// Compétences
	$tabCompetences = $offreDAlternance->getListesCompetences();
	for ($i = 0; $i < sizeof($tabCompetences); $i++) {
	    $sql = "INSERT INTO $tab28 VALUES('" . $tabCompetences[$i]->getIdentifiantBDD() . "', '" . $lastId . "')";
	    $db->query($sql);
	}

	// Promotions
	$tabPromotions = $offreDAlternance->getPromotions();
	for ($i =0; $i < sizeof($tabPromotions); $i++) {
	    $sql = "INSERT INTO $tab36 VALUES('" . $tabPromotions[$i]->getIdentifiantBDD() . "', '" . $lastId . "')";
	    $db->query($sql);
	}

	return $lastId;
    }

    /**
     * Suppression d'un enregistrement à partir de son identifiant
     *
     * La table relation_competence_offredalternance est mise à jour du fait
     * des contraintes d'intégrité relationnelles
     *
     * La table profilsouhaite_offredalternance est mise à jour du fait
     * des contraintes d'intégrité relationnelles
     *
     * La table theme_offredalternance est mise à jour du fait
     * des contraintes d'intégrité relationnelles
     *
     * @global resource $db Référence sur la base ouverte
     * @global string $tab29 Nom de la table 'offredalternance'
     * @param integer $identifiantBDD Identifiant de l'enregistrement à supprimer
     */
    public static function delete($identifiantBDD) {
	global $db;
	global $tab29;

	$sql = "DELETE FROM $tab29 WHERE idoffre='$identifiantBDD'";
	$db->query($sql);
    }

    /**
     * Obtenir un enregistrement OffreDAlternance à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab26 Nom de la table 'profilsouhaite_offredalternance'
     * @global string $tab27 Nom de la table 'theme_offredalternance'
     * @global string $tab28 Nom de la table 'relation_competence_offredalternance'
     * @global string $tab29 Nom de la table 'offredalternance'
     * @global string $tab36 Nom de la table 'relation_promotion_offredalternance'
     * @param integer $identifiantBDD Identifiant de l'enregistrement cherché
     * @return enregistrement
     */
    public static function getOffreDAlternance($identifiantBDD) {
	global $db;
	global $tab26;
	global $tab27;
	global $tab28;
	global $tab29;
	global $tab36;

	$sql = "SELECT * FROM $tab29 WHERE idoffre='$identifiantBDD'";
	$res = $db->query($sql);
	$data = $res->fetch_array();
	$res->free();
	$tabOffreDAlternance = array();

	array_push($tabOffreDAlternance, $data['idoffre']);
	array_push($tabOffreDAlternance, $data['sujet']);
	array_push($tabOffreDAlternance, $data['titre']);

	// Parcours
	$sql2 = "SELECT * FROM $tab27 WHERE idoffre='$identifiantBDD'";
	$res2 = $db->query($sql2);
	$tabThemes = array();
	while ($theme = $res2->fetch_array()) {
	    array_push($tabThemes, $theme['idparcours']);
	}
	$res2->free();
	array_push($tabOffreDAlternance, $tabThemes);

	// Filiere
	$sql3 = "SELECT * FROM $tab26 WHERE idoffre='$identifiantBDD'";
	      $res3 = $db->query($sql3);
	$tabProfils = array();
	while ($profil = $res3->fetch_array()) {
	    array_push($tabProfils, $profil['idfiliere']);
	}
	$res3->free();
	array_push($tabOffreDAlternance, $tabProfils);

	array_push($tabOffreDAlternance, $data['duree']);
	array_push($tabOffreDAlternance, $data['indemnite']);
	array_push($tabOffreDAlternance, $data['remarques']);
	array_push($tabOffreDAlternance, $data['estVisible']);

	// Compétences
	$sql4 = "SELECT * FROM $tab28 WHERE idoffre='$identifiantBDD'";
	$res4 = $db->query($sql4);
	$tabCompetences = array();
	while ($competence = $res4->fetch_array()) {
	    array_push($tabCompetences, $competence['idcompetence']);
	}
	$res4->free();
	array_push($tabOffreDAlternance, $tabCompetences);

	array_push($tabOffreDAlternance, $data['idcontact']);
	array_push($tabOffreDAlternance, $data['typedecontrat']);

	// Promotions
	$sql5 = "SELECT * FROM $tab36 WHERE idoffre='$identifiantBDD'";
	$res5 = $db->query($sql5);
	$tabPromotions = array();
	while ($promotion = $res5->fetch_array()) {
	    array_push($tabPromotions, $promotion['idpromotion']);
	}
	$res5->free();
	array_push($tabOffreDAlternance, $tabPromotions);

	return $tabOffreDAlternance;
    }

    /**
     * Obtenir une liste d'offres d'alternance correspondant à un filtre
     * @global resource $db Référence sur la base ouverte
     * @global string $tab3 Nom de la table 'contact'
     * @global string $tab6 Nom de la table 'entreprise'
     * @global string $tab26 Nom de la table 'profilsouhaite_offredalternance'
     * @global string $tab27 Nom de la table 'theme_offredalternance'
     * @global string $tab28 Nom de la table 'relation_competence_offredalternance'
     * @global string $tab29 Nom de la table 'offredalternance'
     * @global string $tab36 Nom de la table 'relation_promotion_offredalternance'
     * @param Filtre $filtre Le filtre de la recherche
     * @return tableau d'enregistrements
     */
    public static function getListeOffreDAlternance($filtre) {
	global $db;
	global $tab3;
	global $tab6;
	global $tab26;
	global $tab27;
	global $tab28;
	global $tab29;
	global $tab36;

	// --------------------------------------------------------------------
	// Recherche des identifiants des offres d'alternance selon le filtre

	if ($filtre == "") {
	    $requete = "SELECT $tab29.idoffre FROM $tab29";
	} else {

	    $table = "FROM $tab29,$tab3,$tab6";

	    $requete = "WHERE $tab29.idcontact=$tab3.idcontact AND $tab6.identreprise=$tab3.identreprise";

	    $pos1 = strripos($filtre->getStrFiltres(), "idfiliere");
	    $pos2 = strripos($filtre->getStrFiltres(), "idparcours");
	    $pos3 = strripos($filtre->getStrFiltres(), "idcompetence");
	    $pos4 = strripos($filtre->getStrFiltres(), "idpromotion");

	    if ($pos1 !== false) {
		$requete = $requete . " AND $tab26.idoffre=$tab29.idoffre";
		$table = $table . ",$tab26";
	    }

	    if ($pos2 !== false) {
		$requete = $requete . " AND $tab27.idoffre=$tab29.idoffre";
		$table = $table . "," . $tab27;
	    }

	    if ($pos3 !== false) {
		$requete = $requete . " AND $tab28.idoffre=$tab29.idoffre";
		$table = $table . "," . $tab28;
	    }

	    if ($pos4 !== false) {
		$requete = $requete . " AND $tab36.idoffre=$tab29.idoffre";
		$table = $table . "," . $tab36;
	    }

	    $requete = "SELECT DISTINCT $tab29.idoffre $table $requete AND " . $filtre->getStrFiltres() . " ORDER BY $tab29.idoffre";
	}

	$result = $db->query($requete);

	// --------------------------------------------------------------------
	// Construire le tableau des enregistrements trouvés

	$tabODS = array();

	if ($result != FALSE) {
	    while ($idods = $result->fetch_array()) {
		$ods = offreDAlternance_BDD::getOffreDAlternance($idods['idoffre']);
		array_push($tabODS, $ods);
	    }
	    $result->free();
	}

	return $tabODS;
    }

    public static function supprimerSuivi($idOffre){
      global $db;
      global $tab30;

      $sql = "DELETE FROM $tab30 WHERE idoffre='$idOffre'";
      $db->query($sql);
    }

}

?>
