<?php
class Promotion_BDD {

	/**Méthodes statiques**/

	/**
	 * Sauvegarde d'une promotion
	 * @param $promotion promotion à sauvegarder
	 */
	public static function sauvegarder($promotion){
		global $tab15;
		global $db;

		$parcours = $promotion->getParcours();
		$idParcours = $parcours->getIdentifiantBDD();

		$filiere = $promotion->getFiliere();
		$idFiliere = $filiere->getIdentifiantBDD();

		if($promotion->getIdentifiantBDD()==""){
			$sql = "INSERT INTO ".$tab15."(anneeuniversitaire, idparcours, idfiliere, email_promotion) VALUES (
							'".$promotion->getAnneeUniversitaire()."',
							'".$idParcours."',
							'".$idFiliere."',
							'".$promotion->getEmailPromotion()."');";

			//echo $sql."<br/>";

			$db->query($sql);

			$sql2 = "SELECT LAST_INSERT_ID() AS ID FROM $tab15";
			$req = $db->query($sql2);
			$result = mysqli_fetch_array($req);
			return $result['ID'];
		}else {
			$sql = "UPDATE $tab15 SET
						anneeuniversitaire='".$promotion->getAnneeUniversitaire()."',
						idparcours='".$idParcours."',
						idfiliere='".$idFiliere."',
						email_promotion='".$promotion->getEmailPromotion()."'
						WHERE idpromotion ='".$promotion->getIdentifiantBDD()."'";

			$db->query($sql);
			return $promotion->getIdentifiantBDD();
		}
	}

	/**
	 * Récupère une promotion suivant son identifiant
	 * @param $identifiantBDD l'identifiant de l'entreprise à récupérer
	 * @return String[] tableau contenant les informations d'une entreprise
	 */
	public static function getPromotion($identifiantBDD){
		global $tab15;
		global $db;

		$result=array();
		$sql = "SELECT * FROM $tab15 WHERE idpromotion='$identifiantBDD'";
		//echo $sql."<br/>";
		$req = $db->query($sql);
		return mysqli_fetch_array($req);
	}

	public static function getPromotionFromParcoursAndFiliere($annee, $idfiliere, $idparcours) {
		global $tab15;
		global $db;

		$result = array();
		$sql = "SELECT * FROM $tab15 WHERE anneeuniversitaire='$annee' AND idparcours='$idparcours' AND idfiliere='$idfiliere'";
		//echo $sql."<br/>";
		$req = $db->query($sql);
		return mysqli_fetch_array($req);
	}

	public static function getAnneesUniversitaires(){
		global $tab15;
		global $db;

		$sql = "SELECT DISTINCT anneeuniversitaire FROM $tab15 ORDER BY anneeuniversitaire DESC";
		$req = $db->query($sql);

		$tabAU = array();

		while ($au = mysqli_fetch_array($req))
  			array_push($tabAU, $au[0]);

  		return $tabAU;
	}

	public static function getListePromotions($filtres){
		global $tab15;
		global $db;

		if($filtres == "")
			$requete = "SELECT * FROM $tab15";
		else
			$requete = "SELECT * FROM $tab15 WHERE ".$filtres->getStrFiltres();

		// echo "REQUETE : $requete<br/>";
		$res = $db->query($requete);

		$tabPromos = array();
		while ($p = mysqli_fetch_array($res)){
			$tab = array();
			array_push($tab, $p["idpromotion"]);
			array_push($tab, $p["anneeuniversitaire"]);
			array_push($tab, $p["idparcours"]);
			array_push($tab, $p["idfiliere"]);
			array_push($tab, $p["email_promotion"]);
			array_push($tabPromos, $tab);
		}

		return $tabPromos;
	}

	public static function getLastAnnee(){
		global $tab15;
		global $db;

		$sql = "SELECT MAX(anneeuniversitaire) as maxAU FROM $tab15";
		$req = $db->query($sql);
		$result = mysqli_fetch_array($req);
		return $result['maxAU'];
	}

	public static function supprimerPromotion($identifiantBDD){
		global $tab15;
		global $db;

		$sql = "DELETE FROM $tab15 WHERE idpromotion='$identifiantBDD'";
		//echo $sql."<br/>";
		$db->query($sql);
	}

	public static function existe($promo){
		global $tab15;
		global $db;

		$filiere = $promo->getFiliere();
		$parcours = $promo->getParcours();

		$sql = "SELECT idpromotion FROM $tab15
			WHERE anneeuniversitaire='".$promo->getAnneeUniversitaire()."'
			AND idfiliere='".$filiere->getIdentifiantBDD()."'
			AND idparcours='".$parcours->getIdentifiantBDD()."'
			AND email_promotion='".$promo->getEmailPromotion()."'";
		//echo $sql."<br/>";
		$result = $db->query($sql);

		if(mysqli_num_rows($result) == 0)
			return false;
		else
			return true;
	}
}
?>