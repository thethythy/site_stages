<?php

/**
 * Représentation et accès à la table n°21 : les tâches d'administration
 */

class Tache_BDD {

    /**
     * Enregistrer ou mettre à jour un objet Tache
     * @global resource $db Référence sur la base ouverte
     * @global string $tab21 Nom de la table 'taches'
     * @param Tache $tache L'objet à enregistrer
     */
    public static function save($tache) {
	global $db;
	global $tab21;

	if ($tache->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab21
		    VALUES ('" . $tache->getIdentifiantBDD() . "',
			    '" . $tache->getIntitule() . "',
			    '" . $tache->getStatut() . "',
			    '" . $tache->getPriorite() . "',
			    '" . $tache->getDateLimite() . "')";
	} else {
	    $sql = "UPDATE $tab21
		    SET intitule='" . $tache->getIntitule() . "',
			statut='" . $tache->getStatut() . "',
			priorite='" . $tache->getPriorite() . "',
			datelimite='" . $tache->getDateLimite() . "'
		    WHERE idtache='" . $tache->getIdentifiantBDD() . "'";
	}

	$db->query($sql);
    }

    /**
     * Obtenir un enregistrement Tache à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab21 Nom de la table 'taches'
     * @param integer $identifiant Identifiant de la tâche
     * @return enregistrement
     */
    public static function getTache($identifiant) {
	global $db;
	global $tab21;

	$sql = "SELECT * FROM $tab21 WHERE idtache='$identifiant'";
	$result = $db->query($sql);
	return mysqli_fetch_array($result);
    }

    /**
     * Obtenir les enregistrements de tous les objets Taches
     * classé par date et priorité
     *
     * @global resource $db Référence sur la base ouverte
     * @global string $tab21 Nom de la table 'taches'
     * @return tableau d'enregistrements
     */
    public static function getTaches() {
	global $db;
	global $tab21;

	$sql = "SELECT * FROM $tab21 ORDER BY datelimite ASC, priorite DESC";
	$result = $db->query($sql);

	$tabTache = array();
	while ($tache = mysqli_fetch_array($result)) {
	    $tab = array();
	    array_push($tab, $tache["idtache"]);
	    array_push($tab, $tache["intitule"]);
	    array_push($tab, $tache["statut"]);
	    array_push($tab, $tache["priorite"]);
	    array_push($tab, $tache["datelimite"]);
	    array_push($tabTache, $tab);
	}
	return $tabTache;
    }

    /**
     * Suppression d'un enregistrement Tache
     * @global resource $db Référence sur la base ouverte
     * @global string $tab21 Nom de la table 'taches'
     * @param integer $identifiantBDD Identifiant de la tâche à supprimer
     */
    public static function delete($identifiantBDD) {
	global $db;
	global $tab21;

	$sql = "DELETE FROM $tab21 WHERE idtache='$identifiantBDD'";
	$db->query($sql);
    }

}

?>
