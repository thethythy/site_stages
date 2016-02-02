<?php

class Contact_BDD {

    // Méthodes statiques

    public static function sauvegarder($contact) {
		global $tab3;
		global $db;

		$entreprise = $contact->getEntreprise();

		if ($contact->getIdentifiantBDD() == "") {
		    $sql = "INSERT INTO " . $tab3 . " VALUES (
							'" . $contact->getIdentifiantBDD() . "',
							'" . $contact->getNom() . "',
							'" . $contact->getPrenom() . "',
							'" . $contact->getTelephone() . "',
							'" . $contact->getTelecopie() . "',
							'" . $contact->getEmail() . "',
							'" . $entreprise->getIdentifiantBDD() . "');";
		    $db->query($sql);

		    $sql2 = "SELECT LAST_INSERT_ID() AS ID FROM $tab3";
		    $req = $db->query($sql2);
		    $result = mysqli_fetch_array($req);
		    return $result['ID'];
		} else {
		    $sql = "UPDATE $tab3 SET nomcontact = '" . $contact->getNom() . "',
					     prenomcontact = '" . $contact->getPrenom() . "',
					     telephone = '" . $contact->getTelephone() . "',
					     telecopie = '" . $contact->getTelecopie() . "',
					     email = '" . $contact->getEmail() . "',
					     identreprise = '" . $entreprise->getIdentifiantBDD() . "'
			    WHERE idcontact = '" . $contact->getIdentifiantBDD() . "'";

		    $db->query($sql);
		    return $contact->getIdentifiantBDD();
		}
    }

    /**
     * Récupère un contact suivant son identifiant
     * @param $identifiantBDD l'identifiant du contact à récupérer
     * @return String[] tableau contenant les informations d'un contact
     */
    public static function getContact($identifiantBDD) {
		global $tab3;
		global $db;

		$result = array();
		$sql = "SELECT * FROM $tab3 WHERE idcontact = '" . $identifiantBDD . "'";
		$req = $db->query($sql);
		return mysqli_fetch_array($req);
    }

    public static function supprimerContact($identifiantBDD) {
		global $tab3;
		global $db;

		$sql = "DELETE FROM $tab3 WHERE idcontact='".$identifiantBDD."'";
		//echo $sql."<br/>";
		$db->query($sql);
    }

    /**
     * Renvoie la liste des contacts d'entreprise
     * @param $identreprise l'identifiant de l'entreprise
     * @return String[] tablrau contenant tous les contacts de l'entreprise
     */
    public static function listerContacts($identifiantEntreprise) {
		$listeContacts = array();
		global $tab3;
		global $db;

		$result = array();
		$sql = "SELECT * FROM " . $tab3 . " WHERE identreprise = '" . $identifiantEntreprise . "' ORDER BY nomcontact ASC;";
		$req = $db->query($sql);
		while ($data = mysqli_fetch_array($req)) {
		    $tab = array();
		    array_push($tab, $data["idcontact"]);
		    array_push($tab, $data["nomcontact"]);
		    array_push($tab, $data["prenomcontact"]);
		    array_push($tab, $data["telephone"]);
		    array_push($tab, $data["telecopie"]);
		    array_push($tab, $data["email"]);
		    array_push($tab, $data["identreprise"]);
		    array_push($listeContacts, $tab);
		}
		return $listeContacts;
    }

    /**
     * Retourne une liste de contacts suivant un filtre
     * @param $filtres le filtre de la recherche
     * @return String[] tableau contenant les contacts concernées par le filtre
     */
    public static function getListeContacts($filtres) {
		global $tab3;
		global $db;

		if ($filtres == "")
		    $requete = "SELECT * FROM $tab3 ORDER BY nomcontact ASC;";
		else
		    $requete = "SELECT * FROM $tab3 WHERE " . $filtres->getStrFiltres() . " ORDER BY nomcontact ASC;";

		//echo $requete."<br/>";
		$result = $db->query($requete);

		$tabContacts = array();

		while ($contact = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		    $tab = array();
		    array_push($tab, $contact["idcontact"]);
		    array_push($tab, $contact["nomcontact"]);
		    array_push($tab, $contact["prenomcontact"]);
		    array_push($tab, $contact["telephone"]);
		    array_push($tab, $contact["telecopie"]);
		    array_push($tab, $contact["email"]);
		    array_push($tab, $contact["identreprise"]);
		    array_push($tabContacts, $tab);
		}

		return $tabContacts;
	}

}

?>