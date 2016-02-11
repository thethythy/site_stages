<?php

class ThemeDeStage {
	var $idTheme;
	var $theme;

	/* Constructeur(s) */
	public function ThemeDeStage($idtheme, $theme){
		$this->idTheme = $idtheme;
		$this->theme = $theme;
	}

	/* Accesseurs */

	public function setTheme($label){
		$this->theme = $label;
	}

	public function setIdTheme($id){
		$this->idTheme = $id;
	}

	/*public function getIdTheme(){
		$idThemeString = ThemeDeStage_BDD::getIdTheme($this->theme);
		$idThemeDeStage = $idThemeString['idtheme'];

		return $idThemeDeStage;
	}*/

	public function getIdTheme(){
		return $this->idTheme;
	}

	public function getTheme(){
		return $this->theme;
	}

	public static function getThemeDeStage($id){
		$themeDeStageStr = ThemeDeStage_BDD::getThemeDeStage($id);

		return new ThemeDeStage($themeDeStageStr['idtheme'], $themeDeStageStr['theme']);
	}


	/* Methode(s) */
	public static function getListeTheme(){
		$tabThemesStr = ThemeDeStage_BDD::getListeTheme();

		$tab_themes = array();
		for($i=0; $i<sizeof($tabThemesStr); $i++)
  			array_push($tab_themes, new ThemeDeStage($tabThemesStr[$i][0], $tabThemesStr[$i][1]));
  			
		return $tab_themes;
	}

	public static function saisirDonneesTheme($themeDeStage){
		$theme = new ThemeDeStage('', $themeDeStage);
		ThemeDeStage_BDD::sauvegarder($theme);
	}

	public static function deleteTheme($themeDeStage){
		ThemeDeStage_BDD::delete($themeDeStage);
	}

}
?>