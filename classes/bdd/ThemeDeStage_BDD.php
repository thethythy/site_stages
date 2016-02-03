<?php

	class ThemeDeStage_BDD {

	    public static function getListeTheme(){
	    	global $db;
	    	global $tab23;
	    	global $tab4;

	    	$requete = "SELECT DISTINCT $tab23.idtheme, theme FROM $tab4, $tab23 WHERE $tab4.idtheme =  $tab23.idtheme;";

			$result = $db->query($requete);

			$tabThemes = array();
			while ($theme = mysqli_fetch_array($result, MYSQL_ASSOC)) {
				$tab = array();
			    array_push($tab, $theme["idtheme"]);
			    array_push($tab, $theme["theme"]);
			    array_push($tabThemes, $tab);
			}

			return $tabThemes;
	    }

	}
?>