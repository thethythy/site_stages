<?php

class Contact {

    // Déclaration des attributs de la classe
    var $identifiantBDD;
    var $nom;
    var $prenom;
    var $telephone;
    var $telecopie;
    var $email;
    var $identifiant_entreprise;

    // Constructeur de classe
    public function Contact($identifiantBDD, $nom, $prenom, $telephone,
	    $telecopie, $email, $identifiant_entreprise) {
	$this->identifiantBDD = $identifiantBDD;
	$this->nom = $nom;
	$this->prenom = $prenom;
	$this->telephone = $telephone;
	$this->telecopie = $telecopie;
	$this->email = $email;
	$this->identifiant_entreprise = $identifiant_entreprise;
    }

    // Méthodes diverses

    public function setNom($nom) {
	$this->nom = $nom;
    }

    public function setPrenom($prenom) {
	$this->prenom = $prenom;
    }

    public function setTelephone($telephone) {
	$this->telephone = $telephone;
    }

    public function setTelecopie($telecopie) {
	$this->telecopie = $telecopie;
    }

    public function setEmail($email) {
	$this->email = $email;
    }

    public function setIdentifiant_entreprise($identifiant_entreprise) {
	$this->identifiant_entreprise = $identifiant_entreprise;
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

    public function getTelecopie() {
	return $this->telecopie;
    }

    public function getEmail() {
	return $this->email;
    }

    public function getEntreprise() {
	return Entreprise::getEntreprise($this->identifiant_entreprise);
    }

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    /** Méthodes statiques * */

    public static function supprimerContact($idContact) {
	Contact_BDD::supprimerContact($idContact);
    }

    public static function getContact($idContact) {
	$contactBDD = Contact_BDD::getContact($idContact);

	return new Contact($contactBDD["idcontact"], $contactBDD["nomcontact"],
			   $contactBDD["prenomcontact"], $contactBDD["telephone"],
			   $contactBDD["telecopie"], $contactBDD["email"],
			   $contactBDD["identreprise"]);
    }

    public static function getListeContacts($filtres) {
	$tabContactString = Contact_BDD::getListeContacts($filtres);
	$tabContacts = array();

	for ($i = 0; $i < sizeof($tabContactString); $i++) {
	    array_push($tabContacts, new Contact($tabContactString[$i][0],
						 $tabContactString[$i][1],
						 $tabContactString[$i][2],
						 $tabContactString[$i][3],
						 $tabContactString[$i][4],
						 $tabContactString[$i][5],
						 $tabContactString[$i][6]));
	}

	return $tabContacts;
    }

    public static function listerContacts($identifiant_entreprise) {
	$tab_contacts = array();
	$tabContactsStr = Contact_BDD::listerContacts($identifiant_entreprise);

	for ($i = 0; $i < sizeof($tabContactsStr); $i++) {
	    array_push($tab_contacts, new Contact($tabContactsStr[$i][0],
						  $tabContactsStr[$i][1],
						  $tabContactsStr[$i][2],
						  $tabContactsStr[$i][3],
						  $tabContactsStr[$i][4],
						  $tabContactsStr[$i][5],
						  $tabContactsStr[$i][6]));
	}

	return $tab_contacts;
    }

}

?>