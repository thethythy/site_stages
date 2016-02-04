<?php

	class ThemeDeStage_BDD {

	    public static function getListeTheme(){
	    	global $db;
	    	global $tab23;

	    	$requete = "SELECT * FROM $tab23;";

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