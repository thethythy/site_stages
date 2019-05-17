<?php

/**
 * La classe Affectation sert à mémoriser les affectations
 * pour le suivi d'alternance aux enseignants
 */

class Affectation {

    var $idaffectation;  // Identifiant unique
    var $envoi;  // Flag indiquant si la notification a déjà été faite
    var $idcontrat;  // Identifiant du contrat concerné

    /**
     * Initialisation d'un objet Affectation
     * @param integer $idaffectation
     * @param integer $envoi
     * @param integer $idcontrat
     */
    public function __construct($idaffectation, $envoi, $idcontrat) {
	$this->idaffectation = $idaffectation;
	$this->envoi = $envoi;
	$this->idcontrat = $idcontrat;
    }

    // ------------------------------------------------------------------------
    // Accesseurs

    function getIdentifiantBDD() {
	return $this->idaffectation;
    }

    function getEnvoi() {
	return $this->envoi;
    }

    function getIdContrat() {
	return $this->idcontrat;
    }

    function setEnvoi($envoi) {
	$this->envoi = $envoi;
    }

    function setIdContrat($idcontrat) {
	$this->idcontrat = $idcontrat;
    }

    // ------------------------------------------------------------------------
    // Méthodes statiques

    /**
     * Rechercher un objet Affectation à partir de son identifiant
     * @param integer $idAffectation
     * @return FALSE ou Affectation
     */
    public static function getAffectation($idAffectation) {
	$affectationBDD = Affectation_BDD::getAffectation($idAffectation);
	if ($affectationBDD)
	    return new Affectation($affectationBDD["idaffectation"],
				   $affectationBDD["envoi"],
				   $affectationBDD["idcontrat"]);
	else
	    return FALSE;
    }

    /**
     * Rechercher un objet Affectation à partir du contrat associé
     * @param integer $idcontrat
     * @return FALSE ou Affectation
     */
    public static function getAffectationFromContrat($idcontrat) {
	$affectationBDD = Affectation_BDD::getAffectationFromContrat($idcontrat);
	if ($affectationBDD)
	    return new Attribution($affectationBDD["idaffectation"],
				   $affectationBDD["envoi"],
				   $affectationBDD["idcontrat"]);
	else
	    return FALSE;
    }


    /**
     * Rechercher les affectations associées à une promotion
     * @param integer $annee
     * @param integer $idparcours
     * @param integer $idfiliere
     */
    public static function getListeAffectationFromPromotion($annee, $idparcours, $idfiliere) {
	$tabAffectationBDD = Affectation_BDD::getListeAffectationFromPromotion($annee, $idparcours, $idfiliere);

	$tabOA = array();
	for ($i = 0; $i < sizeof($tabAffectationBDD); $i++)
	    array_push ($tabOA,
		    new Affectation($tabAffectationBDD[$i][0],
				    $tabAffectationBDD[$i][1],
				    $tabAffectationBDD[$i][2]));

	return $tabOA;
    }

}

?>