<?php

/**
 * Page convocation.php
 * Utilisation : page pour faire la convocation des étudiants et des entreprises
 * Dépendance(s) : convocationData.php --> traitement des requêtes Ajax
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// ----------------------------------------------------------------------------
// Contrôleur

/**
 * Envoyer l'invitation au contact dans l'entreprise aini qu'à l'étudiant.
 * (copie au responsable des relations entreprise)
 * @param objet Etudiant $oEtudiant
 * @param objet Contact $oContact
 * @param string $cadre
 * @param string $date
 * @param integer $heure
 * @param string $salle
 */
function envoyerConvocation($oEtudiant, $oContact, $cadre, $date, $heure, $salle) {
    $emailResponsable = Responsable::getResponsableFromResponsabilite("site")->getEmailresponsable();
    $contexte = $cadre === "alternant" ? "de l'alternance" : " du stage";

    $headers = "Content-Type: text/html; charset=utf-8\n";
    $headers .= "Content-Transfer-Encoding: 8bit\n";
    $headers .= "From: $emailResponsable\n";
    $headers .= "Reply-To: $emailResponsable\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    $nom = $oEtudiant->getNom();
    $prenom = $oEtudiant->getPrenom();

    $msg =     "Bonjour,<br/>
		<br/>
		Dans le cadre du suivi $contexte de $prenom $nom<br/>
		vous êtes cordialement invité à venir assister à la soutenance prévue<br/>
		le $date à $heure dans le bâtiment IC2 (avenue Laënnec au Mans / $salle).<br/>
		<br/>
		Si vous n'êtes pas en charge du suivi du travail de $prenom $nom, veuillez<br/>
		m'excuser et si possible transférer ce courrier à l'encadrant de cet(te) étudiant(e)<br/>
		ou m'informer de cette erreur.<br/>
		<br/>
		Cordialement<br/>

		Le Mans Université
		Département Informatique<br/>
		http://www-info.univ-lemans.fr/";

    mail($emailResponsable . "," . $oEtudiant->getEmailInstitutionel() . "," . $oContact->getEmail(), "Invitation soutenance", $msg, $headers);
}

// Envoyer les convocations sélectionnées
// Attention, il faut faire l'envoie qu'une seule fois

if (isset($_POST['convocation']) && isset($_POST['date']) && isset($_POST['convocations'])) {
    $oDS = DateSoutenance::getDateSoutenance($_POST['date']);
    foreach ($_POST['convocations'] as $idConvocation) {
	$oConvocation = Convocation::getConvocation($idConvocation);

	// Envoie si pas déjà envoyé
	if ($oConvocation->getEnvoi() == 0) {
	    $oSoutenance = Soutenance::getSoutenance($oConvocation->getIDsoutenance());

	    $oConvention = Soutenance::getConvention($oSoutenance);
	    $oContrat = Soutenance::getContrat($oSoutenance);

	    if ($oConvention) {
		$oEtudiant = $oConvention->getEtudiant();
		$oContact = $oConvention->getContact();
	    } else {
		$oEtudiant = $oContrat->getEtudiant();
		$oContact = $oContrat->getContact();
	    }

	    if ($oContrat)
		$cadre = "alternant";
	    else
		$cadre = "stagiaire";

	    $date = $oDS->getJour()." ".Utils::numToMois($oDS->getMois())." ".$oDS->getAnnee();

	    $min = $oSoutenance->getMinuteDebut() == 0 ? '00' : $oSoutenance->getMinuteDebut();
	    $heure = $oSoutenance->getHeureDebut() . "h" . $min;

	    $salle = $oSoutenance->getSalle()->getNom();

	    // Envoyer la convocation
	    envoyerConvocation($oEtudiant, $oContact, $cadre, $date, $heure, $salle);

	    // Indiquer que l'envoi de la convocation a été fait
	    $oConvocation->setEnvoi(1);
	    Convocation_BDD::sauvegarder($oConvocation);
	}
    }
    $oDS->setConvocation(1);
    DateSoutenance_BDD::sauvegarder($oDS);
}

// ----------------------------------------------------------------------------
// Affichage

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Convocations aux", "soutenances", "../../", $tabLiens);

Convocation_IHM::afficherSelectionDateSoutenance("convocationData.php");

// Affichage des données
echo "<div id='data'>";
include_once("convocationData.php");
echo "</div>";

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

deconnexion();

?>