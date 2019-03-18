<?php

/**
* Représentation et accès à la table n°9 : les étudiants
*/

class Candidature_BDD {

  /**
  * Enregistrement ou mise à jour d'un objet Etudiant
  * @global resource $db Référence sur la base ouverte
  * @global string $tab30 Nom de la table 'candidature_alternance'
  * @param Etudiant $etudiant L'objet à sauvegarder
  */
  public static function sauvegarder($candidature) {
    global $db;
    global $tab30;

    if ($candidature->getIdentifiantBDD() == "") {
      $sql = "INSERT INTO $tab30
      VALUES ('0',
      '" . $candidature->getEtudiant() . "',
      '" . $candidature->getOffre() . "',
      '" . $candidature->getEntreprise() . "',
      '" . $candidature->getStatut() . "')";
      $db->query($sql);
    } else {
      $sql = "UPDATE $tab30
      SET idetudiant='" . $candidature->getEtudiant() . "',
      idoffre='" . $candidature->getOffre() . "',
      identreprise='" . $candidature->getEntreprise() . "',
      statut='" . $candidature->getStatut() . "'
      WHERE idcandidature = '" . $candidature->getIdentifiantBDD() . "'";
    //  Utils.printLog($sql);
      $db->query($sql);
    }

    return $candidature->getIdentifiantBDD() ? $candidature->getIdentifiantBDD() : $db->insert_id;
  }

  /**
  * Obtenir un enregistrement Candidature à partir de ses champs
  * @global resource $db Référence sur la base ouverte
  * @global string $tab30 Nom de la table 'candidature_alternant'
  * @param integer $idetudiant L'identifiant de l'étudiant concerné
  * @param integer $idoffre L'identifiant de l'offre
  * @param integer $identreprise L'identifiant de l'entreprise
  * @return enregistrement ou FALSE
  */
  public static function getCandidature($idetudiant, $idoffre, $identreprise) {
    global $db;
    global $tab30;
    $sql = "SELECT * FROM $tab30 WHERE idetudiant=$idetudiant AND idoffre=$idoffre AND identreprise=$identreprise";
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
  * Obtenir la liste des candidatures pour un étudiant donné
  * @global resource $db Référence sur la base ouverte
  * @global string $tab30 Nom de la table 'candidature_alternance'
  * @param integer $idetudiant L'identifiant de l'étudiant
  * @return tableau d'enregistrements
  */
  public static function getListeCandidatures($idetudiant) {
    global $db;
    global $tab30;

    $sql = "SELECT idcandidature FROM $tab30 WHERE idetudiant = '$idetudiant';";
    $res = $db->query($sql);

    $candidatures = array();

    if ($res) {
      while ($cndtr = $res->fetch_assoc()) {
        array_push($candidatures, $cndtr);
      }
      $res->free();
    }

    return $candidatures;
  }

  /**
  * Obtenir la liste des candidats à une offre
  *
  */



}

?>
