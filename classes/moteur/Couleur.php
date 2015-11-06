<?php

class Couleur {
	var $identifiant_BDD;
	var $nom;
	var $code;
	
	public function Couleur($identifiant_BDD,$nom,$code){
		$this->identifiant_BDD = $identifiant_BDD;
		$this->nom = $nom;
		$this->code = $code;
	}
	
	public function setNom($nom) {
		$this->nom = $nom;
	}

	public function setCode($code) {
		$this->code = $code;
	}
		
	public function getNom() {
		return $this->nom;
	}

	public function getCode() {
		return $this->code;
	}
	
	public function getIdentifiantBDD() {
		return $this->identifiant_BDD;
	}
	
	/** Méthodes statiques **/
	
	public static function getCouleur($idCouleur){
		$couleurBDD = Couleur_BDD::getCouleur($idCouleur);
		
		return new Couleur($couleurBDD["idcouleur"], $couleurBDD["nomcouleur"], $couleurBDD["codehexa"]);
	}
	
	public static function saisirDonneesCouleur($tab_donnees){
		$couleur = new Couleur('',$tab_donnees[0],$tab_donnees[1]);
		Couleur_BDD::sauvegarder($couleur);
	}
	
	public static function listerCouleur(){
		$tabCouleur = array();
			
		$tabCouleurString = Couleur_BDD::listerCouleur();
			
		for($i=0; $i<sizeof($tabCouleurString); $i++)
	  		array_push($tabCouleur, new Couleur($tabCouleurString[$i][0],$tabCouleurString[$i][1],$tabCouleurString[$i][2]));
	  			
		return $tabCouleur;
	}
	
	public static function deleteCouleur($identifiantcouleur){
		Couleur_BDD::delete($identifiantcouleur);
	}
}

?>