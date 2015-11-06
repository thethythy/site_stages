<?php

class SujetDeStage_BDD {

	// Méthodes statiques

	// $sds : Un objet SujetDeStage
	public static function sauvegarder($sds){
		global $tab18;
		global $db;

		$etudiant=$sds->getEtudiant();
		$promotion=$sds->getPromotion();
		// Permet de vérifier si le Sujet de Stage existe déjà dans la BDD
		if($sds->getIdentifiantBDD() == ""){
			// Création du Sujet de Stage
			$requete = "INSERT INTO $tab18(description, valide, enattente, idetudiant, idpromotion)
				    VALUES ('".$sds->getDescription()."',
					    '".$sds->isValide()."',
					    '".$sds->isEnAttenteDeValidation()."',
					    '".$etudiant->getIdentifiantBDD()."',
					    '".$promotion->getIdentifiantBDD()."')";
			//echo $requete."<br/>";
			mysql_query($requete, $db);
		}else{
			// Mise à jour du Sujet de Stage
			$requete = "UPDATE $tab18 SET description = '".$sds->getDescription()."',
						      valide = '".$sds->isValide()."',
						      enattente = '".$sds->isEnAttenteDeValidation()."',
						      idetudiant = '".$etudiant->getIdentifiantBDD()."',
						      idpromotion = '".$promotion->getIdentifiantBDD()."'
				    WHERE idsujetdestage = '".$sds->getIdentifiantBDD()."'";
			//echo $requete."<br/>";
			mysql_query($requete, $db);
		}

	}

	// $id : Un int, représentant un identifiant dans la BDD
	public static function getSujetDeStage($id){
		global $tab18;
		global $db;

		$requete = "SELECT * FROM $tab18 WHERE idsujetdestage='$id'";

		$result = mysql_query($requete, $db);

		return mysql_fetch_assoc($result);
	}

	public static function getListeSujetDeStage($filtres){
		global $tab18;
		global $db;

		if($filtres == "")
			$requete = "SELECT * FROM $tab18";
		else
			$requete = "SELECT * FROM $tab18 WHERE ".$filtres->getStrFiltres();

		//echo $requete."<br/>";
		$result = mysql_query($requete, $db);

		$tabSujetDeStage = array();

		while ($sds = mysql_fetch_array($result, MYSQL_ASSOC)){
			$tab = array();
			array_push($tab, $sds["idsujetdestage"]);
			array_push($tab, $sds["idetudiant"]);
			array_push($tab, $sds["idpromotion"]);
			array_push($tab, $sds["description"]);
			array_push($tab, $sds["valide"]);
			array_push($tab, $sds["enattente"]);
  			array_push($tabSujetDeStage, $tab);
		}

  		return $tabSujetDeStage;
	}

	public static function rechercheSujetDeStage($idEtudiant, $idPromotion) {
		global $tab18;
		global $db;

		$requete = "SELECT idsujetdestage FROM $tab18 WHERE idpromotion='$idPromotion' AND idetudiant='$idEtudiant'";
		$result = mysql_query($requete, $db);
		$result2 = mysql_fetch_assoc($result);
		return $result2[0];
	}

	public static function delete($identifiantBDD) {
		global $tab18;
		global $db;

		$sql = "DELETE FROM $tab18 WHERE idsujetdestage='$identifiantBDD'";
		mysql_query($sql,$db);
	}

}

?>