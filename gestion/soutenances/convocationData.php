<?php

/**
 * Page convocationData.php
 * Utilisation : page retournant un tableau de sélection d'envoie d'un courriel
 *		 de convocation / invitation aux étudiants et aux entreprises
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

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