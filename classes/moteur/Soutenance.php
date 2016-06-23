<?php

class Soutenance {

    // Déclaration des attributs de la classe
    var $identifiantBDD;
    var $identifiantDateSoutenance;
    var $identifiantSalle;
    var $heureDebut;
    var $minuteDebut;
    var $aHuitClos;

    // Constructeur de classe
    public function Soutenance($identifiantBDD, $identifiantDateSoutenance,
	    $identifiantSalle, $heureDebut, $minuteDebut, $aHuitClos) {
	$this->identifiantBDD = $identifiantBDD;
	$this->identifiantDateSoutenance = $identifiantDateSoutenance;
	$this->identifiantSalle = $identifiantSalle;
	$this->heureDebut = $heureDebut;
	$this->minuteDebut = $minuteDebut;
	$this->aHuitClos = $aHuitClos;
    }

    // Méthodes diverses

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function setIdentifiantBDD($id) {
	$this->identifiantBDD = $id;
    }

    public function getDateSoutenance() {
	if ($this->identifiantDateSoutenance == 0)
	    return new DateSoutenance(0, 0, 0, 0);
	else
	    return DateSoutenance::getDateSoutenance($this->identifiantDateSoutenance);
    }

    public function getSalle() {
	if ($this->identifiantSalle == 0)
	    return new Salle(0, 0);
	else
	    return Salle::getSalle($this->identifiantSalle);
    }

    public function getHeureDebut() {
	return $this->heureDebut;
    }

    public function setHeureDebut($heureDebut) {
	$this->heureDebut = $heureDebut;
    }

    public function getMinuteDebut() {
	return $this->minuteDebut;
    }

    public function setMinuteDebut($minuteDebut) {
	$this->minuteDebut = $minuteDebut;
    }

    public function isAHuitClos() {
	return $this->aHuitClos;
    }

    public function setHuitClos($aHuitClos) {
	$this->aHuitClos = $aHuitClos;
    }

    // M�thodes statiques

    public static function getSoutenance($idSoutenance) {
	$soutenanceBDD = Soutenance_BDD::getSoutenance($idSoutenance);
	return new Soutenance($soutenanceBDD["idsoutenance"],
			      $soutenanceBDD["iddatesoutenance"],
			      $soutenanceBDD["idsalle"],
			      $soutenanceBDD["heuredebut"],
			      $soutenanceBDD["mindebut"],
			      $soutenanceBDD["ahuitclos"]);
    }

    public static function getConvention($soutenance) {
	$tab_donnees = Soutenance_BDD::getConvention($soutenance->getIdentifiantBDD());
	return new Convention($tab_donnees[0], $tab_donnees[1], $tab_donnees[2],
			      $tab_donnees[3], $tab_donnees[4], $tab_donnees[5],
			      $tab_donnees[6], $tab_donnees[7], $tab_donnees[8],
			      $tab_donnees[9]);
    }

    public static function listerSoutenanceFromSalleAndDate($salle, $date) {
	$tabSString = Soutenance_BDD::listerSoutenanceFromSalleAndDate($salle->getIdentifiantBDD(), $date->getIdentifiantBDD());
	$tabS = array();
	while ($soutenance = mysqli_fetch_row($tabSString))
	    array_push($tabS, new Soutenance($soutenance[0], $soutenance[4],
					     $soutenance[5], $soutenance[1],
					     $soutenance[2], $soutenance[3]));
	return $tabS;
    }

    public static function compareHeureSoutenance($a, $b) {
	if ($a->getHeureDebut() == $b->getHeureDebut() && $a->getMinuteDebut() == $b->getMinuteDebut())
	    return 0;

	if ($a->getHeureDebut() == $b->getHeureDebut())
	    return ($a->getMinuteDebut() > $b->getMinuteDebut()) ? +1 : -1;

	return ($a->getHeureDebut() > $b->getHeureDebut()) ? +1 : -1;
    }

    public static function listerSoutenancesFromAnnee($annee) {
	$tabSString = Soutenance_BDD::listerSoutenanceFromAnnee($annee);
	$tabS = array();
	while ($soutenance = mysqli_fetch_row($tabSString))
	    array_push($tabS,
		    new Soutenance($soutenance[0], $soutenance[4],
				   $soutenance[5], $soutenance[1],
				   $soutenance[2], $soutenance[3]));
	return $tabS;
    }

}

?>