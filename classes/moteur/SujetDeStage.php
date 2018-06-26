<?php

/**
 * Classe SujetDeStage : les sujets de stage proposés par les étudiants et à valider
 */

class SujetDeStage {

    var $identifiantBDD;  // Identifiant unique en base
    var $description;  // Description du sujet
    var $valide;  // Statut valide ou invalide
    var $enAttenteDeValidation;  // Indicateur de traitement fait ou en attente
    var $identifiantEtudiant;  // Identifiant de l'étudiant
    var $identifiantPromotion;  // Identifiant de la promotion

    /**
     * Constructeur
     * @param integer $identifiantBDD
     * @param integer $identifiantEtudiant
     * @param integer $identifiantPromotion
     * @param string $description
     * @param boolean $valide
     * @param boolean $enAttenteDeValidation
     */
    public function __construct($identifiantBDD, $identifiantEtudiant,
	    $identifiantPromotion, $description, $valide, $enAttenteDeValidation) {
	$this->identifiantBDD = $identifiantBDD;
	$this->identifiantEtudiant = $identifiantEtudiant;
	$this->identifiantPromotion = $identifiantPromotion;
	$this->description = $description;
	$this->valide = $valide;
	$this->enAttenteDeValidation = $enAttenteDeValidation;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en lecture

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function getDescription() {
	return $this->description;
    }

    public function isEnAttenteDeValidation() {
	return $this->enAttenteDeValidation;
    }

    public function isValide() {
	$valid = 0;
	if ($this->valide == true) {
	    $valid = 1;
	}
	return $valid;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en écriture

    public function setDescription($description) {
	$this->description = $description;
    }

    public function setValide($valide) {
	$this->valide = $valide;
    }

    public function setEnAttenteDeValidation($enAttenteDeValidation) {
	$this->enAttenteDeValidation = $enAttenteDeValidation;
    }

    // ------------------------------------------------------------------------
    // Méthodes dérivées

    public function getEtudiant() {
	return Etudiant::getEtudiant($this->identifiantEtudiant);
    }

    public function getPromotion() {
	return Promotion::getPromotion($this->identifiantPromotion);
    }

    // ------------------------------------------------------------------------
    // Méthodes statiques

    /**
     * Enregistrer un sujet de stage à partir d'un tableau d'attributs
     * @param array $tab_donnees
     */
    public static function saisirDonnees($tab_donnees) {
	$sds = new SujetDeStage("", $tab_donnees[0], $tab_donnees[1],
				    $tab_donnees[2], false, true);
	SujetDeStage_BDD::sauvegarder($sds);
    }

    /**
     * Obtenir la liste des objets SujetDeStage à traiter
     * @return array
     */
    public static function getSujetDeStageAValider() {
	$filtre = new FiltreNumeric("enattente", 1);
	$tabSdS = SujetDeStage_BDD::getListeSujetDeStage($filtre);

	$tabSujetDeStage = array();
	for ($i = 0; $i < sizeof($tabSdS); $i++)
	    array_push($tabSujetDeStage,
		    new SujetDeStage($tabSdS[$i][0], $tabSdS[$i][1],
				     $tabSdS[$i][2], $tabSdS[$i][3],
				     $tabSdS[$i][4], $tabSdS[$i][5]));

	return $tabSujetDeStage;
    }

    /**
     * Obtenir la liste des objets SujetDeStage traités
     * @return array
     */
    public static function getSujetDeStageTraite() {
	$filtre = new FiltreNumeric("enattente", 0);
	$tabSdS = SujetDeStage_BDD::getListeSujetDeStage($filtre);

	$tabSujetDeStage = array();
	for ($i = 0; $i < sizeof($tabSdS); $i++)
	    array_push($tabSujetDeStage,
		    new SujetDeStage($tabSdS[$i][0], $tabSdS[$i][1],
				     $tabSdS[$i][2], $tabSdS[$i][3],
				     $tabSdS[$i][4], $tabSdS[$i][5]));

	return $tabSujetDeStage;
    }

    /**
     * Obtenir la liste des objets SujetDeStage corresponds au filtre de sélection
     * @param Filtre $filtre
     * @return array
     */
    public static function getListeSujetDeStage($filtre) {
	$tabSdS = SujetDeStage_BDD::getListeSujetDeStage($filtre);
	$tabSujetDeStage = array();

	for ($i = 0; $i < sizeof($tabSdS); $i++)
	    array_push($tabSujetDeStage,
		    new SujetDeStage($tabSdS[$i][0], $tabSdS[$i][1],
				     $tabSdS[$i][2], $tabSdS[$i][3],
				     $tabSdS[$i][4], $tabSdS[$i][5]));

	return $tabSujetDeStage;
    }

    /**
     * Obtenir un objet SujetDeStage à partir d'un identifiant
     * @param integer $identifiant
     * @return SujetDeStage
     */
    public static function getSujetDeStage($identifiant) {
	$sds = SujetDeStage_BDD::getSujetDeStage($identifiant);
	return new SujetDeStage($sds["idsujetdestage"],
				$sds["idetudiant"],
				$sds["idpromotion"],
				$sds["description"],
				$sds["valide"],
				$sds["enattente"]);
    }

    /**
     * Supprimer un sujet de stage à partir de son identifiant
     * @param integer $idSujetDeStage
     */
    public static function supprimeSujetDeStage($idSujetDeStage) {
	SujetDeStage_BDD::delete($idSujetDeStage);
    }

}

?>