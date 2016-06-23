<?php

class Salle {

    // Déclaration des attributs de la classe
    var $identifiantBDD;
    var $nom;

    // Constructeur de classe
    public function Salle($identifiantBDD, $nom) {
	$this->identifiantBDD = $identifiantBDD;
	$this->nom = $nom;
    }

    // Méhodes diverses

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function getNom() {
	return $this->nom;
    }

    public function setNom($nom) {
	$this->nom = $nom;
    }

    /** Méthodes statiques **/

    public static function getSalle($idSalle) {
	$salleBDD = Salle_BDD::getSalle($idSalle);
	return new Salle($salleBDD["idsalle"], $salleBDD["nomsalle"]);
    }

    public static function saisirDonneesSalle($tab_donnees) {
	$salle = new Salle('', $tab_donnees[0]);
	Salle_BDD::sauvegarder($salle);
    }

    public static function listerSalle() {
	$tabSalle = array();
	$tabSalleString = Salle_BDD::listerSalle();

	for ($i = 0; $i < sizeof($tabSalleString); $i++)
	    array_push($tabSalle,
		    new Salle($tabSalleString[$i][0],
			      $tabSalleString[$i][1]));

	return $tabSalle;
    }

    public static function deleteSalle($identifiantsalle) {
	Salle_BDD::delete($identifiantsalle);
    }

}

?>