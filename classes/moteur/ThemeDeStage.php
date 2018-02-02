<?php

/**
 * Classe ThemeDeStage : le thème du stage
 */

class ThemeDeStage {

    var $idTheme;  // Identifiant unique en base
    var $theme;  // L'intitulé du thème
    var $identifiant_couleur;  // Identifiant de la couleur

    /**
     * Constructeur
     * @param integer $idtheme
     * @param string $theme
     * @param integer $identifiant_couleur
     */
    public function ThemeDeStage($idtheme, $theme, $identifiant_couleur) {
	$this->idTheme = $idtheme;
	$this->theme = $theme;
	$this->identifiant_couleur = $identifiant_couleur;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en lecture

    public function getIdentifiantBDD() {
	return $this->idTheme;
    }

    public function getTheme() {
	return $this->theme;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en écriture

    public function setTheme($label) {
	$this->theme = $label;
    }

    public function setIdentifiant_couleur($identifiant_couleur) {
	$this->identifiant_couleur = $identifiant_couleur;
    }

    // ------------------------------------------------------------------------
    // Méthodes dérivées

    public function getCouleur() {
	return Couleur::getCouleur($this->identifiant_couleur);
    }

    // ------------------------------------------------------------------------
    // Methode(s) statiques

    /**
     * Obtenir un objet ThemeDeStage à partir de son identifiant
     * @param integer $id
     * @return ThemeDeStage
     */
    public static function getThemeDeStage($id) {
	$themeDeStageStr = ThemeDeStage_BDD::getThemeDeStage($id);
	return new ThemeDeStage($themeDeStageStr['idtheme'],
				$themeDeStageStr['theme'],
				$themeDeStageStr['idcouleur']);
    }

    /**
     * Obtenir un objet ThemeDeStage à partir de son nom
     * @param string $nom
     * @return ThemeDeStage
     */
    public static function getThemeDeStageFromNom($nom) {
	$themeDeStageStr = ThemeDeStage_BDD::getThemeDeStageFromNom($nom);
	return new ThemeDeStage($themeDeStageStr['idtheme'],
				$themeDeStageStr['theme'],
				$themeDeStageStr['idcouleur']);
    }

    /**
     * Obtenir tous les objets ThemeDeStage
     * @return array
     */
    public static function getListeTheme() {
	$tabThemesStr = ThemeDeStage_BDD::getListeTheme();

	$tab_themes = array();
	for ($i = 0; $i < sizeof($tabThemesStr); $i++)
	    array_push($tab_themes,
		    new ThemeDeStage($tabThemesStr[$i][0],
				     $tabThemesStr[$i][1],
				     $tabThemesStr[$i][2]));

	return $tab_themes;
    }

    /**
     * Enregistrer un thème de stage à partir d'un tableau d'attributs
     * @param array $tab_donnees
     */
    public static function saisirDonneesTheme($tab_donnees) {
	$theme = new ThemeDeStage('', $tab_donnees[0], $tab_donnees[1]);
	ThemeDeStage_BDD::sauvegarder($theme);
    }

    /**
     * Suppression en base d'un thème de stage
     * @param integer $idThemeDeStage
     */
    public static function deleteTheme($idThemeDeStage) {
	ThemeDeStage_BDD::delete($idThemeDeStage);
    }

}

?>