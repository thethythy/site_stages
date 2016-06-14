<?php

class offreDeStage_BDD {

    public static function sauvegarder($offreDeStage) {
	global $tab12;
	global $tab8;
	global $tab7;
	global $tab11;
	global $db;

	$lastId = "0";
	$estVisible = 0;
	if ($offreDeStage->estVisible()) {
	    $estVisible = 1;
	}

	if ($offreDeStage->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab12 VALUES ('" . $offreDeStage->getIdentifiantBDD() . "',
					       '" . $offreDeStage->getSujet() . "',
					       '" . $offreDeStage->getTitre() . "',
					       '" . $offreDeStage->getListeEnvironnements() . "',
					       '" . $offreDeStage->getDureeMinimale() . "',
					       '" . $offreDeStage->getDureeMaximale() . "',
					       '" . $offreDeStage->getIndemnite() . "',
					       '" . $offreDeStage->getRemarques() . "',
					       '" . $estVisible . "',
					       '" . $offreDeStage->getIdContact() . "');";

	    //echo $sql."<br/>";

	    $db->query($sql);
	    //récupération de l'identifiant
	    $sql = "SELECT max(idoffre) AS lastId FROM $tab12;";
	    $result = $db->query($sql);
	    $data = mysqli_fetch_array($result);
	    $lastId = $data['lastId'];
	} else {
	    $sql = "UPDATE $tab12 SET sujet='" . $offreDeStage->getSujet() . "',
				     titre='" . $offreDeStage->getTitre() . "',
				     listeenvironnement='" . $offreDeStage->getListeEnvironnements() . "',
				     dureemin='" . $offreDeStage->getDureeMinimale() . "',
				     dureemax='" . $offreDeStage->getDureeMaximale() . "',
				     indemnite='" . $offreDeStage->getIndemnite() . "',
				     remarques='" . $offreDeStage->getRemarques() . "',
				     estVisible='" . $estVisible . "',
				     idcontact='" . $offreDeStage->getIdContact() . "'
		    WHERE idoffre='" . $offreDeStage->getIdentifiantBDD() . "';";
	    $db->query($sql);

	    //Themes
	    $sql = "DELETE FROM $tab8 WHERE idoffre='" . $offreDeStage->getIdentifiantBDD() . "';";
	    $db->query($sql);

	    //echo $sql."<br/>";
	    //Profils
	    $sql = "DELETE FROM $tab7 WHERE idoffre='" . $offreDeStage->getIdentifiantBDD() . "';";
	    $db->query($sql);

	    //echo $sql."<br/>";
	    //Competences
	    $sql = "DELETE FROM $tab11 WHERE idoffre='" . $offreDeStage->getIdentifiantBDD() . "';";
	    $db->query($sql);

	    //echo $sql."<br/>";

	    $lastId = $offreDeStage->getIdentifiantBDD();
	}

	//Themes = Parcours
	$tabThemes = $offreDeStage->getThemes();
	for ($i = 0; $i < sizeof($tabThemes); $i++) {
	    $sql = "INSERT INTO $tab8 VALUES('" . $tabThemes[$i]->getIdentifiantBDD() . "', '" . $lastId . "');";
	    $db->query($sql);
	}

	//Profils = Filière
	$tabProfils = $offreDeStage->getListeProfilSouhaite();
	for ($i = 0; $i < sizeof($tabProfils); $i++) {
	    $sql = "INSERT INTO $tab7 VALUES('" . $lastId . "', '" . $tabProfils[$i]->getIdentifiantBDD() . "')";
	    $db->query($sql);
	}

	//Competences
	$tabCompetences = $offreDeStage->getListesCompetences();
	for ($i = 0; $i < sizeof($tabCompetences); $i++) {
	    $sql = "INSERT INTO $tab11 VALUES('" . $tabCompetences[$i]->getIdentifiantBDD() . "', '" . $lastId . "')";
	    //echo $sql."<br/>";
	    $db->query($sql);
	}

	return $lastId;
    }

    public static function delete($identifiantBDD) {
	global $tab12;
	global $tab8;
	global $tab7;
	global $tab11;
	global $db;

	$sql = "DELETE FROM $tab12 WHERE idoffre='$identifiantBDD'";
	$db->query($sql);

	//Themes
	$sql = "DELETE FROM $tab8 WHERE idoffre='$identifiantBDD'";
	$db->query($sql);

	//Profils
	$sql = "DELETE FROM $tab7 WHERE idoffre='$identifiantBDD'";
	$db->query($sql);

	//Competences
	$sql = "DELETE FROM $tab11 WHERE idoffre='$identifiantBDD'";
	$db->query($sql);
    }

    public static function getOffreDeStage($identifiantBDD) {
	global $tab7;
	global $tab11;
	global $tab12;
	global $tab8;
	global $db;

	$sql2 = "SELECT * FROM $tab12 WHERE idoffre='$identifiantBDD'";
	$result = $db->query($sql2);
	$data = mysqli_fetch_array($result);
	$tabOffreDeStage = array();

	array_push($tabOffreDeStage, $data['idoffre']);
	array_push($tabOffreDeStage, $data['sujet']);
	array_push($tabOffreDeStage, $data['titre']);
	array_push($tabOffreDeStage, $data['listeenvironnement']);

	$sql2 = "SELECT * FROM $tab8 WHERE idoffre='$identifiantBDD'";
	$res = $db->query($sql2);
	$tabThemes = array();
	while ($theme = mysqli_fetch_array($res)) {
	    array_push($tabThemes, $theme['idparcours']);
	}
	array_push($tabOffreDeStage, $tabThemes);

	$sql2 = "SELECT * FROM $tab7 WHERE idoffre='$identifiantBDD'";
	$res = $db->query($sql2);
	$tabProfils = array();
	while ($profil = mysqli_fetch_array($res)) {
	    array_push($tabProfils, $profil['idfiliere']);
	}
	array_push($tabOffreDeStage, $tabProfils);

	array_push($tabOffreDeStage, $data['dureemin']);
	array_push($tabOffreDeStage, $data['dureemax']);
	array_push($tabOffreDeStage, $data['indemnite']);
	array_push($tabOffreDeStage, $data['remarques']);
	array_push($tabOffreDeStage, $data['estVisible']);

	$sql2 = "SELECT * FROM $tab11 WHERE idoffre='$identifiantBDD'";
	$res = $db->query($sql2);
	$tabCompetences = array();
	while ($competence = mysqli_fetch_array($res)) {
	    array_push($tabCompetences, $competence['idcompetence']);
	}
	array_push($tabOffreDeStage, $tabCompetences);

	array_push($tabOffreDeStage, $data['idcontact']);

	return $tabOffreDeStage;
    }

    /**
     * Retourne une liste d'offre de stage suivant un filtre
     * @param $filtres le filtre de la recherche
     * @return String[] tableau contenant les offres de stage concernées par le filtre
     */
    public static function getListeOffreDeStage($filtres) {
	global $tab3;
	global $tab6;
	global $tab7;
	global $tab8;
	global $tab11;
	global $tab12;
	global $db;

	if ($filtres == "") {
	    $requete = "SELECT * FROM $tab12";
	} else {

	    $table = "FROM $tab12,$tab3,$tab6";

	    $requete = "WHERE $tab12.idcontact=$tab3.idcontact AND $tab6.identreprise=$tab3.identreprise";

	    $pos1 = strripos($filtres->getStrFiltres(), "idfiliere");
	    $pos2 = strripos($filtres->getStrFiltres(), "idparcours");
	    $pos3 = strripos($filtres->getStrFiltres(), "idcompetence");

	    if ($pos1 !== false) {
		$requete = $requete . " AND $tab7.idoffre=$tab12.idoffre";
		$table = $table . ",$tab7";
	    }

	    if ($pos2 !== false) {
		$requete = $requete . " AND $tab8.idoffre=$tab12.idoffre";
		$table = $table . "," . $tab8;
	    }

	    if ($pos3 !== false) {
		$requete = $requete . " AND $tab11.idoffre=$tab12.idoffre";
		$table = $table . "," . $tab11;
	    }

	    $requete = "SELECT * $table $requete AND " . $filtres->getStrFiltres() . " ORDER BY $tab12.idoffre";
	}

	//echo $requete."<br/>";
	$result = $db->query($requete);

	$tabODS = array();

	while ($result != FALSE && $ods = mysqli_fetch_array($result)) {
	    $tab = array();

	    array_push($tab, $ods['idoffre']);
	    array_push($tab, $ods['sujet']);
	    array_push($tab, $ods['titre']);
	    array_push($tab, $ods['listeenvironnement']);

	    $sql2 = "SELECT * FROM " . $tab8 . " WHERE idoffre=" . $ods['idoffre'];
	    $res = $db->query($sql2);
	    $tabThemes = array();
	    while ($theme = mysqli_fetch_array($res)) {
		array_push($tabThemes, $theme['idparcours']);
	    }
	    array_push($tab, $tabThemes);

	    $sql2 = "SELECT * FROM " . $tab7 . " WHERE idoffre=" . $ods['idoffre'];
	    $res = $db->query($sql2);
	    $tabProfils = array();
	    while ($profil = mysqli_fetch_array($res)) {
		array_push($tabProfils, $profil['idfiliere']);
	    }
	    array_push($tab, $tabProfils);

	    array_push($tab, $ods['dureemin']);
	    array_push($tab, $ods['dureemax']);
	    array_push($tab, $ods['indemnite']);
	    array_push($tab, $ods['remarques']);
	    array_push($tab, $ods['estVisible']);

	    $sql2 = "SELECT * FROM " . $tab11 . " WHERE idoffre=" . $ods['idoffre'];
	    $res = $db->query($sql2);
	    $tabCompetences = array();
	    while ($competence = mysqli_fetch_array($res)) {
		array_push($tabCompetences, $competence['idcompetence']);
	    }
	    array_push($tab, $tabCompetences);

	    array_push($tab, $ods['idcontact']);

	    array_push($tabODS, $tab);
	}

	return $tabODS;
    }

}

?>