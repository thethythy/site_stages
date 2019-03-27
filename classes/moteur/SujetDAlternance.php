<?php

/**
* Classe SujetDAlternance : les sujets d'alternance proposés par les étudiants et à valider
*/

class SujetDAlternance {

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
  * Enregistrer un sujet d'alternance à partir d'un tableau d'attributs
  * @param array $tab_donnees
  */
  public static function saisirDonnees($tab_donnees) {
    $sda = new SujetDAlternance("", $tab_donnees[0], $tab_donnees[1],
    $tab_donnees[2], false, true);
    SujetDAlternance_BDD::sauvegarder($sda);
  }

  /**
  * Obtenir la liste des objets SujetDAlternance à traiter
  * @return array
  */
  public static function getSujetDAlternanceAValider() {
    $filtre = new FiltreNumeric("enattente", 1);
    $tabSdS = SujetDAlternance_BDD::getListeSujetDAlternance($filtre);

    $tabSujetDAlternance = array();
    for ($i = 0; $i < sizeof($tabSdS); $i++)
    array_push($tabSujetDAlternance,
    new SujetDAlternance($tabSdS[$i][0], $tabSdS[$i][1],
    $tabSdS[$i][2], $tabSdS[$i][3],
    $tabSdS[$i][4], $tabSdS[$i][5]));

    return $tabSujetDAlternance;
  }

  /**
  * Obtenir la liste des objets SujetDAlternance traités
  * @return array
  */
  public static function getSujetDAlternanceTraite() {
    $filtre = new FiltreNumeric("enattente", 0);
    $tabSdS = SujetDAlternance_BDD::getListeSujetDAlternance($filtre);

    $tabSujetDAlternance = array();
    for ($i = 0; $i < sizeof($tabSdS); $i++)
    array_push($tabSujetDAlternance,
    new SujetDAlternance($tabSdS[$i][0], $tabSdS[$i][1],
    $tabSdS[$i][2], $tabSdS[$i][3],
    $tabSdS[$i][4], $tabSdS[$i][5]));

    return $tabSujetDAlternance;
  }

  /**
  * Obtenir la liste des objets SujetDAlternance corresponds au filtre de sélection
  * @param Filtre $filtre
  * @return array
  */
  public static function getListeSujetDAlternance($filtre) {
    $tabSdS = SujetDAlternance_BDD::getListeSujetDAlternance($filtre);
    $tabSujetDAlternance = array();

    for ($i = 0; $i < sizeof($tabSdS); $i++)
    array_push($tabSujetDAlternance,
    new SujetDAlternance($tabSdS[$i][0], $tabSdS[$i][1],
    $tabSdS[$i][2], $tabSdS[$i][3],
    $tabSdS[$i][4], $tabSdS[$i][5]));

    return $tabSujetDAlternance;
  }

  /**
  * Obtenir un objet SujetDAlternance à partir d'un identifiant
  * @param integer $identifiant
  * @return SujetDAlternance
  */
  public static function getSujetDAlternance($identifiant) {
    $sda = SujetDAlternance_BDD::getSujetDAlternance($identifiant);
    return new SujetDAlternance($sda["idsujetdalternance"],
    $sda["idetudiant"],
    $sda["idpromotion"],
    $sda["description"],
    $sda["valide"],
    $sda["enattente"]);
  }

  /**
  * Supprimer un sujet d'alternance à partir de son identifiant
  * @param integer $idSujetDAlternance
  */
  public static function supprimeSujetDAlternance($idSujetDAlternance) {
    SujetDAlternance_BDD::delete($idSujetDAlternance);
  }

}

?>
