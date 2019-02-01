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
     * @param OffreDAlternance $offreDAlternance L'objet à enregistrer
     * @return integer L'identifiant de l'enregistrement
     */
    public static function sauvegarder($offreDAlternance) {
	global $db;
	global $tab26;
	global $tab27;
	global $tab28;
	global $tab29;

	$estVisible = $offreDAlternance->estVisible() ? 1 : 0;
  $d = fopen("log.txt", "a+");
  fwrite($d, "\n->$estVisible<-\n");
  fclose($d);
	if ($offreDAlternance->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab29
		    VALUES ('0',
			    '" . $offreDAlternance->getSujet() . "',
			    '" . $offreDAlternance->getTitre() . "',
			    '" . $offreDAlternance->getListeEnvironnements() . "',
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
			listeenvironnement='" . $offreDAlternance->getListeEnvironnements() . "',
<<<<<<< HEAD
			dureemin='" . $offreDAlternance->getDuree() . "',
=======
			duree='" . $offreDAlternance->getDuree() . "',
>>>>>>> thomas
			indemnite='" . $offreDAlternance->getIndemnite() . "',
			remarques='" . $offreDAlternance->getRemarques() . "',
			estVisible='$estVisible',
			idcontact='" . $offreDAlternance->getIdContact() . "'
		    WHERE idoffre='" . $offreDAlternance->getIdentifiantBDD() . "';";
	    $db->query($sql);

	    //Themes
	    $sql = "DELETE FROM $tab27 WHERE idoffre='" . $offreDAlternance->getIdentifiantBDD() . "';";
	    $db->query($sql);

	    //Profils
	    $sql = "DELETE FROM $tab26 WHERE idoffre='" . $offreDAlternance->getIdentifiantBDD() . "';";
	    $db->query($sql);

	    //Competences
	    $sql = "DELETE FROM $tab28 WHERE idoffre='" . $offreDAlternance->getIdentifiantBDD() . "';";
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
     * @param integer $identifiantBDD Identifiant de l'enregistrement cherché
     * @return enregistrement
     */
    public static function getOffreDAlternance($identifiantBDD) {
	global $db;
	global $tab26;
	global $tab27;
	global $tab28;
	global $tab29;

	$sql = "SELECT * FROM $tab29 WHERE idoffre='$identifiantBDD'";
	$res = $db->query($sql);
	$data = $res->fetch_array();
	$res->free();
	$tabOffreDAlternance = array();

	array_push($tabOffreDAlternance, $data['idoffre']);
	array_push($tabOffreDAlternance, $data['sujet']);
	array_push($tabOffreDAlternance, $data['titre']);
	array_push($tabOffreDAlternance, $data['listeenvironnement']);

	$sql2 = "SELECT * FROM $tab27 WHERE idoffre='$identifiantBDD'";
	$res2 = $db->query($sql2);
	$tabThemes = array();
	while ($theme = $res2->fetch_array()) {
	    array_push($tabThemes, $theme['idparcours']);
	}
	$res2->free();
	array_push($tabOffreDAlternance, $tabThemes);

<<<<<<< HEAD
	$sql3 = "SELECT * FROM $tab26 WHERE idoffre='$identifiantBDD'";
	$res3 = $db->query($sql3);
	$tabProfils = array();
	while ($profil = $res3->fetch_array()) {
	    array_push($tabProfils, $profil['idfiliere']);
	}
	$res3->free();
	array_push($tabOffreDAlternance, $tabProfils);

	array_push($tabOffreDAlternance, $data['dureemin']);
	array_push($tabOffreDAlternance, $data['dureemax']);
	array_push($tabOffreDAlternance, $data['indemnite']);
	array_push($tabOffreDAlternance, $data['remarques']);
	array_push($tabOffreDAlternance, $data['estVisible']);
=======


  $sql3 = "SELECT * FROM $tab26 WHERE idoffre='$identifiantBDD'";
	$res3 = $db->query($sql3);
  $tabProfils = array();
  while ($profil = $res3->fetch_array()) {
      array_push($tabProfils, $profil['idfiliere']);
  }
  $res3->free();
  array_push($tabOffreDAlternance, $tabProfils);


  array_push($tabOffreDAlternance, $data['duree']);//Erreur ici
  array_push($tabOffreDAlternance, $data['indemnite']);
  array_push($tabOffreDAlternance, $data['remarques']);
  array_push($tabOffreDAlternance, $data['estVisible']);
>>>>>>> thomas

	$sql4 = "SELECT * FROM $tab28 WHERE idoffre='$identifiantBDD'";
	$res4 = $db->query($sql4);
	$tabCompetences = array();
	while ($competence = $res4->fetch_array()) {
	    array_push($tabCompetences, $competence['idcompetence']);
	}
	$res4->free();
	array_push($tabOffreDAlternance, $tabCompetences);
<<<<<<< HEAD

	array_push($tabOffreDAlternance, $data['idcontact']);
=======
  array_push($tabOffreDAlternance, $data['idcontact']);
  array_push($tabOffreDAlternance, $data['typedecontrat']);

>>>>>>> thomas

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

	    $requete = "SELECT $tab29.idoffre $table $requete AND " . $filtre->getStrFiltres() . " ORDER BY $tab29.idoffre";
	}

<<<<<<< HEAD
	$result = $db->query($requete);

=======



	$result = $db->query($requete);




>>>>>>> thomas
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

}

?>
