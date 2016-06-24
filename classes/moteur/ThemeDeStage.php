<?php

class ThemeDeStage {

    var $idTheme;
    var $theme;
    var $identifiant_couleur;

    /* Constructeur(s) */

    public function ThemeDeStage($idtheme, $theme, $identifiant_couleur) {
	$this->idTheme = $idtheme;
	$this->theme = $theme;
	$this->identifiant_couleur = $identifiant_couleur;
    }

    /* Accesseurs */

    public function getIdentifiantBDD() {
	return $this->idTheme;
    }

    public function setTheme($label) {
	$this->theme = $label;
    }

    public function setIdTheme($id) {
	$this->idTheme = $id;
    }

    public function setIdentifiant_couleur($identifiant_couleur) {
	$this->identifiant_couleur = $identifiant_couleur;
    }

    public function getCouleur() {
	return Couleur::getCouleur($this->identifiant_couleur);
    }

    public function getIdTheme() {
	return $this->idTheme;
    }

    public function getTheme() {
	return $this->theme;
    }

    /* Methode(s) statiques */

    public static function getThemeDeStage($id) {
	$themeDeStageStr = ThemeDeStage_BDD::getThemeDeStage($id);
	return new ThemeDeStage($themeDeStageStr['idtheme'],
				$themeDeStageStr['theme'],
				$themeDeStageStr['idcouleur']);
    }

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

    public static function saisirDonneesTheme($tab_donnees) {
	$theme = new ThemeDeStage('', $tab_donnees[0], $tab_donnees[1]);
	ThemeDeStage_BDD::sauvegarder($theme);
    }

    public static function deleteTheme($themeDeStage) {
	ThemeDeStage_BDD::delete($themeDeStage);
    }

}

?>