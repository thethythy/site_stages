<?php

/**
 * Page convocationData.php
 * Utilisation : page retournant un tableau de sélection d'envoie d'un courriel
 *		 de convocation / invitation aux étudiants et aux entreprises
 * Accès : restreint par authentification HTTP
 */

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");

include_once($chemin . "ihm/IHM_Generale.php");

include_once($chemin . "bdd/DateSoutenance_BDD.php");
include_once($chemin . "moteur/DateSoutenance.php");

include_once($chemin . "ihm/Convocation_IHM.php");
include_once($chemin . "bdd/Convocation_BDD.php");
include_once($chemin . "moteur/Convocation.php");

include_once($chemin . "bdd/Soutenance_BDD.php");
include_once($chemin . "moteur/Soutenance.php");

include_once($chemin . "bdd/Convention_BDD.php");
include_once($chemin . "moteur/Convention.php");

include_once($chemin . "bdd/Etudiant_BDD.php");
include_once($chemin . "moteur/Etudiant.php");

include_once($chemin . "bdd/Promotion_BDD.php");
include_once($chemin . "moteur/Promotion.php");

include_once($chemin . "bdd/Parcours_BDD.php");
include_once($chemin . "moteur/Parcours.php");

include_once($chemin . "bdd/Filiere_BDD.php");
include_once($chemin . "moteur/Filiere.php");

include_once($chemin . "bdd/Contact_BDD.php");
include_once($chemin . "moteur/Contact.php");

include_once($chemin . "bdd/Entreprise_BDD.php");
include_once($chemin . "moteur/Entreprise.php");

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

// Si une date de soutenance a été sélectionnée
if (isset($_POST['date']) && $_POST['date'] > 0) {
    $oDS = DateSoutenance::getDateSoutenance($_POST['date']);

    // Afficher un warning si l'envoie des convocations a déjà été fait pour
    // certaines soutenances
    if ($oDS->getConvocation()) {
	IHM_Generale::erreur("Certaines ou toutes les convocations ont déjà été envoyées pour cette date de soutenance.");
    }

    // Afficher la liste des convocations à envoyer ou déjà envoyées
    $tabOC = Convocation::getListeConvovationFromDateSoutenance($_POST['date']);
    $anneeUniversitaire = DateSoutenance::getDateSoutenance($_POST['date'])->getAnnee() - 1;
    Convocation_IHM::afficherSelectionDestinairesConvocation("convocation.php",$tabOC, $anneeUniversitaire, $_POST['date']);

} else {
    echo "<center>Veuillez sélectioner une date</center>";
}

?>