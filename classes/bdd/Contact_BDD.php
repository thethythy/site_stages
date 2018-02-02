<?php

/**
 * Représentation et accès à la table n°3 : les contacts en entreprises
 */

class Contact_BDD {

    /**
     * Sauvegarde ou et met à jour en base un objet Contact
     * @global string $tab3 Nom de la table 'contact'
     * @global resource $db Référence sur la base ouverte
     * @param Contact $contact Un objet contact
     * @return integer Identifiant en base de l'ojet créé
     */
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
     * @global string $tab3 Nom de la table 'contact'
     * @global resource $db Référence sur la base ouverte
     * @param $identifiantBDD l'identifiant du contact à récupérer
     * @return String[] tableau contenant les informations d'un contact ou NULL
     */
    public static function getContact($identifiantBDD) {
	global $tab3;
	global $db;

	$sql = "SELECT * FROM $tab3 WHERE idcontact = '" . $identifiantBDD . "'";
	$req = $db->query($sql);
	return mysqli_fetch_array($req);
    }

    /**
     * Suppression en base d'un contact à partir de son identifiant
     * @global string $tab3 Nom de la table 'contact'
     * @global resource $db Référence sur la base ouverte
     * @param integer $identifiantBDD Identifiant en base de l'objet à supprimer
     */
    public static function supprimerContact($identifiantBDD) {
	global $tab3;
	global $db;
	$sql = "DELETE FROM $tab3 WHERE idcontact='" . $identifiantBDD . "'";
	$db->query($sql);
    }

    /**
     * Renvoie la liste des contacts d'une entreprise
     * @global string $tab3 Nom de la table 'contact'
     * @global resource $db Référence sur la base ouverte
     * @param integer $identifiantEntreprise L'identifiant de l'entreprise
     * @return Tableau d'enregistrements de tous les contacts
     */
    public static function listerContacts($identifiantEntreprise) {
	global $tab3;
	global $db;

	$sql = "SELECT * FROM " . $tab3 . " WHERE identreprise = '" . $identifiantEntreprise . "' ORDER BY nomcontact ASC;";
	$req = $db->query($sql);

	$listeContacts = array();

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
     * @global string $tab3 Nom de la table 'contact'
     * @global resource $db Référence sur la base ouverte
     * @param Filtre $filtre Le filtre global de la recherche
     * @return Tableau d'enregistrements des contacts concernés par le filtre
     */
    public static function getListeContacts($filtre) {
	global $tab3;
	global $db;

	if ($filtre == "")
	    $requete = "SELECT * FROM $tab3 ORDER BY nomcontact ASC;";
	else
	    $requete = "SELECT * FROM $tab3 WHERE " . $filtre->getStrFiltres() . " ORDER BY nomcontact ASC;";

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