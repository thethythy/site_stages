<?php

/**
 * Page listeDesEntreprises.php
 * Utilisation : page pour visualiser les entreprises selon un filtre de sélection
 * Accès : restreint par authentification HTTP
 */

include_once("../../classes/bdd/connec.inc");

include_once('../../classes/moteur/Utils.php');
spl_autoload_register('Utils::my_autoloader_from_level2');

$tabLiens = array();
$tabLiens[0] = array('../../', 'Accueil');
$tabLiens[1] = array('../', 'Gestion de la base');

IHM_Generale::header("Liste des", "entreprises", "../../", $tabLiens);

Entreprise_IHM::afficherFormulaireRecherche("listeDesEntreprises.php");

// Si une recherche a été effectuée
if (isset($_POST['rech'])) {
    $filtres = array();

    // Si une recherche sur le nom de l'entreprise est demandée
    if (isset($_POST['nom']) && $_POST['nom'] != "")
	array_push($filtres, new FiltreString("nom", "%" . $_POST['nom'] . "%"));

    // Si une recherche sur le code postal est demandée
    if (isset($_POST['cp']) && $_POST['cp'] != "")
	array_push($filtres, new FiltreString("codepostal", $_POST['cp'] . "%"));

    // Si une recherche sur la ville est demandée
    if (isset($_POST['ville']) && $_POST['ville'] != "")
	array_push($filtres, new FiltreString("ville", $_POST['ville'] . "%"));

    // Si une recherche sur le pays est demandée
    if (isset($_POST['pays']) && $_POST['pays'] != "")
	array_push($filtres, new FiltreString("pays", $_POST['pays'] . "%"));

    $nbFiltres = sizeof($filtres);

    if ($nbFiltres >= 2) {
	$filtre = $filtres[0];
	for ($i = 1; $i < sizeof($filtres); $i++)
	    $filtre = new Filtre($filtre, $filtres[$i], "AND");
    } else if ($nbFiltres == 1) {
	$filtre = $filtres[0];
    } else {
	$filtre = "";
    }

    $tabEntreprises = Entreprise::getListeEntreprises($filtre);
} else {
    $tabEntreprises = Entreprise::getListeEntreprises("");
}

// Si il y a au moins une entreprise
if (sizeof($tabEntreprises) > 0) {
    // Affichage des entreprises correspondants aux critères de recherches
    Entreprise_IHM::afficherListeEntreprise($tabEntreprises);
}else {
    echo "Aucune entreprise ne correspond aux critères de recherche.";
}

IHM_Generale::endHeader(false);
IHM_Generale::footer("../../");

?>