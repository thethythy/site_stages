<?php

class Parrain {

    var $identifiant_BDD;
    var $nom;
    var $prenom;
    var $email;
    var $identifiant_couleur;

    public function Parrain($identifiant_BDD, $nom, $prenom, $email, $identifiant_couleur) {
	$this->identifiant_BDD = $identifiant_BDD;
	$this->nom = $nom;
	$this->prenom = $prenom;
	$this->email = $email;
	$this->identifiant_couleur = $identifiant_couleur;
    }

    public function setNom($nom) {
	$this->nom = $nom;
    }

    public function setPrenom($prenom) {
	$this->prenom = $prenom;
    }

    public function setEmail($email) {
	$this->email = $email;
    }

    public function setIdentifiant_couleur($identifiant_couleur) {
	$this->identifiant_couleur = $identifiant_couleur;
    }

    public function getNom() {
	return $this->nom;
    }

    public function getPrenom() {
	return $this->prenom;
    }

    public function getEmail() {
	return $this->email;
    }

    public function getCouleur() {
	return Couleur::getCouleur($this->identifiant_couleur);
    }

    public function getIdentifiantBDD() {
	return $this->identifiant_BDD;
    }

    /** Méthodes statiques **/

    public static function getParrain($idParrain) {
	$parrainBDD = Parrain_BDD::getParrain($idParrain);

	return new Parrain($parrainBDD["idparrain"],
			   $parrainBDD["nomparrain"],
			   $parrainBDD["prenomparrain"],
			   $parrainBDD["emailparrain"],
			   $parrainBDD["idcouleur"]);
    }

    public static function saisirDonneesParrain($tab_donnees) {
	$parrain = new Parrain('', $tab_donnees[0], $tab_donnees[1],
				   $tab_donnees[2], $tab_donnees[3]);
	Parrain_BDD::sauvegarder($parrain);
    }

    public static function listerParrain() {
	$tabParrain = array();
	$tabParrainString = Parrain_BDD::listerParrain();

	for ($i = 0; $i < sizeof($tabParrainString); $i++)
	    array_push($tabParrain,
		    new Parrain($tabParrainString[$i][0], $tabParrainString[$i][1],
				$tabParrainString[$i][2], $tabParrainString[$i][3],
				$tabParrainString[$i][4]));

	return $tabParrain;
    }

    public static function deleteParrain($identifiantparr) {
	Parrain_BDD::delete($identifiantparr);
    }

}

?>