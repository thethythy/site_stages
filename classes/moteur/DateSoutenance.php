<?php

class DateSoutenance {

    // Déclaration des attributs de la classe
    var $identifiantBDD;
    var $jour;
    var $mois;
    var $annee;
    var $convocation;

    // Constructeur de classe
    public function DateSoutenance($identifiantBDD, $jour, $mois, $annee, $convocation) {
	$this->identifiantBDD = $identifiantBDD;
	$this->jour = $jour;
	$this->mois = $mois;
	$this->annee = $annee;
	$this->convocation = $convocation;
    }

    // Accesseurs

    public function getIdentifiantBDD() {
	return $this->identifiantBDD;
    }

    public function getJour() {
	return $this->jour;
    }

    public function setJour($jour) {
	$this->jour = $jour;
    }

    public function getMois() {
	return $this->mois;
    }

    public function setMois($mois) {
	$this->mois = $mois;
    }

    public function getAnnee() {
	return $this->annee;
    }

    public function setAnnee($annee) {
	$this->annee = $annee;
    }

    public function getDateComplete() {
	return $this->annee . '-' . $this->mois . '-' . $this->jour;
    }

    public function getConvocation() {
	return $this->convocation;
    }

    public function setConvocation($convocation) {
	$this->convocation = $convocation;
    }

    /** Méthodes statiques **/

    public static function getDateSoutenance($idDateSoutenance) {
	$dateSoutenanceBDD = DateSoutenance_BDD::getDateSoutenance($idDateSoutenance);
	return new DateSoutenance($dateSoutenanceBDD["iddatesoutenance"],
				  $dateSoutenanceBDD["jour"],
				  $dateSoutenanceBDD["mois"],
				  $dateSoutenanceBDD["annee"],
				  $dateSoutenanceBDD["convocation"]);
    }

    public static function saisirDonneesDateSoutenance($tab_donnees) {
	$dateSoutenance = new DateSoutenance('', $tab_donnees[0],
						 $tab_donnees[1],
						 $tab_donnees[2],
						 $tab_donnees[3]);
	$id = DateSoutenance_BDD::sauvegarder($dateSoutenance);
	DateSoutenance_BDD::sauvegarderRelationPromo($id, $tab_donnees[4]);
    }

    public static function listerDateSoutenance($filtres = '') {
	$tabDateSoutenance = array();
	$tabDateSoutenanceString = DateSoutenance_BDD::listerDateSoutenance($filtres);

	for ($i = 0; $i < sizeof($tabDateSoutenanceString); $i++)
	    array_push($tabDateSoutenance,
		    new DateSoutenance($tabDateSoutenanceString[$i][0],
				       $tabDateSoutenanceString[$i][1],
				       $tabDateSoutenanceString[$i][2],
				       $tabDateSoutenanceString[$i][3],
				       $tabDateSoutenanceString[$i][4]));

	return $tabDateSoutenance;
    }

    public static function listerRelationPromoDate($idDateSoutenance) {
	$tabPromos = DateSoutenance_BDD::listerRelationPromoDate($idDateSoutenance);
	return $tabPromos;
    }

    public static function deleteDateSoutenance($identifiantDateSoutenance) {
	DateSoutenance_BDD::delete($identifiantDateSoutenance);
	DateSoutenance_BDD::deleteDatePromo($identifiantDateSoutenance);
    }

    public static function deleteDatePromo($identifiantDateSoutenance) {
	DateSoutenance_BDD::delete($identifiantDateSoutenance);
    }

}

?>