<?php

/**
 * Classe DateSoutenance : les dates de soutenance
 */

class DateSoutenance {

    var $identifiantBDD; // Identifiant unique en base
    var $jour; // Le jour de la soutenance
    var $mois; // Le mois de la soutenance
    var $annee; // L'année de la soutenance
    var $convocation; // Flag de l'envoi des convocations

    /**
     * Création d'un objet DateSoutenance
     * @param integer $identifiantBDD
     * @param integer $jour
     * @param integer $mois
     * @param integer $annee
     * @param integer $convocation
     */
    public function __construct($identifiantBDD, $jour, $mois, $annee, $convocation) {
	$this->identifiantBDD = $identifiantBDD;
	$this->jour = $jour;
	$this->mois = $mois;
	$this->annee = $annee;
	$this->convocation = $convocation;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en lecture

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function getJour() {
	return $this->jour;
    }

    public function getMois() {
	return $this->mois;
    }

    public function getAnnee() {
	return $this->annee;
    }

    public function getConvocation() {
	return $this->convocation;
    }

    // ------------------------------------------------------------------------
    // Accesseurs en écriture

    public function setJour($jour) {
	$this->jour = $jour;
    }

    public function setMois($mois) {
	$this->mois = $mois;
    }

    public function setAnnee($annee) {
	$this->annee = $annee;
    }

    public function setConvocation($convocation) {
	$this->convocation = $convocation;
    }

    // ------------------------------------------------------------------------
    // Méthodes statiques

    /**
     * Rechercher un objet DateSoutenance à partir de son identifiant
     * @param type $idDateSoutenance
     * @return objet DateSoutenance
     */
    public static function getDateSoutenance($idDateSoutenance) {
	$dateSoutenanceBDD = DateSoutenance_BDD::getDateSoutenance($idDateSoutenance);
	return new DateSoutenance($dateSoutenanceBDD["iddatesoutenance"],
				  $dateSoutenanceBDD["jour"],
				  $dateSoutenanceBDD["mois"],
				  $dateSoutenanceBDD["annee"],
				  $dateSoutenanceBDD["convocation"]);
    }

    /**
     * Enregistrer un nouvel objet en base.
     * Mettre à jour la relation avec les promotions.
     * @param tableau de données $tab_donnees
     */
    public static function saisirDonneesDateSoutenance($tab_donnees) {
	$dateSoutenance = new DateSoutenance('', $tab_donnees[0],
						 $tab_donnees[1],
						 $tab_donnees[2],
						 $tab_donnees[3]);
	$id = DateSoutenance_BDD::sauvegarder($dateSoutenance);
	DateSoutenance_BDD::sauvegarderRelationPromo($id, $tab_donnees[4]);
    }

    /**
     * Rechercher la liste des objets DateSoutenance à partir d'un filtre
     * @param string $filtre
     * @param string $ordre L'ordre de classement des objets trouvés
     * @return tableau d'objets
     */
    public static function listerDateSoutenance($filtre = '', $ordre = 'ASC') {
	$tabDateSoutenance = array();
	$tabDateSoutenanceString = DateSoutenance_BDD::listerDateSoutenance($filtre, $ordre);

	for ($i = 0; $i < sizeof($tabDateSoutenanceString); $i++)
	    array_push($tabDateSoutenance,
		    new DateSoutenance($tabDateSoutenanceString[$i][0],
				       $tabDateSoutenanceString[$i][1],
				       $tabDateSoutenanceString[$i][2],
				       $tabDateSoutenanceString[$i][3],
				       $tabDateSoutenanceString[$i][4]));

	return $tabDateSoutenance;
    }

    /**
     * Rechercher les promotions associées à une date de soutenance
     * @param integer $idDateSoutenance
     * @return tableau des identifiants des promotions associées
     */
    public static function listerRelationPromoDate($idDateSoutenance) {
	$tabPromos = DateSoutenance_BDD::listerRelationPromoDate($idDateSoutenance);
	return $tabPromos;
    }

    /**
     * Supprimer un enregistrement en base à partir de son identifiant.
     *
     * La table relation_promotion_datesoutenance est mise à jour du fait
     * des contraintes d'intégrité relationnelles
     *
     * @param integer $identifiantDateSoutenance
     */
    public static function deleteDateSoutenance($identifiantDateSoutenance) {
	DateSoutenance_BDD::delete($identifiantDateSoutenance);
    }

}

?>