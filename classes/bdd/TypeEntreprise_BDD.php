<?php

class TypeEntreprise_BDD {

	public static function sauvegarder($typeEntreprise) {
		global $tab22;
		global $db;

		$couleur = $typeEntreprise->getCouleur();

		if ($typeEntreprise->getIdentifiantBDD() == "") {
		    $sql = "INSERT INTO $tab22 VALUES (
							'" . $typeEntreprise->getIdentifiantBDD() . "',
							'" . $typeEntreprise->getType() . "',
							'" . $couleur->getIdentifiantBDD() . "')";
		} else {
		    $sql = "UPDATE $tab22 SET 
		    	type = '" . $typeEntreprise->getType() . "',
		    	idcouleur = '".$couleur->getIdentifiantBDD()."'
				WHERE idtypeentreprise = '" . $typeEntreprise->getIdentifiantBDD() . "'";
		}
		$result = $db->query($sql);
    }

    public static function getTypeEntreprise($identifiant) {
		global $tab22;
		global $db;
		$sql = "SELECT * FROM $tab22 WHERE idtypeentreprise='".$identifiant."'";
		$result = $db->query($sql);
		return mysqli_fetch_array($result);
    }

    public static function getListeTypeEntreprise() {
		global $tab22;
		global $db;
		$sql = "SELECT * FROM $tab22";
		$result = $db->query($sql);
		$tabTypeEntreprise = array();
		while($type = mysqli_fetch_array($result)) {
		    $tab = array();
		    array_push($tab, $type["idtypeentreprise"]);
		    array_push($tab, $type["type"]);
		    array_push($tab, $type["idcouleur"]);
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