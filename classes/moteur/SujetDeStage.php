<?php

class SujetDeStage {

    // Déclaration des attributs de la classe
    var $identifiantBDD;
    var $identifiantEtudiant;
    var $identifiantPromotion;
    var $description;
    var $valide;
    var $enAttenteDeValidation;

    // Constructeur de classe
    public function SujetDeStage($identifiantBDD, $identifiantEtudiant,
	    $identifiantPromotion, $description, $valide, $enAttenteDeValidation) {
	$this->identifiantBDD = $identifiantBDD;
	$this->identifiantEtudiant = $identifiantEtudiant;
	$this->identifiantPromotion = $identifiantPromotion;
	$this->description = $description;
	$this->valide = $valide;
	$this->enAttenteDeValidation = $enAttenteDeValidation;
    }

    /** Méthodes diverses **/

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function getEtudiant() {
	return Etudiant::getEtudiant($this->identifiantEtudiant);
    }

    public function getPromotion() {
	return Promotion::getPromotion($this->identifiantPromotion);
    }

    public function getDescription() {
	return $this->description;
    }

    public function setDescription($description) {
	$this->description = $description;
    }

    public function isValide() {
	$valid = 0;
	if ($this->valide == true) {
	    $valid = 1;
	}
	return $valid;
    }

    public function setValide($valide) {
	$this->valide = $valide;
    }

    public function isEnAttenteDeValidation() {
	$attenteDeValidation = 0;
	if ($this->enAttenteDeValidation == true) {
	    $attenteDeValidation = 1;
	}
	return $attenteDeValidation;
    }

    public function setEnAttenteDeValidation($enAttenteDeValidation) {
	$this->enAttenteDeValidation = $enAttenteDeValidation;
    }

    /** Méthodes statiques * */

    public static function saisirDonnees($tab_donnees) {
	$sds = new SujetDeStage("", $tab_donnees[0], $tab_donnees[1],
				    $tab_donnees[2], false, true);
	SujetDeStage_BDD::sauvegarder($sds);
    }

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

    public static function getSujetDeStageValide() {
	$filtre = new FiltreNumeric("valide", 1);
	$tabSdS = SujetDeStage_BDD::getListeSujetDeStage($filtre);

	$tabSujetDeStage = array();
	for ($i = 0; $i < sizeof($tabSdS); $i++)
	    array_push($tabSujetDeStage,
		    new SujetDeStage($tabSdS[$i][0], $tabSdS[$i][1],
				     $tabSdS[$i][2], $tabSdS[$i][3],
				     $tabSdS[$i][4], $tabSdS[$i][5]));

	return $tabSujetDeStage;
    }

    public static function getListeSujetDeStage($filtres) {
	$tabSdS = SujetDeStage_BDD::getListeSujetDeStage($filtres);
	$tabSujetDeStage = array();

	for ($i = 0; $i < sizeof($tabSdS); $i++)
	    array_push($tabSujetDeStage,
		    new SujetDeStage($tabSdS[$i][0], $tabSdS[$i][1],
				     $tabSdS[$i][2], $tabSdS[$i][3],
				     $tabSdS[$i][4], $tabSdS[$i][5]));

	return $tabSujetDeStage;
    }

    public static function getSujetDeStage($identifiant) {
	$sds = SujetDeStage_BDD::getSujetDeStage($identifiant);
	return new SujetDeStage($sds["idsujetdestage"],
				$sds["idetudiant"],
				$sds["idpromotion"],
				$sds["description"],
				$sds["valide"],
				$sds["enattente"]);
    }

    public static function rechercheSujetDeStage($etudiant, $promotion) {
	return SujetDeStage::getSujetDeStage(
		SujetDeStage_BDD::rechercheSujetDeStage($etudiant->getIdentifiantBDD(),
							$promotion->getIdentifiantBDD()));
    }

    public static function supprimeSujetDeStage($idSujetDeStage) {
	SujetDeStage_BDD::delete($idSujetDeStage);
    }

}

?>