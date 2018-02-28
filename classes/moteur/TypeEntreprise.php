<?php

/**
 * Classe TypeEntreprise : le type de l'entreprise (petite ESN, grande ESN, etc.)
 */

class TypeEntreprise {

    var $identifiantBDD;  // Identifiant unique en base
    var $type;  // Intitulé du type
    var $identifiant_couleur;  // Identifiant de la couleur associée

    /**
     * Constructeur
     * @param integer $identifiantBDD
     * @param string $type
     * @param integer $identifiant_couleur
     */
    public function __construct($identifiantBDD, $type, $identifiant_couleur) {
	$this->identifiantBDD = $identifiantBDD;
	$this->type = $type;
	$this->identifiant_couleur = $identifiant_couleur;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en lecture

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function getType() {
	return $this->type;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en écriture

    public function setType($type) {
	$this->type = $type;
    }

    public function setIdentifiant_couleur($identifiant_couleur) {
	$this->identifiant_couleur = $identifiant_couleur;
    }

    // ------------------------------------------------------------------------
    // Méthodes dérivées

    public function getCouleur() {
	return Couleur::getCouleur($this->identifiant_couleur);
    }

    // ------------------------------------------------------------------------
    // Méthodes statiques

    /**
     * Obtenir un objet TypeEntreprise à partir de son identifiant
     * @param integer $identifiant
     * @return TypeEntreprise
     */
    public static function getTypeEntreprise($identifiant) {
	$typeEntrepriseBDD = TypeEntreprise_BDD::getTypeEntreprise($identifiant);
	return new TypeEntreprise($typeEntrepriseBDD["idtypeentreprise"],
				  $typeEntrepriseBDD["type"],
				  $typeEntrepriseBDD["idcouleur"]);
    }

    /**
     * Obtenir un objet TypeEntreprise à partir de son nom
     * @param string $nom
     * @return TypeEntreprise
     */
    public static function getTypeEntrepriseFromNom($nom) {
	$typeEntrepriseBDD = TypeEntreprise_BDD::getTypeEntrepriseFromNom($nom);
	return new TypeEntreprise($typeEntrepriseBDD["idtypeentreprise"],
				  $typeEntrepriseBDD["type"],
				  $typeEntrepriseBDD["idcouleur"]);
    }

    /**
     * Obtenir tous les objets TypeEntreprise
     * @return array
     */
    public static function getListeTypeEntreprise() {
	$tabTypeEntreprise = array();
	$tabTypeEntrepriseString = TypeEntreprise_BDD::getListeTypeEntreprise();

	for ($i = 0; $i < sizeof($tabTypeEntrepriseString); $i++)
	    array_push($tabTypeEntreprise,
		    new TypeEntreprise($tabTypeEntrepriseString[$i][0],
				       $tabTypeEntrepriseString[$i][1],
				       $tabTypeEntrepriseString[$i][2]));

	return $tabTypeEntreprise;
    }

    /**
     * Enregistrer un type d'entreprise à partir d'un tableau d'attributs
     * @param type $tab_donnees
     */
    public static function saisirDonneesType($tab_donnees) {
	$type = new TypeEntreprise('', $tab_donnees[0], $tab_donnees[1]);
	TypeEntreprise_BDD::sauvegarder($type);
    }

    /**
     * Supprimer un type d'entreprise à partir de son identifiant
     * @param integer $identifiant
     */
    public static function supprimerTypeEntreprise($identifiant) {
	TypeEntreprise_BDD::supprimerTypeEntreprise($identifiant);
    }

}

?>