<?php

/**
 * Les compétences nécessaires pour les offres de stage
 */

class Competence {

    var $identifiantBDD; // Identifiant en base
    var $nom; // Le nom de la compétence affichable

    /**
     * Initialisation d'un nouvel objet Competence
     * @param integer $identifiant
     * @param string $name
     */
    public function Competence($identifiant, $name) {
	$this->nom = $name;
	$this->identifiantBDD = $identifiant;
    }

    // Accesseurs

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function getNom() {
	return $this->nom;
    }

    public function setNom($name) {
	$this->nom = $name;
    }

    // Méthodes statiques

    /**
     * Obtenir un objet Competence à partir d'un identifiant
     * @param integer $identifiantCompetence
     * @return Competence ou NULL
     */
    public static function getCompetence($identifiantCompetence) {
	$competenceString = Competence_BDD::getCompetence($identifiantCompetence);

	if ($competenceString != NULL)
	    return new Competence($competenceString['idcompetence'],
				  $competenceString['nomcompetence']);
	else
	    return NULL;
    }

    /**
     * Obtenir une liste d'objets Competence
     * @return tableau d'objets
     */
    public static function listerCompetences() {
	$tabCompetences = array();
	$tabCompetenceString = Competence_BDD::listerCompetences();

	for ($i = 0; $i < sizeof($tabCompetenceString); $i++)
	    array_push($tabCompetences,
		    new Competence($tabCompetenceString[$i][0],
				   $tabCompetenceString[$i][1]));

	return $tabCompetences;
    }

    /**
     * Enregistrer en base une nouvelle compétence à partir d'informations
     * @param tableau de valeurs d'attributs $tabDonnees
     */
    public static function saisirDonneesCompetences($tabDonnees) {
	$competence = new Competence("", $tabDonnees[0]);
	Competence_BDD::sauvegarder($competence);
    }

    /**
     * Supprimer une compétence en base à partir de son identifiant
     * @param integer $identifiant
     */
    public static function deleteCompetence($identifiant) {
	Competence_BDD::delete($identifiant);
    }

}

?>