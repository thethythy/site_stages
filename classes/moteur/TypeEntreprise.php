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
		/*var_dump($tabTypeEntrepriseString[0][0],$tabTypeEntrepriseString[0][1]);
		var_dump($tabTypeEntrepriseString[1][0],$tabTypeEntrepriseString[1][1]);
		var_dump($tabTypeEntrepriseString[2][0],$tabTypeEntrepriseString[2][1]);
		var_dump($tabTypeEntrepriseString[3][0],$tabTypeEntrepriseString[3][1]);*/
		for($i=0; $i<sizeof($tabTypeEntrepriseString); $i++)
			array_push($tabTypeEntreprise, new TypeEntreprise($tabTypeEntrepriseString[$i][0],$tabTypeEntrepriseString[$i][1]));
		//var_dump($tabTypeEntreprise);
		/*$truc = $tabTypeEntreprise[3]->getIdentifiantBDD();
		$truc2 = $tabTypeEntreprise[3]->getTypeEntreprise($truc);
		echo "$truc";
		echo $truc2->getType();*/
  		return $tabTypeEntreprise;
    }

    public static function supprimerTypeEntreprise($identifiant) {
    	TypeEntreprise_BDD::supprimerTypeEntreprise($identifiant);
    }

}

?>