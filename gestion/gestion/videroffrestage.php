<?php

header ('Content-type:text/html; charset=utf-8');

$chemin = "../../classes/";

include_once($chemin."bdd/connec.inc");
include_once($chemin."ihm/IHM_Generale.php");
include_once($chemin."moteur/OffreDeStage.php");
include_once($chemin."bdd/OffreDeStage_BDD.php");
include_once($chemin."moteur/Convention.php");
include_once($chemin."bdd/Convention_BDD.php");
include_once($chemin."moteur/Contact.php");
include_once($chemin."bdd/Contact_BDD.php");
include_once($chemin."moteur/Entreprise.php");
include_once($chemin."bdd/Entreprise_BDD.php");

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion des stages');
IHM_Generale::header("Gestion de la", "base", "../../", $tabLiens);

// Vérification de la période pour exécuter cette fonction
$date = date('n');
if ($date == 9 || $date == 10) { // Il faut être entre le 1 septembre et le 31 octobre de l'année en cours
	
	// Suppression des anciennes offres de stages
	$tabOffres = OffreDeStage::getListeOffreDeStage("");
	foreach ($tabOffres as $offre) {
		OffreDeStage::supprimerDonnees($offre->getIdentifiantBDD());
	}
	echo "<p>Suppression des anciennes offres de stages effectuée.</p>";
	
	// Suppression des contacts superflus
	$tabConventions = Convention::getListeConvention("");
	$tabIdContactConventions = array();
	foreach ($tabConventions as $convention) {
		array_push($tabIdContactConventions, $convention->getContact()->getIdentifiantBDD());
	}
	$tabContacts = Contact::getListeContacts("");
	foreach ($tabContacts as $contact) {
		if (! in_array($contact->getIdentifiantBDD(), $tabIdContactConventions))
			Contact::supprimerContact($contact->getIdentifiantBDD());
	}
	echo "<p>Suppression des contacts superflus effectuée.</p>";
	
	// Suppression des entreprises superflues
	$tabContacts = Contact::getListeContacts("");
	$tabIdEntrepriseContacts = array();
	foreach ($tabContacts as $contact) {
		array_push($tabIdEntrepriseContacts, $contact->getEntreprise()->getIdentifiantBDD());
	}
	$tabEntreprises = Entreprise::getListeEntreprises("");
	foreach ($tabEntreprises as $entreprise) {
		if (! in_array($entreprise->getIdentifiantBDD(), $tabIdEntrepriseContacts))
			Entreprise::supprimerEntreprise($entreprise->getIdentifiantBDD());
	}
	echo "<p>Suppression des entreprises superflues effectuée.</p>";
	
}
else
	IHM_Generale::erreur("Cette fonctionnalité n'est accessible que durant le mois de Septembre et le mois d'octobre");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>