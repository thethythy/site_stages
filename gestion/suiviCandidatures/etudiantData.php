<?php

include_once("../../classes/bdd/connec.inc");
include_once('../../classes/moteur/Utils.php');

spl_autoload_register('Utils::my_autoloader_from_level2');
header("Content-Type", "application/json");

try {
  // Erreur si on reçoit un GET
  if ($_SERVER['REQUEST_METHOD'] !== "POST") {

    throw new Exception('Invalid Request', 2000);
  } else {
    $tabResponse = array();
    $tabResponse['idEtudiant'] = $_POST['idEtudiant'];
    $tabResponse['length'] = $_POST['length'];
    $tabResponse['requestStatus'] = true;

    echo json_encode($tabResponse);
    exit;
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
