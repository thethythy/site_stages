<?php

/**
 * Classe Soutenance : les soutenances de stage
 */

class Soutenance {

    var $identifiantBDD;  // Identifiant unique en base
    var $heureDebut;  // Heure de début
    var $minuteDebut;  // Minute de début
    var $aHuisClos;  // Indicateur à true si la soutenance est confidentielle
    var $identifiantDateSoutenance;  // Identifiant de la date de soutenance
    var $identifiantSalle;  // Identifiant de la salle

    /**
     * Constructeur
     * @param integer $identifiantBDD
     * @param integer $identifiantDateSoutenance
     * @param integer $identifiantSalle
     * @param integer $heureDebut
     * @param integer $minuteDebut
     * @param boolean $aHuitClos
     */
    public function Soutenance($identifiantBDD, $identifiantDateSoutenance,
	    $identifiantSalle, $heureDebut, $minuteDebut, $aHuitClos) {
	$this->identifiantBDD = $identifiantBDD;
	$this->identifiantDateSoutenance = $identifiantDateSoutenance;
	$this->identifiantSalle = $identifiantSalle;
	$this->heureDebut = $heureDebut;
	$this->minuteDebut = $minuteDebut;
	$this->aHuisClos = $aHuitClos;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en lecture

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function getHeureDebut() {
	return $this->heureDebut;
    }

    public function getMinuteDebut() {
	return $this->minuteDebut;
    }

    public function isAHuisClos() {
	return $this->aHuisClos;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en écriture

    public function setIdentifiantBDD($id) {
	$this->identifiantBDD = $id;
    }

    public function setHeureDebut($heureDebut) {
	$this->heureDebut = $heureDebut;
    }

    public function setMinuteDebut($minuteDebut) {
	$this->minuteDebut = $minuteDebut;
    }

    public function setHuisClos($aHuitClos) {
	$this->aHuisClos = $aHuitClos;
    }

    // ------------------------------------------------------------------------
    // Méthodes dérivées

    public function getDateSoutenance() {
	if ($this->identifiantDateSoutenance == 0)
	    return new DateSoutenance(0, 0, 0, 0, 0);
	else
	    return DateSoutenance::getDateSoutenance($this->identifiantDateSoutenance);
    }

    public function getSalle() {
	if ($this->identifiantSalle == 0)
	    return new Salle(0, 0);
	else
	    return Salle::getSalle($this->identifiantSalle);
    }

    // ------------------------------------------------------------------------
    // Méthodes statiques

    /**
     * Obtenir un objet Soutenance à partir de identifiant
     * @param integer $idSoutenance
     * @return Soutenance
     */
    public static function getSoutenance($idSoutenance) {
	$soutenanceBDD = Soutenance_BDD::getSoutenance($idSoutenance);
	return new Soutenance($soutenanceBDD["idsoutenance"],
			      $soutenanceBDD["iddatesoutenance"],
			      $soutenanceBDD["idsalle"],
			      $soutenanceBDD["heuredebut"],
			      $soutenanceBDD["mindebut"],
			      $soutenanceBDD["ahuitclos"]);
    }

    /**
     * Obtenir un objet Convention associée à la soutenance
     * @param integer $soutenance
     * @return Convention
     */
    public static function getConvention($soutenance) {
	$tab_donnees = Soutenance_BDD::getConvention($soutenance->getIdentifiantBDD());
	return new Convention($tab_donnees[0], $tab_donnees[1], $tab_donnees[2],
			      $tab_donnees[3], $tab_donnees[4], $tab_donnees[5],
			      $tab_donnees[6], $tab_donnees[7], $tab_donnees[8],
			      $tab_donnees[9]);
    }

    /**
     * Obtenir la liste des objets Soutenance pour une salle et pour une date
     * @param integer $salle
     * @param integer $date
     * @return array
     */
    public static function listerSoutenanceFromSalleAndDate($salle, $date) {
	$tabSString = Soutenance_BDD::listerSoutenanceFromSalleAndDate($salle->getIdentifiantBDD(), $date->getIdentifiantBDD());
	$tabS = array();

	for ($i = 0; $i < sizeof($tabSString); $i++)
	    array_push($tabS,
			new Soutenance($tabSString[$i][0],
				       $tabSString[$i][4],
				       $tabSString[$i][5],
				       $tabSString[$i][1],
				       $tabSString[$i][2],
				       $tabSString[$i][3]));

	return $tabS;
    }

    /**
     * Obtenir la liste des objets Soutenance pour une année donnée
     * @param integer $annee
     * @return array
     */
    public static function listerSoutenancesFromAnnee($annee) {
	$tabSString = Soutenance_BDD::listerSoutenanceFromAnnee($annee);
	$tabS = array();

	for ($i = 0; $i < sizeof($tabSString); $i++)
	    array_push($tabS,
			new Soutenance($tabSString[$i][0],
				       $tabSString[$i][4],
				       $tabSString[$i][5],
				       $tabSString[$i][1],
				       $tabSString[$i][2],
				       $tabSString[$i][3]));

	return $tabS;
    }

    /**
     * Comparer les heures de passage de deux soutenances
     * @param Soutenance $a
     * @param Soutenance $b
     * @return integer
     */
    public static function compareHeureSoutenance($a, $b) {
	if ($a->getHeureDebut() == $b->getHeureDebut() && $a->getMinuteDebut() == $b->getMinuteDebut())
	    return 0;
	if ($a->getHeureDebut() == $b->getHeureDebut())
	    return ($a->getMinuteDebut() > $b->getMinuteDebut()) ? +1 : -1;
	return ($a->getHeureDebut() > $b->getHeureDebut()) ? +1 : -1;
    }

}

?>