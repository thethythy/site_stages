<?php

/**
 * Classe Candidature : les candidatures sur une offre d'alternance
 */
class Candidature {

    var $identifiantBDD;  // Identifiant unique en base
    var $etudiant;  // L'id de l'étudiant
    var $offre;  // L'id de l'offre
    var $entreprise;  // L'id de l'entreprise
    var $statut;  // Le statut de la candidature

    /**
     * Constructeur de classe
     * @param integer $identifiantBDD
     * @param integer $etudiant
     * @param integer $offre
     * @param integer $entreprise
     * @param string $statut
     */

    public function __construct($identifiantBDD, $etudiant, $offre, $entreprise, $statut) {
	$this->identifiantBDD = $identifiantBDD;
	$this->etudiant = $etudiant;
	$this->offre = $offre;
	$this->entreprise = $entreprise;
	$this->statut = $statut;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en lecture

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function getEtudiant() {
	return $this->etudiant;
    }

    public function getOffre() {
	return $this->offre;
    }

    public function getEntreprise() {
	return $this->entreprise;
    }

    public function getStatut() {
	return $this->statut;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en écriture

    public function setEtudiant($etudiant) {
	$this->etudiant = $etudiant;
    }

    public function setOffre($offre) {
	$this->offre = $offre;
    }

    public function setEntreprise($entreprise) {
	$this->entreprise = $entreprise;
    }

    public function setStatut($statut) {
	$this->statut = $statut;
    }

    // ------------------------------------------------------------------------
    // Méthodes statiques

    /*
     * Enregistrement d'une candidature à partir d'un tableau d'attributs
     */
    public static function saisirDonnees($tabDonnees) {
	$cndtr = new Candidature(
		"", // AUTO INCREMENT ID CANDIDATURE
		$tabDonnees[0], //etudiant
		$tabDonnees[1], //offre
		$tabDonnees[2], //entreprise
		$tabDonnees[3]  // statut
	);
	return Candidature_BDD::sauvegarder($cndtr);
    }

    /*
     * Enregistrement d'une candidature à partir d'un tableau d'attributs
     */

    public static function modifierDonnees($tabDonnees) {
	$cndtr = new Candidature(
		$tabDonnees[0], $tabDonnees[1], //etudiant
		$tabDonnees[2], //offre
		$tabDonnees[3], //entreprise
		$tabDonnees[4] // statut
	);
	return Candidature_BDD::sauvegarder($cndtr);
    }

    /*
     * Obtenir une candidature à partir d'un étudiant, d'une offre et d'une entreprise
     */

    public static function getCandidature($etudiant, $offre, $entreprise) {
	$cndtr = Candidature_BDD::getCandidature($etudiant, $offre, $entreprise);
	if (!$cndtr)
	    return false;
	return new Candidature(
		$cndtr["idcandidature"], $cndtr["idetudiant"], $cndtr["idoffre"], $cndtr["identreprise"], $cndtr["statut"]
	);
    }

    /**
     * Obtenir les candidatures pour un étudiant donné
     * @param integer $idetudiant
     * @return boolean ou tableau de candidatures
     */
    public static function getListeCandidatures($idetudiant) {
	$cndtrs = Candidature_BDD::getListeCandidatures($idetudiant);
	if (!$cndtrs)
	    return false;
	return $cndtrs;
    }

    /**
     * Obtenir la liste des candidatures de tous les étudiants d'un tableau d'étudiants
     * @param tableau d'objets étudiant
     */
    public static function getCandidaturesEtudiant($tabE) {
	$candidatures = array();
	foreach ($tabE as $etu) {
	    $cndtrs = Candidature::getListeCandidatures($etu->getIdentifiantBDD());
	    if (is_array($cndtrs)) {
		foreach ($cndtrs as $cndtr) {
		    array_push($candidatures, $cndtr);
		}
	    }
	}
	if (!$candidatures)
	    return false;
	return $candidatures;
    }

}

?>
