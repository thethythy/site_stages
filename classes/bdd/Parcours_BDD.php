<?php
class Parcours_BDD {

	/** Méthodes statiques **/

	/**
	 * Récupère un parcours suivant son identifiant
	 * @param $identifiantBDD l'identifiant du parcours à récupérer
	 * @return String[] tableau contenant les informations d'un parcours
	 */
	public static function getParcours($identifiantBDD){
		global $tab13;
		global $db;
		$result=array();
		$sql = "SELECT * FROM $tab13 WHERE idparcours='$identifiantBDD';";
		//echo "getParcours : $sql<br/>";
		$req = mysql_query($sql,$db);
		return mysql_fetch_assoc($req);
	}

	public static function listerParcours(){
		global $tab13;
		global $db;
		$sql = "SELECT * FROM $tab13 ORDER BY nomparcours ASC;";
		$result = mysql_query($sql,$db);

		$tabParcours = array();

		while ($parcours = mysql_fetch_assoc($result)){
			$tab = array();
			array_push($tab, $parcours["idparcours"]);
			array_push($tab, $parcours["nomparcours"]);
  			array_push($tabParcours, $tab);
		}

		return $tabParcours;
	}

	// 	$p : Un objet Parcours
	public static function sauvegarder($p){
		global $tab13;
		global $db;

		if($p->getIdentifiantBDD() == ""){
			// Création d'un parcours
			$requete = "INSERT INTO $tab13(nomparcours) VALUES ('".$p->getNom()."')";
			mysql_query($requete, $db);
			$sql2 = "SELECT LAST_INSERT_ID() AS ID FROM $tab13";
			$req = mysql_query($sql2);
			$result = mysql_fetch_assoc($req);
			return $result['ID'];
		} else {
			// Mise à jour d'un parcours
			$requete = "UPDATE $tab13 SET nomparcours = '".$p->getNom()."' WHERE idparcours = '".$p->getIdentifiantBDD()."'";
			mysql_query($requete, $db);
			return $p->getIdentifiantBDD();
		}
	}
}
?>