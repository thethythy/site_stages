<?php

/**
 * Classe Salle : les salles de soutenance
 */

class Salle {

    var $identifiantBDD;  // Identifiant unique en base
    var $nom;  // Nom de la salle

    /**
     * Constructeur de classe
     * @param integer $identifiantBDD
     * @param string $nom
     */
    public function __construct($identifiantBDD, $nom) {
	$this->identifiantBDD = $identifiantBDD;
	$this->nom = $nom;
    }

    // Accesseurs

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function getNom() {
	return $this->nom;
    }

    public function setNom($nom) {
	$this->nom = $nom;
    }

    // Méthodes statiques

    /**
     * Obtenir un objet Salle à partir de son identifiant
     * @param integer $idSalle
     * @return Salle
     */
    public static function getSalle($idSalle) {
	$salleBDD = Salle_BDD::getSalle($idSalle);
	return new Salle($salleBDD["idsalle"], $salleBDD["nomsalle"]);
    }

    /**
     * Enregistrer une salle à partir d'un tableau d'attributs
     * @param array $tab_donnees
     */
    public static function saisirDonneesSalle($tab_donnees) {
	$salle = new Salle('', $tab_donnees[0]);
	Salle_BDD::sauvegarder($salle);
    }

    /**
     * Obtenir tous les objets Salle
     * @return array
     */
    public static function listerSalle() {
	$tabSalle = array();
	$tabSalleString = Salle_BDD::listerSalle();

	for ($i = 0; $i < sizeof($tabSalleString); $i++)
	    array_push($tabSalle,
		    new Salle($tabSalleString[$i][0],
			      $tabSalleString[$i][1]));

	return $tabSalle;
    }

    /**
     * Supprimer une salle à partir de son identifiant
     * @param integer $identifiantsalle
     */
    public static function deleteSalle($identifiantsalle) {
	Salle_BDD::delete($identifiantsalle);
    }

}

?>