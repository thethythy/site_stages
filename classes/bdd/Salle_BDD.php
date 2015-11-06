<?php

class Salle_BDD{

	/**Méthodes statiques**/

	public static function sauvegarder($salle){
		global $tab16;
		global $db;
		if($salle->getIdentifiantBDD()==""){
			$sql = "INSERT INTO $tab16 VALUES ('".$salle->getIdentifiantBDD()."', '".$salle->getNom()."')";
		}else {
			$sql = "UPDATE $tab16 SET nomsalle='".$salle->getNom()."' WHERE idsalle=".$salle->getIdentifiantBDD();
		}
		$result = mysql_query($sql,$db);
	}

	public static function getSalle($identifiant){
		global $tab16;
		global $db;

		$result=array();
		$sql = "SELECT * FROM $tab16 WHERE idsalle='$identifiant'";
		$req = mysql_query($sql,$db);
		return mysql_fetch_array($req);
	}

	public static function listerSalle(){
		global $tab16;
		global $db;
		$sql = "SELECT * FROM $tab16 ORDER BY nomsalle ASC;";
		$result = mysql_query($sql,$db);

		$tabSalle = array();

		while ($salle = mysql_fetch_assoc($result)){
			$tab = array();
			array_push($tab, $salle["idsalle"]);
			array_push($tab, $salle["nomsalle"]);
  			array_push($tabSalle, $tab);
		}

		return $tabSalle;
	}

	public static function delete($identifiantBDD){
		global $tab16;
		$sql = "DELETE FROM $tab16 WHERE idsalle='$identifiantBDD'";
		$result=mysql_query($sql);

	}
}
?>