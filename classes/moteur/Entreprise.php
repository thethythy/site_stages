<?php

class Entreprise {

	// Déclaration des attributs de la classe
	var $identifiantBDD;
	var $nom;
	var $adresse;
	var $codePostal;
	var $ville;
	var $pays;
	var $email;
	var $type;

	// Constructeur de classe
	public function Entreprise($identifiantBDD, $nom, $adresse, $codePostal, $ville, $pays, $email, $type) {
		$this->identifiantBDD = $identifiantBDD;
		$this->nom = $nom;
		$this->adresse = $adresse;
		$this->codePostal = $codePostal;
		$this->ville = $ville;
		$this->pays = $pays;
		$this->email = $email;
		$this->type = $type;
	}

	// Méthodes diverses

	public function getIdentifiantBDD(){
    	return $this->identifiantBDD;
	}

	public function getNom(){
    	return $this->nom;
	}

	public function setNom($nom){
    	$this->nom = $nom;
	}

	public function getAdresse(){
    	return $this->adresse;
	}

	public function setAdresse($adresse){
    	$this->adresse = $adresse;
	}

	public function getCodePostal(){
    	return $this->codePostal;
	}

	public function setCodePostal($codePostal){
    	$this->codePostal = $codePostal;
	}

	public function getVille(){
    	return $this->ville;
	}

	public function setVille($ville){
    	$this->ville = $ville;
	}

	public function getPays(){
    	return $this->pays;
	}

	public function setPays($pays){
    	$this->pays = $pays;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function getType() {
		return $this->type;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function listeDeContacts(){
		return Contact::listerContacts($this->identifiantBDD);
	}

	/** Méthodes statiques **/

	public static function supprimerEntreprise($idEntreprise){
		Entreprise_BDD::supprimerEntreprise($idEntreprise);
	}

	public static function getEntreprise($idEntreprise){
		$entrepriseBDD = Entreprise_BDD::getEntreprise($idEntreprise);

		return new Entreprise($entrepriseBDD["identreprise"],
				      $entrepriseBDD["nom"],
				      $entrepriseBDD["adresse"],
				      $entrepriseBDD["codepostal"],
				      $entrepriseBDD["ville"],
				      $entrepriseBDD["pays"],
				      $entrepriseBDD["email"],
				      $entrepriseBDD["idtype"]);
	}

	public static function getListeEntreprises($filtres){
		$tabEntrepriseString = Entreprise_BDD::getListeEntreprises($filtres);

		$tabEntreprise = array();
		for($i=0; $i<sizeof($tabEntrepriseString); $i++)
  			array_push($tabEntreprise, new Entreprise($tabEntrepriseString[$i][0],
								  $tabEntrepriseString[$i][1],
								  $tabEntrepriseString[$i][2],
								  $tabEntrepriseString[$i][3],
								  $tabEntrepriseString[$i][4],
								  $tabEntrepriseString[$i][5],
								  $tabEntrepriseString[$i][6],
								  @$tabEntrepriseString[$i][7]));

  		return $tabEntreprise;
	}

	// $tab_donnees : Un tableau de String contenant les champs du formulaire de saisie
	public static function saisisrDonneesEntreprise($tab_donnees){
    	$entreprise = new Entreprise("", $tab_donnees[0], $tab_donnees[1], $tab_donnees[2], $tab_donnees[3], $tab_donnees[4], $tab_donnees[5], $tab_donnees[6]);
    	$id = Entreprise_BDD::sauvegarder($entreprise);
    	return id;
	}
}

?>