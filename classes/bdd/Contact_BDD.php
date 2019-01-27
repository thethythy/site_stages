<?php

/**
 * Représentation et accès à la table n°3 : les contacts en entreprises
 */

class Contact_BDD {

    /**
     * Sauvegarde ou et met à jour en base un objet Contact
     * @global resource $db Référence sur la base ouverte
     * @global string $tab3 Nom de la table 'contact'
     * @param Contact $contact Un objet contact
     * @return integer Identifiant en base de l'ojet créé
     */
    public static function sauvegarder($contact) {
	global $db;
	global $tab3;

	$entreprise = $contact->getEntreprise();

	if ($contact->getIdentifiantBDD() == "") {
	    $sql = "INSERT INTO " . $tab3 . " VALUES (
			'0',
			'" . $contact->getNom() . "',
			'" . $contact->getPrenom() . "',
			'" . $contact->getTelephone() . "',
			'" . $contact->getTelecopie() . "',
			'" . $contact->getEmail() . "',
			'" . $entreprise->getIdentifiantBDD() . "');";
	    $db->query($sql);

	    $sql = "SELECT LAST_INSERT_ID() AS ID FROM $tab3";
	    $res = $db->query($sql);
	    $enreg = $res->fetch_array();
	    $res->free();
	    return $enreg['ID'];
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
     * @global resource $db Référence sur la base ouverte
     * @global string $tab3 Nom de la table 'contact'
     * @param $identifiantBDD l'identifiant du contact à récupérer
     * @return String[] tableau contenant les informations d'un contact ou FALSE
     */
    public static function getContact($identifiantBDD) {
	global $db;
	global $tab3;

	$sql = "SELECT * FROM $tab3 WHERE idcontact = '$identifiantBDD'";
	$res = $db->query($sql);

	$ok = $res != FALSE;

	if ($ok) {
	    $enreg = $res->fetch_array();
	    $res->free();
	}

	return $ok ? $enreg : FALSE;
    }

    /**
     * Suppression en base d'un contact à partir de son identifiant
     * @global resource $db Référence sur la base ouverte
     * @global string $tab3 Nom de la table 'contact'
     * @param integer $identifiantBDD Identifiant en base de l'objet à supprimer
     */
    public static function supprimerContact($identifiantBDD) {
	global $db;
	global $tab3;
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
	global $db;
	global $tab3;

	$sql = "SELECT * FROM " . $tab3 . " WHERE identreprise = '" . $identifiantEntreprise . "' ORDER BY nomcontact ASC;";
	$res = $db->query($sql);

	$listeContacts = array();

	if ($res) {
	    while ($data = $res->fetch_array()) {
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
	    $res->free();
	}

	return $listeContacts;
    }

    /**
     * Retourne une liste de contacts suivant un filtre
     * @global resource $db Référence sur la base ouverte
     * @global string $tab3 Nom de la table 'contact'
     * @param Filtre $filtre Le filtre global de la recherche
     * @return Tableau d'enregistrements des contacts concernés par le filtre
     */
    public static function getListeContacts($filtre) {
	global $db;
	global $tab3;

	if ($filtre == "")
	    $requete = "SELECT * FROM $tab3 ORDER BY nomcontact ASC;";
	else
	    $requete = "SELECT * FROM $tab3 WHERE " . $filtre->getStrFiltres() . " ORDER BY nomcontact ASC;";

	$res = $db->query($requete);

	$tabContacts = array();

	if ($res) {
	    while ($contact = $res->fetch_assoc()) {
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
	    $res->free();
	}

	return $tabContacts;
    }

}

?>
