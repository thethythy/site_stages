<?php

/**
 * Page videroffrestage.php
 * Utilisation : page de suppression des anciennes offres de stage
 *		 ainsi que les contacts et les entreprises superflues
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

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
    $tab1Contacts = Contact::getListeContacts("");
    foreach ($tab1Contacts as $contact) {
	if (!in_array($contact->getIdentifiantBDD(), $tabIdContactConventions))
	    Contact::supprimerContact($contact->getIdentifiantBDD());
    }
    echo "<p>Suppression des contacts superflus effectuée.</p>";

    // Suppression des entreprises superflues
    $tab2Contacts = Contact::getListeContacts("");
    $tabIdEntrepriseContacts = array();
    foreach ($tab2Contacts as $contact) {
	array_push($tabIdEntrepriseContacts, $contact->getEntreprise()->getIdentifiantBDD());
    }
    $tabEntreprises = Entreprise::getListeEntreprises("");
    foreach ($tabEntreprises as $entreprise) {
	if (!in_array($entreprise->getIdentifiantBDD(), $tabIdEntrepriseContacts))
	    Entreprise::supprimerEntreprise($entreprise->getIdentifiantBDD());
    }
    echo "<p>Suppression des entreprises superflues effectuée.</p>";
} else
    IHM_Generale::erreur("Cette fonctionnalité n'est accessible que durant le mois de Septembre et le mois d'octobre");

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>