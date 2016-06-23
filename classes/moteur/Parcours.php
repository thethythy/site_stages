<?php

class Parcours {

    var $identifiant_BDD;
    var $nom;

    public function Parcours($identifiant_BDD, $nom) {
	$this->identifiant_BDD = $identifiant_BDD;
	$this->nom = $nom;
    }

    public function setNom($nom) {
	$this->nom = $nom;
    }

    public function getNom() {
	return $this->nom;
    }

    public function getIdentifiantBDD() {
	return $this->identifiant_BDD;
    }

    public static function getParcours($identifiantParcours) {
	$parcoursString = Parcours_BDD::getParcours($identifiantParcours);
	$parcours = new Parcours($parcoursString['idparcours'], $parcoursString['nomparcours']);
	return $parcours;
    }

    /**
     * Renvoie une liste de tous les parcours
     * @return Parcours[] tableau contenant tous les parcours
     */
    public static function listerParcours() {
	$tabParcours = array();
	$tabParcoursString = Parcours_BDD::listerParcours();

	for ($i = 0; $i < sizeof($tabParcoursString); $i++)
	    array_push($tabParcours, new Parcours($tabParcoursString[$i][0], $tabParcoursString[$i][1]));

	return $tabParcours;
    }

}

?>