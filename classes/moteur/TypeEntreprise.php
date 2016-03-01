<?php
class TypeEntreprise {

	// Déclaration des attributs de la classe
	var $identifiantBDD;
	var $type;

	// Constructeur de classe
	public function TypeEntreprise($identifiantBDD, $type) {
		$this->identifiantBDD = $identifiantBDD;
		$this->type = $type;
	}

	// getter-setter
	public function getIdentifiantBDD(){
    	return $this->identifiantBDD;
	}

	public function getType(){
    	return $this->type;
	}

	public function setType($type){
    	$this->type = $type;
	}

	// méthodes statiques
	public static function getTypeEntreprise($identifiant) {
		$typeEntrepriseBDD = TypeEntreprise_BDD::getTypeEntreprise($identifiant);
		return new TypeEntreprise($typeEntrepriseBDD["idtypeentreprise"], $typeEntrepriseBDD["type"]);
    }

    public static function getListeTypeEntreprise() {
		$tabTypeEntreprise = array();
		$tabTypeEntrepriseString = TypeEntreprise_BDD::getListeTypeEntreprise();
		for($i=0; $i<sizeof($tabTypeEntrepriseString); $i++)
			array_push($tabTypeEntreprise, new TypeEntreprise($tabTypeEntrepriseString[$i][0],$tabTypeEntrepriseString[$i][1]));
  		return $tabTypeEntreprise;
    }

    public static function supprimerTypeEntreprise($identifiant) {
    	TypeEntreprise_BDD::supprimerTypeEntreprise($identifiant);
    }

}

?>