<?php

class ThemeDeStage_BDD {

    public static function getListeTheme(){
    	global $db;
    	global $tab23;

    	$requete = "SELECT * FROM $tab23;";

		$result = $db->query($requete);

		$tabThemes = array();
		while ($theme = mysqli_fetch_array($result)) {
			$tab = array();
		    array_push($tab, $theme["idtheme"]);
		    array_push($tab, $theme["theme"]);
		    array_push($tabThemes, $tab);
		}

		return $tabThemes;
    }

    public static function getIdTheme($label){
    	global $tab23;
    	global $db;
    	$sql = "SELECT idtheme FROM $tab23 WHERE theme = '".$label."';";
    	$result = $db->query($sql);
    	return mysqli_fetch_array($result);
    }

    public static function getThemeDeStage($id){
    	global $tab23;
    	global $db;
    	$sql = "SELECT * FROM $tab23 WHERE idtheme = '".$id."';";
    	$result = $db->query($sql);
    	return mysqli_fetch_array($result);
    }

    public static function sauvegarder($themeDeStage){
    	global $tab23;
    	global $db;

    	if($themeDeStage->getIdTheme() == ""){
    		$sql = "INSERT INTO $tab23 VALUES (
    					'".$themeDeStage->getIdTheme()."',
    					'".$themeDeStage->getTheme()."')";
		}
		else{
    		$sql = "UPDATE $tab23 SET theme = '".$themeDeStage->getTheme()."'
                    WHERE idtheme = '".$themeDeStage->getIdTheme()."'";
    	}
    	$result = $db->query($sql);
    }

    public static function delete($themeDeStage){
    	global $tab23;
    	global $db;
		$sql = "DELETE FROM $tab23 WHERE idtheme='".$themeDeStage."';";
		$db->query($sql);
    }

}
?>