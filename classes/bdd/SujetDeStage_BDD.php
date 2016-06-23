<?php

class SujetDeStage_BDD {

    // Méthodes statiques
    //
    // $sds : Un objet SujetDeStage
    public static function sauvegarder($sds) {
	global $db;
	global $tab18;

	$etudiant = $sds->getEtudiant();
	$promotion = $sds->getPromotion();
	// Permet de vérifier si le Sujet de Stage existe déjà dans la BDD
	if ($sds->getIdentifiantBDD() == "") {
	    // Création du Sujet de Stage
	    $requete = "INSERT INTO $tab18(description, valide, enattente, idetudiant, idpromotion)
			VALUES ('" . $sds->getDescription() . "',
				'" . $sds->isValide() . "',
				'" . $sds->isEnAttenteDeValidation() . "',
				'" . $etudiant->getIdentifiantBDD() . "',
				'" . $promotion->getIdentifiantBDD() . "')";
	    $db->query($requete);
	} else {
	    // Mise à jour du Sujet de Stage
	    $requete = "UPDATE $tab18
			SET description = '" . $sds->getDescription() . "',
			    valide = '" . $sds->isValide() . "',
			    enattente = '" . $sds->isEnAttenteDeValidation() . "',
			    idetudiant = '" . $etudiant->getIdentifiantBDD() . "',
			    idpromotion = '" . $promotion->getIdentifiantBDD() . "'
			WHERE idsujetdestage = '" . $sds->getIdentifiantBDD() . "'";
	    $db->query($requete);
	}
    }

    // $id : Un int, représentant un identifiant dans la BDD
    public static function getSujetDeStage($id) {
	global $db;
	global $tab18;

	$requete = "SELECT * FROM $tab18 WHERE idsujetdestage='$id'";
	$result = $db->query($requete);
	return mysqli_fetch_array($result);
    }

    public static function getListeSujetDeStage($filtres) {
	global $db;
	global $tab18;

	if ($filtres == "")
	    $requete = "SELECT * FROM $tab18";
	else
	    $requete = "SELECT * FROM $tab18 WHERE " . $filtres->getStrFiltres();

	$result = $db->query($requete);

	$tabSujetDeStage = array();

	while ($sds = mysqli_fetch_array($result, MYSQL_ASSOC)) {
	    $tab = array();
	    array_push($tab, $sds["idsujetdestage"]);
	    array_push($tab, $sds["idetudiant"]);
	    array_push($tab, $sds["idpromotion"]);
	    array_push($tab, $sds["description"]);
	    array_push($tab, $sds["valide"]);
	    array_push($tab, $sds["enattente"]);
	    array_push($tabSujetDeStage, $tab);
	}

	return $tabSujetDeStage;
    }

    public static function rechercheSujetDeStage($idEtudiant, $idPromotion) {
	global $db;
	global $tab18;

	$requete = "SELECT idsujetdestage FROM $tab18 WHERE idpromotion='$idPromotion' AND idetudiant='$idEtudiant'";
	$result = $db->query($requete);
	$result2 = mysqli_fetch_array($result);
	return $result2[0];
    }

    public static function delete($identifiantBDD) {
	global $db;
	global $tab18;

	$sql = "DELETE FROM $tab18 WHERE idsujetdestage='$identifiantBDD'";
	$db->query($sql);
    }

}

?>