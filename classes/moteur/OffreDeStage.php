<?php

/**
 * Classe OffreDeStage : les offres de stage des entreprises
 */

class OffreDeStage {

    var $identifiantBDD;  // Identifiant unique en base
    var $sujet;  // Texte descriptif de l'offre
    var $titre;  // Titre de l'offre
    var $listeEnvironnement;  // SE utilisés
    var $theme;  // Tableau d'identifiants des parcours
    var $listeProfilSouhaite; // Tableau d'identifiants des filières
    var $dureeMin;  // Durée minimale
    var $dureeMax;  // Durée maximale
    var $indemnite;  // Valeurde la gratification
    var $remarques;  // Remarques divers sur les conditsions du stage
    var $estVisible;  // Indicateur de visibilite sur la vue des étudiants
    var $competences;  // Tableau des identifiants des compétences
    var $maitreDeStage;  // Identifiant du contact

    /**
     * Constructeur
     * @param integer $identifiantBDD
     * @param string $sujet
     * @param string $titre
     * @param string $listeEnvironnement
     * @param array $theme
     * @param array $listeProfilSouhaite
     * @param integer $dureeMin
     * @param integer $dureeMax
     * @param double $indemnite
     * @param string $remarques
     * @param boolean $estVisible
     * @param array $listeCompetences
     * @param integer $maitreDeStage
     */
    public function __construct($identifiantBDD, $sujet, $titre, $listeEnvironnement,
	    $theme, $listeProfilSouhaite, $dureeMin, $dureeMax, $indemnite, $remarques,
	    $estVisible, $listeCompetences, $maitreDeStage) {
	$this->identifiantBDD = $identifiantBDD;
	$this->sujet = $sujet;
	$this->titre = $titre;
	$this->listeEnvironnement = $listeEnvironnement;
	$this->theme = $theme;
	$this->listeProfilSouhaite = $listeProfilSouhaite;
	$this->dureeMin = $dureeMin;
	$this->dureeMax = $dureeMax;
	$this->indemnite = $indemnite;
	$this->remarques = $remarques;
	$this->estVisible = $estVisible;
	$this->competences = $listeCompetences;
	$this->maitreDeStage = $maitreDeStage;
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

    public function getListeEnvironnements() {
	return $this->listeEnvironnement;
    }

    public function getDureeMinimale() {
	return $this->dureeMin;
    }

    public function getDureeMaximale() {
	return $this->dureeMax;
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
	return $this->maitreDeStage;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en écriture

    public function setSujet($sujet) {
	$this->sujet = $sujet;
    }

    public function setTitre($titre) {
	$this->titre = $titre;
    }

    public function setListeEnvironnements($listeEnvironnement) {
	$this->listeEnvironnement = $listeEnvironnement;
    }

    public function setDureeMinimale($dureeMin) {
	$this->dureeMin = $dureeMin;
    }

    public function setDureeMaximale($dureeMax) {
	$this->dureeMax = $dureeMax;
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

    // ------------------------------------------------------------------------
    // Méthodes dérivées

    public function getContact() {
	return Contact::getContact($this->maitreDeStage);
    }

    public function getEntreprise() {
	$contact = Contact::getContact($this->maitreDeStage);
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

    // ------------------------------------------------------------------------
    // Méthodes statiques

    /**
     * Enregistrement d'une offre de stage à partir d'un tableau d'attributs
     * @param array $tab_donnees
     * @return integer Identifiant en base
     */
    public static function saisirDonnees($tab_donnees) {
	$ods = new OffreDeStage("", $tab_donnees[0], $tab_donnees[1],
				    $tab_donnees[2], $tab_donnees[3],
				    $tab_donnees[4], $tab_donnees[5],
				    $tab_donnees[6], $tab_donnees[7],
				    $tab_donnees[8], '0',
				    $tab_donnees[9], $tab_donnees[10]);
	return OffreDeStage_BDD::sauvegarder($ods);
    }

    /**
     * Mettre à jour une offre de stage à partir d'un tableau d'attributs
     * @param array $tab_donnees
     * @return integer Identifiant en base
     */
    public static function modifierDonnees($tab_donnees) {
	$ods = new OffreDeStage($tab_donnees[0], $tab_donnees[1],
				$tab_donnees[2], $tab_donnees[3],
				$tab_donnees[4], $tab_donnees[5],
				$tab_donnees[6], $tab_donnees[7],
				$tab_donnees[8], $tab_donnees[9],
				$tab_donnees[10], $tab_donnees[11],
				$tab_donnees[12]);
	return OffreDeStage_BDD::sauvegarder($ods);
    }

    /**
     * Supprimer en base une offre de stage à partir de son identifiant
     * @param integer $identifiantBDD
     */
    public static function supprimerDonnees($identifiantBDD) {
	OffreDeStage_BDD::delete($identifiantBDD);
    }

    /**
     * Obtenir un objet OffreDeStage à partir de son identifiant
     * @param integer $identifiantBDD
     * @return OffreDeStage
     */
    public static function getOffreDeStage($identifiantBDD) {
	$offreDeStage = OffreDeStage_BDD::getOffreDeStage($identifiantBDD);

	return new OffreDeStage($offreDeStage[0], $offreDeStage[1],
				$offreDeStage[2], $offreDeStage[3],
				$offreDeStage[4], $offreDeStage[5],
				$offreDeStage[6], $offreDeStage[7],
				$offreDeStage[8], $offreDeStage[9],
				$offreDeStage[10], $offreDeStage[11],
				$offreDeStage[12]);
    }

    /**
     * Obtenir une liste d'objets OffreDeStage à partir d'un filtre
     * @param Filtre $filtre
     * @return array
     */
    public static function getListeOffreDeStage($filtre) {
	$tabODSString = OffreDeStage_BDD::getListeOffreDeStage($filtre);

	$tabODS = array();
	for ($i = 0; $i < sizeof($tabODSString); $i++) {
	    array_push($tabODS,
		    new OffreDeStage($tabODSString[$i][0], $tabODSString[$i][1],
				     $tabODSString[$i][2], $tabODSString[$i][3],
				     $tabODSString[$i][4], $tabODSString[$i][5],
				     $tabODSString[$i][6], $tabODSString[$i][7],
				     $tabODSString[$i][8], $tabODSString[$i][9],
				     $tabODSString[$i][10], $tabODSString[$i][11],
				     $tabODSString[$i][12]));
	}

	return $tabODS;
    }

}

?>
