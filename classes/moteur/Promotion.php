<?php
class Promotion {
	var $identifiant_BDD;
	var $anneeUniversitaire;
	var $idParcours;
	var $idFiliere;
	var $email_promotion;
	
	public function Promotion($identifiant_BDD,$anneeUniversitaire,$idParcours,$idFiliere, $emailPromotion){
		$this->identifiant_BDD = $identifiant_BDD;
		$this->anneeUniversitaire = $anneeUniversitaire;
		$this->idParcours = $idParcours;
		$this->idFiliere = $idFiliere;
		$this->email_promotion = $emailPromotion;
	}
	
	public function setAnneeUniversitaire($anneeUniversitaire) {
		$this->anneeUniversitaire = $anneeUniversitaire;
	}

	public function setIdParcours($idParcours) {
		$this->idParcours = $idParcours;
	}
	
	public function setIdFiliere($idFiliere) {
		$this->idFiliere = $idFiliere;
	}
	
	public function getAnneeUniversitaire() {
		return $this->anneeUniversitaire;
	}
	
	public function getEmailPromotion(){
		return $this->email_promotion;
	}
	
	public function setEmailPromotion($emailPromotion){
		$this->email_promotion = $emailPromotion;
	}
	
	public function getParcours() {
		return Parcours::getParcours($this->idParcours);
	}
	
	public function getFiliere() {
		return Filiere::getFiliere($this->idFiliere);
	}
	
	public function getIdentifiantBDD() {
		return $this->identifiant_BDD;
	}
	
	/** Fonctions statiques **/	
	public static function supprimerPromotion($idPromotion){
		Promotion_BDD::supprimerPromotion($idPromotion);
	}
	
	public static function getPromotion($idPromotion){
		$tab_donnees = Promotion_BDD::getPromotion($idPromotion);
		return new Promotion($tab_donnees["idpromotion"],$tab_donnees["anneeuniversitaire"],$tab_donnees["idparcours"],$tab_donnees["idfiliere"],$tab_donnees["email_promotion"]);
	}
	
	public static function getPromotionFromParcoursAndFiliere($annee, $idfiliere, $idparcours) {
		$tab_donnees = Promotion_BDD::getPromotionFromParcoursAndFiliere($annee, $idfiliere, $idparcours);
		return new Promotion($tab_donnees["idpromotion"],$tab_donnees["anneeuniversitaire"],$tab_donnees["idparcours"],$tab_donnees["idfiliere"],$tab_donnees["email_promotion"]);
	}
	
	public static function listerPromotions($filtre) {
		// Récupération des Promotions correspondant au filtre
		$tabDonneesPromos = Promotion_BDD::getListePromotions($filtre);
		
		$tabP = array();
		for ($i=0; $i<sizeof($tabDonneesPromos); $i++)
			array_push($tabP, new Promotion($tabDonneesPromos[$i][0], $tabDonneesPromos[$i][1], $tabDonneesPromos[$i][2], $tabDonneesPromos[$i][3], $tabDonneesPromos[$i][4]));
		
		return $tabP;
	}
	
	public static function listerEtudiants($filtre){
		// Récupération des Promotions correspondant au filtre
		$tabPromos = Promotion_BDD::getListePromotions($filtre);
		
		$tabEtudiants = array();
		for($i=0; $i<sizeof($tabPromos); $i++){
			// Récupération des Etudiants appartenant à la Promotion
			$tabTemp = Etudiant::getListeEtudiants($tabPromos[$i][0]);
			
			for($j=0; $j<sizeof($tabTemp); $j++)
				array_push($tabEtudiants, $tabTemp[$j]);
		}
		
		return $tabEtudiants;
	}
}
?>