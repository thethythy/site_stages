<?php

/**
 * Classe Couleur : les couleurs utilisables associées
 * aux parrains, aux thèmes de stage et type d'entreprise
 */

class Couleur {

    var $identifiant_BDD; // Identifiant unique en base
    var $nom;  // Nom de la couleur
    var $code;  // Code héxadécimal de la couleur

    /**
     * Constructeur d'un nouvel objet Couleur
     * @param integer $identifiant_BDD
     * @param string $nom
     * @param string $code
     */
    public function __construct($identifiant_BDD, $nom, $code) {
	$this->identifiant_BDD = $identifiant_BDD;
	$this->nom = $nom;
	$this->code = $code;
    }

    // Accesseurs en lecture

    public function getIdentifiantBDD() {
	return $this->identifiant_BDD;
    }

    public function getNom() {
	return $this->nom;
    }

    public function getCode() {
	return $this->code;
    }

    // Accesseurs en écriture

    public function setNom($nom) {
	$this->nom = $nom;
    }

    public function setCode($code) {
	$this->code = $code;
    }

    // Méthodes statiques

    /**
     * Obtenir un objet Couleur à partir d'un identifiant
     * @param integer $idCouleur
     * @return Couleur
     */
    public static function getCouleur($idCouleur) {
	$couleurBDD = Couleur_BDD::getCouleur($idCouleur);
	return new Couleur($couleurBDD["idcouleur"],
			   $couleurBDD["nomcouleur"],
			   $couleurBDD["codehexa"]);
    }

    /**
     * Enregistrer une couleur à partir des attributs
     * @param tableau d'attributs $tab_donnees
     */
    public static function saisirDonneesCouleur($tab_donnees) {
	$couleur = new Couleur('', $tab_donnees[0], $tab_donnees[1]);
	Couleur_BDD::sauvegarder($couleur);
    }

    /**
     * Obtenir tous les objets Couleur
     * @return tableau d'objets
     */
    public static function listerCouleur() {
	$tabCouleur = array();
	$tabCouleurString = Couleur_BDD::listerCouleur();

	for ($i = 0; $i < sizeof($tabCouleurString); $i++)
	    array_push($tabCouleur, new Couleur($tabCouleurString[$i][0],
						$tabCouleurString[$i][1],
						$tabCouleurString[$i][2]));
	return $tabCouleur;
    }

    /**
     * Supprimer en base une couleur à partir de son identifiant
     * @param integer $identifiantcouleur
     */
    public static function deleteCouleur($identifiantcouleur) {
	Couleur_BDD::delete($identifiantcouleur);
    }

}

?>