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


    for( $i = 0 ; $i < $_POST['length'] ; $i++){
      $tabCndtr = array();
      $cndtr = Candidature::getCandidature($_POST['idetudiant'], $_POST['idoffre'.$i], $_POST['identreprise'.$i]);

      // Chercher si cette candidature existe dans la BDD
      if($cndtr){
         //La candidature existe, on la met à jour
        array_push($tabCndtr, $cndtr->getIdentifiantBDD());
        array_push($tabCndtr, $cndtr->getEtudiant());
        array_push($tabCndtr, $cndtr->getOffre());
        array_push($tabCndtr, $cndtr->getEntreprise());
        array_push($tabCndtr, $_POST['statut'.$i]);
        Candidature::modifierDonnees($tabCndtr);
      } else {
        //La candidature n'existe pas, on la crée
        if($_POST['statut'.$i] != "-------------"){
          //On ne crée que si on a une candidature, et pas un truc laissé par défaut
          array_push($tabCndtr, $_POST['idetudiant']);
          array_push($tabCndtr, $_POST['idoffre'.$i]);
          array_push($tabCndtr, $_POST['identreprise'.$i]);
          array_push($tabCndtr, $_POST['statut'.$i]);
          Candidature::saisirDonnees($tabCndtr);
        }
      }
    }

    $result = true;


    if ($result === false) {
      throw new Exception('Erreur lors de l\'enregistrement en base de données.', 202);
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
