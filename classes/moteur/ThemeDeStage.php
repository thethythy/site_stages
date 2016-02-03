<?php

	class ThemeDeStage {
		var $idTheme;
		var $theme;

		/* Constructeur(s) */
		public function ThemeDeStage($idtheme, $theme){
			$this->idtheme = $idtheme;
			$this->theme = $theme;
		}

		/* Accesseurs */
		/*public function setIdTheme($idTheme){
			$this->idTheme = $idTheme;
		}

		public function setTheme($theme){
			$this->theme = $theme;
		}
		*/
		public function getIdTheme(){
			return $this->idTheme;
		}

		public function getTheme(){
			return $this->theme;
		}


		/* Methode(s) */
		public static function getListeTheme(){
			$tabThemesStr = ThemeDeStage_BDD::getListeTheme();
			
			$tab_themes = array();
			for($i=0; $i<sizeof($tabThemesStr); $i++)
	  			array_push($tab_themes, new ThemeDeStage($tabThemesStr[$i][0], $tabThemesStr[$i][1]));
	  			
			return $tab_themes;
		}

	}
?>