<?php

class Parrain_BDD{

	/**Méthodes statiques**/

	public static function sauvegarder($parrain){
		global $tab14;
		global $db;

		$couleur = $parrain->getCouleur();

		if($parrain->getIdentifiantBDD()==""){
			$sql = "INSERT INTO $tab14 VALUES (
						'".$parrain->getIdentifiantBDD()."',
						'".$parrain->getNom()."',
						'".$parrain->getPrenom()."',
						'".$parrain->getEmail()."',
						'".$couleur->getIdentifiantBDD()."')";
		}else {
			$sql = "UPDATE $tab14 SET
						prenomparrain='".$parrain->getPrenom()."',
						nomparrain='".$parrain->getNom()."',
						emailparrain='".$parrain->getEmail()."',
						idcouleur='".$couleur->getIdentifiantBDD()."'
						WHERE idparrain=".$parrain->getIdentifiantBDD();
		}
		$result = $db->query($sql);
	}

	public static function getParrain($identifiant){
		global $tab14;
		global $db;

		$result=array();
		$sql = "SELECT * FROM $tab14 WHERE idparrain='$identifiant';";
		$req = @$db->query($sql);
		return @mysqli_fetch_array($req);
	}

	public static function listerParrain(){
		global $tab14;
		global $db;
		$sql = "SELECT * FROM $tab14 ORDER BY nomparrain ASC;";
		$result = $db->query($sql);

		$tabParrain = array();

		while ($parrain = mysqli_fetch_array($result)){
			$tab = array();
			array_push($tab, $parrain["idparrain"]);
			array_push($tab, $parrain["nomparrain"]);
			array_push($tab, $parrain["prenomparrain"]);
			array_push($tab, $parrain["emailparrain"]);
			array_push($tab, $parrain["idcouleur"]);
  			array_push($tabParrain, $tab);
		}

		return $tabParrain;
	}

	public static function delete($identifiantBDD){
		global $tab14;
		global $db;
		$sql = "DELETE FROM $tab14 WHERE idparrain='$identifiantBDD'";
		$db->query($sql);
	}
}
?>