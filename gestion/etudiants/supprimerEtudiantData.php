<?php

/**
 * Page supprimerEtudiantData.php
 * Utilisation : page pour obtenir un tableau d'étudiants à supprimer de la base
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

// Précisons l'encodage des données si cela n'est pas déjà fait
if (!headers_sent())
    header("Content-type: text/html; charset=utf-8");

// Si une recherche a été effectuée
if ((isset($_POST['rech'])) || (isset($_GET['id']))) {
    $annee = $_POST['annee'];
    $parcours = $_POST['parcours'];
    $filiere = $_POST['filiere'];
} else {
    if (!isset($_POST['annee']))
	$annee = Promotion_BDD::getLastAnnee();
    else
	$annee = $_POST['annee'];

    if (!isset($_POST['parcours'])) {
	$tabParcours = Parcours::listerParcours();
	$parcours = $tabParcours[0]->getIdentifiantBDD();
    } else
	$parcours = $_POST['parcours'];

    if (!isset($_POST['filiere'])) {
	$tabFilieres = Filiere::listerFilieres();
	$filiere = $tabFilieres[0]->getIdentifiantBDD();
    } else
	$filiere = $_POST['filiere'];
}

$filtres = array();
array_push($filtres, new FiltreString("anneeuniversitaire", $annee));
array_push($filtres, new FiltreString("idparcours", $parcours));
array_push($filtres, new FiltreString("idfiliere", $filiere));

$nbFiltres = sizeof($filtres);
$filtre = $filtres[0];

for ($i = 1; $i < sizeof($filtres); $i++)
    $filtre = new Filtre($filtre, $filtres[$i], "AND");

$tabEtudiants = Promotion::listerEtudiants($filtre);
$tabPromos = Promotion_BDD::getListePromotions($filtre);

if (sizeof($tabPromos) > 0) {
    // Récupération des étudiants n'ayant pas de convention
    $tabEtuSansConv = array();

    for ($i = 0; $i < sizeof($tabEtudiants); $i++) {
	if ($tabEtudiants[$i]->getConvention($annee) == null)
	    array_push($tabEtuSansConv, $tabEtudiants[$i]);
    }

    // Affichage des étudiants sans conventions
    Etudiant_IHM::afficherListeEtudiantsSansConventions($tabPromos[0][0], $tabEtuSansConv);

} else {
    echo "<br/><center>Aucune promotion ne correspond à ces critères de recherche.<br/></center>";
}

?>