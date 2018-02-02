<?php

/**
 * Classe Tache : les tâches d'administration
 */

class Tache {

    var $identifiant_BDD;  // Identifiant unique en base
    var $intitule;  // Intitulé de la tâche
    var $statut;  // Statut de la tâche (pas faite ; en cpours ; faite)
    var $priorite;  // Niveau de priorité de la tâche
    var $datelimite;  // Date limite pour effectuer la tâche

    /**
     * Constructeur
     * @param integer $identifiant_BDD
     * @param string $intitule
     * @param string $statut
     * @param integer $priorite
     * @param unix time $datelimite
     */
    public function Tache($identifiant_BDD, $intitule, $statut, $priorite, $datelimite) {
	$this->identifiant_BDD = $identifiant_BDD;
	$this->intitule = $intitule;
	$this->statut = $statut;
	$this->priorite = $priorite;
	$this->datelimite = $datelimite;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en lecture

    public function getIdentifiantBDD() {
	return $this->identifiant_BDD;
    }

    public function getIntitule() {
	return $this->intitule;
    }

    public function getStatut() {
	return $this->statut;
    }

    public function getPriorite() {
	return $this->priorite;
    }

    public function getDateLimite() {
	return $this->datelimite;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en écriture

    public function setIntitule($intitule) {
	$this->intitule = $intitule;
    }

    public function setStatut($statut) {
	$this->statut = $statut;
    }

    public function setPriorite($priorite) {
	$this->priorite = $priorite;
    }

    public function setDateLimite($dateLimite) {
	$this->datelimite = $dateLimite;
    }

    // ------------------------------------------------------------------------
    // Méthodes statiques

    /**
     * Obtenir un objet Tache à partir de son identifiant
     * @param integer $idTache
     * @return Tache
     */
    public static function getTache($idTache) {
	$tacheBDD = Tache_BDD::getTache($idTache);
	return new Tache($tacheBDD["idtache"],
			 $tacheBDD["intitule"],
			 $tacheBDD["statut"],
			 $tacheBDD["priorite"],
			 $tacheBDD["datelimite"]);
    }

    /**
     * Enregistrer une tâche à partir d'un tableau d'attributs
     * @param array $tab_donnees
     */
    public static function saisirDonneesTache($tab_donnees) {
	$tache = new Tache('', $tab_donnees[0], $tab_donnees[1],
			       $tab_donnees[2], $tab_donnees[3]);
	Tache_BDD::save($tache);
    }

    /**
     * Obtenir la liste complète des tâches
     * @return array
     */
    public static function listerTaches() {
	$tabOTache = array();

	foreach (Tache_BDD::getTaches() as $sTache)
	    array_push($tabOTache, new Tache($sTache[0], $sTache[1],
					     $sTache[2], $sTache[3],
					     $sTache[4]));

	return $tabOTache;
    }

    /**
     * Enregistrer un objet Tache
     * @param Tache $oTache
     */
    public static function saveTache($oTache) {
	Tache_BDD::save($oTache);
    }

    /**
     * Suppression d'une tâche à partir de son identifiant
     * @param integer $identifiant
     */
    public static function deleteTache($identifiant) {
	Tache_BDD::delete($identifiant);
    }

}

?>