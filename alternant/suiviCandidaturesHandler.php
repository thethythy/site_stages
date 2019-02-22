<?php

include_once("../classes/bdd/connec.inc");
include_once('../classes/moteur/Utils.php');

spl_autoload_register('Utils::my_autoloader_from_level1');
header("Content-Type", "application/json");

try {
  // Erreur si on reçoit un GET
  if ($_SERVER['REQUEST_METHOD'] !== "POST") {

    throw new Exception('Invalid Request', 2000);
  } else {
    Utils::PrintLog(print_r($_POST));
    $result = true;
    // global $db;
    // global $tab9;
    //
    // if ($etudiant->getIdentifiantBDD() == "") {
    //   $sql = "INSERT INTO $tab9 (nometudiant, prenometudiant, email_institutionnel, email_personnel, codeetudiant)
    //   VALUES ('" . $etudiant->getNom() . "',
    //   '" . $etudiant->getPrenom() . "',
    //   '" . $etudiant->getEmailInstitutionel() . "',
    //   '" . $etudiant->getEmailPersonnel() . "',
    //   '" . $etudiant->getCodeEtudiant() . "')";
    //
    //   $db->query($sql);
    // } else {
    //   $sql = "UPDATE $tab9
    //   SET nometudiant='" . $etudiant->getNom() . "',
    //   prenometudiant='" . $etudiant->getPrenom() . "',
    //   email_institutionnel='" . $etudiant->getEmailInstitutionel() . "',
    //   email_personnel='" . $etudiant->getEmailPersonnel() . "',
    //   codeetudiant='" . $etudiant->getCodeEtudiant() . "'
    //   WHERE idetudiant = '" . $etudiant->getIdentifiantBDD() . "'";
    //   $db->query($sql);
    // }

    if ($result === false) {
      throw new Exception('DB Query Failed', 202);
    } else  {
      // requestStatus à true si tout s'est bien passé
      exit(json_encode(
        array(
          'requestStatus' => true
        )
      )); // fin json encode
    }
  }
} catch(Exception $e) {
  echo json_encode(
    array(
      'requestStatus' => false,
      'error' => $e -> getMessage(),
      'error_code' => $e -> getCode()
    )
  ); // fin json encode

  exit;

}

?>
