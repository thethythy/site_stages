<?php

class TypeEntreprise {

    // Déclaration des attributs de la classe
    var $identifiantBDD;
    var $type;
    var $identifiant_couleur;

    // Constructeur de classe
    public function TypeEntreprise($identifiantBDD, $type, $identifiant_couleur) {
	$this->identifiantBDD = $identifiantBDD;
	$this->type = $type;
	$this->identifiant_couleur = $identifiant_couleur;
    }

    // getter-setter
    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function getType() {
	return $this->type;
    }

    public function getCouleur() {
	return Couleur::getCouleur($this->identifiant_couleur);
    }

    public function setIdentifiant_couleur($identifiant_couleur) {
	$this->identifiant_couleur = $identifiant_couleur;
    }

    public function setType($type) {
	$this->type = $type;
    }

    // méthodes statiques

    public static function getTypeEntreprise($identifiant) {
	$typeEntrepriseBDD = TypeEntreprise_BDD::getTypeEntreprise($identifiant);
	return new TypeEntreprise($typeEntrepriseBDD["idtypeentreprise"],
				  $typeEntrepriseBDD["type"],
				  $typeEntrepriseBDD["idcouleur"]);
    }

    public static function getTypeEntrepriseFromNom($nom) {
	$typeEntrepriseBDD = TypeEntreprise_BDD::getTypeEntrepriseFromNom($nom);
	return new TypeEntreprise($typeEntrepriseBDD["idtypeentreprise"],
				  $typeEntrepriseBDD["type"],
				  $typeEntrepriseBDD["idcouleur"]);
    }

    public static function getListeTypeEntreprise() {
	$tabTypeEntreprise = array();
	$tabTypeEntrepriseString = TypeEntreprise_BDD::getListeTypeEntreprise();

	for ($i = 0; $i < sizeof($tabTypeEntrepriseString); $i++)
	    array_push($tabTypeEntreprise,
		    new TypeEntreprise($tabTypeEntrepriseString[$i][0],
				       $tabTypeEntrepriseString[$i][1],
				       $tabTypeEntrepriseString[$i][2]));

	return $tabTypeEntreprise;
    }

    public static function saisirDonneesType($tab_donnees) {
	$type = new TypeEntreprise('', $tab_donnees[0], $tab_donnees[1]);
	TypeEntreprise_BDD::sauvegarder($type);
    }

    public static function supprimerTypeEntreprise($identifiant) {
	TypeEntreprise_BDD::supprimerTypeEntreprise($identifiant);
    }

}

?>