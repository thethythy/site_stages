<?php

/**
 * Page mailAttributionReferentStage.php
 * Utilisation : page pour notifier l'enseignant-référent d'un étudiant auprès de l'entreprise
 * Dépendance(s) : mailAttributionReferentStageData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// ----------------------------------------------------------------------------
// Contrôleur

/**
 * Envoyer la notification au contact dans l'entreprise aini qu'à l'étudiant
 * et au référent (copie au responsable)
 * @param type $oEtudiant
 * @param type $oContact
 * @param type $oReferent
 */
function envoyerNotification($oEtudiant, $oContact, $oReferent) {
    $responsable = Responsable::getResponsableFromResponsabilite("stage");
    $emailResp = $responsable->getEmailresponsable();
    $nomResp = $responsable->getPrenomresponsable(). ' ' . $responsable->getNomresponsable();
    $titreResp = $responsable->getTitreresponsable();

    $headers = "Content-Type: text/html; charset=utf-8\n";
    $headers .= "Content-Transfer-Encoding: 8bit\n";
    $headers .= "From: $emailResp\n";
    $headers .= "Reply-To: $emailResp\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    $nomE = $oEtudiant->getNom();
    $prenomE = $oEtudiant->getPrenom();
    $emailE = $oEtudiant->getEmailInstitutionel();

    $prenomR = $oReferent->getPrenom();
    $nomR = $oReferent->getNom();
    $emailR = $oReferent->getEmail();

    $msg =
"Bonjour,<br/>
<br/>
Dans le cadre du suivi du stage de $prenomE $nomE,<br/>
étudiant(e) en Master Informatique à l'Université du Mans,<br/>
je vous informe par ce courrier que l'enseignant en charge<br/>
du suivi de stage à l'Université du Mans est $prenomR $nomR<br/>
(contactable par mail à l'adresse $emailR).<br/>
<br/>
N'hésitez pas à contacter cette personne pour toutes questions<br/>
concernant le suivi de stage de $prenomE $nomE.<br/>
<br/>
Si vous n'êtes pas en charge du suivi du travail de $prenomE $nomE,<br/>
veuillez m'excuser et, si possible, transférer ce courrier à l'encadrant<br/>
de cet(te) étudiant(e) ou m'informer de cette erreur.<br/>
<br/>
Cordialement<br/>
<br/>
$nomResp<br/>
$titreResp<br/>
Le Mans Université<br/>
Département Informatique<br/>
https://info-stages.univ-lemans.fr/";

    mail($emailResp . "," . $emailE . "," . $oContact->getEmail() . "," . $emailR, "Suivi de stage", $msg, $headers);
}

// Envoyer les notifications sélectionnées
// Attention, il faut faire l'envoie qu'une seule fois

if (isset($_POST['notification']) && isset($_POST['notifications'])) {
    foreach ($_POST['notifications'] as $idAttribution) {
	$oAttribution = Attribution::getAttribution($idAttribution);

	// Envoie si pas déjà envoyé
	if ($oAttribution->getEnvoi() == 0) {
	    $oConvention = Convention::getConvention($oAttribution->getIdconvention());
	    $oEtudiant = $oConvention->getEtudiant();
	    $oContact = $oConvention->getContact();
	    $oReferent = $oConvention->getParrain();

	    // Envoyer la notification
	    envoyerNotification($oEtudiant, $oContact, $oReferent);

	    // Indiquer que l'envoi de la notification a été fait
	    $oAttribution->setEnvoi(1);
	    Attribution_BDD::sauvegarder($oAttribution);
	}
    }
}

// ----------------------------------------------------------------------------
// Générer Sortie

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion des stages');

IHM_Generale::header("Notification des attributions de", "stage", "../../", $tabLiens);

Promotion_IHM::afficherFormulaireRecherche("mailAttributionReferentStageData.php", false, true);

// Affichage des données
echo "<div id='data'>";
include_once("mailAttributionReferentStageData.php");
echo "</div>";

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

deconnexion();

?>