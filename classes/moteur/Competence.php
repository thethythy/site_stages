<?php

class Competence {

    var $identifiantBDD;
    var $nom;

    public function Competence($identifiant, $name) {
	$this->nom = $name;
	$this->identifiantBDD = $identifiant;
    }

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function getNom() {
	return $this->nom;
    }

    public function setNom($name) {
	$this->nom = $name;
    }

    public static function getCompetence($identifiantCompetence) {
	$competenceString = Competence_BDD::getCompetence($identifiantCompetence);

	$competence = new Competence($competenceString['idcompetence'],
				     $competenceString['nomcompetence']);

	return $competence;
    }

    public static function listerCompetences() {
	$tabCompetences = array();
	$tabCompetenceString = Competence_BDD::listerCompetences();

	for ($i = 0; $i < sizeof($tabCompetenceString); $i++)
	    array_push($tabCompetences,
		    new Competence($tabCompetenceString[$i][0],
				   $tabCompetenceString[$i][1]));

	return $tabCompetences;
    }

    public static function saisirDonneesCompetences($tabDonnees) {
	$competence = new Competence("", $tabDonnees[0]);
	Competence_BDD::sauvegarder($competence);
    }

    public static function deleteCompetence($identifiant) {
	Competence_BDD::delete($identifiant);
    }

}

?>