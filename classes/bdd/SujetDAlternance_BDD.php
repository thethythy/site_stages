<?php

/**
 * Représentation et accès à la table n°18 : les sujets d'alternances à valider
 */

class SujetDAlternance_BDD {

    /**
     * Enregistrer ou mettre à jour un objet SujetDAlternance
     * @global resource $db Référence sur la base ouverte
     * @global string $tab33 Nom de la table 'sujetdalternance'
     * @param SujetDAlternance $sda L'objet à enregistrer
     */
    public static function sauvegarder($sda) {
	global $db;
	global $tab33;

	$etudiant = $sda->getEtudiant();
	$promotion = $sda->getPromotion();
	// Permet de vérifier si le Sujet de Stage existe déjà dans la BDD
	if ($sda->getIdentifiantBDD() == "") {
	    // Création du Sujet de Stage
	    $requete = "INSERT INTO $tab33(description, valide, enattente, idetudiant, idpromotion)
			VALUES ('" . $sda->getDescription() . "',
				'" . $sda->isValide() . "',
				'" . $sda->isEnAttenteDeValidation() . "',
				'" . $etudiant->getIdentifiantBDD() . "',
				'" . $promotion->getIdentifiantBDD() . "')";
	    $db->query($requete);
	} else {
	    // Mise à jour du Sujet de Stage
	    $requete = "UPDATE $tab33
			SET description = '" . $sda->getDescription() . "',
			    valide = '" . $sda->isValide() . "',
			    enattente = '" . $sda->isEnAttenteDeValidation() . "',
			    idetudiant = '" . $etudiant->getIdentifiantBDD() . "',
			    idpromotion = '" . $promotion->getIdentifiantBDD() . "'
			WHERE idsujetdalternance = '" . $sda->getIdentifiantBDD() . "'";
	    $db->query($requete);
	}
    }

    /**
     * Obtenir un enregistrement SujetDAlternance à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab33 Nom de la table 'sujetdalternance'
     * @param integer $id Identifiant de l'enregistrement recherché
     * @return enregistrement ou FALSE
     */
    public static function getSujetDAlternance($id) {
	global $db;
	global $tab33;

	$requete = "SELECT * FROM $tab33 WHERE idsujetdalternance='$id'";
	$result = $db->query($requete);

	if ($result) {
	    $enreg = $result->fetch_array();
	    $result->free();
	    return $enreg;
	} else
	    return FALSE;
    }

    /**
     * Obtenir les enregistrements SujetDAlternance filtrés
     * @global resource $db Référence sur la base ouverte
     * @global string $tab33 Nom de la table 'sujetdalternance'
     * @param Filtre $filtre Le filtre global à appliquer
     * @return tableau d'enregistrements
     */
    public static function getListeSujetDAlternance($filtre) {
	global $db;
	global $tab33;

	if ($filtre == "")
	    $requete = "SELECT * FROM $tab33";
	else
	    $requete = "SELECT * FROM $tab33 WHERE " . $filtre->getStrFiltres();

	$result = $db->query($requete);

	$tabSujetDAlternance = array();

	if ($result) {
	    while ($sda = $result->fetch_assoc()) {
		$tab = array();
		array_push($tab, $sda["idsujetdalternance"]);
		array_push($tab, $sda["idetudiant"]);
		array_push($tab, $sda["idpromotion"]);
		array_push($tab, $sda["description"]);
		array_push($tab, $sda["valide"]);
		array_push($tab, $sda["enattente"]);
		array_push($tabSujetDAlternance, $tab);
	    }
	    $result->free();
	}

	return $tabSujetDAlternance;
    }

    /**
     * Supprimer un enregistrement SujetDAlternance à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab33 Nom de la table 'sujetdalternance'
     * @param integer $identifiantBDD Identifiant de l'enregistrement
     */
    public static function delete($identifiantBDD) {
	global $db;
	global $tab33;

	$sql = "DELETE FROM $tab33 WHERE idsujetdalternance='$identifiantBDD'";
	$db->query($sql);
    }

}

?>
