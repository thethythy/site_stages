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
    if (isset($_GET["id"]) &&
	isset($_GET["action"]) && $_GET["action"] == "visua") {
	SujetDeStage_IHM::afficherSDS($_GET["id"]);
	$_GET["id"] = $_GET["action"] = "";
    }
}

visualiser();

function traiter() {
    if (isset($_GET["id"]) &&
	isset($_GET["action"]) && $_GET["action"] == "trait") {
	SujetDeStage_IHM::traiterSDS($_GET["id"]);
	$_GET["id"] = $_GET["action"] = "";
    }
}

traiter();

function accepter() {
    if (isset($_POST["id"]) &&
	isset($_POST["accept"])) {
	$sds = SujetDeStage::getSujetDeStage($_POST['id']);
	$sds->setEnAttenteDeValidation(false);
	$sds->setValide(true);
	SujetDeStage_BDD::sauvegarder($sds);

	global $baseSite;
	$message = "Bonjour,<br><br>
		Votre demande de validation d'un sujet de stage a été traitée et le sujet acceptée.<br>
		Veuillez poursuivre la procédure spécifique comme elle est indiquée <a href='" . $baseSite . "presentation/index.php'>ici</a>.<br>
		Bon courage<br><br>

		Thierry Lemeunier<br>
		Responsable pédagogique des stages";

	envoyerNotification($message, $sds);
    }
}

accepter();

function refuser() {
    if (isset($_POST["id"]) &&
	isset($_POST["refus"])) {
	$sds = SujetDeStage::getSujetDeStage($_POST['id']);
	$sds->setEnAttenteDeValidation(false);
	$sds->setValide(false);
	SujetDeStage_BDD::sauvegarder($sds);

	$message = "Bonjour,<br><br>

		Votre demande de validation d'un sujet de stage a été traitée mais le sujet proposé<br>
		ne peut être accepté tel que vous le présentez actuellement car il ne correspond<br>
		pas à votre formation.<br><br>

		Vous avez plusieurs possibilités :<br>
		- refaire une demande de validation avec un sujet modifié ;<br>
		- trouver un autre sujet et faire une demande de validation de ce sujet ;<br>
		- demander plus d'explications en venant voir le responsable pédagogique.<br><br>

		Bon courage <br>

		Thierry Lemeunier<br>
		Responsable pédagogique des stages";

	envoyerNotification($message, $sds);
    }
}

refuser();

// ----------------------------------------------
// Afficher le tableau des demandes à traiter

$tabSDSAValider = SujetDeStage::getSujetDeStageAValider();
if (sizeof($tabSDSAValider) > 0)
    SujetDeStage_IHM::afficherTableauSDSAValider($tabSDSAValider);
else
    echo "<p>Il n'y a aucune demande en attente de traitement.</p>";

// ----------------------------------------------
// Afficher le tableau des demandes déjà traitées

$tabSDSValide = SujetDeStage::getSujetDeStageTraite();
if (sizeof($tabSDSValide) > 0)
    SujetDeStage_IHM::afficherTableauSDSTraite($tabSDSValide);
else
    echo "<p>Il n'y a aucune demande traitée.</p>";

deconnexion();
IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>