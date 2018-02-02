<?php

/**
 * Page mailAttributionData.php
 * Utilisation : page retournant une liste de sélection des notifications
 * Accès : restreint par authentification HTTP
 */

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");

include_once($chemin . "ihm/Attribution_IHM.php");
include_once($chemin . "bdd/Attribution_BDD.php");
include_once($chemin . "moteur/Attribution.php");

include_once($chemin . "bdd/Convention_BDD.php");
include_once($chemin . "moteur/Convention.php");

include_once($chemin . "bdd/Etudiant_BDD.php");
include_once($chemin . "moteur/Etudiant.php");

include_once($chemin . "bdd/Parrain_BDD.php");
include_once($chemin . "moteur/Parrain.php");

include_once($chemin . "bdd/Contact_BDD.php");
include_once($chemin . "moteur/Contact.php");

include_once($chemin . "bdd/Entreprise_BDD.php");
include_once($chemin . "moteur/Entreprise.php");

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

// Si une année a été sélectionnée
if (isset($_POST['annee']) && $_POST['annee'] > 0) {
    // Afficher la liste des notifications à envoyer ou déjà envoyées
    $tabOA = Attribution::getListeAttributionFromPromotion($_POST['annee'], $_POST['parcours'], $_POST['filiere']);
    Attribution_IHM::afficherSelectionDestinairesNotification($tabOA, $_POST['annee'], $_POST['parcours'], $_POST['filiere']);
} else {
    echo "<center>Veuillez sélectioner une année</center>";
}

?>