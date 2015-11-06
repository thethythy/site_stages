<?php

class offreDeStage {

    var $identifiantBDD;
    var $sujet;
    var $titre;
    var $listeEnvironnement;
    var $theme; // Tableau d'identifiants de Parcours
    var $listeProfilSouhaite; // Tableau d'identifiants de Filières
    var $dureeMin;
    var $dureeMax;
    var $indemnite;
    var $remarques;
    var $estVisible;
    var $competences;      //Tableau des compétences
    var $maitreDeStage;

    public function offreDeStage($identifiantBDD, $sujet, $titre, $listeEnvironnement, $theme, $listeProfilSouhaite, $dureeMin, $dureeMax, $indemnite, $remarques, $estVisible, $listeCompetences, $maitreDeStage) {
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

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function getSujet() {
	return $this->sujet;
    }

    public function setSujet($sujet) {
	$this->sujet = $sujet;
    }

    public function getTitre() {
	return $this->titre;
    }

    public function setTitre($titre) {
	$this->titre = $titre;
    }

    public function getListeEnvironnements() {
	return $this->listeEnvironnement;
    }

    public function setListeEnvironnements($listeEnvironnement) {
	$this->listeEnvironnement = $listeEnvironnement;
    }

    public function getThemes() {
	$tabTheme = array();

	for ($i = 0; $i < sizeof($this->theme); $i++) {
	    array_push($tabTheme, Parcours::getParcours($this->theme[$i]));
	}

	return $tabTheme;
    }

    public function setThemes($theme) {
	$this->theme = $theme;
    }

    public function getListeProfilSouhaite() {
	$tabProfil = array();

	for ($i = 0; $i < sizeof($this->listeProfilSouhaite); $i++) {
	    array_push($tabProfil, Filiere::getFiliere($this->listeProfilSouhaite[$i]));
	}

	return $tabProfil;
    }

    public function setListeProfilSouhaite($listeProfilSouhaite) {
	$this->listeProfilSouhaite = $listeProfilSouhaite;
    }

    public function getDureeMinimale() {
	return $this->dureeMin;
    }

    public function setDureeMinimale($dureeMin) {
	$this->dureeMin = $dureeMin;
    }

    public function getDureeMaximale() {
	return $this->dureeMax;
    }

    public function setDureeMaximale($dureeMax) {
	$this->dureeMax = $dureeMax;
    }

    public function getIndemnite() {
	return $this->indemnite;
    }

    public function setIndemnite($indemnite) {
	$this->indemnite = $indemnite;
    }

    public function getRemarques() {
	return $this->remarques;
    }

    public function setRemarques($remarques) {
	$this->remarques = $remarques;
    }

    public function estVisible() {
	return $this->estVisible;
    }

    public function setEstVisible($estVisible) {
	$this->estVisible = $estVisible;
    }

    public function getIdContact() {
	return $this->maitreDeStage;
    }

    public function getEntreprise() {
	$contact = Contact::getContact($this->maitreDeStage);
	return $contact->getEntreprise();
    }

    public function getContact() {
	return Contact::getContact($this->maitreDeStage);
    }

    public function getListesCompetences() {
	$tabCompetence = array();

	for ($i = 0; $i < sizeof($this->competences); $i++) {
	    array_push($tabCompetence, Competence::getCompetence($this->competences[$i]));
	}

	return $tabCompetence;
    }

    public static function saisirDonnees($tab_donnees) {
	$ods = new offreDeStage("", $tab_donnees[0], $tab_donnees[1], $tab_donnees[2], $tab_donnees[3], $tab_donnees[4], $tab_donnees[5], $tab_donnees[6], $tab_donnees[7], $tab_donnees[8], '0', $tab_donnees[9], $tab_donnees[10]);
	return offreDeStage_BDD::sauvegarder($ods);
    }

    public static function modifierDonnees($tab_donnees) {
	$ods = new offreDeStage($tab_donnees[0], $tab_donnees[1], $tab_donnees[2], $tab_donnees[3], $tab_donnees[4], $tab_donnees[5], $tab_donnees[6], $tab_donnees[7], $tab_donnees[8], $tab_donnees[9], $tab_donnees[10], $tab_donnees[11], $tab_donnees[12]);
	return offreDeStage_BDD::sauvegarder($ods);
    }

    public static function supprimerDonnees($identifiantBDD) {
	offreDeStage_BDD::delete($identifiantBDD);
    }

    public static function getOffreDeStage($identifiantBDD) {
	$offreDeStage = OffreDeStage_BDD::getOffreDeStage($identifiantBDD);

	return new OffreDeStage($offreDeStage[0], $offreDeStage[1], $offreDeStage[2], $offreDeStage[3], $offreDeStage[4], $offreDeStage[5], $offreDeStage[6], $offreDeStage[7], $offreDeStage[8], $offreDeStage[9], $offreDeStage[10], $offreDeStage[11], $offreDeStage[12]);
    }

    public static function getListeOffreDeStage($filtres) {
	$tabODSString = OffreDeStage_BDD::getListeOffreDeStage($filtres);

	$tabODS = array();
	for ($i = 0; $i < sizeof($tabODSString); $i++) {
	    array_push($tabODS, new OffreDeStage($tabODSString[$i][0], $tabODSString[$i][1], $tabODSString[$i][2], $tabODSString[$i][3], $tabODSString[$i][4], $tabODSString[$i][5], $tabODSString[$i][6], $tabODSString[$i][7], $tabODSString[$i][8], $tabODSString[$i][9], $tabODSString[$i][10], $tabODSString[$i][11], $tabODSString[$i][12]));
	}

	return $tabODS;
    }

}

?>