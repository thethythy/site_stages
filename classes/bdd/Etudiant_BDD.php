<?php

/**
* Représentation et accès à la table n°9 : les étudiants
*/

class Etudiant_BDD {

  /**
  * Enregistrement ou mise à jour d'un objet Etudiant
  * @global resource $db Référence sur la base ouverte
  * @global string $tab9 Nom de la table 'etudiant'
  * @param Etudiant $etudiant L'objet à sauvegarder
  */
  public static function sauvegarder($etudiant) {
    global $db;
    global $tab9;

    if ($etudiant->getIdentifiantBDD() == "") {
      $sql = "INSERT INTO $tab9 (nometudiant, prenometudiant, email_institutionnel, email_personnel, codeetudiant)
      VALUES ('" . $etudiant->getNom() . "',
      '" . $etudiant->getPrenom() . "',
      '" . $etudiant->getEmailInstitutionel() . "',
      '" . $etudiant->getEmailPersonnel() . "',
      '" . $etudiant->getCodeEtudiant() . "')";

      $db->query($sql);
    } else {
      $sql = "UPDATE $tab9
      SET nometudiant='" . $etudiant->getNom() . "',
      prenometudiant='" . $etudiant->getPrenom() . "',
      email_institutionnel='" . $etudiant->getEmailInstitutionel() . "',
      email_personnel='" . $etudiant->getEmailPersonnel() . "',
      codeetudiant='" . $etudiant->getCodeEtudiant() . "'
      WHERE idetudiant = '" . $etudiant->getIdentifiantBDD() . "'";
      $db->query($sql);
    }

    return $etudiant->getIdentifiantBDD() ? $etudiant->getIdentifiantBDD() : $db->insert_id;
  }

  /**
  * Obtenir un enregistrement Etudiant à partir de son identifiant
  * @global resource $db Référence sur la base ouverte
  * @global string $tab9 Nom de la table 'etudiant'
  * @param integer $identifiantBDD L'identifiant de l'étudiant recherché
  * @return enregistrement ou FALSE
  */
  public static function getEtudiant($identifiantBDD) {
    global $db;
    global $tab9;
    $sql = "SELECT * FROM $tab9 WHERE idetudiant='$identifiantBDD'";
    $res = $db->query($sql);

    $ok = $res != FALSE;

    if ($ok) {
      $enreg = $res->fetch_array();
      $res->free();
      return $enreg;
    } else
    return FALSE;
  }

  /**
  * Suppression d'un étudiant dans une promotion.
  * L'étudiant ne doit pas avoir de convention.
  * @global resource $db Référence sur la base ouverte
  * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
  * @param integer $identifiantBDD Identifiant de l'étudiant concerné
  * @param integer $idPromo Identifiant de la promotion concernée
  */
  public static function supprimerLienPromotionEtudiant($identifiantBDD, $idPromo) {
    global $db;
    global $tab19;
    $sql = "DELETE FROM $tab19 WHERE idetudiant='$identifiantBDD' AND idpromotion='$idPromo' AND idconvention is NULL";
    $db->query($sql);
  }

  /**
  * Suppression d'un enregistrement Etudiant à partir de son identifiant
  *
  * La table relation_promotion_etudiant_convention est mise à jour du fait
  * des contraintes d'intégrité relationnelles
  *
  * @global resource $db Référence sur la base ouverte
  * @global string $tab9 Nom de la table 'etudiant'
  * @param integer $identifiantBDD Identifiant de l'enregistrement à supprimer
  */
  public static function supprimerEtudiant($identifiantBDD) {
    global $db;
    global $tab9;
    $sql = "DELETE FROM $tab9 WHERE idetudiant='$identifiantBDD'";
    $db->query($sql);
  }

  /**
  * Obtenir la liste des étudiants d'une promotion
  * @global resource $db Référence sur la base ouverte
  * @global string $tab9 Nom de la table 'etudiant'
  * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
  * @param integer $identifiantPromo L'identifiant de la promotion
  * @return tableau d'enregistrements
  */
  public static function getListeEtudiants($identifiantPromo) {
    global $db;
    global $tab9;
    global $tab19;

    $sql = "SELECT * FROM $tab9 WHERE idetudiant IN
    (SELECT idetudiant FROM $tab19 WHERE idpromotion='$identifiantPromo');";
    $res = $db->query($sql);

    $listeEtudiants = array();

    if ($res) {
      while ($etu = $res->fetch_assoc()) {
        $tab = array();
        array_push($tab, $etu["idetudiant"]);
        array_push($tab, $etu["nometudiant"]);
        array_push($tab, $etu["prenometudiant"]);
        array_push($tab, $etu["email_institutionnel"]);
        array_push($tab, $etu["email_personnel"]);
        array_push($tab, $etu["codeetudiant"]);
        array_push($listeEtudiants, $tab);
      }
      $res->free();
    }

    return $listeEtudiants;
  }

  /**
  * Obtenir une liste d'étudiants selon le filtre (année / parcours / filiere)
  * @global resource $db Référence sur la base ouverte
  * @global string $tab9 Nom de la table 'etudiant'
  * @global string $tab15 Nom de la table 'promotion'
  * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
  * @param string $filtre
  * @return tableau d'enregistrements
  */
  public static function getEtudiants($filtre) {
    global $db;
    global $tab9;
    global $tab15;
    global $tab19;

    if ($filtre) {
      $sql = "SELECT * FROM $tab9 WHERE idetudiant IN
      (SELECT idetudiant FROM $tab19, $tab15 WHERE $tab19.idpromotion=$tab15.idpromotion AND $filtre);";
    } else {
      $sql = "SELECT * FROM $tab9;";
    }

    $res = $db->query($sql);

    $listeEtudiants = array();

    if ($res) {
      while ($etu = $res->fetch_assoc()) {
        $tab = array();
        array_push($tab, $etu["idetudiant"]);
        array_push($tab, $etu["nometudiant"]);
        array_push($tab, $etu["prenometudiant"]);
        array_push($tab, $etu["email_institutionnel"]);
        array_push($tab, $etu["email_personnel"]);
        array_push($tab, $etu["codeetudiant"]);
        array_push($listeEtudiants, $tab);
      }
      $res->free();
    }

    return $listeEtudiants;
  }

  /**
  * Ajouter un étudiant à une promotion
  * On vérifie d'abord que la relation étudiant-promotion n'existe pas déjà
  *
  * @global resource $db Référence sur la base ouverte
  * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
  * @param integer $etu Identifiant de l'étudiant
  * @param integer $promo Identifiant de la promotion
  */
  public static function ajouterPromotion($etu, $promo) {
    global $db;
    global $tab19;

    $sql = "SELECT COUNT(idetudiant) AS NB_ETU FROM $tab19 WHERE idetudiant='$etu' AND idpromotion='$promo';";
    $res = $db->query($sql);
    $enreg = $res->fetch_assoc();
    $res->free();

    if ($enreg['NB_ETU'] == 0) {
      $sql = "INSERT INTO $tab19(idetudiant, idpromotion) VALUES ('$etu', '$promo')";
      $db->query($sql);
    }
  }

  /**
  * Associer une convention à un étudiant et une promotion existants
  * @global resource $db Référence sur la base ouverte
  * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
  * @param integer $idetu Identifiant de l'étudiant
  * @param integer $idconv Identifiant de la convention
  * @param integer $idpromo Identifiant de la promotion
  */
  public static function ajouterConvention($idetu, $idconv, $idpromo) {
    global $db;
    global $tab19;

    $sql = "UPDATE $tab19 SET idconvention = '$idconv'
    WHERE idetudiant = '$idetu' AND idpromotion = '$idpromo'";
    $db->query($sql);
  }

  /**
  * Obtenir la promotion d'un étudiant pour une certaine année
  * @global resource $db Référence sur la base ouverte
  * @global string $tab15  Nom de la table 'promotion'
  * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
  * @param integer $idetu Identifiant de l'étudiant concerné
  * @param integer $annee Année de la promotion recherchée
  * @return integer Identifiant de la promotion trouvée
  */
  public static function recherchePromotion($idetu, $annee) {
    global $db;
    global $tab15;
    global $tab19;

    $sql = "SELECT $tab19.idpromotion AS idpromo FROM $tab19, $tab15
    WHERE $tab19.idetudiant = '$idetu'
    AND $tab15.anneeuniversitaire LIKE '$annee'
    AND $tab19.idpromotion = $tab15.idpromotion";

    $res = $db->query($sql);
    $enreg = $res->fetch_array();
    $res->free();
    return $enreg['idpromo'];
  }

  /**
  * Obtenir l'identifiant de la convention d'un étudiant et une année donnée
  * @global resource $db Référence sur la base ouverte
  * @global string $tab4 Nom de la table 'convention'
  * @global string $tab15 Nom de la table 'promotion'
  * @global string $tab19 Nom de la table 'relation_promotion_etudiant_convention'
  * @param integer $idetu Identifiant de l'étudiant concerné
  * @param integer $annee Année de la convention recherchée
  * @return integer ou ""
  */
  public static function rechercheConvention($idetu, $annee) {
    global $db;
    global $tab4;
    global $tab15;
    global $tab19;

    $sql = "SELECT $tab19.idconvention AS idconv FROM $tab19, $tab4, $tab15
    WHERE $tab19.idetudiant='$idetu'
    AND $tab15.anneeuniversitaire='$annee'
    AND $tab19.idpromotion = $tab15.idpromotion
    AND $tab19.idconvention = $tab4.idconvention";

    $res = $db->query($sql);
    $enreg = $res->fetch_array();
    $res->free();
    return $enreg['idconv'];
  }

  /**
  * Recherche les étudiants s'appelant $nom $prenom
  * @global resource $db Référence sur la base ouverte
  * @global string $tab9 Nom de la table 'etudiant'
  * @param string $nom Le nom recherché
  * @param string $prenom Le prénom recherché�
  * @return tableau d'enregistrements
  */
  public static function searchEtudiants($nom, $prenom) {
    global $db;
    global $tab9;

    $sql = "SELECT * FROM $tab9 WHERE nometudiant LIKE '$nom' AND prenometudiant LIKE '$prenom'";
    $res = $db->query($sql);

    $tabSEtudiants = array();

    if ($res) {
      while ($etu = $res->fetch_assoc()) {
        $tab = array();
        array_push($tab, $etu["idetudiant"]);
        array_push($tab, $etu["nometudiant"]);
        array_push($tab, $etu["prenometudiant"]);
        array_push($tab, $etu["email_institutionnel"]);
        array_push($tab, $etu["email_personnel"]);
        array_push($tab, $etu["codeetudiant"]);
        array_push($tabSEtudiants, $tab);
      }
      $res->free();
    }

    return $tabSEtudiants;
  }

}

?>
