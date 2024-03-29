<?php

/**
* Classe OffreDAlternance : les offres de alternance des entreprises
*/

class OffreDAlternance {

  var $identifiantBDD;  // Identifiant unique en base
  var $sujet;  // Texte descriptif de l'offre
  var $titre;  // Titre de l'offre
  var $theme;  // Tableau d'identifiants des parcours
  var $listeProfilSouhaite; // Tableau d'identifiants des filières
  var $duree;  // Durée minimale
  var $indemnite;  // Valeurde la gratification
  var $remarques;  // Remarques divers sur les conditsions du alternance
  var $estVisible;  // Indicateur de visibilite sur la vue des étudiants
  var $competences;  // Tableau des identifiants des compétences
  var $maitreDAlternance;  // Identifiant du contact
  var $typeContrat;
  var $promotions;  // Tableau des identifiants des promotions

  /**
  * Constructeur
  * @param integer $identifiantBDD
  * @param string $sujet
  * @param string $titre
  * @param array $theme
  * @param array $listeProfilSouhaite
  * @param integer $duree
  * @param double $indemnite
  * @param string $remarques
  * @param boolean $estVisible
  * @param array $listeCompetences
  * @param integer $maitreDAlternance
  * @param integer $typeContrat
  * @param array $promotions  
  */
  public function __construct($identifiantBDD, $sujet, $titre, $theme, $listeProfilSouhaite,
                              $duree, $indemnite, $remarques, $estVisible, $listeCompetences,
                              $maitreDAlternance, $typeContrat, $promotions=array()) {
    $this->identifiantBDD = $identifiantBDD;
    $this->sujet = $sujet;
    $this->titre = $titre;
    $this->theme = $theme;
    $this->listeProfilSouhaite = $listeProfilSouhaite;
    $this->duree = $duree;
    $this->indemnite = $indemnite;
    $this->remarques = $remarques;
    $this->estVisible = $estVisible;
    $this->competences = $listeCompetences;
    $this->maitreDAlternance = $maitreDAlternance;
    $this->typeContrat = $typeContrat;
    $this->promotions = $promotions;
  }

  // ------------------------------------------------------------------------
  // Accesseurs en lecture

  public function getIdentifiantBDD() {
    return $this->identifiantBDD;
  }

  public function getSujet() {
    return $this->sujet;
  }

  public function getTitre() {
    return $this->titre;
  }

  public function getDuree() {
    return $this->duree;
  }

  public function getIndemnite() {
    return $this->indemnite;
  }

  public function getRemarques() {
    return $this->remarques;
  }

  public function estVisible() {
    return $this->estVisible;
  }

  public function getIdContact() {
    return $this->maitreDAlternance;
  }

  public function getTypeContrat() {
    return $this->typeContrat;
  }

  public function getTypeContratStr(){
    if($this->typeContrat == 1){
      return("Apprentissage");
    }
    else if($this->typeContrat == 0){
      return("Professionnalisation");
    }else{
      return("N/A");
    }
  }

  // ------------------------------------------------------------------------
  // Accesseurs en écriture

  public function setSujet($sujet) {
    $this->sujet = $sujet;
  }

  public function setTitre($titre) {
    $this->titre = $titre;
  }

  public function setDureeMinimale($duree) {
    $this->dureeMin = $duree;
  }

  public function setIndemnite($indemnite) {
    $this->indemnite = $indemnite;
  }

  public function setRemarques($remarques) {
    $this->remarques = $remarques;
  }

  public function setEstVisible($estVisible) {
    $this->estVisible = $estVisible;
  }

  public function setTypeContrat($typeContrat) {
    $this->typeContrat = $typeContrat;
  }

  // ------------------------------------------------------------------------
  // Méthodes dérivées

  public function getContact() {
    return Contact::getContact($this->maitreDAlternance);
  }

  public function getEntreprise() {
    $contact = Contact::getContact($this->maitreDAlternance);
    return $contact->getEntreprise();
  }

  public function getListesCompetences() {
    $tabCompetence = array();

    for ($i = 0; $i < sizeof($this->competences); $i++) {
      array_push($tabCompetence, Competence::getCompetence($this->competences[$i]));
    }
    return $tabCompetence;
  }

  public function getThemes() {
    $tabTheme = array();

    for ($i = 0; $i < sizeof($this->theme); $i++) {
      array_push($tabTheme, Parcours::getParcours($this->theme[$i]));
    }

    return $tabTheme;
  }

  public function getListeProfilSouhaite() {
    $tabProfil = array();

    for ($i = 0; $i < sizeof($this->listeProfilSouhaite); $i++) {
        array_push($tabProfil, Filiere::getFiliere($this->listeProfilSouhaite[$i]));
    }

    return $tabProfil;
  }

  public function getPromotions() {
    $tabPromotions = array();

    foreach ($this->promotions as $value) {
	array_push($tabPromotions, Promotion::getPromotion($value));
    }

    return $tabPromotions;
}  

  // ------------------------------------------------------------------------
  // Méthodes statiques

  /**
  * Enregistrement d'une offre de alternance à partir d'un tableau d'attributs
  * @param array $tab_donnees
  * @return integer Identifiant en base
  */
  public static function saisirDonnees($tab_donnees) {
    $ods = new OffreDAlternance("", $tab_donnees[0], $tab_donnees[1], $tab_donnees[2],
                                $tab_donnees[3], $tab_donnees[4], $tab_donnees[5],
                                $tab_donnees[6], '0', $tab_donnees[7], $tab_donnees[8],
                                $tab_donnees[9]);
    return OffreDAlternance_BDD::sauvegarder($ods);
  }

  /**
  * Mettre à jour une offre de alternance à partir d'un tableau d'attributs
  * @param array $tab_donnees
  * @return integer Identifiant en base
  */
  public static function modifierDonnees($tab_donnees) {
    $ods = new OffreDAlternance($tab_donnees[0], $tab_donnees[1], $tab_donnees[2],
                                $tab_donnees[3], $tab_donnees[4], $tab_donnees[5],
                                $tab_donnees[6], $tab_donnees[7], $tab_donnees[8],
                                $tab_donnees[9], $tab_donnees[10], $tab_donnees[11],
                                $tab_donnees[12]);
    return OffreDAlternance_BDD::sauvegarder($ods);
  }

  /**
  * Supprimer en base une offre de alternance à partir de son identifiant
  * @param integer $identifiantBDD
  */
  public static function supprimerDonnees($identifiantBDD) {
    OffreDAlternance_BDD::delete($identifiantBDD);
  }

  /**
  * Obtenir un objet OffreDAlternance à partir de son identifiant
  * @param integer $identifiantBDD
  * @return OffreDAlternance
  */
  public static function getOffreDAlternance($identifiantBDD) {
    $offreDAlternance = OffreDAlternance_BDD::getOffreDAlternance($identifiantBDD);

    return new OffreDAlternance($offreDAlternance[0], $offreDAlternance[1],
                                $offreDAlternance[2], $offreDAlternance[3],
                                $offreDAlternance[4], $offreDAlternance[5],
                                $offreDAlternance[6], $offreDAlternance[7],
                                $offreDAlternance[8], $offreDAlternance[9],
                                $offreDAlternance[10], $offreDAlternance[11],
                                $offreDAlternance[12]);
  }

  /**
  * Obtenir une liste d'objets OffreDAlternance à partir d'un filtre
  * @param Filtre $filtre
  * @return array
  */
  public static function getListeOffreDAlternance($filtre) {
    $tabODSString = OffreDAlternance_BDD::getListeOffreDAlternance($filtre);

    $tabODS = array();
    for ($i = 0; $i < sizeof($tabODSString); $i++) {
      array_push($tabODS, new OffreDAlternance($tabODSString[$i][0], $tabODSString[$i][1],
                                                $tabODSString[$i][2], $tabODSString[$i][3],
                                                $tabODSString[$i][4], $tabODSString[$i][5],
                                                $tabODSString[$i][6], $tabODSString[$i][7],
                                                $tabODSString[$i][8], $tabODSString[$i][9],
                                                $tabODSString[$i][10], $tabODSString[$i][11],
                                                $tabODSString[$i][12]));
    }

    return $tabODS;
  }

  public static function supprimerSuivi($idOffre) {
    OffreDAlternance_BDD::supprimerSuivi($idOffre);
  }

}

?>
