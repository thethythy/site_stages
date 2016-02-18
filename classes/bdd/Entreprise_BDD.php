<?php

class Entreprise_BDD {
    /* * Méthodes statiques* */

    /**
     * Sauvegarde d'une entreprise
     * @param $entreprise l'entreprise à sauvegarder
     */
    public static function sauvegarder($entreprise) {
		global $tab6;
		global $db;

		$typeEntreprise = $entreprise->getType();

		if ($entreprise->getIdentifiantBDD() == "") {
		    $sql = "INSERT INTO " . $tab6 . " VALUES ('" . $entreprise->getIdentifiantBDD() . "',
							      '" . $entreprise->getNom() . "',
							      '" . $entreprise->getAdresse() . "',
							      '" . $entreprise->getCodePostal() . "',
							      '" . $entreprise->getVille() . "',
							      '" . $entreprise->getPays() . "',
							      '" . $entreprise->getEmail() . "',
	         					  '" . $typeEntreprise->getIdentifiantBDD() . "')";

		    $req = $db->query($sql);

		    $sql2 = "SELECT LAST_INSERT_ID() AS ID FROM $tab6";
		    $req = $db->query($sql2);
		    $result = mysqli_fetch_array($req);
		    return $result['ID'];
		} else {
		    $sql = "UPDATE $tab6 SET nom='".$entreprise->getNom()."',
					     adresse='".$entreprise->getAdresse()."',
					     codepostal='".$entreprise->getCodePostal()."',
					     ville='".$entreprise->getVille()."',
					     pays='".$entreprise->getPays()."',
					     email='".$entreprise->getEmail()."',
					     idtypeentreprise='".$entreprise->getIdentifiantBDD()."',
			    WHERE identreprise ='".$entreprise->getIdentifiantBDD()."'";
		    $req = $db->query($sql);

		    echo "Ici UPDATE dans entreprise_bdd: (".$entreprise->getIdentifiantBDD()."), ".$entreprise->getNom().", ".$typeEntreprise->getIdentifiantBDD();

		    return $entreprise->getIdentifiantBDD();
		}
    }

    /**
     * Récupère une entreprise suivant son identifiant
     * @param $identifiantBDD l'identifiant de l'entreprise à récupérer
     * @return String[] tableau contenant les informations d'une entreprise
     */
    public static function getEntreprise($identifiantBDD) {
		global $tab6;
		global $db;

		$sql = "SELECT * FROM " . $tab6 . " WHERE identreprise='$identifiantBDD';";
		$req = $db->query($sql);
		if ($req == FALSE) {
		    return FALSE;
		}
		return mysqli_fetch_array($req);
    }

    /**
     * Retourne une liste d'entreprise suivant un filtre
     * @param $filtres le filtre de la recherche
     * @return String[] tableau contenant les entreprises concernées par le filtre
     */
    public static function getListeEntreprises($filtres) {
		global $tab6;
		global $db;

		if ($filtres == "")
		    $requete = "SELECT * FROM $tab6 ORDER BY nom ASC;";
		else
		    $requete = "SELECT * FROM $tab6 WHERE " . $filtres->getStrFiltres() . " ORDER BY nom ASC;";

		//echo $requete."<br/>";
		$result = $db->query($requete);

		$tabEntreprises = array();

		while ($entreprise = mysqli_fetch_array($result)) {
		    $tab = array();
		    array_push($tab, $entreprise["identreprise"]);
		    array_push($tab, $entreprise["nom"]);
		    array_push($tab, $entreprise["adresse"]);
		    array_push($tab, $entreprise["codepostal"]);
		    array_push($tab, $entreprise["ville"]);
		    array_push($tab, $entreprise["pays"]);
		    array_push($tab, $entreprise["email"]);
		    array_push($tab, $entreprise["idtypeentreprise"]);
		    array_push($tabEntreprises, $tab);
		}

		return $tabEntreprises;
    }

    public static function supprimerEntreprise($identifiantBDD) {
		global $tab6;
		global $db;

		$sql = "DELETE FROM $tab6 WHERE identreprise='$identifiantBDD'";
		//echo $sql."<br/>";
		$db->query($sql);
    }

    public static function existe($ent) {
		global $tab6;
		global $db;

		$sql = "SELECT identreprise FROM $tab6
					WHERE nom LIKE '" . $ent->getNom() . "'
					AND ville LIKE '" . $ent->getVille() . "'
					AND pays LIKE '" . $ent->getPays() . "'";
		//echo $sql."<br/>";
		$result = $db->query($sql);

		if (mysqli_num_rows($result) == 0)
		    return false;
		else
		    return true;
    }

}

?>