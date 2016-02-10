<?php

class TypeEntreprise_BDD {

	public static function sauvegarder($typeEntreprise) {
		global $tab22;
		global $db;

		if ($typeEntreprise->getIdentifiantBDD() == "") {
		    $sql = "INSERT INTO $tab22 VALUES (
							'" . $typeEntreprise->getIdentifiantBDD() . "',
							'" . $typeEntreprise->getType() . "')";
		    $db->query($sql);
		    $sql2 = "SELECT LAST_INSERT_ID() AS ID FROM $tab22";
		    $req = $db->query($sql2);
		    $result = mysqli_fetch_array($req);
		    return $result['ID'];
		} else {
		    $sql = "UPDATE $tab22 SET type = '" . $typeEntreprise->getType() . "',
				WHERE idtypeentreprise = '" . $typeEntreprise->getIdentifiantBDD() . "'";
		    $db->query($sql);
		    return $typeEntreprise->getIdentifiantBDD();
		}

    }

    public static function getTypeEntreprise($identifiant) {
		global $tab22;
		global $db;
		$sql = "SELECT * FROM $tab22 WHERE idtypeentreprise='".$identifiant."'";
		$req = $db->query($sql);
		return mysqli_fetch_array($req);
    }

    public static function getListeTypeEntreprise() {
		global $tab22;
		global $db;
		$sql = "SELECT * FROM $tab22 ORDER BY idtypeentreprise ASC";
		$req = $db->query($sql);
		$tabTypeEntreprise = array();
		while($result = mysqli_fetch_array($req)) {
			//echo "result[0][1] = $result[0], $result[1]\n";
		    $tab = array();
		    array_push($tab, $result["idtypeentreprise"]);
		    array_push($tab, $result["type"]);
		    array_push($tabTypeEntreprise, $tab);
		}
		return $tabTypeEntreprise;
    }

    public static function supprimerTypeEntreprise($identifiant) {
		global $tab22;
		global $db;
		$sql = "DELETE FROM $tab22 WHERE idtypeentreprise='".$identifiant."'";
		$db->query($sql);
    }

}

?>