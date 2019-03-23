<?php

/**
 * Les contacts en entreprises
 */

class Contact {

    var $identifiantBDD; // Identifiant unique en base
    var $nom; // Nom de famille
    var $prenom; // Prénom
    var $telephone; // Numéro de téléphone
    var $email; // Adresse de courriel
    var $identifiant_entreprise; // Identifiant de l'entreprise associée

    /**
     * Constructeur d'un objet Contact
     * @param integer $identifiantBDD
     * @param string $nom
     * @param string $prenom
     * @param string $telephone
     * @param string $email
     * @param integer $identifiant_entreprise
     */
    public function __construct($identifiantBDD, $nom, $prenom, $telephone,
	    $email, $identifiant_entreprise) {
	$this->identifiantBDD = $identifiantBDD;
	$this->nom = $nom;
	$this->prenom = $prenom;
	$this->telephone = $telephone;
	$this->email = $email;
	$this->identifiant_entreprise = $identifiant_entreprise;

    }

    // ------------------------------------------------------------------------
    // Accesseurs en lecture

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function getNom() {
	return $this->nom;
    }

    public function getPrenom() {
	return $this->prenom;
    }

    public function getTelephone() {
	return $this->telephone;
    }

    public function getEmail() {
	return $this->email;
    }

    public function getEntreprise() {
	return Entreprise::getEntreprise($this->identifiant_entreprise);
    }

    // ------------------------------------------------------------------------
    // Accesseurs en écriture

    public function setNom($nom) {
	$this->nom = $nom;
    }

    public function setPrenom($prenom) {
	$this->prenom = $prenom;
    }

    public function setTelephone($telephone) {
	$this->telephone = $telephone;
    }

    public function setEmail($email) {
	$this->email = $email;
    }

    public function setIdentifiant_entreprise($identifiant_entreprise) {
	$this->identifiant_entreprise = $identifiant_entreprise;
    }

    // ------------------------------------------------------------------------
    // Méthodes statiques

    /**
     * Suppression d'un contact en base de données
     * @param integer $idContact
     */
    public static function supprimerContact($idContact) {
	Contact_BDD::supprimerContact($idContact);
    }

    /**
     * Obtenir un objet Contact à partir de son identfiant en base
     * @param integer $idContact
     * @return Contact
     */
    public static function getContact($idContact) {
	$contactBDD = Contact_BDD::getContact($idContact);

	return new Contact($contactBDD["idcontact"], $contactBDD["nomcontact"],
			   $contactBDD["prenomcontact"], $contactBDD["telephone"],
			  $contactBDD["email"],
			   $contactBDD["identreprise"]);
    }

    /**
     * Obtenir une liste d'objets Contact à partir d'un filtre de sélection
     * @param Filtre $filtre
     * @return tableau d'objets
     */
    public static function getListeContacts($filtre) {
	$tabContactString = Contact_BDD::getListeContacts($filtre);
	$tabContacts = array();

	for ($i = 0; $i < sizeof($tabContactString); $i++) {
	    array_push($tabContacts, new Contact(
              $tabContactString[$i][0],
						 $tabContactString[$i][1],
						 $tabContactString[$i][2],
						 $tabContactString[$i][3],
						 $tabContactString[$i][4],
						 $tabContactString[$i][5]));
	}

	return $tabContacts;
    }

    /**
     * Obtenir tous les contacts d'une entreprise
     * @param integer $identifiant_entreprise
     * @return tableau d'objets
     */
    public static function listerContacts($identifiant_entreprise) {
	$tab_contacts = array();
	$tabContactsStr = Contact_BDD::listerContacts($identifiant_entreprise);

	for ($i = 0; $i < sizeof($tabContactsStr); $i++) {
	    array_push($tab_contacts, new Contact($tabContactsStr[$i][0],
						  $tabContactsStr[$i][1],
						  $tabContactsStr[$i][2],
						  $tabContactsStr[$i][3],
						  $tabContactsStr[$i][4],
						  $tabContactsStr[$i][5]));
	}

	return $tab_contacts;
    }

}

?>