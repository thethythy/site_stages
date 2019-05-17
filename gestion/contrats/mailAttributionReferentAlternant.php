<?php

/**
 * Page mailAttributionReferentAlternant.php
 * Utilisation : page pour notifier l'enseignant-référent d'un étudiant auprès de l'entreprise
 * Dépendance(s) : mailAttributionReferentAlternantData.php --> traitement des requêtes Ajax
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
 * @global type $emailResponsable
 * @param type $oEtudiant
 * @param type $oContact
 * @param type $oReferent
 */
function envoyerNotification($oEtudiant, $oContact, $oReferent) {
    global $emailResponsableAlter;

    $headers = "Content-Type: text/html; charset=utf-8\n";
    $headers .= "Content-Transfer-Encoding: 8bit\n";
    $headers .= "From: $emailResponsableAlter\n";
    $headers .= "Reply-To: $emailResponsableAlter\n";
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
Dans le cadre du suivi d'alternance de $prenomE $nomE,<br/>
étudiant(e) en Master Informatique à l'Université du Mans,<br/>
je vous informe par ce courrier que l'enseignant en charge<br/>
du suivi de l'aternance à l'Université du Mans est $prenomR $nomR<br/>
(contactable par mail à l'adresse $emailR).<br/>
<br/>
N'hésitez pas à contacter cette personne pour toutes questions<br/>
concernant le suivi d'alternance de $prenomE $nomE.<br/>
<br/>
Si vous n'êtes pas en charge du suivi du travail de $prenomE $nomE,<br/>
veuillez m'excuser et, si possible, transférer ce courrier à l'encadrant<br/>
de cet(te) étudiant(e) ou m'informer de cette erreur.<br/>
<br/>
Cordialement<br/>
<br/>
Valérie Renault<br/>
Responsable de l'alternance<br/>
Département Informatique<br/>
http://www-info.univ-lemans.fr/";

    mail($emailResponsableAlter . "," . $emailE . "," . $oContact->getEmail() . "," . $emailR, "Suivi de stage", $msg, $headers);
}

// Envoyer les notifications sélectionnées
// Attention, il faut faire l'envoie qu'une seule fois

if (isset($_POST['notification']) && isset($_POST['notifications'])) {
    foreach ($_POST['notifications'] as $idAffectation) {
	$oAffectation = Affectation::getAffectation($idAffectation);

	// Envoie si pas déjà envoyé
	if ($oAffectation->getEnvoi() == 0) {
	    $oContrat = Contrat::getContrat($oAffectation->getIdContrat());
	    $oEtudiant = $oContrat->getEtudiant();
	    $oContact = $oContrat->getTuteur();
	    $oReferent = $oContrat->getParrain();

	    // Envoyer la notification
	    envoyerNotification($oEtudiant, $oContact, $oReferent);

	    // Indiquer que l'envoi de la notification a été fait
	    $oAffectation->setEnvoi(1);
	    Affectation_BDD::sauvegarder($oAffectation);
	}
    }
}

// ----------------------------------------------------------------------------
// Générer Sortie

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion des stages');

IHM_Generale::header("Notification des affectations des", "alternants", "../../", $tabLiens);

Promotion_IHM::afficherFormulaireRecherche("mailAttributionReferentAlternantData.php", false, true);

// Affichage des données
echo "<div id='data'>";
include_once("mailAttributionReferentAlternantData.php");
echo "</div>";

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

deconnexion();

?>