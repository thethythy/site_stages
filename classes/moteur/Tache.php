<?php

class Tache {

    var $identifiant_BDD;
    var $intitule;
    var $statut;
    var $priorite;
    var $datelimite;

    public function Tache($identifiant_BDD, $intitule, $statut, $priorite, $datelimite) {
	$this->identifiant_BDD = $identifiant_BDD;
	$this->intitule = $intitule;
	$this->statut = $statut;
	$this->priorite = $priorite;
	$this->datelimite = $datelimite;
    }

    public function getIdentifiantBDD() {
	return $this->identifiant_BDD;
    }

    public function getIntitule() {
	return $this->intitule;
    }

    public function setIntitule($intitule) {
	$this->intitule = $intitule;
    }

    public function getStatut() {
	return $this->statut;
    }

    public function setStatut($statut) {
	$this->statut = $statut;
    }

    public function getPriorite() {
	return $this->priorite;
    }

    public function setPriorite($priorite) {
	$this->priorite = $priorite;
    }

    public function getDateLimite() {
	return $this->datelimite;
    }

    public function setDateLimite($dateLimite) {
	$this->datelimite = $dateLimite;
    }

    /** Méthodes statiques **/
    public static function getTache($idTache) {
	$tacheBDD = Tache_BDD::getTache($idTache);
	return new Tache($tacheBDD["idtache"],
			 $tacheBDD["intitule"],
			 $tacheBDD["statut"],
			 $tacheBDD["priorite"],
			 $tacheBDD["datelimite"]);
    }

    public static function saisirDonneesTache($tab_donnees) {
	$tache = new Tache('', $tab_donnees[0], $tab_donnees[1],
			       $tab_donnees[2], $tab_donnees[3]);
	Tache_BDD::save($tache);
    }

    public static function listerTaches() {
	$tabOTache = array();

	foreach (Tache_BDD::getTaches() as $sTache)
	    array_push($tabOTache, new Tache($sTache[0], $sTache[1],
					     $sTache[2], $sTache[3],
					     $sTache[4]));

	return $tabOTache;
    }

    public static function saveTache($oTache) {
	Tache_BDD::save($oTache);
    }

    public static function deleteTache($identifiant) {
	Tache_BDD::delete($identifiant);
    }

}

?>