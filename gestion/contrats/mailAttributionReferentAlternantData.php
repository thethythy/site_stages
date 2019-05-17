<?php

/**
 * Page mailAttributionReferentReferentData.php
 * Utilisation : page retournant une liste de sélection des notifications
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

// Si une année a été sélectionnée
if (isset($_POST['annee']) && $_POST['annee'] > 0) {

    // Afficher la liste des notifications à envoyer ou déjà envoyées
    $tabOA = Affectation::getListeAffectationFromPromotion(
	    $_POST['annee'], $_POST['parcours'], $_POST['filiere']);

    Affectation_IHM::afficherSelectionDestinairesNotification(
	    $tabOA, $_POST['annee'], $_POST['parcours'], $_POST['filiere'],
	    "mailAttributionReferentAlternant.php");

} else {
    echo "<center>Veuillez sélectioner une année</center>";
}

?>
