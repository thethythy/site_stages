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

    

    // requestStatus à true si tout s'est bien passé
    exit(json_encode(
      array(
        'requestStatus' => true
      )
    )); // fin json encode
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
