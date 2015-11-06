<?php

class Soutenance_BDD {

	/**
	 * Sauvegarde un objet Soutenance
	 * @param $soutenance la soutenance a sauvegarder
	 */
	public static function sauvegarder($soutenance) {
		global $tab17;
		global $db;

		$heuredebut = $soutenance->getHeureDebut();
		$mindebut = $soutenance->getMinuteDebut();
		$ahuitclos = $soutenance->isAHuitClos();
		$iddatesoutenance = $soutenance->getDateSoutenance()->getIdentifiantBDD();
		$idsalle = $soutenance->getSalle()->getIdentifiantBDD();

		// Permet de vérifier si la Convention existe déjà dans la BDD
		if ($soutenance->getIdentifiantBDD() == "") {
			// Création de la soutenance
			$requete = "INSERT INTO $tab17(heuredebut, mindebut, ahuitclos, iddatesoutenance, idsalle)
				    VALUES ('$heuredebut', '$mindebut', '$ahuitclos', '$iddatesoutenance', '$idsalle')";
			mysql_query($requete,$db);

			// Chercher l'id de la soutenance
			$sql = "SELECT LAST_INSERT_ID() AS ID FROM $tab17";
			$req = mysql_query($sql, $db);
			$result = mysql_fetch_assoc($req);
			$soutenance->setIdentifiantBDD($result['ID']);
		} else {
			// Mise à jour de la soutenance
			$requete = "UPDATE $tab17 SET heuredebut = '$heuredebut',
						      mindebut = '$mindebut',
						      ahuitclos = '$ahuitclos',
						      iddatesoutenance = '$iddatesoutenance',
						      idsalle = '$idsalle'
				    WHERE idsoutenance = ".$soutenance->getIdentifiantBDD();

			mysql_query($requete,$db);
		}

		// Retourner l'id de la soutenance
		return $soutenance->getIdentifiantBDD();
	}

	/**
	 * Suppression d'une soutenance
	 * @param $id L'identifiant de la soutenance
	 */
	public static function supprimer($id) {
		global $db;
		global $tab17;

		$requete = "DELETE FROM $tab17 WHERE idsoutenance='$id'";
		mysql_query($requete, $db);
	}

	// $id : Un int, représentant un identifiant dans la BDD
	public static function getSoutenance($id){
		global $tab17;
		global $db;

		$requete = "SELECT * FROM $tab17 WHERE idsoutenance='$id'";
		$convention = mysql_query($requete, $db);
		return mysql_fetch_assoc($convention);
	}

	public static function getConvention($idsoutenance) {
		global $tab4;
		global $db;

		$requete = "SELECT * FROM $tab4 WHERE idsoutenance='$idsoutenance'";
		$convention = mysql_query($requete, $db);
		return mysql_fetch_row($convention);
	}

	public static function listerSoutenanceFromSalleAndDate($idsalle, $iddate) {
		global $tab17;
		global $db;

		$requete = "SELECT * FROM $tab17 WHERE iddatesoutenance='$iddate' AND idsalle='$idsalle'";
		return mysql_query($requete, $db);
	}

	public static function listerSoutenanceFromAnnee($annee) {
		global $tab5;
		global $tab17;
		global $db;

		$requete = "SELECT $tab17.idsoutenance, $tab17.heuredebut, $tab17.mindebut, $tab17.ahuitclos, $tab17.iddatesoutenance, $tab17.idsalle
			    FROM $tab17, $tab5 WHERE $tab17.iddatesoutenance = $tab5.iddatesoutenance AND $tab5.annee='$annee'";
		return mysql_query($requete, $db);
	}
}

?>