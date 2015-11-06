<?php

class Filiere {
	var $identifiant_BDD;
	var $nom;
	var $tempsSoutenance;
	var $affDepot;

	public function Filiere($identifiant_BDD,$nom, $tempsSoutenance=20, $affDepot=1){
		$this->identifiant_BDD = $identifiant_BDD;
		$this->nom = $nom;
		$this->tempsSoutenance = $tempsSoutenance;
		$this->affDepot = $affDepot;
	}

	public function setNom($nom) {
		$this->nom = $nom;
	}

	public function getNom() {
		return $this->nom;
	}

	public function setTempsSoutenance($temps) {
		$this->tempsSoutenance = $temps;
	}

	public function getTempsSoutenance() {
		return $this->tempsSoutenance;
	}

	public function getIdentifiantBDD() {
		return $this->identifiant_BDD;
	}

	public function getAffDepot() {
		return $this->affDepot;
	}

	public static function getFiliere($identifiantFiliere) {
		$filiereString = Filiere_BDD::getFiliere($identifiantFiliere);
		//echo "Filiere::getFiliere : ".$filiereString['idfiliere']."</br>";
		$filiere = new Filiere($filiereString['idfiliere'], $filiereString['nomfiliere'], $filiereString['temps_soutenance'], $filiereString['affDepot']);
		return $filiere;
	}

	/**
	 * Renvoie une liste de toutes les filières
	 * @return Filiere[] tableau contenant toutes les filières
	 */
	public static function listerFilieres(){
		$tabFilieres = array();
		$tabFiliereString = Filiere_BDD::listerFilieres();
		for($i=0; $i<sizeof($tabFiliereString); $i++)
			array_push($tabFilieres, new Filiere($tabFiliereString[$i][0],$tabFiliereString[$i][1],$tabFiliereString[$i][2],$tabFiliereString[$i][3]));
		return $tabFilieres;
	}
}
?>