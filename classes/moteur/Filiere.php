<?php

/**
 * Classe Filiere : les filières (correspondant aux formations post-BAC)
 */

class Filiere {

    var $identifiant_BDD;  // Identifiant unique en base
    var $nom;  // Nom de la filière
    var $tempsSoutenance;  // Temps de soutenance de la filière
    var $affDepot;  // Indicateur d'affichage lors du dépôt d'une offre de stage
    var $idfilieresuivante;  // Identifiant de la filière suivante

    /**
     * Constructeur
     * @param integer $identifiant_BDD
     * @param string $nom
     * @param integer $tempsSoutenance
     * @param boolean $affDepot
     * @param integer $idfilieresuivante
     */
    public function __construct($identifiant_BDD, $nom, $tempsSoutenance = 20, $affDepot = 1, $idfilieresuivante = Null) {
	$this->identifiant_BDD = $identifiant_BDD;
	$this->nom = $nom;
	$this->tempsSoutenance = $tempsSoutenance;
	$this->affDepot = $affDepot;
	$this->idfilieresuivante = $idfilieresuivante;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en lecture

    public function getIdentifiantBDD() {
	return $this->identifiant_BDD;
    }

    public function getNom() {
	return $this->nom;
    }

    public function getTempsSoutenance() {
	return $this->tempsSoutenance;
    }

    public function getAffDepot() {
	return $this->affDepot;
    }

    public function getIdFiliereSuivante() {
	return $this->idfilieresuivante;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en lecture

    public function setNom($nom) {
	$this->nom = $nom;
    }

    public function setTempsSoutenance($temps) {
	$this->tempsSoutenance = $temps;
    }

    public function setIdFiliereSuivante($idfilieresuivante) {
	$this->idfilieresuivante = $idfilieresuivante;
    }

    // ------------------------------------------------------------------------
    // Méthodes statiques

    /**
     * Obtenir un objet Filiere à partir d'un identifant
     * @param integer $identifiantFiliere
     * @return Filiere
     */
    public static function getFiliere($identifiantFiliere) {
	$filiereString = Filiere_BDD::getFiliere($identifiantFiliere);
	$filiere = new Filiere($filiereString['idfiliere'],
			       $filiereString['nomfiliere'],
			       $filiereString['temps_soutenance'],
			       $filiereString['affDepot'],
			       $filiereString['idfilieresuivante']);
	return $filiere;
    }

    /**
     * Obtenir la liste de toutes les filières
     * @return tableau d'objets Filière
     */
    public static function listerFilieres() {
	$tabFilieres = array();
	$tabFiliereString = Filiere_BDD::listerFilieres();
	for ($i = 0; $i < sizeof($tabFiliereString); $i++)
	    array_push($tabFilieres,
		    new Filiere($tabFiliereString[$i][0],
				$tabFiliereString[$i][1],
				$tabFiliereString[$i][2],
				$tabFiliereString[$i][3],
				$tabFiliereString[$i][4]));
	return $tabFilieres;
    }

}

?>