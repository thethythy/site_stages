<?php

/**
 * Classe d'objets Responsable (stage, alternance, site, etc.)
 */

class Responsable {

    var $identifiantBDD; // Identifiant unique en base
    var $responsabilite; // La responsabilité
    var $nomresponsable; // Nom du responsable
    var $prenomresponsable; // Prénom du responsable
    var $emailresponsable; // Adresse de courriel
    var $titreresponsable; // Titre du responsable

    /**
     * Constructeur d'un objet Responsable
     * @param integer $identifiantBDD
     * @param string $responsabilite
     * @param string $nom
     * @param string $prenom
     * @param string $email
     * @param string $titre
    */
    public function __construct($identifiantBDD, $responsabilite, $nom, $prenom, $email, $titre) {
	$this->identifiantBDD = $identifiantBDD;
	$this->responsabilite = $responsabilite;
	$this->nomresponsable = $nom;
	$this->prenomresponsable = $prenom;
	$this->emailresponsable = $email;
	$this->titreresponsable = $titre;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en lecture

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function getResponsabilite() {
	return $this->responsabilite;
    }

        public function getNomresponsable() {
	return $this->nomresponsable;
    }

    public function getPrenomresponsable() {
	return $this->prenomresponsable;
    }

    public function getEmailresponsable() {
	return $this->emailresponsable;
    }

    public function getTitreresponsable() {
	return $this->titreresponsable;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en écriture

    public function setResponsabilite($responsabilite) {
	$this->responsabilite = $responsabilite;
    }

    public function setNomresponsable($nomresponsable) {
	$this->nomresponsable = $nomresponsable;
    }

    public function setPrenomresponsable($prenomresponsable) {
	$this->prenomresponsable = $prenomresponsable;
    }

    public function setEmailresponsable($emailresponsable) {
	$this->emailresponsable = $emailresponsable;
    }

    public function setTitreresponsable($titreresponsable) {
	$this->titreresponsable = $titreresponsable;
    }

    // ------------------------------------------------------------------------
    // Méthodes statiques

    /**
     * Obtenir un objet Responsbale à partir d'un identifiant
     * @param integer $identifiant
     * @return Responsable
     */
    public static function getResponsable($identifiant) {
	$responsableBDD = Responsable_BDD::getResponsable($identifiant);
	return new Responsable($responsableBDD["idresponsable"],
			       $responsableBDD["responsabilite"],
			       $responsableBDD["nomresponsable"],
			       $responsableBDD["prenomresponsable"],
			       $responsableBDD["emailresponsable"],
			       $responsableBDD["titreresponsable"]);
    }

    /**
     * Obtenir un objet Responsable correspond au paramètre
     * @param string $responsabilite
     * @return objet ou FALSE
     */
    public static function getResponsableFromResponsabilite($responsabilite) {
	$responsableBDD = Responsable_BDD::getResponsableFromResponsabilite($responsabilite);
	if ($responsableBDD) {
	    return new Responsable($responsableBDD["idresponsable"],
				   $responsableBDD["responsabilite"],
				   $responsableBDD["nomresponsable"],
				   $responsableBDD["prenomresponsable"],
				   $responsableBDD["emailresponsable"],
				   $responsableBDD["titreresponsable"]);
	} else {
	    return FALSE;
	}
    }

    /**
     * Enregistrer un responsable à partir des attributs
     * @param tableau d'attributs $tab_donnees
     */
    public static function saisirDonneesResponsable($tab_donnees) {
	$resp = new Responsable('', $tab_donnees[0], $tab_donnees[1],
		                $tab_donnees[2], $tab_donnees[3],
				$tab_donnees[4]);
	Responsable_BDD::sauvegarder($resp);
    }

    /**
     * Obtenir tous les objets Responsable
     * @return tableau d'objets
     */
    public static function listerResponsable() {
	$tabResponsable = array();
	$tabResponsableString = Responsable_BDD::listerResponsable();

	for ($i = 0; $i < sizeof($tabResponsableString); $i++)
	    array_push($tabResponsable,
		    new Responsable($tabResponsableString[$i][0],
				    $tabResponsableString[$i][1],
				    $tabResponsableString[$i][2],
				    $tabResponsableString[$i][3],
				    $tabResponsableString[$i][4],
				    $tabResponsableString[$i][5]));

	return $tabResponsable;
    }

    /**
     * Supprimer en base un responsable à partir de son identifiant
     * @param integer $identifiant
     */
    public static function deleteResponsable($identifiant) {
	Responsable_BDD::delete($identifiant);
    }

}

?>