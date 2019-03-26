<?php

/**
* Représentation et accès à la table n°4 : les contrats de stage
*/

class Contrat_BDD {

  /**
  * Sauvegarde ou et met à jour un objet Contrat
  * @global resource $db Référence à la base ouverte
  * @global string $tab31 Nom de la table 'contrat'
  * @param Contrat $contrat Le contrat à sauvegarder
  */
  public static function sauvegarder($contrat) {
    global $db;
    global $tab31;
    $parrain = $contrat->getParrain();
    $etudiant = $contrat->getEtudiant();
    $referent = $contrat->getContact();
    // Test si la chaîne contenant le sujet n'est pas déjà échappé
    if (strpos($contrat->getSujetDeContrat(), '\\') === false) {
      $contrat->setSujetDeContrat($db->escape_string($contrat->getSujetDeContrat()));
    }

    // Permet de vérifier si le Contrat existe déjà dans la BDD
    if ($contrat->getIdentifiantBDD() == "") {
      // Création du Contrat
      $requete = "INSERT INTO $tab31(idparrain, idetudiant, idreferent, sujetcontrat, typedecontrat, duree, indemnite, idTheme)
      VALUES ('" . $parrain->getIdentifiantBDD() . "',
      '" . $etudiant->getIdentifiantBDD() . "',
      '" . $referent->getIdentifiantBDD() . "',
      '" . $contrat->getSujetDeContrat() . "',
      '" . $contrat->getTypeDeContrat() . "',
      '" . $contrat->getDuree() . "',
      '" . $contrat->getIndemnites() . "',
      '" . $contrat->getIdTheme() . "')";

      $db->query($requete);

      $sql = "SELECT LAST_INSERT_ID() AS ID FROM $tab31";
      $res = $db->query($sql);
      $result = $res->fetch_array();
      $res->free();
      return $result['ID'];
    } else {
      Utils::printLog("Ici ".$contrat->getIndemnites());
      $idsoutenance = $contrat->getIdSoutenance() ? $contrat->getIdSoutenance() : "NULL";

      // Mise à jour du Contrat
      $requete = "UPDATE $tab31 SET idparrain = '" . $parrain->getIdentifiantBDD() . "',
      idetudiant = '" . $etudiant->getIdentifiantBDD() . "',
      idsoutenance = $idsoutenance,
      idreferent = '" . $referent->getIdentifiantBDD() . "',
      sujetcontrat = '" . $contrat->getSujetDeContrat() . "',
      typedecontrat = '" . $contrat->getTypeDeContrat() . "',
      duree =  '" . $contrat->getDuree() . "',
      indemnite = '" . $contrat->getIndemnites() . "',
      asonresume ='" . $contrat->getASonResume() . "',
      note = '" . $contrat->getNote() . "',
      idtheme = '" . $contrat->getIdTheme() . "'
      WHERE idcontrat = '" . $contrat->getIdentifiantBDD() . "'";

      $res = $db->query($requete);
      if (!$res) { return FALSE; }

      return $contrat->getIdentifiantBDD();
    }
  }

  /**
  * Obtenir une contrat à partir de son identifiant
  * @global resource $db Référence à la base ouverte
  * @global string $tab31 Nom de la table 'contrat'
  * @param integer $id Identifiant de la contrat
  * @return Un enregistrement ou FALSE
  */
  public static function getContrat($id) {
    global $db;
    global $tab31;

    $requete = "SELECT * FROM $tab31 WHERE idcontrat='$id'";
    $res = $db->query($requete);

    $ok = $res != FALSE;

    if ($ok) {
      $enreg = $res->fetch_array();
      $res->free();
    }

    return $ok ? $enreg : FALSE;
  }

  /**
  * Retourne la contrat d'un étudiant d'une certaine promotion
  * @global resource $db Référence à la base ouverte
  * @global string $tab31 Nom de la table 'contrat'
  * @global string $tab32 Nom de la table 'relation_promotion_etudiant_contrat'
  * @param integer $idetudiant Identifiant de l'étudiant
  * @param integer $idpromotion Identifiant de la promotion
  * @return enregistrement ou FALSE
  */
  public static function getContrat2($idetudiant, $idpromotion) {
    global $db;
    global $tab31;
    global $tab32;

    $req = "SELECT * FROM $tab31 WHERE idcontrat IN
    (SELECT idcontrat FROM $tab32
      WHERE idetudiant = $idetudiant AND
      idpromotion = $idpromotion);";
      $res = $db->query($req);

      $ok = $res != FALSE;

      if ($ok) {
        $enreg = $res->fetch_array();
        $res->free();
      }

      return $ok ? $enreg : FALSE;
    }

    /**
    * Obtenir une liste de contrats filtrées
    * @global resource $db Référence à la base ouverte
    * @global string $tab31 Nom de la table 'contrat'
    * @global string $tab15 Nom de la table 'promotion'
    * @global string $tab32 Nom de la table 'relation_promotion_etudiant_contrat'
    * @param objet Filtre $filtre Le filtre global à appliquer
    * @return Tableau d'enregistrements
    */
    public static function getListeContrat($filtre) {
      global $db;
      global $tab31;
      global $tab15;
      global $tab32;

      if ($filtre == "") {
        $req = "SELECT * FROM $tab31 ORDER BY $tab31.idparrain";
      } else {
        $req = "SELECT *
        FROM $tab31, $tab15, $tab32
        WHERE $tab31.idcontrat=$tab32.idcontrat AND
        $tab15.idpromotion=$tab32.idpromotion AND
        ". $filtre->getStrFiltres() ."
        ORDER BY $tab31.idparrain ";
      }

      $res = $db->query($req);

      $tabC = array();

      if ($res) {
        while ($ods = $res->fetch_array()) {
          $tab = array();
          array_push($tab, $ods['idcontrat']);
          array_push($tab, $ods['sujetcontrat']);
          array_push($tab, $ods['typedecontrat']);
          array_push($tab, $ods['duree']);
          array_push($tab, $ods['indemnite']);
          array_push($tab, $ods['asonresume']);
          array_push($tab, $ods['note']);
          array_push($tab, $ods['idparrain']);
          array_push($tab, $ods['idetudiant']);
          array_push($tab, $ods['idsoutenance']);
          array_push($tab, $ods['idreferent']);
          array_push($tab, $ods['idtheme']);

          array_push($tabC, $tab);
        }
        $res->free();
      }

      return $tabC;
    }

    /**
    * Calcul le nombre de parrainage pour un référent et pour une promotion
    * @global resource $db Référence à la base ouverte
    * @global string $tab31 Nom de la table 'parrain'
    * @global string $tab15 Nom de la table 'promotion'
    * @global string $tab32 Nom de la table 'relation_promotion_etudiant_contrat'
    * @param integer $annee L'année de la promotion concernée
    * @param integer $parrain L'identifiant du parrain concerné
    * @param integer $filiere L'identifiant de la filière concernée
    * @param integer $parcours L'identifiant du parcours concerné
    * @return integer
    */
    public static function getListeContratFromParrainAndPromotion($annee, $parrain, $filiere, $parcours) {
      global $db;
      global $tab31;
      global $tab15;
      global $tab32;

      $requete = "SELECT *
      FROM $tab15, $tab32, $tab31
      WHERE $tab15.anneeuniversitaire='$annee' AND
      $tab15.idfiliere='$filiere' AND
      $tab15.idparcours='$parcours' AND
      $tab32.idpromotion=$tab15.idpromotion AND
      $tab31.idcontrat = $tab32.idcontrat AND
      $tab31.idparrain = '$parrain';";

      $res = $db->query($requete);

      $tabC = array();

      if ($res) {
        while ($ods = $res->fetch_array()) {
          $tab = array();
          array_push($tab, $ods['idcontrat']);
          array_push($tab, $ods['sujetcontrat']);
          array_push($tab, $ods['typedecontrat']);
          array_push($tab, $ods['duree']);
          array_push($tab, $ods['indemnite']);
          array_push($tab, $ods['asonresume']);
          array_push($tab, $ods['note']);
          array_push($tab, $ods['idparrain']);
          array_push($tab, $ods['idetudiant']);
          array_push($tab, $ods['idsoutenance']);
          array_push($tab, $ods['idreferent']);
          array_push($tab, $ods['idtheme']);

          array_push($tabC, $tab);
        }
        $res->free();
      }

      return $tabC;
    }

    /**
    * Test si une contrat existe ou pas pour un étudiant pour une certaine année
    * @global resource $db Référence à la base ouverte
    * @global string $tab32 Nom de la table 'relation_promotion_etudiant_contrat'
    * @param objet Contrat $conv Une contrat pour un étudiant
    * @param integer $annee L'année de la contrat
    * @return boolean
    */
    public static function existe($conv, $annee) {
      global $db;
      global $tab32;

      $etu = $conv->getEtudiant();
      $promo = $etu->getPromotion($annee);

      if ($promo == "")
      return false;

      $sql = "SELECT idcontrat
      FROM $tab32
      WHERE idpromotion='" . $promo->getIdentifiantBDD() . "' AND
      idetudiant='" . $etu->getIdentifiantBDD() . "' AND
      idcontrat IS NOT NULL";

      $result = $db->query($sql);
      $nb_result = $result->num_rows;
      $result->close();

      return ($nb_result > 0);
    }

    /**
    * Test si une contrat existe ou pas pour un referent
    * @global resource $db Référence à la base ouverte
    * @global string $tab31 Nom de la table 'contrat'
    * @global string $tab15 Nom de la table 'promotion'
    * @global string $tab32 Nom de la table 'relation_promotion_etudiant_contrat'
    * @param integer $idreferent Identifiant du referent
    * @param objet Filtre $filtre Filtre éventuel sur l'année, la filière et le parcours
    * @return boolean
    */
    public static function existe2($idreferent, $filtre) {
      global $db;
      global $tab31;
      global $tab15;
      global $tab32;

      if ($filtre != '')
      $requete = "SELECT $tab32.idcontrat
      FROM $tab31, $tab15, $tab32
      WHERE " . $filtre->getStrFiltres() . "
      AND $tab32.idpromotion=$tab15.idpromotion
      AND $tab31.idcontrat=$tab32.idcontrat
      AND $tab31.idreferent='$idreferent'";
      else
      $requete = "SELECT idreferent FROM $tab31 WHERE idreferent='$idreferent';";

      $result = $db->query($requete);
      $compte = $result->num_rows;
      $result->close();

      return ($compte > 0);
    }

    /**
    * Suppression d'une contrat en base.
    * La suppression est possible s'il n'y a pas de soutenane associée.
    *
    * Du fait des contraintes d'intégrité référentielle, la table n°19
    * 'relation_promotion_etudiant_contrat' est mise à jour automatiquement
    *
    * Du fait des contraintes d'intégrité référentielle, la table n°25
    * 'attribution' est mise à jour automatiquement
    *
    * @global resource $db Référence à la base ouverte
    * @global string $tab32 Nom de la table 'relation_promotion_etudiant_contrat'
    * @global string $tab31 Nom de la table 'contrat'
    * @param integer $identifiantBDD Identifiant de la contrat à supprimer
    * @param integer $idEtu Identifiant de l'étudiant concerné
    * @param integer $idPromo Identifiant de la promotion de l'étudiant concerné
    */
    public static function supprimerContrat($identifiantBDD) {
      global $db;
      global $tab31;

      // Suppression de l'enregistrement dans la table 'contrat'
      $sql2 = "DELETE FROM $tab31 WHERE idcontrat='$identifiantBDD' AND idsoutenance is NULL";
      $db->query($sql2);
    }

    /**
    * Retourne l'identifiant de la promotion d'un étudiant d'une contrat donnée
    * @global resource $db Référence à la base ouverte
    * @global string $tab32 Nom de la table 'relation_promotion_etudiant_contrat'
    * @param integer $idContrat Identifiant du contrat concernée
    * @return integer
    */
    public static function getPromotion($idContrat) {
      global $db;
      global $tab32;

      $sql = "SELECT idpromotion
      FROM $tab32
      WHERE idcontrat = '$idContrat'";


      $res = $db->query($sql);
      $result = $res->fetch_array();
      $res->free();

      return $result['idpromotion'];
    }

  }

  ?>
