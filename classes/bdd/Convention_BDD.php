<?php

class Convention_BDD {
    /** Méthodes statiques * */

    /**
     * Sauvegarde un objet Convention
     * @param $convention la convention à sauvegarder
     */
    public static function sauvegarder($convention) {
	global $tab4;
	global $db;

	$parrain = $convention->getParrain();
	$examinateur = $convention->getExaminateur();
	$etudiant = $convention->getEtudiant();
	$contact = $convention->getContact();

	// Test si la chaîne contenant le sujet n'est pas déjà échappé
	if (strpos($convention->getSujetDeStage(), '\\') === false) {
		/* Pas sur de la conversion mysql vers mysqli */
		//$convention->setSujetDeStage(mysql_real_escape_string($convention->getSujetDeStage()));
	    $convention->setSujetDeStage(mysqli_real_escape_string($db, $convention->getSujetDeStage()));
	}

	// Permet de vérifier si la Convention existe déjà dans la BDD
	if ($convention->getIdentifiantBDD() == "") {
	    // Création de la Convention
	    $requete = "INSERT INTO $tab4(idparrain, idexaminateur, idetudiant, idsoutenance, idcontact, sujetdestage, asonresume, note)
						VALUES ('" . $parrain->getIdentifiantBDD() . "',
							'" . $examinateur->getIdentifiantBDD() . "',
							'" . $etudiant->getIdentifiantBDD() . "',
							'" . $convention->getIdSoutenance() . "',
							'" . $contact->getIdentifiantBDD() . "',
							'" . $convention->getSujetDeStage() . "',
							'" . $convention->getASonResume() . "',
							'" . $convention->getNote() . "'
							)";
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
					 note = '" . $convention->getNote() . "'
				WHERE idconvention = '" . $convention->getIdentifiantBDD() . "'";

	    $req = $db->query($requete);

	    if (!$req) { return FALSE; }

	    return $convention->getIdentifiantBDD();
	}
    }

    // $id : Un int, représentant un identifiant dans la BDD
    public static function getConvention($id) {
	global $tab4;
	global $db;

	$requete = "SELECT * FROM $tab4 WHERE idconvention='$id'";
	$convention = $db->query($requete);
	return mysqli_fetch_array($convention);
    }

    public static function getConvention2($idetudiant, $idpromotion) {
	global $tab19;
	global $tab4;
	global $db;

	$requete = "SELECT $tab4.idconvention FROM $tab19, $tab4 WHERE $tab19.idetudiant = $idetudiant AND $tab19.idpromotion = $idpromotion AND $tab4.idconvention=$tab19.idconvention";
	$result = $db->query($requete);
	$dConvention = mysqli_fetch_array($result);
	return Convention_BDD::getConvention($dConvention["idconvention"]);
    }

    public static function getListeConvention($filtres) {
	global $tab3;
	global $tab4;
	global $tab9;
	global $tab15;
	global $tab19;
	global $db;

	if ($filtres == "") {
	    $requete = "SELECT * FROM $tab4 ORDER BY $tab4.idparrain";
	} else {
	    $requete = "SELECT * FROM $tab4, $tab15, $tab19 WHERE $tab4.idconvention=$tab19.idconvention AND
			$tab15.idpromotion=$tab19.idpromotion AND " . $filtres->getStrFiltres() . " ORDER BY $tab4.idparrain ";
	}

	//echo $requete."<br/>";
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

	    array_push($tabC, $tab);
	}

	return $tabC;
    }

    public static function compteConvention($annee, $parrain, $filiere, $parcours) {
	global $db;
	global $tab15;
	global $tab19;

	$requete = "SELECT $tab19.idconvention FROM $tab15, $tab19 WHERE $tab15.anneeuniversitaire='$annee' AND $tab15.idfiliere='$filiere'
		    AND $tab15.idparcours='$parcours' AND $tab19.idpromotion=$tab15.idpromotion";

	//echo $requete."<br/>";

	$result = $db->query($requete);

	$compte = 0;
	while ($ods = mysqli_fetch_array($result)) {
	    if (Convention::getConvention($ods["idconvention"])->getParrain()->getIdentifiantBDD() == $parrain)
		$compte++;
	}

	return $compte;
    }

    public static function existe($conv, $annee) {
	global $tab19;
	global $db;

	$etu = $conv->getEtudiant();
	$promo = $etu->getPromotion($annee);

	if ($promo == "")
	    return false;

	$sql = "SELECT idconvention FROM $tab19
		WHERE idpromotion='" . $promo->getIdentifiantBDD() . "'
		AND idetudiant='" . $etu->getIdentifiantBDD() . "'
		AND idconvention <> 0";

	// echo "REQUETE : $sql<br/>";

	$result = $db->query($sql);// echo "RESULT : ".$result['idconvention']."<br/>";

	if (mysqli_num_rows($result) == 0)
	    return false;
	else
	    return true;
    }

    public static function existe2($idcontact, $filtre) {
	global $db;
	global $tab15;
	global $tab19;

	if ($filtre != '')
	    $requete = "SELECT $tab19.idconvention FROM $tab15, $tab19 WHERE " . $filtre->getStrFiltres() . " AND $tab19.idpromotion=$tab15.idpromotion";
	else
	    $requete = "SELECT $tab19.idconvention FROM $tab19";

	//echo "Requete Convention_BDD::existe2 : ".$requete."<br/>";
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

    public static function supprimerConvention($identifiantBDD, $idEtu, $idPromo) {
	global $tab19;
	global $tab4;
	global $db;

	$sql1 = "UPDATE $tab19 SET idconvention = NULL WHERE idetudiant = '" . $idEtu . "' AND idpromotion = '" . $idPromo . "'";
	//echo $sql1."<br/>";
	$db->query($sql1);
	$sql2 = "DELETE FROM $tab4 WHERE idconvention='$identifiantBDD'";
	//echo $sql2."<br/>";
	$db->query($sql2);
	}

    public static function getPromotion($idConvention) {
	global $tab4; // = 'convention';
	global $tab19; // = 'relation_promotion_etudiant_convention';
	global $db;

	$sql = "SELECT $tab19.idpromotion AS idpromo
			FROM $tab19, $tab4
			WHERE $tab19.idconvention = $tab4.idconvention AND $tab4.idconvention = $idConvention";

	//echo "REQUETE : ".$sql."<br/>";
	$req = $db->query($sql);
	$result = mysqli_fetch_array($req);
	//echo $result['idpromo']."<br/>";
	return $result['idpromo'];
    }

    public static function getListeEntreprises($annee_in, $annee_fin) {
	global $tab3; // ='contact'
	global $tab4; // = 'convention';
	global $tab5; // = 'datesoutenances';
	global $tab6; // = 'entreprise';
	global $tab9; // = 'etudiant';
	global $tab17; // = 'soutenances'
	global $db;

	$filtre = "$tab5.annee >= $annee_in AND $tab5.annee <= $annee_fin";

	$sql = "SELECT $tab6.nom, $tab6.adresse, $tab6.ville, $tab6.pays, $tab9.nometudiant, $tab9.prenometudiant
		FROM $tab3, $tab4, $tab5, $tab6, $tab9, $tab17
		WHERE $tab4.idsoutenance =  $tab17.idsoutenance AND $tab17.iddatesoutenance = $tab5.iddatesoutenance AND $filtre AND $tab4.idetudiant = $tab9.idetudiant AND $tab4.idcontact = $tab3.idcontact AND $tab3.identreprise = $tab6.identreprise
		ORDER BY $tab6.pays";

	// echo "REQUETE : ".$sql."<br/>";
	$req = $db->query($sql);
	$tabConventions = array();
	while ($data = mysqli_fetch_array($req)) {
	    $infos = array();
	    array_push($infos, $data['nom']);
	    array_push($infos, $data['adresse']);
	    array_push($infos, $data['ville']);
	    array_push($infos, $data['pays']);
	    array_push($infos, $data['nometudiant']);
	    array_push($infos, $data['prenometudiant']);
	    array_push($tabConventions, $infos);
	}

	return $tabConventions;
    }

    public static function getListeVillesRepartition($annee_in, $annee_fin) {
	global $tab3; // ='contact'
	global $tab4; // = 'convention';
	global $tab5; // = 'datesoutenances';
	global $tab6; // = 'entreprise';
	global $tab17; // = 'soutenances'
	global $db;

	$filtre = "$tab5.annee >= '$annee_in' AND $tab5.annee <= '$annee_fin'";

	$sql = "SELECT $tab6.ville
		FROM $tab3, $tab4, $tab5, $tab6, $tab17
		WHERE $tab4.idsoutenance =  $tab17.idsoutenance AND $tab17.iddatesoutenance = $tab5.iddatesoutenance AND $filtre AND $tab4.idcontact = $tab3.idcontact AND $tab3.identreprise = $tab6.identreprise
		ORDER BY $tab6.ville";

	// echo "REQUETE : ".$sql."<br/>";
	$req = $db->query($sql);// Compter le nombre de stage par conventions
	$infos = array();
	while ($data = mysqli_fetch_array($req)) {
	    $ville = strtoupper($data['ville']);

	    // Traitement des adresses avec Cedex
	    if (stripos($ville, 'CEDEX') !== false) {
		$ville = substr_replace($ville, '', stripos($ville, 'CEDEX') - 1);
	    }

	    // Suppression des espaces
	    $ville = trim($ville);

	    $infos[$ville] ++;
	    // echo  $ville." : ".$infos[$ville]."<br/>";
	}

	// Construire la réponse
	$tabVilles = array();
	foreach ($infos as $ville => $compteur) {
	    $laville = array();
	    array_push($laville, $ville);
	    array_push($laville, $compteur);
	    array_push($tabVilles, $laville);
	}

	return $tabVilles;
    }

    public static function getListePaysRepartition($annee_in, $annee_fin) {
	global $tab3; // ='contact'
	global $tab4; // = 'convention';
	global $tab5; // = 'datesoutenances';
	global $tab6; // = 'entreprise';
	global $tab17; // = 'soutenances'
	global $db;

	$filtre = "$tab5.annee >= '$annee_in' AND $tab5.annee <= '$annee_fin'";

	$sql = "SELECT $tab6.pays
		FROM $tab3, $tab4, $tab5, $tab6, $tab17
		WHERE $tab4.idsoutenance =  $tab17.idsoutenance AND $tab17.iddatesoutenance = $tab5.iddatesoutenance AND $filtre AND $tab4.idcontact = $tab3.idcontact AND $tab3.identreprise = $tab6.identreprise
		ORDER BY $tab6.pays";

	// echo "REQUETE : ".$sql."<br/>";
	$req = $db->query($sql); // Compter le nombre de stage par conventions
	$infos = array();
	while ($data = mysqli_fetch_array($req)) {
	    $infos[strtoupper($data['pays'])] ++;
	    // echo  strtoupper($data['pays'])." : ".$infos[strtoupper($data['pays'])]."<br/>";
	}

	// Construire la réponse
	$tabPays = array();
	foreach ($infos as $ville => $compteur) {
	    $pays = array();
	    array_push($pays, $ville);
	    array_push($pays, $compteur);
	    array_push($tabPays, $pays);
	}

	return $tabPays;
    }

}

?>