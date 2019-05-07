<?php

$access_control_target = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

include_once("../classes/bdd/connec.inc");
include_once('../classes/moteur/Utils.php');

spl_autoload_register('Utils::my_autoloader_from_level1');
header("Content-Type", "application/json");

try {
  // Erreur si on reçoit un GET
  if ($_SERVER['REQUEST_METHOD'] !== "POST") {

    throw new Exception('Invalid Request', 2000);
  } else {
    $tabResponse = array();
    for( $i = 0 ; $i < $_POST['length'] ; $i++){
      $cndtr = Candidature::getCandidature($_POST['idetudiant'], $_POST['idoffre'.$i], $_POST['identreprise'.$i]);

      // Chercher si cette candidature existe dans la BDD
      if($cndtr){
         //La candidature existe, on récupère son statut
        $tabResponse[$i] = $cndtr->statut;
      } else {
        //La candidature n'existe pas, on renvoit la chaine par défaut
        $tabResponse[$i] = "-------------";
      }
    }
    $tabResponse['length'] = $_POST['length'];
    // requestStatus à true si tout s'est bien passé
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
