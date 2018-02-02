<?php

/**
 * Représentation et accès à la table n°23 : les thèmes de stages
 */

class ThemeDeStage_BDD {

    /**
     * Enregistrer ou mettre à jour un objet ThemeDeStage
     * @global resource $db Référence sur la base ouverte
     * @global string $tab23 Nom de la table 'theme_destage'
     * @param ThemeDeStage $themeDeStage L'objet à enregistrer
     */
    public static function sauvegarder($themeDeStage) {
	global $db;
	global $tab23;

	$couleur = $themeDeStage->getCouleur();

	if ($themeDeStage->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO $tab23
		    VALUES ('" . $themeDeStage->getIdentifiantBDD() . "',
			    '" . $themeDeStage->getTheme() . "',
			    '" . $couleur->getIdentifiantBDD() . "')";
	} else {
	    $sql = "UPDATE $tab23
		    SET theme = '" . $themeDeStage->getTheme() . "',
			idcouleur = '" . $couleur->getIdentifiantBDD() . "'
		    WHERE idtheme = '" . $themeDeStage->getIdentifiantBDD() . "'";
	}
	$db->query($sql);
    }

    /**
     * Obtenir un enregistrement ThemeDeStage à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab23 Nom de la table 'theme_destage'
     * @param integer $id Identifiant de l'enregistrement recherché
     * @return enregistrement
     */
    public static function getThemeDeStage($id) {
	global $db;
	global $tab23;

	$sql = "SELECT * FROM $tab23 WHERE idtheme = '" . $id . "';";
	$result = $db->query($sql);
	return mysqli_fetch_array($result);
    }

    /**
     * Obtenir un enregistrement ThemeDeStage à partir de son nom
     * @global resource $db Référence sur la base ouverte
     * @global string $tab23 Nom de la table 'theme_destage'
     * @param string $nom Le nom du thème de stage recherché
     * @return enregistrement
     */
    public static function getThemeDeStageFromNom($nom) {
	global $db;
	global $tab23;

	$sql = "SELECT * FROM $tab23 WHERE theme LIKE '$nom';";
	$result = $db->query($sql);
	return mysqli_fetch_array($result);
    }

    /**
     * Obtenir les enregistrements de tous les thèmes de stage
     * @global resource $db Référence sur la base ouverte
     * @global string $tab23 Nom de la table 'theme_destage'
     * @return tableau d'enregistrements
     */
    public static function getListeTheme() {
	global $db;
	global $tab23;

	$requete = "SELECT * FROM $tab23;";

	$result = $db->query($requete);

	$tabThemes = array();
	while ($theme = mysqli_fetch_array($result)) {
	    $tab = array();
	    array_push($tab, $theme["idtheme"]);
	    array_push($tab, $theme["theme"]);
	    array_push($tab, $theme["idcouleur"]);
	    array_push($tabThemes, $tab);
	}

	return $tabThemes;
    }

    /**
     * Suppression d'un enregistrement ThemeDeStage
     * @global resource $db Référence sur la base ouverte
     * @global string $tab23 Nom de la table 'theme_destage'
     * @param integer $themeDeStage Identifiant de l'enregistrement à supprimer
     */
    public static function delete($themeDeStage) {
	global $db;
	global $tab23;

	$sql = "DELETE FROM $tab23 WHERE idtheme='" . $themeDeStage . "';";
	$db->query($sql);
    }

}

?>