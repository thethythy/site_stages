<?php

/**
 * Page suiviPromotionData.php
 * Utilisation : obtenir un tableau du statut actuel des étudiants d'une promotion
 * Accès : restreint par authentification HTTP
 */

$chemin = "../../classes/";

include_once($chemin . "bdd/connec.inc");

include_once($chemin . "moteur/Filtre.php");
include_once($chemin . "moteur/FiltreNumeric.php");

include_once($chemin . "ihm/Promotion_IHM.php");
include_once($chemin . "bdd/Promotion_BDD.php");
include_once($chemin . "moteur/Promotion.php");

include_once($chemin . "bdd/Etudiant_BDD.php");
include_once($chemin . "moteur/Etudiant.php");

include_once($chemin . "bdd/Filiere_BDD.php");
include_once($chemin . "moteur/Filiere.php");

include_once($chemin . "bdd/Parcours_BDD.php");
include_once($chemin . "moteur/Parcours.php");

include_once($chemin . "bdd/Convention_BDD.php");
include_once($chemin . "moteur/Convention.php");

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

// Prise en compte des paramètres
$filtres = array();

if (!isset($_POST['annee']))
    $annee = Promotion_BDD::getLastAnnee();
else if (is_numeric($_POST['annee']))
    $annee = $_POST['annee'];

array_push($filtres, new FiltreNumeric("anneeuniversitaire", $annee));

if (isset($_POST['parcours']) && is_numeric($_POST['parcours']) && $_POST['parcours'] != '*' && $_POST['parcours'] != '') {
    $parcours = $_POST['parcours'];
    array_push($filtres, new FiltreNumeric("idparcours", $parcours));
}

if (isset($_POST['filiere']) && is_numeric($_POST['filiere']) && $_POST['filiere'] != '*' && $_POST['filiere'] != '') {
    $filiere = $_POST['filiere'];
    array_push($filtres, new FiltreNumeric("idfiliere", $filiere));
}

$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
    $filtre = new Filtre($filtre, $filtres[$i], "AND");

// Recherche selon les paramètres

$tabPromos = Promotion_BDD::getListePromotions($filtre);
$tabEtudiants = Promotion::listerEtudiants($filtre);

// Affichage des données collectées

if (!isset($filiere)) $filiere ="";
if (!isset($parcours)) $parcours ="";
Promotion_IHM::afficherListeStatutSuiviEtudiant($annee, $filiere, $parcours, $tabPromos, $tabEtudiants);

?>