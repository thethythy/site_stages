<?php

/**
 * Classe Parcours : les différents parcours pour chaque filière
 */

class Parcours {

    var $identifiant_BDD;  // Identifiant unique en base
    var $nom;  // Nom du parcours

    /**
     * Constructeur
     * @param integer $identifiant_BDD
     * @param string $nom
     */
    public function Parcours($identifiant_BDD, $nom) {
	$this->identifiant_BDD = $identifiant_BDD;
	$this->nom = $nom;
    }

    // Accesseurs

    public function getIdentifiantBDD() {
	return $this->identifiant_BDD;
    }

    public function getNom() {
	return $this->nom;
    }

    public function setNom($nom) {
	$this->nom = $nom;
    }

    // Méthodes statiques

    /**
     * Obtenir un objet PaArcours à partir de son identifiant
     * @param integer $identifiantParcours
     * @return Parcours
     */
    public static function getParcours($identifiantParcours) {
	$parcoursString = Parcours_BDD::getParcours($identifiantParcours);
	$parcours = new Parcours($parcoursString['idparcours'], $parcoursString['nomparcours']);
	return $parcours;
    }

    /**
     * Renvoie une liste de tous les objets Parcours
     * @return tableau contenant tous les objets Parcours
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