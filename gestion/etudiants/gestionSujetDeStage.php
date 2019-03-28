<?php

/**
* Page gestionSujetDeStage.php
* Utilisation : page pour gérer les demandes de validation
* Accès : restreint par authentification HTTP
*/

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion');

IHM_Generale::header("Gérer", "les demandes de validation", "../../", $tabLiens);

// ----------------------------------------------
// Contrôleur

function envoyerNotification($message, $sds) {
  //Envoie d'un mail de validation ou invalidation à l'étudiant
  global $emailResponsable;

  $destinataire = $sds->getEtudiant()->getEmailInstitutionel();
  if ($sds->getEtudiant()->getEmailPersonnel() != "")
  $destinataire = $destinataire . ", " . $sds->getEtudiant()->getEmailPersonnel();
  $expediteur = $emailResponsable;
  $reponse = $expediteur;

  $headers = "From: $expediteur\nReply-To: $reponse\nCc: $expediteur\n";
  $headers .="Content-Type: text/html; charset=utf-8\n";
  $headers .="Content-Transfer-Encoding: 8bit";
  mail($destinataire, 'Site des stages : reponse demande de validation', $message, $headers);
}

function visualiser() {
  if (isset($_GET["id"]) && isset($_GET["type"]) &&
  isset($_GET["action"]) && $_GET["action"] == "visua") {
    if($_GET["type"] == 'sta'){
      SujetDeStage_IHM::afficherSDS($_GET["id"]);
      $_GET["id"] = $_GET["action"] = "";
    } else {
      SujetDAlternance_IHM::afficherSDA($_GET["id"]);
      $_GET["id"] = $_GET["action"] = "";
    }
  }
}

visualiser();

function traiter() {
  if (isset($_GET["id"]) && isset($_GET["type"]) &&
  isset($_GET["action"]) && $_GET["action"] == "trait") {
    if($_GET["type"] == 'sta'){
      SujetDeStage_IHM::traiterSDS($_GET["id"]);
      $_GET["id"] = $_GET["action"] = "";
    } else {
      SujetDAlternance_IHM::traiterSDA($_GET["id"]);
      $_GET["id"] = $_GET["action"] = "";
    }
  }
}

traiter();

function accepter() {
  if (isset($_POST["id"]) && isset($_POST["type"]) &&
  isset($_POST["accept"])) {
    if($_POST["type"] == 'sta'){
      $sds = SujetDeStage::getSujetDeStage($_POST['id']);
      // Ne pas mettre false, utilisé comme chaine vide dans la $requete
      // N'est plus compté comme faux avec la nouvelle version de mySQL
      $sds->setEnAttenteDeValidation(0);
      $sds->setValide(1);
      SujetDeStage_BDD::sauvegarder($sds);
      //
      // global $baseSite;
      // $message = "Bonjour,<br><br>
      // Votre demande de validation d'un sujet de stage a été traitée et le sujet accepté.<br>
      // Veuillez poursuivre la procédure spécifique comme elle est indiquée <a href='" . $baseSite . "presentation/index.php'>ici</a>.<br>
      // Bon courage<br><br>
      //
      // Thierry Lemeunier<br>
      // Responsable pédagogique des stages";
      //
      // envoyerNotification($message, $sds);
    } else {
      $sda = SujetDAlternance::getSujetDAlternance($_POST['id']);
      $sda->setEnAttenteDeValidation(0);
      $sda->setValide(1);
      Utils::printLog("A");
      SujetDAlternance_BDD::sauvegarder($sda);

      // global $baseSite;
      // $message = "Bonjour,<br><br>
      // Votre demande de validation d'un sujet d'alternance a été traitée et le sujet accepté.<br>
      // Veuillez poursuivre la procédure spécifique comme elle est indiquée <a href='" . $baseSite . "presentation/index.php'>ici</a>.<br>
      // Bon courage<br><br>
      //
      // Thierry Lemeunier<br>
      // Responsable pédagogique des stages";
      //
      // envoyerNotification($message, $sda);
    }
  }
}

accepter();

function refuser() {
  if (isset($_POST["id"]) && isset($_POST["type"]) &&
  isset($_POST["refus"])) {
    if($_GET["type"] == 'sta'){
      $sds = SujetDeStage::getSujetDeStage($_POST['id']);
      $sds->setEnAttenteDeValidation(0);
      $sds->setValide(0);
      Utils::printLog("A");
      SujetDeStage_BDD::sauvegarder($sds);

      // $message = "Bonjour,<br><br>
      //
      // Votre demande de validation d'un sujet de stage a été traitée mais le sujet proposé<br>
      // ne peut être accepté tel que vous le présentez actuellement car il ne correspond<br>
      // pas à votre formation.<br><br>
      //
      // Vous avez plusieurs possibilités :<br>
      // - refaire une demande de validation avec un sujet modifié ;<br>
      // - trouver un autre sujet et faire une demande de validation de ce sujet ;<br>
      // - demander plus d'explications en venant voir le responsable pédagogique.<br><br>
      //
      // Bon courage <br>
      //
      // Thierry Lemeunier<br>
      // Responsable pédagogique des stages";
      //
      // envoyerNotification($message, $sds);
    } else {
      $sda = SujetDeStage::getSujetDeStage($_POST['id']);
      $sda->setEnAttenteDeValidation(0);
      $sda->setValide(0);
      Utils::printLog("A");
      SujetDAlternance_BDD::sauvegarder($sda);

      // $message = "Bonjour,<br><br>
      //
      // Votre demande de validation d'un sujet de stage a été traitée mais le sujet proposé<br>
      // ne peut être accepté tel que vous le présentez actuellement car il ne correspond<br>
      // pas à votre formation.<br><br>
      //
      // Vous avez plusieurs possibilités :<br>
      // - refaire une demande de validation avec un sujet modifié ;<br>
      // - trouver un autre sujet et faire une demande de validation de ce sujet ;<br>
      // - demander plus d'explications en venant voir le responsable pédagogique.<br><br>
      //
      // Bon courage <br>
      //
      // Thierry Lemeunier<br>
      // Responsable pédagogique des stages";
      //
      // envoyerNotification($message, $sda);
    }
  }
}

refuser();

// ----------------------------------------------
// Afficher le tableau des demandes à traiter

$tabSDSAValider = SujetDeStage::getSujetDeStageAValider();
$tabSDAAValider = SujetDalternance::getSujetDAlternanceAValider();
$tabSDSValide = SujetDeStage::getSujetDeStageTraite();
$tabSDAValide = SujetDAlternance::getSujetDAlternanceTraite();

echo "<span style='font-size : 18pt;'> STAGE</br></br> </span>";
if (sizeof($tabSDSAValider) > 0)
SujetDeStage_IHM::afficherTableauSDSAValider($tabSDSAValider);
else
echo "<p>Il n'y a aucune demande de stage en attente de traitement.</p>";

if (sizeof($tabSDSValide) > 0)
SujetDeStage_IHM::afficherTableauSDSTraite($tabSDSValide);
else
echo "<p>Il n'y a aucune demande de stage traitée.</p>";

echo '</br><hr></br>';
echo "<span style='font-size : 18pt;'> ALTERNANCE</br></br> </span>";
if(sizeof($tabSDAAValider) > 0)
SujetDAlternance_IHM::afficherTableauSDAAValider($tabSDAAValider);
else
echo "<p>Il n'y a aucune demande d'alternance en attente de traitement.</p>";

if (sizeof($tabSDAValide) > 0)
SujetDAlternance_IHM::afficherTableauSDATraite($tabSDAValide);
else
echo "<p>Il n'y a aucune demande d'alternance traitée.</p>";

// ----------------------------------------------
// Afficher le tableau des demandes déjà traitées






deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>
