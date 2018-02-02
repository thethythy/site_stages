<?php

/**
 * Représentation et accès à la table n°18 : les sujets de stages à valider
 */

class SujetDeStage_BDD {

    /**
     * Enregistrer ou mettre à jour un objet SujetDeStage
     * @global resource $db Référence sur la base ouverte
     * @global string $tab18 Nom de la table 'sujetdestage'
     * @param SujetDeStage $sds L'objet à enregistrer
     */
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

    /**
     * Obtenir un enregistrement SujetDeStage à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab18 Nom de la table 'sujetdestage'
     * @param integer $id Identifiant de l'enregistrement recherché
     * @return enregistrement
     */
    public static function getSujetDeStage($id) {
	global $db;
	global $tab18;

	$requete = "SELECT * FROM $tab18 WHERE idsujetdestage='$id'";
	$result = $db->query($requete);
	return mysqli_fetch_array($result);
    }

    /**
     * Obtenir les enregistrements SujetDeStage filtrés
     * @global resource $db Référence sur la base ouverte
     * @global string $tab18 Nom de la table 'sujetdestage'
     * @param Filtre $filtre Le filtre global à appliquer
     * @return tableau d'enregistrements
     */
    public static function getListeSujetDeStage($filtre) {
	global $db;
	global $tab18;

	if ($filtre == "")
	    $requete = "SELECT * FROM $tab18";
	else
	    $requete = "SELECT * FROM $tab18 WHERE " . $filtre->getStrFiltres();

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

    /**
     * Supprimer un enregistrement SujetDeStage à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab18 Nom de la table 'sujetdestage'
     * @param integer $identifiantBDD Identifiant de l'enregistrement
     */
    public static function delete($identifiantBDD) {
	global $db;
	global $tab18;

	$sql = "DELETE FROM $tab18 WHERE idsujetdestage='$identifiantBDD'";
	$db->query($sql);
    }

}

?>