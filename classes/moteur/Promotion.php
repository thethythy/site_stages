<?php

/**
 * Classe Promotion : les promotions d'étudiants
 */

class Promotion {

    var $identifiant_BDD;  // Identifiant unique en base
    var $anneeUniversitaire;  // L'année de rentrée de la promotion
    var $idParcours;  // Le parcours de la promotion
    var $idFiliere;  // La filière de la promotion
    var $email_promotion;  // L'adresse couriel de diffustion

    /**
     * Constructeur
     * @param integer $identifiant_BDD
     * @param integer $anneeUniversitaire
     * @param integer $idParcours
     * @param integer $idFiliere
     * @param string $emailPromotion
     */
    public function __construct($identifiant_BDD, $anneeUniversitaire,
	    $idParcours, $idFiliere, $emailPromotion) {
	$this->identifiant_BDD = $identifiant_BDD;
	$this->anneeUniversitaire = $anneeUniversitaire;
	$this->idParcours = $idParcours;
	$this->idFiliere = $idFiliere;
	$this->email_promotion = $emailPromotion;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en lecture

    public function getIdentifiantBDD() {
	return $this->identifiant_BDD;
    }

    public function getAnneeUniversitaire() {
	return $this->anneeUniversitaire;
    }

    public function getParcours() {
	return Parcours::getParcours($this->idParcours);
    }

    public function getFiliere() {
	return Filiere::getFiliere($this->idFiliere);
    }

    public function getEmailPromotion() {
	return $this->email_promotion;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en lecture

    public function setAnneeUniversitaire($anneeUniversitaire) {
	$this->anneeUniversitaire = $anneeUniversitaire;
    }

    public function setIdParcours($idParcours) {
	$this->idParcours = $idParcours;
    }

    public function setIdFiliere($idFiliere) {
	$this->idFiliere = $idFiliere;
    }

    public function setEmailPromotion($emailPromotion) {
	$this->email_promotion = $emailPromotion;
    }

    // ------------------------------------------------------------------------
    // Méthodes statiques

    /**
     * Supprimer une promotion à partir de son identifiant
     * @param integer $idPromotion
     */
    public static function supprimerPromotion($idPromotion) {
	Promotion_BDD::supprimerPromotion($idPromotion);
    }

    /**
     * Obtenir un objet Promotion à partir de son identifiant
     * @param integer $idPromotion
     * @return Promotion
     */
    public static function getPromotion($idPromotion) {
	$tab_donnees = Promotion_BDD::getPromotion($idPromotion);
	return new Promotion($tab_donnees["idpromotion"],
			     $tab_donnees["anneeuniversitaire"],
			     $tab_donnees["idparcours"],
			     $tab_donnees["idfiliere"],
			     $tab_donnees["email_promotion"]);
    }

    /**
     * Obtenir un objet Promotion à partir de l'année, de la filière et du parcours
     * @param type $annee
     * @param type $idfiliere
     * @param type $idparcours
     * @return \Promotion
     */
    public static function getPromotionFromParcoursAndFiliere($annee, $idfiliere, $idparcours) {
	$tab_donnees = Promotion_BDD::getPromotionFromParcoursAndFiliere($annee, $idfiliere, $idparcours);
	return new Promotion($tab_donnees["idpromotion"],
			     $tab_donnees["anneeuniversitaire"],
			     $tab_donnees["idparcours"],
			     $tab_donnees["idfiliere"],
			     $tab_donnees["email_promotion"]);
    }

    /**
     * Obtenir une liste de promotions selon un filtre de sélection
     * @param Filtre $filtre
     * @return array
     */
    public static function listerPromotions($filtre) {
	// Récupération des promotions correspondantes au filtre
	$tabDonneesPromos = Promotion_BDD::getListePromotions($filtre);

	$tabP = array();
	for ($i = 0; $i < sizeof($tabDonneesPromos); $i++)
	    array_push($tabP,
		    new Promotion($tabDonneesPromos[$i][0],
				  $tabDonneesPromos[$i][1],
				  $tabDonneesPromos[$i][2],
				  $tabDonneesPromos[$i][3],
				  $tabDonneesPromos[$i][4]));

	return $tabP;
    }

    /**
     * Obtenir une liste d'étudiants selon un filtre de sélection des promotions
     * @param Filtre $filtre
     * @return array
     */
    public static function listerEtudiants($filtre) {
	// Récupération des promotions correspondantes au filtre
	$tabPromos = Promotion_BDD::getListePromotions($filtre);

	$tabEtudiants = array();
	for ($i = 0; $i < sizeof($tabPromos); $i++) {
	    // Récupération des Etudiants appartenants à la Promotion
	    $tabTemp = Etudiant::getListeEtudiants($tabPromos[$i][0]);

	    for ($j = 0; $j < sizeof($tabTemp); $j++)
		array_push($tabEtudiants, $tabTemp[$j]);
	}

	return $tabEtudiants;
    }

}

?>